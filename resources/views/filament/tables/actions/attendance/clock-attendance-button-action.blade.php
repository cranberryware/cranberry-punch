<div class="oa-attendance-clock-btn-wrap">
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
