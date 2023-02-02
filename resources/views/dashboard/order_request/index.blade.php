@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/order_request.page_title.index'); ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb')
@endsection

@section('content')
    <div class="page-container">
        <div class="block sm:flex items-baseline justify-between">
            <h1 class="text-2xl">
                @if(request('search'))
                    {{ trans('dashboard/order_request.list.search_results') }}: {{ request('search') }} {{--@if($users->total() > 0)<span class="text-sm">{{ $users->total() }} บัญชี</span>@endif--}}
                @else
                    {{ $pageTitle }} {{--<span class="text-sm">{{ $users->total() }} บัญชี</span>--}}
                @endif
            </h1>
            @can('create', App\Models\User::class)
            <a href="{{ route('dashboard.order_request.create') }}" class="button text-white bg-gray-700 inline-flex items-center">
            <svg class="fill-current w-4 h-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9V5H9v4H5v2h4v4h2v-4h4V9h-4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>
            {{ trans('dashboard/order_request.page_title.create') }}</a>
            @endcan
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
                        {{--<option value="users">ผู้ใช้ทั่วไป</option>--}}
                        {{--@foreach($roles as $role)--}}
                            {{--<option value="{{ $role->id }}">{{ snakeCaseToText($role->name) }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="w-full px-2 text-right">--}}
                    {{--<button class="button text-white bg-gray-700 inline-flex items-center" type="submit">@include('dashboard._partials.icon_filter') Filter</button>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

        @if(count($orders) > 0)
            <x-table>
                <x-slot name="header">
                    <tr>
                        <th class="text-left">
                            {{ trans('dashboard/order_request.form.id') }}
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/order_request.form.kitchen') }}
                        </th>
                        <th class="text-center">
                            {{ trans('dashboard/order_request.form.status') }}
                        </th>
                        <th class="text-center">
                            Time Spend (MINUTE)
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/order_request.form.order_at') }}
                        </th>
                        <th class="text-left"></th>

                    </tr>
                </x-slot>

                @foreach($orders as $index => $order)
                    <tr class="">
                        <td class="">
                            <a href="{{ $order->dashboardUrl() }}" class="table-link-primary">{{ $order->present()->id }}</a>
                        </td>
                        <td class="">
                            <a href="{{ $order->dashboardUrl() }}" class="table-link-secondary">{{ $order->present()->name }}</a>
                        </td>
                        <td class="text-center">
                            <a href="{{ $order->dashboardUrl() }}" class="table-link-secondary">
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full">{{ $order->present()->status === 1 ? "Pending" : "Completed" }}</span>
                            </a>
                        </td>
                        <td class="text-center">

                            <a href="{{ $order->dashboardUrl() }}" class="">{{$order->getDiffMinute($order->created_at)}}</a>
                        </td>
                        <td class="">

                            <a href="{{ $order->dashboardUrl() }}" class="">{!! $order->created_at !!}</a>
                        </td>
                        <td class="text-right">



                            <div>
                                <div class="grid grid-cols-2 gap-4">
                                    <a class="" href="{{ route('dashboard.order_request.edit', $order->id) }}">
                                        @include('dashboard._partials.icon_edit')
                                     </a>
                                    <!-- ... -->
                                    <a class="" href="{{ route('dashboard.order_request.show', $order->id) }}">
                                        @include('dashboard._partials.icon_order')
                                     </a>
                                  </div>


                            </div>
                        </td>
                    </tr>
                @endforeach

                {{-- <x-slot name="footer">{{ $orders->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot> --}}
            </x-table>

            @else
            @include('dashboard._partials.illustration_not_found')
            <p class="text-center my-10">
                @if(request('search'))
                    {{ trans('dashboard/user.list.not_found') }}
                @else
                    {{ trans('dashboard/user.list.empty') }}
                @endif
            </p>
        @endif
    </div>
@endsection

@section('js')
    <script>
        // initial scroll set, used when refresh page and browser auto scroll to bottom
        document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
        // listener when user scroll
        window.addEventListener('scroll', () => {
            document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
        });
    </script>
    {{--@javascript('baseUrl', url()->current())--}}
{{--    <script src="{{ mix('js/dashboard/manifest.js') }}"></script>--}}
{{--    <script src="{{ mix('js/dashboard/vendor.js') }}"></script>--}}
{{--    <script src="{{ mix('js/dashboard/usersDataTable.js') }}"></script>--}}
@endsection
