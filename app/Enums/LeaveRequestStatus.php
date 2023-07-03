<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static APPROVED()
 * @method static static REJECTED()
 * @method static static CANCELLED()
 */
final class LeaveRequestStatus extends Enum
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    const CANCELLED = 'cancelled';

    public static function getStatuses()
    {
        return [
            self::PENDING()->value => __('cranberry-punch::cranberry-punch.leave-request.status.pending'),
            self::APPROVED()->value => __('cranberry-punch::cranberry-punch.leave-request.status.approved'),
            self::REJECTED()->value => __('cranberry-punch::cranberry-punch.leave-request.status.rejected'),
            self::CANCELLED()->value => __('cranberry-punch::cranberry-punch.leave-request.status.cancelled'),
        ];
    }

    public static function getStatusColors()
    {
        return [
            'warning' => fn ($state): bool => (string)$state === self::PENDING()->value,
            'success' => fn ($state): bool => (string)$state === self::APPROVED()->value,
            'danger' => fn ($state): bool => (string)$state === self::REJECTED()->value,
            'primary' => fn ($state): bool => (string)$state === self::CANCELLED()->value,
        ];
    }
}
