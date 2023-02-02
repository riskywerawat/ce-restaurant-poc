@extends('dashboard._layouts.app')
<?php $pageTitle = $orders->present()->name; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' => [trans('dashboard/order_request.page_title.index') => route('dashboard.users.index')]])
@endsection

@section('content')
    <div class="page-container">
        <x-data-card class="mb-6">
            <x-slot name="title">{{ trans('dashboard/order_request.page_title.show') }} {{ $orders->id }}</x-slot>
            <x-slot name="actions">

                    <a class="button text-white bg-gray-700 inline-flex items-center" href="{{ route('dashboard.order_request.edit', $orders) }}">
                        @include('dashboard._partials.icon_edit')
                        {{ __('common.edit') }}</a>

            </x-slot>
            <x-data-item>
                <x-slot name="title">ID</x-slot>
                {{ $orders->id }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/order_request.form.kitchen') }}</x-slot>
                {{ $orders->kitchen }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/order_request.form.status') }}</x-slot>
                {{ $orders->status }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/order_request.form.menu') }}</x-slot>
                {{ $orders->name }}
            </x-data-item>
            <x-data-item>
                <x-slot name="title">{{ trans('dashboard/order_request.form.quantity') }}</x-slot>
                {{ $orders->quantity }}
            </x-data-item>

            <x-data-item>
                <x-slot name="title">Total Price</x-slot>
                <B> {{ $orders->total }} {{ $orders->unit }}</B
            </x-data-item>


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



    </div>
@endsection

@section('js')
@endsection
