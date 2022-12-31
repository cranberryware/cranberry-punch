@php
    $arrival_status = match(auth()->user()->employee->getAverageTimeOfArrivalStatus()) {
        "early" => "text-white bg-success-500",
        "ontime1" => "text-white bg-success-500",
        "ontime2" => " text-success-700 bg-success-200",
        "late" => "text-white bg-warning-500 animate-pulse duration-200",
        "superlate" => "text-white bg-danger-500 animate-bounce animate-pulse duration-50",
    }
@endphp
<div class="oa-attendance-clock-btn-wrap grid grid-cols-3 gap-6 justify-items-center">
    <h2 class="col-span-3 text-center text-2xl md:text-3xl">
        {{
            __("cranberry-punch::cranberry-punch.attendance-kiosk.attendance-clock.widget.title", [
                        "employee_name" => auth()->user()->employee ? auth()->user()->employee->full_name : ""
                    ])
        }}
    </h2>
    <div class="col-span-3 text-center uppercase">
        {{
            __("cranberry-punch::cranberry-punch.attendance-kiosk.attendance-clock.widget.subtitle", [
                "action" => $getLabel()
            ])
        }}
    </div>
    <div class="col-start-2 {{
        (auth()->user()->employee && auth()->user()->employee->clocked_out())
                            ? ''
                            : 'animate-pulse'
        }}">
        <x-tables::actions.action
            :action="$action"
            component="tables::button"
            :outlined="$isOutlined()"
            :icon-position="$getIconPosition()"
            class="filament-tables-button-action oa-attendance-clock-btn"
        >
            {{ $getLabel() }}
        </x-tables::actions.action>
    </div>
    <div class="col-span-3 text-center">
        {{__("cranberry-punch::cranberry-punch.attendance-kiosk.widget.average-time-of-arrival", ["current_month" => now()->format("Y-m")])}}:
        <div>
            <div class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-lg font-medium tracking-tight rounded-xl whitespace-nowrap {{$arrival_status}}">
                {{$getRecord()->employee->getAverageTimeOfArrival()}}
            </div>

        </div>
    </div>
</div>
