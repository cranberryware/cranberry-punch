<?php

namespace App\Filament\Filters;

use Carbon\Carbon;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter as WebbingbrasilDateFilter;

class DateFilter extends WebbingbrasilDateFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->indicateUsing(function (array $state): array {
            if (isset($state['clause']) && !empty($state['clause'])) {
                $message = $this->getLabel() . ' ' . $this->clauses()[$state['clause']];

                if ($state['clause'] === self::CLAUSE_SET || $state['clause'] === self::CLAUSE_NOT_SET) {
                    return [$message];
                }
                if ($state['period_value']
                    && ($state['clause'] === self::CLAUSE_GREATER_THAN || $state['clause'] === self::CLAUSE_LESS_THAN)) {
                    return [$message . ' ' . $state['period_value'] . ' ' . $state['period'] . ' ' . $state['direction']];
                }

                if ($state['value']) {
                    return [$message . ' ' . Carbon::parse($state['value'])->format(config('tables.date_format', 'Y-m-d'))];
                }
                if ($state['from'] || $state['until']) {
                    return [$message . ' ' .
                        ($state['from'] ? Carbon::parse($state['from'])->format(config('tables.date_format', 'Y-m-d')) : 0) . ' and ' .
                        ($state['until'] ? Carbon::parse($state['until'])->format(config('tables.date_format', 'Y-m-d')) : "~")
                    ];
                }
            }

            return [];
        });
    }
}
