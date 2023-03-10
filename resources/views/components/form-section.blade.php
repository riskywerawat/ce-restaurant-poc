@props(['submit' => null, 'method' => 'post', 'action' => null])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>

            <p class="mt-1 text-sm text-gray-500">
                {{ $description }}
            </p>
        </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form @if($submit)wire:submit.prevent="{{ $submit }}" @elseif($action) action="{{ $action }}" method="{{ $method }}" @endif>
            @if($action)
                @csrf
            @endif
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        {{ $form }}
                    </div>
                </div>

                @if (isset($actions))
                    <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
