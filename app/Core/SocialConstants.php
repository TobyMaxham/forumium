<?php

namespace App\Core;

use App\Helpers\SocialIntegration;

enum SocialConstants: string
{

    case FACEBOOK = "facebook";
    case GITHUB = "github";
    case GOOGLE = "google";
    case TWITTER = "twitter";

    public static function color(string $name)
    {
        return match ($name) {
            self::FACEBOOK->value => '3b5998',
            self::GITHUB->value => '24292F',
            self::GOOGLE->value => 'DB4437',
            self::TWITTER->value => '00ACEE',
        };
    }

    public static function isEnabled(string $name)
    {
        return SocialIntegration::enablesSocials()->contains($name);
    }

    public static function enabledCases()
    {
        $socials = [];
        foreach (array_column(self::cases(), 'value') as $social) {
            if (self::isEnabled($social)) {
                $socials[] = $social;
            }
        }
        return $socials;
    }

}
