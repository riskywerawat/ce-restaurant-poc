@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/transaction.page_title.show').' #'.$transaction->present()->id; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' =>
    [trans('dashboard/transaction.page_title.index') => route('dashboard.transactions.index')]])
@endsection

@section('content')
    <div class="page-container">
        <x-data-card>
            <x-slot name="title">{{ trans('dashboard/transaction.page_title.show') }} #{{ $transaction->id }}</x-slot>
            <x-slot name="actions">
                {{--@can('update', $transaction)--}}
                    {{--<a class="button button-primary flex items-center" href="{{ route('dashboard.transactions.edit', $transaction) }}">--}}
                        {{--@include('dashboard._partials.icon_edit')--}}
                        {{--{{ __('common.edit') }}</a>--}}
                {{--@endcan--}}
            </x-slot>
            <x-data-item>
                <x-slot name="title">ID</x-slot>
                {{ $transaction->id }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.delivery_date') }}</x-slot>
                {{ $transaction->present()->deliveryDate }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.price') }}</x-slot>
                {{ $transaction->present()->price }} <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}/MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.quantity') }}</x-slot>
                {{ $transaction->present()->quantity }} <span class="text-gray-500 text-xs ml-2">MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.total') }}</x-slot>
                <span class="font-bold">{{ money($transaction->present()->total) }}</span> <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.buyer') }}</x-slot>
                <a href="{{ $transaction->bidRequest->user->dashboardUrl() }}" class="link text-lg">{{ $transaction->present()->buyer }}</a>
                <div class="text-xs">
                    <div>Fee: {{ $transaction->bid_fee }} % <span class="text-gray-500">({{ money($transaction->present()->buyerFee) }}) {{ trans('common.baht') }}</span></div>
                    {{ trans('dashboard/transaction.spend') }} {{ money($transaction->present()->buyerSpend) }} {{ trans('common.baht') }}
                </div>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/transaction.form.seller') }}</x-slot>
                <a href="{{ $transaction->askRequest->user->dashboardUrl() }}" class="link text-lg">{{ $transaction->present()->seller }}</a>
                <div class="text-xs">
                    <div>Fee: {{ $transaction->ask_fee }} % <span class="text-gray-500">({{ money($transaction->present()->sellerFee) }}) {{ trans('common.baht') }}</span></div>
                    {{ trans('dashboard/transaction.received') }} {{ money($transaction->present()->sellerReceived) }} {{ trans('common.baht') }}
                </div>
            </x-data-item>
            <x-data-item>
                <x-slot name="title"><span class="capitalize">{{ trans('dashboard/bid_request.model') }}</span></x-slot>
                <a href="{{ $transaction->bidRequest->dashboardUrl() }}" class="link">#{{ $transaction->bidRequest->present()->id }}</a>
            </x-data-item>
            <x-data-item>
                <x-slot name="title"><span class="capitalize">{{ trans('dashboard/ask_request.model') }}</span></x-slot>
                <a href="{{ $transaction->askRequest->dashboardUrl() }}" class="link">#{{ $transaction->askRequest->present()->id }}</a>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ __('common.created_at') }}</x-slot>
                @if($transaction->created_at == $transaction->updated_at)
                    <time datetime="{{ $transaction->present()->createdAtDateTime }}">{{ $transaction->present()->createdAt }}</time>
                @else
                    {{ $transaction->present()->createdAt }}
                @endif
            </x-data-item>
            @if($transaction->created_at != $transaction->updated_at)
                <x-data-item>
                    <x-slot name="title">{{ __('common.updated_at') }}</x-slot>
                    <time datetime="{{ $transaction->present()->updatedAtDateTime }}">{{ $transaction->present()->updatedAt }}</time>
                </x-data-item>
            @endif
        </x-data-card>
    </div>
@endsection

@section('js')
@endsection
