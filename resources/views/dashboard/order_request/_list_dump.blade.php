@if(count($orders) > 0)
<x-table>

    <x-slot name="header">
        <tr>
            <th class="text-left">
           Kitchen
            </th>

            <th class="">Status</th>
            <th class="">TIME SPEND (MINUTE)</th>
            <th class=""> </th>
        </tr>
    </x-slot>
    @foreach ($orders as $order )
    <tr class="">
        <td class="">
            {{$order->name}}
           </td>
           <td class="text-center">
            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full">{{ $order->present()->status === 1 ? "Pending" : "Completed" }}</span>
           </td>
           <td class="text-center">
            {{$order->getDiffMinute($order->created_at)}}
           </td>
           <td class="text-right">

                   <a href="{{ route('dashboard.order_request.show', $order->id) }}"  class="link">{{ __('common.view') }}</a>

           </td>
    </tr>

       @endforeach
       <td class="text-center">
        <a href="{{ $order->dashboardUrl() }}" class="table-link-secondary">

        </a>
    </td>

    @if(method_exists($orders, 'links'))
    <x-slot name="footer">{{ $orders->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
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
