<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CHECK_IN()
 * @method static static CHECK_OUT()
 * @method static static BOTH()
 */
final class DeviceMode extends Enum
{
    const CHECK_IN = 'check_in';
    const CHECK_OUT = 'check_out';
    const BOTH = 'both';

    public static function getModes()
    {
        return [
            self::CHECK_IN()->value => __('cranberry-punch::cranberry-punch.device.mode.check_in'),
            self::CHECK_OUT()->value => __('cranberry-punch::cranberry-punch.device.mode.check_out'),
            self::BOTH()->value => __('cranberry-punch::cranberry-punch.device.mode.both'),
        ];
    }
}
