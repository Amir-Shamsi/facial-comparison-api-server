import contextlib
import locale
import inspect

from distutils.version import LooseVersion

from . import exceptions, engines, utilities, resources
from .version import __version__


class FacePP(object):
    def __init__(self, api_key, api_secret, **kwargs):
        self.url = kwargs.get('url', None)
        if self.url is None:
            url = 'https://api-{0}.faceplusplus.com'
            if locale.getdefaultlocale()[0].lower() == 'zh_cn':
                self.url = url.format('cn')
            else:
                self.url = url.format('us')

        self.ver = kwargs.get('version', None)
        self.date_format = kwargs.get('date_format', '%Y-%m-%d')
        self.datetime_format = kwargs.get('datetime_format', '%Y-%m-%dT%H:%M:%SZ')
        self.raise_attr_exception = kwargs.get('raise_attr_exception', True)

        engine = kwargs.get('engine', engines.DefaultEngine)

        if not inspect.isclass(engine) or not issubclass(engine, engines.BaseEngine):
            raise exceptions.EngineClassError

        self.engine = engine(api_key=api_key, api_secret=api_secret, **kwargs)

    def __getattr__(self, resource_name):
        if resource_name.startswith('_'):
            raise AttributeError

        resource_name = ''.join(word[0].upper() + word[1:] for word in str(resource_name).split('_'))

        try:
            resource_class = resources.registry[resource_name]['class']
        except KeyError:
            raise exceptions.ResourceError

        if self.ver is not None and LooseVersion(str(self.ver)) < LooseVersion(resource_class.facepp_version):
            raise exceptions.ResourceVersionMismatchError

        return resource_class.manager_class(self, resource_class)

    @classmethod
    def version(cls):
        return __version__

    @contextlib.contextmanager
    def session(self, **options):
        engine = self.engine
        self.engine = engine.__class__(
            requests=utilities.merge_dicts(engine.requests, options.pop('requests', {})), **options)
        yield self
        self.engine = engine

