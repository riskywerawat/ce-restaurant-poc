@extends('dashboard._layouts.app')

@section('content')
    <div class="page-container">
        <h1 class="text-2xl font-semibold text-gray-900">Kitchen Room</h1>
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">


            @foreach($data as $member)

         <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                        room_{{ $loop->index+1 }}
                    </dt>
                    <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                        {{ $member['count'] }} Orders
                    </dd>
                 @foreach ( $member['order'] as $order )
                 <li class="" >

                    <div class="flex align-middle flex-row justify-between">
                        <div class="">

                        </div>
                        <div class="">
                            <p class="text-md text-black">{{$order->name}}</p>
                        </div>
                       x {{$order->quantity}}
                    </div>
                    <hr class="mt-1"/>
                </li>
                 @endforeach

                </dl>
            </div>
        </div>
            @endforeach
        </div>
    </div>


    <div class="page-container mt-5">
        <!-- Replace with your content -->
        <div class="py-5">
            <div class="flex items-baseline">
                <h1 class="text-2xl mb-4">Latest 10 Orders</h1>
                <a href="{{ route('dashboard.order_request.index') }}" class="link ml-2 text-sm">View all</a>
            </div>
            @include('dashboard.order_request._list_dump')
        </div>
        <!-- /End replace -->
    </div>
@endsection
