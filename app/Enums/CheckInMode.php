<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static WEB()
 * @method static static DEVICE()
 * @method static static BOTH()
 */
final class CheckInMode extends Enum
{
    const WEB = 'web';
    const DEVICE = 'device';
    const BOTH = 'both';

    public static function getModes()
    {
        return [
            self::WEB()->value => __('cranberry-punch::cranberry-punch.employee.check_in_mode.web'),
            self::DEVICE()->value => __('cranberry-punch::cranberry-punch.employee.check_in_mode.device'),
            self::BOTH()->value => __('cranberry-punch::cranberry-punch.employee.check_in_mode.both'),
        ];
    }
}
