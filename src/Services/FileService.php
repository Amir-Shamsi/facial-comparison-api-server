<?php


namespace App\Services;


class FileService
{
    public static function destroySpaces(string $filename): string
    {
        return str_replace(' ', '_', $filename);
    }

    public static function getUniqueFilename(string $filename): string
    {
        $filename = self::destroySpaces($filename);
        return ($filename) . '_' . uniqid() . '.' . self::getFileFormat($filename);
    }

    private static function getFileFormat(string $filename): string
    {
        $format = '';
        for ($index = strlen($filename); $filename[$index] != '.'; $index--)
            $format .= strtolower($filename[$index]);
        return strrev($format);
    }
}