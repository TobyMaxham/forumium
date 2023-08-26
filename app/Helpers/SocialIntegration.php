<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SocialIntegration
{
    public static function enablesSocials(): Collection
    {
        $shouldEnable = env('APP_ENABLED_SOCIALS');
        return Str::of($shouldEnable)->explode(',')
            ->filter(self::checkService());
    }

    private static function checkService(): \Closure
    {
        return function ($social) {
            if (!is_string($social) || empty($social)) {
                return false;
            }

            $config = config('services.'.$social);
            if (empty($config) || !is_array($config)) {
                return false;
            }

            foreach ($config as $value) {
                if (is_array($value)) {
                    continue;
                }
                if (empty($value)) {
                    return false;
                }
            }

            return true;
        };
    }
}
