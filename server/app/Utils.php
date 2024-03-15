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
}
