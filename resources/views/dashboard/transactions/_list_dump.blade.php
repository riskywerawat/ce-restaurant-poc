@if(count($transactions) > 0)
    <x-table>
        <x-slot name="header">
            <tr>
                <th class="text-left">
                    <span :class="{'font-bold': order_by == 'id'}">ID</span>
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
                @if(!isset($user) || !$user->isBuyer())
                    <th class="text-left">
                        {{ trans('dashboard/transaction.form.buyer') }}
                        <div>&nbsp;</div>
                    </th>
                @endif
                @if(!isset($user) || !$user->isSeller())
                    <th class="text-left">
                        {{ trans('dashboard/transaction.form.seller') }}
                        <div>&nbsp;</div>
                    </th>
                @endif
                <th class="text-left" @click="changeOrder('created_at')">
                    <span :class="{'font-bold': order_by == 'created_at'}">{{ trans('dashboard/transaction.form.time') }}</span>
                    <div>&nbsp;</div>
                </th>
                <th class=""></th>
            </tr>
        </x-slot>

        @foreach($transactions as $index => $transaction)
            <tr class="">
                <td class="">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-primary">
                        {{ $transaction->present()->id }}
                    </a>
                </td>
                <td class="">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-primary">
                        {{ $transaction->present()->deliveryDate }}
                    </a>
                </td>
                <td class="text-right">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary">
                        {{ money($transaction->present()->price) }}
                    </a>
                </td>
                <td class="text-right">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary">
                        {{ money($transaction->present()->quantity) }}
                    </a>
                </td>
                <td class="text-right">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary">
                        {{ money($transaction->present()->total) }}
                    </a>
                </td>
                @if(!isset($user) || !$user->isBuyer())
                    <td class="">
                        <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary"
                           data-tippy-content="{{ trans('dashboard/transaction.spend') }} {{ money($transaction->present()->buyerSpend) }} {{ trans('common.baht') }}"
                        >
                            {{ $transaction->present()->buyer }}
                        </a>
                    </td>
                @endif
                @if(!isset($user) || !$user->isSeller())
                    <td class="">
                        <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary"
                           data-tippy-content="{{ trans('dashboard/transaction.received') }} {{ money($transaction->present()->sellerReceived) }} {{ trans('common.baht') }}"
                        >
                            {{ $transaction->present()->seller }}
                        </a>
                    </td>
                @endif
                <td class="">
                    <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary">
                        {{ $transaction->present()->createdAt }}
                    </a>
                </td>

                <td class="text-right">
                    @can('view', $transaction)
                        <a href="{{ $transaction->dashboardUrl() }}" class="link">{{ __('common.view') }}</a>
                    @endcan
                </td>
            </tr>
        @endforeach

        @if(method_exists($transactions, 'links'))
        <x-slot name="footer">{{ $transactions->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
        @endif
    </x-table>
@else
    @include('dashboard._partials.illustration_not_found')
    <p class="text-center my-10">
        @if(request('search'))
            {{ trans('dashboard/transaction.list.not_found') }}
        @else
            {{ trans('dashboard/transaction.list.empty') }}
        @endif
    </p>
@endif
