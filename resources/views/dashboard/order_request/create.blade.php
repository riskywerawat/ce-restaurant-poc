@extends('dashboard._layouts.app', ['white' => true])
<?php $pageTitle = trans('dashboard/order_request.page_title.create'); ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' => [trans('dashboard/order_request.page_title.index') => route('dashboard.order_request.index')]])
@endsection

@section('content')
    <div class="form-container mx-auto my-6">
        <h1 class="text-2xl px-4 sm:px-0">{{ $pageTitle }}</h1>
        <form class="bg-white shadow px-4 py-5 sm:rounded-lg sm:px-6 my-6" method="post"
              action="{{ route('dashboard.order_request.create') }}">
            @csrf
            <div>
                @include('dashboard.order_request._form')
            </div>
            {{--<div class="w-full px-2">--}}
                {{--<button type="submit" class="button button-primary">--}}
                    {{--<svg class="fill-current w-4 h-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/></svg>--}}
                    {{--{{ $pageTitle }}</button>--}}
            {{--</div>--}}
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <button type="submit" class="button text-white bg-gray-700 flex">
                        @include('dashboard._partials.icon_save')
                        {{ $pageTitle }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
{{--    @include('dashboard.shops._upload-photo-script')--}}
@endsection
