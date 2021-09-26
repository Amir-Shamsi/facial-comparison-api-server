<?php


namespace App\Services;


use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileService
{
    public static function destroy_spaces(string $filename): string
    {
        return str_replace(' ', '_', $filename);
    }

    public static function getUniqueFilename(string $filename): string
    {
        $filename = self::destroy_spaces($filename);
        return pathinfo($filename, PATHINFO_FILENAME) . '_' . uniqid() . '.' . self::get_file_format($filename);
    }

    public static function get_file_format(string $filename): string
    {
        $format = '';
        for ($index = strlen($filename)-1; $filename[$index] != '.'; $index--)
            $format .= strtolower($filename[$index]);
        return strrev($format);
    }

    public static function create_file($path, $filename, $content): ?bool
    {
        try {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            file_put_contents($path.$filename, $content);
            return true;
        } catch (FileException $exception) {
            return null;
        }
    }

    public static function url_parse_filename(string $url): ?string
    {
        $name = '';
        try {
            for ($index = strlen($url)-1; $url[$index] != '\\' && $url[$index] != '/'; $index--)
                $name .= strtolower($url[$index]);
            return strrev($name);
        } catch (\Exception $exception){
            return null;
        }
    }

}