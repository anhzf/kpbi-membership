<?php

namespace App;

class Utils
{
    public static function buildOriginFromParsedUrl(object $parts)
    {
        $fullUrl = "{$parts->scheme}://{$parts->host}";
        return $parts->port ? "{$fullUrl}:{$parts->port}" : $fullUrl;
    }

    public static function stripOrigin(string $url)
    {
        return preg_replace('/^https?:\/\/[^\/]+/', '', $url);
    }
}
