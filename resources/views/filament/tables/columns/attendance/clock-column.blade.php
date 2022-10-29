<div class="px-4 py-3">
    <div class="text">
        {{ \Carbon\Carbon::parse($getRecord()->{$getName()})->tz(config('app.user_timezone'))->format(config('app.user_datetime_format')) }}
    </div>
    <div class="text-sm text-gray-400"><strong>From:</strong> {{ $getRecord()->{$getName() . '_location'} }}</div>
    <div class="text-sm text-gray-400"><strong>IP Address:</strong> {{ $getRecord()->{$getName() . '_ip'} }}</div>
</div>
