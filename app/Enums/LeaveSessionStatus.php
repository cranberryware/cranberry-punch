<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 */
final class LeaveSessionStatus extends Enum
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function getStatuses()
    {
        return [
            self::ACTIVE()->value => __('cranberry-punch::cranberry-punch.leave-session.status.active'),
            self::INACTIVE()->value => __('cranberry-punch::cranberry-punch.leave-session.status.inactive'),
        ];
    }

    public static function getStatusColors()
    {
        return [
            'success' => fn ($state): bool => (string)$state === self::ACTIVE()->value,
            'danger' => fn ($state): bool => (string)$state === self::INACTIVE()->value,
        ];
    }
}
