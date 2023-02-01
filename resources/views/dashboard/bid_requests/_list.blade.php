@if(count($bidRequests) > 0)
<x-table>
    <x-slot name="header">
        <tr>
            <th class="text-left">
                <span :class="{'font-bold': order_by == 'id'}">ID</span>
                <div>&nbsp;</div>
            </th>
            <th class="text-left">
                <span :class="{'font-bold': order_by == 'status'}">Status</span>
                <div>&nbsp;</div>
            </th>
            <th class="text-left">
                <span :class="{'font-bold': order_by == 'delivery'}">{{ trans('dashboard/transaction.form.delivery_date') }}</span>
                <div class="text-xxs text-gray-400 normal-case">{{ trans('dashboard/transaction.day_month_year') }}</div>
            </th>
            <th class="text-right" >
                <span :class="{'font-bold': order_by == 'price'}">{{ trans('dashboard/transaction.form.price') }}</span>
                <div class="text-xxs text-gray-400 normal-case">{{ trans('common.baht') }} / MMBTU</div>
            </th>
            <th class="text-right" @click="changeOrder('quantity')">
                <span :class="{'font-bold': order_by == 'quantity'}">{{ trans('dashboard/transaction.form.quantity') }}</span>
                <div class="text-xxs text-gray-400 normal-case">MMBTU</div>
            </th>
            <th class="text-right">
                {{ trans('dashboard/transaction.form.total') }}
                <div class="text-xxs text-gray-400 normal-case">{{ trans('common.baht') }}</div>
            </th>

            <th class="text-left" @click="changeOrder('created_at')">
                <span :class="{'font-bold': order_by == 'created_at'}">{{ trans('dashboard/transaction.form.time') }}</span>
                <div>&nbsp;</div>
            </th>
            <th class=""></th>
        </tr>
    </x-slot>

    @foreach($bidRequests as $index => $bidRequest)
    <tr class="">
        <td class="">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-primary">
                {{ $bidRequest->present()->id }}
            </a>
        </td>
        <td class="">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-primary">
                {!! $bidRequest->present()->statusBadge !!}
            </a>
        </td>
        <td class="">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-primary">
                {{ $bidRequest->present()->deliveryDate }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($bidRequest->present()->price) }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($bidRequest->present()->quantity) }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($bidRequest->present()->total) }}
            </a>
        </td>

        <td class="">
            <a href="{{ $bidRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ $bidRequest->present()->createdAt }}
            </a>
        </td>

        <td class="text-right">
            @can('view', $bidRequest)
            <a href="{{ $bidRequest->dashboardUrl() }}" class="link">{{ __('common.view') }}</a>
            @endcan
        </td>
    </tr>
    @endforeach

    @if(method_exists($bidRequests, 'links'))
    <x-slot name="footer">{{ $bidRequests->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
    @endif
</x-table>
@else
@include('dashboard._partials.illustration_not_found')
<p class="text-center my-10">
    @if(request('search'))
    {{ trans('dashboard/bid_request.list.not_found') }}
    @else
    {{ trans('dashboard/bid_request.list.empty') }}
    @endif
</p>
@endif
