<div class="px-4 py-3" style="width: 175px;">
    @if ($getRecord()->{$getName()})
        <div class="text">
            {{ \Carbon\Carbon::parse($getRecord()->{$getName()})->tz(config('app.user_timezone'))->format('h:i:s A T') }}
        </div>
        <div class="text-sm">
            {{ \Carbon\Carbon::parse($getRecord()->{$getName()})->tz(config('app.user_timezone'))->format('M d, Y') }}
        </div>
        <div class="text-sm text-gray-400"><strong>From:</strong> {{ $getRecord()->{$getName() . '_location'} }}</div>
        <div class="text-sm text-gray-400"><strong>IP Address:</strong> {{ $getRecord()->{$getName() . '_ip'} }}</div>
    @endif
</div>
