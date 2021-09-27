<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Request;

class UrlGenerator
{
    public static function generate(string $filename, Request $request): string
    {
        $host_name = $request->getHost();
        return ($host_name == '127.0.0.1' || $host_name == '::1')?'https://': 'http://'.$host_name.'/assets/img/temp/downloads/'.$filename;
    }
}