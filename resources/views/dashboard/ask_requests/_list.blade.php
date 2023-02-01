@if(count($askRequests) > 0)
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

    @foreach($askRequests as $index => $askRequest)
    <tr class="">
        <td class="">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-primary">
                {{ $askRequest->present()->id }}
            </a>
        </td>
        <td class="">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-primary">
                {!! $askRequest->present()->statusBadge !!}
            </a>
        </td>
        <td class="">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-primary">
                {{ $askRequest->present()->deliveryDate }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($askRequest->present()->price) }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($askRequest->present()->quantity) }}
            </a>
        </td>
        <td class="text-right">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ money($askRequest->present()->total) }}
            </a>
        </td>

        <td class="">
            <a href="{{ $askRequest->dashboardUrl() }}" class="table-link-secondary">
                {{ $askRequest->present()->createdAt }}
            </a>
        </td>

        <td class="text-right">
            @can('view', $askRequest)
            <a href="{{ $askRequest->dashboardUrl() }}" class="link">{{ __('common.view') }}</a>
            @endcan
        </td>
    </tr>
    @endforeach

    @if(method_exists($askRequests, 'links'))
    <x-slot name="footer">{{ $askRequests->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
    @endif
</x-table>
@else
@include('dashboard._partials.illustration_not_found')
<p class="text-center my-10">
    @if(request('search'))
    {{ trans('dashboard/ask_request.list.not_found') }}
    @else
    {{ trans('dashboard/ask_request.list.empty') }}
    @endif
</p>
@endif
