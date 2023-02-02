@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/user.page_title.index'); ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb')
@endsection

@section('content')
    <div class="page-container">
        <div class="block sm:flex items-baseline justify-between">
            <h1 class="text-2xl">
                @if(request('search'))
                    {{ trans('dashboard/user.list.search_results') }}: {{ request('search') }} {{--@if($users->total() > 0)<span class="text-sm">{{ $users->total() }} บัญชี</span>@endif--}}
                @else
                    {{ $pageTitle }} {{--<span class="text-sm">{{ $users->total() }} บัญชี</span>--}}
                @endif
            </h1>
            @can('create', App\Models\User::class)
            <a href="{{ route('dashboard.users.create') }}" class="button text-white bg-gray-700 inline-flex items-center">
            <svg class="fill-current w-4 h-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11 9V5H9v4H5v2h4v4h2v-4h4V9h-4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"/></svg>
            {{ trans('dashboard/user.page_title.create') }}</a>
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
        @if(count($users) > 0)
            <x-table>
                <x-slot name="header">
                    <tr>
                        <th class="text-left">
                            {{ trans('dashboard/user.form.name') }}
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/user.form.email') }}
                        </th>
                        <th class="text-left">
                            {{ trans('dashboard/user.form.role') }}
                        </th>
                        <th class=""></th>
                    </tr>
                </x-slot>

                @foreach($users as $index => $user)
                    <tr class="">
                        <td class="">
                            <a href="{{ $user->dashboardUrl() }}" class="table-link-primary">{{ $user->present()->name }}</a>
                        </td>
                        <td class="">
                            <a href="{{ $user->dashboardUrl() }}" class="table-link-secondary">{{ $user->present()->email }}</a>
                        </td>
                        <td class="">
                            <a href="{{ $user->dashboardUrl() }}" class="">{!! $user->present()->roleBadge !!}</a>
                        </td>
                        <td class="text-right">
                            @can('update', $user)
                                <a href="{{ $user->dashboardUrlEdit() }}" class="link">{{ __('common.edit') }}</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach

                <x-slot name="footer">{{ $users->onEachSide(1)->links('dashboard._partials.pagination_full') }}</x-slot>
            </x-table>


            {{--<div class="flex flex-col mt-4">--}}
                {{--<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">--}}
                    {{--<div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">--}}
                        {{--<table class="min-w-full">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                                    {{--ชื่อ--}}
                                {{--</th>--}}
                                {{--<th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                                    {{--อีเมล--}}
                                {{--</th>--}}
                                {{--<th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                                    {{--Role--}}
                                {{--</th>--}}
                                {{--<th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@foreach($users as $index => $user)--}}
                                {{--<tr class="@if($index % 2 == 0) bg-white @else bg-gray-50 @endif">--}}
                                    {{--<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">--}}
                                        {{--<a href="{{ $user->dashboardUrl() }}">{{ $user->present()->name }}</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">--}}
                                        {{--<a href="{{ $user->dashboardUrl() }}">{{ $user->present()->email }}</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">--}}
                                        {{--<a href="{{ $user->dashboardUrl() }}">{!! $user->present()->roleBadge !!}</a>--}}
                                    {{--</td>--}}
                                    {{--<td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">--}}
                                        {{--@can('update', $user)--}}
                                        {{--<a href="{{ $user->dashboardUrlEdit() }}" class="link">{{ __('common.edit') }}</a>--}}
                                        {{--@endcan--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}

                        {{--</table>--}}
                        {{--{{ $users->onEachSide(1)->links('dashboard._partials.pagination_full') }}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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
