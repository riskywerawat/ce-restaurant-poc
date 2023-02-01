@extends('dashboard._layouts.app')

@section('content')
    <div class="page-container">
        <h1 class="text-2xl font-semibold text-gray-900">Kitchen Room</h1>
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dl>
                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                           Room 1
                        </dt>
                        <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                            {{ numberComma($bidRequestsCount) }}
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dl>
                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                            Room 2
                        </dt>
                        <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                            {{ numberComma($askRequestsCount) }}
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dl>
                        <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                            Room 3
                        </dt>
                        <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                            {{ numberComma($transactionsCount) }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="page-container mt-5">
        <!-- Replace with your content -->
        <div class="py-5">
            <div class="flex items-baseline">
                <h1 class="text-2xl mb-4">Latest Orders</h1>
                <a href="{{ route('dashboard.transactions.index') }}" class="link ml-2 text-sm">View all</a>
            </div>
            @include('dashboard.transactions._list_dump')
        </div>
        <!-- /End replace -->
    </div>
@endsection
