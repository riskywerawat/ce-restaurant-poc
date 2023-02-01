<div {{ $attributes->merge(['class' => 'bg-white shadow overflow-hidden sm:rounded-lg']) }}>
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex items-center justify-between">
        <div class="flex items-center">
            {{--<a href="{{ $user->photo_optimized }}" target="_blank"><img src="{{ $user->photo_optimized }}" alt="user's avatar" class="w-12 rounded-full mr-4"></a>--}}
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $title }}
            </h3>
            {{--<p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">--}}
            {{--Personal details and application.--}}
            {{--</p>--}}
        </div>
        <div>
            {{ $actions }}
        </div>
    </div>
    <div class="px-4 py-5 sm:p-0">
        <dl>
            {{--<div class="data-list">--}}
            {{--<dd class="text-sm leading-5 font-medium text-gray-500">--}}
            {{--ชื่อ--}}
            {{--</dd>--}}
            {{--<dl><dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"></dl>--}}
            {{--{{ $user->name }}--}}
            {{--</dt>--}}
            {{--</div>--}}
            {{ $slot }}
        </dl>
    </div>
</div>
