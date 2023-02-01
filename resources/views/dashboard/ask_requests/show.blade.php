@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/ask_request.page_title.show').' #'.$askRequest->present()->id; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' =>
        [
            // trans('dashboard/ask_request.page_title.index') => route('dashboard.ask_requests.index'),
            trans('dashboard/user.page_title.index') => route('dashboard.users.index'),
            $askRequest->user->present()->name => $askRequest->user->dashboardUrl(),
        ]])
@endsection

@section('content')
    <div class="page-container">
        <x-data-card class="mb-6">
            <x-slot name="title">{{ trans('dashboard/ask_request.page_title.show') }} #{{ $askRequest->id }}</x-slot>
            <x-slot name="actions">
                {{--@can('update', $transaction)--}}
                    {{--<a class="button button-primary flex items-center" href="{{ route('dashboard.transactions.edit', $transaction) }}">--}}
                        {{--@include('dashboard._partials.icon_edit')--}}
                        {{--{{ __('common.edit') }}</a>--}}
                {{--@endcan--}}
            </x-slot>
            <x-data-item>
                <x-slot name="title">ID</x-slot>
                {{ $askRequest->id }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.status') }}</x-slot>
                {!! $askRequest->present()->statusBadge !!}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.delivery_date') }}</x-slot>
                {{ $askRequest->present()->deliveryDate }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.price') }}</x-slot>
                {{ $askRequest->present()->price }} <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}/MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.quantity') }}</x-slot>
                {{ $askRequest->present()->quantity }} <span class="text-gray-500 text-xs ml-2">MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.total') }}</x-slot>
                <span class="font-bold">{{ money($askRequest->present()->total) }}</span> <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.fee') }}</x-slot>
                {{ $askRequest->fee }} %
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.received') }}</x-slot>
                <span class="font-bold">{{ money($askRequest->present()->totalWithFee) }}</span> <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/ask_request.form.seller') }}</x-slot>
                <a href="{{ $askRequest->user->dashboardUrl() }}" class="link">{{ $askRequest->user->present()->name }}</a>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ __('common.created_at') }}</x-slot>
                @if($askRequest->created_at == $askRequest->updated_at)
                    <time datetime="{{ $askRequest->present()->createdAtDateTime }}">{{ $askRequest->present()->createdAt }}</time>
                @else
                    {{ $askRequest->present()->createdAt }}
                @endif
            </x-data-item>
            @if($askRequest->created_at != $askRequest->updated_at)
                <x-data-item>
                    <x-slot name="title">{{ __('common.updated_at') }}</x-slot>
                    <time datetime="{{ $askRequest->present()->updatedAtDateTime }}">{{ $askRequest->present()->updatedAt }}</time>
                </x-data-item>
            @endif
        </x-data-card>

        <h2 class="text-xl mb-4">Transactions</h2>
        @include('dashboard.transactions._list_dump')
    </div>
@endsection

@section('js')
@endsection
