<?php

namespace App\Support;

use DateTimeZone;

class UserTimezone
{
    public static function normalize(?string $timezone): string
    {
        if ($timezone === null || ! in_array($timezone, DateTimeZone::listIdentifiers(), true)) {
            return 'UTC';
        }

        return $timezone;
    }

    public static function fromSession(): string
    {
        return self::normalize(session('userTimezone', 'UTC'));
    }
}
