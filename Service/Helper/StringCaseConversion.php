<?php


namespace Rewsam\DevelopmentAssist\Service\Helper;

class StringCaseConversion
{
    public static function camelToWords(string $string): string
    {
        return ucwords(implode(' ',preg_split('/(?=[A-Z])/', $string)));
    }

    public static function camelToDash(string $string): string
    {
        return strtolower(implode('-',preg_split('/(?=[A-Z])/', $string)));
    }

    public static function underscoreToCamel(string $string): string
    {
        $string = ucwords(str_replace([' ', '_'], ['-', ' '], $string));

        return lcfirst(str_replace([' ', '-'], ['', ' '], $string));
    }
}