@extends('dashboard._layouts.app')
<?php $pageTitle = $user->present()->name; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' => [trans('dashboard/user.page_title.index') => route('dashboard.users.index')]])
@endsection

@section('content')
    <div class="page-container">
        <x-data-card class="mb-6">
            <x-slot name="title">{{ trans('dashboard/user.page_title.show') }} {{ $user->name }}</x-slot>
            <x-slot name="actions">
                @can('update', $user)
                    <a class="button button-primary flex items-center" href="{{ route('dashboard.users.edit', $user) }}">
                        @include('dashboard._partials.icon_edit')
                        {{ __('common.edit') }}</a>
                @endcan
            </x-slot>
            <x-data-item>
                <x-slot name="title">ID</x-slot>
                {{ $user->id }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/user.form.name') }}</x-slot>
                {{ $user->name }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/user.form.email') }}</x-slot>
                {{ $user->email }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/user.form.role') }}</x-slot>
                {{ $user->present()->roleText }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/user.security.title') }}</x-slot>
                <form action="{{ route('dashboard.users.reset.password', $user->id) }}" method="post" class="inline-block mr-2">
                    @csrf
                    <button type="submit" class="button button-outline button-small">{{ trans('dashboard/user.security.send_reset_password_email') }}</button>
                </form>
                @if($user->isUser())
                <form action="{{ route('dashboard.users.reset.pin', $user->id) }}" method="post" class="inline-block mr-2">
                    @csrf
                    <button type="submit" class="button button-outline button-small">{{ trans('dashboard/user.security.send_reset_pin_email') }}</button>
                </form>
                @endif
                @if($user->password === null)
                    <span class="inline-block px-4 py-1 text-xs text-orange-800 bg-orange-100 rounded-full font-bold mr-2">Not set up password yet</span>
                @endif
                @if($user->isUser() && $user->pin === null)
                    <span class="inline-block px-4 py-1 text-xs text-orange-800 bg-orange-100 rounded-full font-bold">Not set up PIN yet</span>
                @endif
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ __('common.created_at') }}</x-slot>
                @if($user->created_at == $user->updated_at)
                    <time datetime="{{ $user->present()->createdAtDateTime }}">{{ $user->present()->createdAt }}</time>
                @else
                    {{ $user->present()->createdAt }}
                @endif
            </x-data-item>
            @if($user->created_at != $user->updated_at)
                <x-data-item>
                    <x-slot name="title">{{ __('common.updated_at') }}</x-slot>
                    <time datetime="{{ $user->present()->updatedAtDateTime }}">{{ $user->present()->updatedAt }}</time>
                </x-data-item>
            @endif
        </x-data-card>

        {{--<x-table-advanced>--}}
            {{--<x-slot name="head">--}}
                {{--<x-table.heading sortable>Hey</x-table.heading>--}}
                {{--<x-table.heading sortable>Yo yo</x-table.heading>--}}
            {{--</x-slot>--}}
            {{--<x-slot name="body">--}}
                {{--<x-table.row>--}}
                    {{--<x-table.cell>--}}
                        {{--One--}}
                    {{--</x-table.cell>--}}
                    {{--<x-table.cell>--}}
                        {{--Two--}}
                    {{--</x-table.cell>--}}
                {{--</x-table.row>--}}
            {{--</x-slot>--}}
        {{--</x-table-advanced>--}}

        <h2 class="text-xl mb-4">Transactions</h2>
        @include('dashboard.transactions._list_dump')

        @if(count($bidRequests) || $user->isBuyer())
            <h2 class="text-xl mb-4 mt-6">Bid Requests</h2>
            @include('dashboard.bid_requests._list')
        @endif

        @if(count($askRequests) || $user->isSeller())
            <h2 class="text-xl mb-4 mt-6">Offer Requests</h2>
            @include('dashboard.ask_requests._list')
        @endif
    </div>
@endsection

@section('js')
@endsection
