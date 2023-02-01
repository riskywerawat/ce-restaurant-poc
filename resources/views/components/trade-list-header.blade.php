<div class="grid grid-cols-3 text-xs text-kimberly-secondary mt-4 font-bold tracking-wide">
    <div>
        {{ trans('market.delivery_date') }}
        <div class="text-xxs font-normal tracking-normal">{{ trans('market.day_month_year') }}</div>
    </div>
    <div class="text-right">
        {{ trans('market.qty') }}
        <div class="text-xxs font-normal tracking-normal">(MMBTU)</div>
    </div>
    <div class="text-right">
        {{ trans('market.price') }}
        <div class="text-xxs font-normal tracking-normal">({{ trans('common.thb') }} / MMBTU)</div>
    </div>
</div>
