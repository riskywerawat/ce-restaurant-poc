@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/bid_request.page_title.show').' #'.$bidRequest->present()->id; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' =>
        [
            // trans('dashboard/bid_request.page_title.index') => route('dashboard.bid_requests.index'),
            trans('dashboard/user.page_title.index') => route('dashboard.users.index'),
            $bidRequest->user->present()->name => $bidRequest->user->dashboardUrl(),
        ]])
@endsection

@section('content')
    <div class="page-container">
        <x-data-card class="mb-6">
            <x-slot name="title">{{ trans('dashboard/bid_request.page_title.show') }} #{{ $bidRequest->id }}</x-slot>
            <x-slot name="actions">
                {{--@can('update', $transaction)--}}
                    {{--<a class="button button-primary flex items-center" href="{{ route('dashboard.transactions.edit', $transaction) }}">--}}
                        {{--@include('dashboard._partials.icon_edit')--}}
                        {{--{{ __('common.edit') }}</a>--}}
                {{--@endcan--}}
            </x-slot>
            <x-data-item>
                <x-slot name="title">ID</x-slot>
                {{ $bidRequest->id }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.status') }}</x-slot>
                {!! $bidRequest->present()->statusBadge !!}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.delivery_date') }}</x-slot>
                {{ $bidRequest->present()->deliveryDate }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.price') }}</x-slot>
                {{ $bidRequest->present()->price }} <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}/MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.quantity') }}</x-slot>
                {{ $bidRequest->present()->quantity }} <span class="text-gray-500 text-xs ml-2">MMBTU</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.total') }}</x-slot>
                <span class="font-bold">{{ money($bidRequest->present()->total) }}</span> <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.fee') }}</x-slot>
                {{ $bidRequest->fee }} %
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.spend') }}</x-slot>
                <span class="font-bold">{{ money($bidRequest->present()->totalWithFee) }}</span> <span class="text-gray-500 text-xs ml-2">{{ trans('common.baht') }}</span>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/bid_request.form.buyer') }}</x-slot>
                <a href="{{ $bidRequest->user->dashboardUrl() }}" class="link">{{ $bidRequest->user->present()->name }}</a>
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ __('common.created_at') }}</x-slot>
                @if($bidRequest->created_at == $bidRequest->updated_at)
                    <time datetime="{{ $bidRequest->present()->createdAtDateTime }}">{{ $bidRequest->present()->createdAt }}</time>
                @else
                    {{ $bidRequest->present()->createdAt }}
                @endif
            </x-data-item>
            @if($bidRequest->created_at != $bidRequest->updated_at)
                <x-data-item>
                    <x-slot name="title">{{ __('common.updated_at') }}</x-slot>
                    <time datetime="{{ $bidRequest->present()->updatedAtDateTime }}">{{ $bidRequest->present()->updatedAt }}</time>
                </x-data-item>
            @endif
        </x-data-card>

        <h2 class="text-xl mb-4">Transactions</h2>
        @include('dashboard.transactions._list_dump')
    </div>
@endsection

@section('js')
@endsection
