@extends('dashboard._layouts.app', ['livewire' => true])
<?php $pageTitle = trans('dashboard/site_settings.title'); ?>
@section('title', $pageTitle)

@section('content')
{{--    @include('dashboard._partials.breadcrumb', ['breadcrumbs' => ['บัญชีผู้ใช้ทั้งหมด' => route('dashboard.users.index')]])--}}
    <div class="form-container">
        <x-form-section action="{{ route('dashboard.site_settings.update') }}">
            <x-slot name="title">
                {{ __('dashboard/site_settings.form.trade_fee.title') }}
            </x-slot>
            <x-slot name="description">
                {{ __('dashboard/site_settings.form.trade_fee.subtitle') }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-2">
                    <x-form-label for="bid_percent">{{ __('dashboard/site_settings.form.trade_fee.bid_percent') }}</x-form-label>
                    <x-form-input id="bid_percent" type="number" step="0.01" name="bid_percent"
                                  value="{{ $tradeFeeSetting->setting['bid_percent'] }}"
                                  suffix="%" class="pr-7"
                    />
                    <x-form-input-error for="bid_percent" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <x-form-label for="ask_percent">{{ __('dashboard/site_settings.form.trade_fee.ask_percent') }}</x-form-label>
                    <x-form-input id="ask_percent" type="number" step="0.01" name="ask_percent"
                                  value="{{ $tradeFeeSetting->setting['ask_percent'] }}"
                                  suffix="%" class="pr-7"
                    />
                    <x-form-input-error for="ask_percent" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-form-button>
                    {{ __('common.save') }}
                </x-form-button>
            </x-slot>
        </x-form-section>

        <x-form-section-divider />

        <div class="mt-10 sm:mt-0">
            @livewire('dashboard.settings.update-price-limit')
        </div>
    </div>
@endsection

{{--@section('js')--}}
    {{--@include('dashboard.shops._upload-photo-script')--}}
{{--@endsection--}}
