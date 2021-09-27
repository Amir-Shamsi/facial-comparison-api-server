import sys
import json
from face_recognition import FacePP, exceptions



def face_comparing(app, Image1, Image2):
    cmp_ = app.compare.get(image_url1=Image1, image_url2=Image2)
    # Comparing Photos
    if cmp_.confidence > 70:
        return {
            "status" : True,
            "percentage" : str(cmp_.confidence) + '%',
            "errors" : None
        }
    else:
        return {
            "status" : False,
            "percentage" : str(cmp_.confidence) + '%',
            "errors" : None
        }

if __name__ == '__main__':
    api_key = 'xQLsTmMyqp1L2MIt7M3l0h-cQiy0Dwhl'
    api_secret = 'TyBSGw8NBEP9Tbhv_JbQM18mIlorY6-D'

    try:
        app_ = FacePP(api_key=api_key, api_secret=api_secret)
        image1 = sys.argv[1]
        image2 = sys.argv[2]

        response = face_comparing(app_, image1, image2)
    except exceptions.BaseFacePPError as e:
        response ={
            'status' : None,
            'percentage': None,
            'errors' : e.args[0]
        }
json_object = json.dumps(response, indent = 3)

print(json_object)