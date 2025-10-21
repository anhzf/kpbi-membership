<?php

namespace App;

class Utils
{
    public static function buildOriginFromParsedUrl(object $parts)
    {
        $fullUrl = "{$parts->scheme}://{$parts->host}";
        $port = $parts->port ?? '';
        return $port ? "{$fullUrl}:{$port}" : $fullUrl;
    }

    public static function stripOrigin(string $url)
    {
        return preg_replace('/^https?:\/\/[^\/]+/', '', $url);
    }

    public static function intToRomanNumeral(int $num)
    {
        static $nf = new \NumberFormatter('@numbers=roman', \NumberFormatter::DECIMAL);
        return $nf->format($num);
    }

    public static function toIndonesianWords(int $num)
    {
        static $nf = new \NumberFormatter('id_ID', \NumberFormatter::SPELLOUT);
        return $nf->format($num);
    }
}
