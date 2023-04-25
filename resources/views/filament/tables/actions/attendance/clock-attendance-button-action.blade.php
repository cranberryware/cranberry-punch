@php
    $arrival_status = match(auth()->user()->employee->getAverageTimeOfArrivalStatus()) {
        "early" => "text-white bg-success-500",
        "ontime1" => "text-white bg-success-500",
        "ontime2" => " text-success-700 bg-success-200",
        "late" => "text-white bg-warning-500 animate-pulse duration-200",
        "superlate" => "text-white bg-danger-500 animate-bounce animate-pulse duration-50",
    }
@endphp


<div class="cp-attendance-clock-btn-wrap flex flex-col gap-6 justify-items-center">
    <div class="col-span-3 text-center uppercase font-semibold">
        {{
            __("cranberry-punch::cranberry-punch.attendance-kiosk.attendance-clock.widget.subtitle", [
                "action" => $getLabel()
            ])
        }}
    </div>
    <div class="col-start-2 clock-btn border-b border-green-350 pb-3 text-center {{
        (auth()->user()->employee && auth()->user()->employee->clocked_out())
                            ? ''
                            : 'animate-pulse'
        }}">
        <x-tables::actions.action
            :action="$action"
            component="tables::button"
            :outlined="$isOutlined()"
            :icon-position="$getIconPosition()"
            class="filament-tables-button-action cp-attendance-clock-btn"
        >
            @if ((auth()->user()->employee && auth()->user()->employee->clocked_out()))
            <img src="{{ url('assets/clockIn.svg') }}" alt="image" />
            @else
            <img src="{{ url('assets/clockOut.svg') }}" alt="image" />
            @endif
        </x-tables::actions.action>
        <div class="font-semibold whitespace-normal">{{auth()->user()->employee->getLastClockTypeAndTime()}}</div>
    </div>
    <div class="col-span-3 text-center">
        {{__("cranberry-punch::cranberry-punch.attendance-kiosk.widget.average-time-of-arrival", ["current_month" => now()->format("Y-m")])}}:
        <div>
            <div class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 mt-2 text-lg font-medium tracking-tight rounded-xl whitespace-nowrap {{$arrival_status}}">
                {{$getRecord()->employee->getAverageTimeOfArrival()}}
            </div>

        </div>
    </div>
</div>
