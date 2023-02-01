@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/transaction.page_title.index'); ?>
@section('title', $pageTitle)

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb')
@endsection

@section('content')
    <div class="page-container">
        <div class="block sm:flex items-baseline justify-between">
            <h1 class="text-2xl">
                @if(request('search'))
                    {{ trans('dashboard/transaction.list.search_results') }} {{ request('search') }} {{--@if($transactions->total() > 0)<span class="text-sm">{{ $transactions->total() }} บัญชี</span>@endif--}}
                @else
                    {{ $pageTitle }} {{--<span class="text-sm">{{ $transactions->total() }} บัญชี</span>--}}
                @endif
            </h1>
            {{--@can('create', App\Models\Transaction::class)--}}
            {{--<a href="{{ route('dashboard.transactions.create') }}" class="button button-primary inline-flex items-center">--}}
            {{--<svg class="fill-current w-4 h-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9V5H9v4H5v2h4v4h2v-4h4V9h-4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>--}}
            {{--{{ trans('dashboard/transaction.page_title.create') }}</a>--}}
            {{--@endcan--}}
        </div>
        {{--<div class="card mt-2 px-4">--}}
            {{--<h2 class="text-lg mb-4 font-semibold">ตัวกรอง</h2>--}}
            {{--<form action="{{ url()->current() }}" class="flex flex-wrap -mx-2" @submit.prevent="reloadSearch">--}}
                {{--<div class="w-full sm:w-1/2 lg:w-3/4 px-2 mb-3">--}}
                    {{--<label class="form-label" for="search">--}}
                        {{--ค้นหาผู้ใช้--}}
                    {{--</label>--}}
                    {{--<input class="form-input w-full"--}}
                           {{--id="search" name="search" type="text"--}}
                           {{--v-model="search"--}}
                           {{--placeholder="พิมพ์ชื่อ หรือ อีเมล">--}}
                {{--</div>--}}
                {{--<div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-3">--}}
                    {{--<label class="form-label">--}}
                        {{--Roles--}}
                    {{--</label>--}}
                    {{--<select name="role" id="" class="form-select w-full" v-model="role">--}}
                        {{--<option :value="null">ทั้งหมด</option>--}}
                        {{--<option value="transactions">ผู้ใช้ทั่วไป</option>--}}
                        {{--@foreach($roles as $role)--}}
                            {{--<option value="{{ $role->id }}">{{ snakeCaseToText($role->name) }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="w-full px-2 text-right">--}}
                    {{--<button class="button button-primary inline-flex items-center" type="submit">@include('dashboard._partials.icon_filter') Filter</button>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}


        <div class="bg-white my-4 py-4 px-4 rounded-lg">
            <h2 class="text-lg mb-4 font-semibold">Filter</h2>
            <form action="{{ url()->current() }}" class="flex flex-wrap -mx-2" @submit.prevent="reloadSearch">
                <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-3">
                    {{--@include('dashboard._partials.formfield', [--}}
                    {{--'label' => 'ค้นหาร้านค้า', 'name' => 'search', 'value' =>  request('search')--}}
                    {{--])--}}
                    <label class="form-label text-xs text-gray-600" for="search">
                        Search by ID
                    </label>
                    <input class="form-input w-full text-sm"
                           id="search" name="search" type="text"
                           v-model="search"
                           placeholder="Transaction ID">
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-3 ">
                    <label class="form-label w-full text-xs text-gray-600" for="price_min">
                        {{ trans('dashboard/transaction.form.price') }}
                    </label>
                    <div class="flex">
                        <div class="w-1/2 flex-1 min-w-0">
                            <input aria-label="Min price" class="form-input text-sm relative block w-full rounded-none rounded-bl rounded-tl bg-transparent focus:z-10 transition ease-in-out duration-150"
                                   name="price_min" placeholder="Min" v-model="price_min" />
                        </div>
                        <div class="-ml-px flex-1 min-w-0">
                            <input aria-label="Max price" class="form-input text-sm relative block w-full rounded-none rounded-br rounded-tr bg-transparent focus:z-10 transition ease-in-out duration-150"
                                   name="price_max" placeholder="Max" v-model="price_max" />
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-3 ">
                    <label class="form-label w-full text-xs text-gray-600" for="price_min">
                        {{ trans('dashboard/transaction.form.quantity') }}
                    </label>
                    <div class="flex">
                        <div class="w-1/2 flex-1 min-w-0">
                            <input aria-label="Min quantity" class="form-input text-sm relative block w-full rounded-none rounded-bl rounded-tl bg-transparent focus:z-10 transition ease-in-out duration-150"
                                   name="quantity_min" placeholder="Min" v-model="quantity_min"/>
                        </div>
                        <div class="-ml-px flex-1 min-w-0">
                            <input aria-label="Max quantity" class="form-input text-sm relative block w-full rounded-none rounded-br rounded-tr bg-transparent focus:z-10 transition ease-in-out duration-150"
                                   name="quantity_max" placeholder="Max" v-model="quantity_max" />
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-1/2 xl:w-1/4 px-2 mb-3 ">
                    <label class="form-label w-full text-xs text-gray-600" for="price_min">
                        {{ trans('dashboard/transaction.form.delivery_date') }}
                    </label>
                    <div class="flex">
                        <div class="w-1/2 flex-1 min-w-0">
                            <vc-date-picker mode="single" :is-required="false" is-dark color="purple" v-model='delivery_start'
                                            :popover="{placement: 'bottom', positionFixed: true}"
                            >
                                <input type="text" name="delivery_start" autocomplete="off"
                                       class="form-input text-sm relative block w-full rounded-none rounded-bl rounded-tl bg-transparent focus:z-10 transition ease-in-out duration-150"
                                       {{--:class="{ 'form-input-error': $v.bid_delivery_date.$error }"--}}
                                       id="delivery_start" :value="dateFormat(delivery_start)">
                            </vc-date-picker>
                            {{--<input aria-label="From" type="text"--}}
                                   {{--class="form-input text-sm relative block w-full rounded-none rounded-bl rounded-tl bg-transparent focus:z-10 transition ease-in-out duration-150"--}}
                                   {{--name="delivery_start" id="delivery_start" v-model="delivery_start" placeholder="From"/>--}}
                        </div>
                        <div class="-ml-px flex-1 min-w-0">
                            <vc-date-picker mode="single" :is-required="false" is-dark color="purple" v-model='delivery_end'
                                            :popover="{placement: 'bottom', positionFixed: true}"
                            >
                                <input type="text" name="delivery_end" autocomplete="off"
                                       class="form-input text-sm relative block w-full rounded-none rounded-br rounded-tr bg-transparent focus:z-10 transition ease-in-out duration-150"
                                       id="delivery_end" :value="dateFormat(delivery_end)">
                            </vc-date-picker>
                            {{--<input aria-label="To" class="form-input text-sm relative block w-full rounded-none rounded-br rounded-tr bg-transparent focus:z-10 transition ease-in-out duration-150"--}}
                                   {{--name="delivery_end" id="delivery_end" v-model="delivery_end" placeholder="To"/>--}}
                        </div>
                    </div>
                </div>

                <div class="w-full px-2 text-right">
                    <button class="button button-primary inline-flex items-center" type="submit">@include('dashboard._partials.icon_filter') Filter</button>
                </div>
            </form>
        </div>

        @if(count($transactions) > 0)
            <x-table>
                <x-slot name="header">
                    <tr>
                        <th class="text-left cursor-pointer" @click="changeOrder('id')">
                            <span :class="{'font-bold': order_by == 'id'}">ID</span>
                            <svg class="w-3 h-3 inline-block fill-current" viewBox="0 0 401.998 401.998" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <path :class="[orderMarkClass('id', 'desc')]" d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424z"/>
                                <path :class="[orderMarkClass('id', 'asc')]" d="M328.905 237.549H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"/>
                            </svg>
                            <div>&nbsp;</div>
                        </th>
                        <th class="text-left cursor-pointer" @click="changeOrder('delivery')">
                            <span :class="{'font-bold': order_by == 'delivery'}">{{ trans('dashboard/transaction.form.delivery_date') }}</span>
                            <svg class="w-3 h-3 inline-block fill-current" viewBox="0 0 401.998 401.998" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <path :class="[orderMarkClass('delivery', 'desc')]" d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424z"/>
                                <path :class="[orderMarkClass('delivery', 'asc')]" d="M328.905 237.549H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"/>
                            </svg>
                            <div class="text-xxs text-gray-400 normal-case">{{ trans('dashboard/transaction.day_month_year') }}</div>
                        </th>
                        <th class="text-right cursor-pointer" @click="changeOrder('price')">
                            <svg class="w-3 h-3 inline-block fill-current" viewBox="0 0 401.998 401.998" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <path :class="[orderMarkClass('price', 'desc')]" d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424z"/>
                                <path :class="[orderMarkClass('price', 'asc')]" d="M328.905 237.549H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"/>
                            </svg>
                            <span :class="{'font-bold': order_by == 'price'}">{{ trans('dashboard/transaction.form.price') }}</span>
                            <div class="text-xxs text-gray-400 normal-case">{{ trans('common.baht') }} / MMBTU</div>
                        </th>
                        <th class="text-right cursor-pointer" @click="changeOrder('quantity')">
                            <svg class="w-3 h-3 inline-block fill-current" viewBox="0 0 401.998 401.998" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <path :class="[orderMarkClass('quantity', 'desc')]" d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424z"/>
                                <path :class="[orderMarkClass('quantity', 'asc')]" d="M328.905 237.549H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"/>
                            </svg>
                            <span :class="{'font-bold': order_by == 'quantity'}">{{ trans('dashboard/transaction.form.quantity') }}</span>
                            <div class="text-xxs text-gray-400 normal-case">MMBTU</div>
                        </th>
                        <th class="text-right">
                            {{ trans('dashboard/transaction.form.total') }}
                            <div class="text-xxs text-gray-400 normal-case">{{ trans('common.baht') }}</div>
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/transaction.form.buyer') }}
                            <div>&nbsp;</div>
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/transaction.form.seller') }}
                            <div>&nbsp;</div>
                        </th>
                        <th class="text-left cursor-pointer" @click="changeOrder('created_at')">
                            <span :class="{'font-bold': order_by == 'created_at'}">{{ trans('dashboard/transaction.form.time') }}</span>
                            <svg class="w-3 h-3 inline-block fill-current" viewBox="0 0 401.998 401.998" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <path :class="[orderMarkClass('created_at', 'desc')]" d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424z"/>
                                <path :class="[orderMarkClass('created_at', 'asc')]" d="M328.905 237.549H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"/>
                            </svg>
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
                        <td class="">
                            <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary"
                               data-tippy-content="{{ trans('dashboard/transaction.spend') }} {{ money($transaction->present()->buyerSpend) }} {{ trans('common.baht') }}"
                            >
                                {{ $transaction->present()->buyer }}
                            </a>
                        </td>
                        <td class="">
                            <a href="{{ $transaction->dashboardUrl() }}" class="table-link-secondary"
                               data-tippy-content="{{ trans('dashboard/transaction.received') }} {{ money($transaction->present()->sellerReceived) }} {{ trans('common.baht') }}"
                            >
                                {{ $transaction->present()->seller }}
                            </a>
                        </td>
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

                <x-slot name="footer">{{ $transactions->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
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
    </div>
@endsection

@section('js')
    <script>
        // initial scroll set, used when refresh page and browser auto scroll to bottom
        document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
        // listener when transaction scroll
        window.addEventListener('scroll', () => {
            document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
        });
    </script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
      tippy('[data-tippy-content]');
    </script>

    {{--@javascript('baseUrl', url()->current())--}}
    <script src="{{ mix('js/dashboard/manifest.js') }}"></script>
    <script src="{{ mix('js/dashboard/vendor.js') }}"></script>
    <script src="{{ mix('js/dashboard/transactionsDataTable.js') }}"></script>

    {{--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>--}}
    {{--<script>--}}
      {{--flatpickr("#delivery_start, #delivery_end", {});--}}
      {{--console.log('yo yo');--}}
    {{--</script>--}}
@endsection
