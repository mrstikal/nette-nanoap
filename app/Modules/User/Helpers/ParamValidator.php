<?php

declare(strict_types=1);

namespace App\Modules\User\Helpers;

use Nette\StaticClass;
use Nette\Utils\Arrays;

class ParamValidator
{
    use StaticClass;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    public static function validateRole(string $role): bool
    {
        return Arrays::contains([static::ROLE_ADMIN, static::ROLE_USER], $role);
    }

    public static function validateStatus(string $status): bool
    {
        return Arrays::contains([static::STATUS_ENABLED, static::STATUS_DISABLED], $status);
    }

    public static function isEnabled(string $status): bool
    {
        return $status === static::STATUS_ENABLED;
    }
}
