<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="icon" href="{{ url('favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>
            @yield('title') | {{ config('app.name') }}
        </title>
    @else
        <title>
            Dashboard | {{ config('app.name') }}
        </title>
    @endif

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Prompt:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
    @yield('css')

    @if(isset($livewire))
        @livewireStyles
    @endif

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.min.js" defer></script>
</head>
<body class="antialiased">
@include('dashboard._partials.toast')
<div class="h-screen flex overflow-hidden bg-gray-100" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
    <!-- Off-canvas menu for mobile -->
    <div class="md:hidden" x-show="sidebarOpen">
        <div class="fixed inset-0 flex z-40">
            <!--
              Off-canvas menu overlay, show/hide based on off-canvas menu state.

              Entering: "transition-opacity ease-linear duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "transition-opacity ease-linear duration-300"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div
                    x-show="sidebarOpen" x-cloak
                    x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0">
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>
            <!--
              Off-canvas menu, show/hide based on off-canvas menu state.

              Entering: "transition ease-in-out duration-300 transform"
                From: "-translate-x-full"
                To: "translate-x-0"
              Leaving: "transition ease-in-out duration-300 transform"
                From: "translate-x-0"
                To: "-translate-x-full"
            -->
            <div
                    x-show="sidebarOpen" x-cloak
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                            @click="sidebarOpen = false"
                            x-show="sidebarOpen"
                            aria-label="Close sidebar">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-shrink-0 flex items-center px-4 text-white">
                    <img class="h-8 w-auto" src="{{ asset('images/logo-white.svg') }}" alt="RMS Dashboard" />
                    {{--<a href="{{ route('dashboard.index') }}"><h3 class="text-2xl">RMS Dashboard</h3></a>--}}
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2">
                        <a href="{{ route('dashboard.index') }}" class="group nav-link-mobile {{ navLinkClass('dashboard.index', 'active', 'inactive') }}">
                            <svg class="mr-4 h-6 w-6 {{ navLinkClass('dashboard.index', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('dashboard/nav.index') }}
                        </a>

                        @can('manage', \App\Models\Transaction::class)
                        <a href="{{ route('dashboard.order_request.index') }}" class="mt-1 group nav-link-mobile {{ navLinkClass('dashboard.order_request', 'active', 'inactive') }}">
                            <svg class="mr-4 h-6 w-6 {{ navLinkClass('dashboard.order_request', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            {{ __('dashboard/nav.orders') }}
                        </a>
                    @endcan

                        @can('manage', \App\Models\User::class)
                        <a href="{{ route('dashboard.users.index') }}" class="mt-1 group nav-link-mobile {{ navLinkClass('dashboard.users', 'active', 'inactive') }}">
                            <svg class="mr-4 h-6 w-6 {{ navLinkClass('dashboard.users', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            {{ __('dashboard/nav.users') }}
                        </a>
                        @endcan



                        {{--<a href="#" class="mt-1 group nav-link-mobile {{ navLinkClass('dashboard.reports', 'active', 'inactive') }}">--}}
                            {{--<svg class="mr-4 h-6 w-6 {{ navLinkClass('dashboard.reports', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>--}}
                            {{--</svg>--}}
                            {{--Reports--}}
                        {{--</a>--}}
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0 bg-gray-800">
        <div class="flex flex-col w-64">
            <div class="flex items-center h-16 flex-shrink-0 px-4 bg-dark text-white">
                {{--<img class="h-8 w-auto" src="/img/logos/workflow-logo-on-dark.svg" alt="Workflow" />--}}
                <a href="{{ route('dashboard.index') }}">
                    <img class=""src="{{ asset('images/logo-white.svg') }}" alt="RMS Dashboard">
                    {{--<h1 class="sr-only">RMS Dashboard</h1>--}}
                </a>
                <h5 class="mt-1 text-center text-3xl leading-9 font-bold text-black-100">
                  RMS
                </h5>
            </div>
            <div class="h-0 flex-1 flex flex-col overflow-y-auto">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <nav class="flex-1 px-2 py-4 dark:bg-slate-800">
                    <a href="{{ route('dashboard.index') }}" class="group nav-link {{ navLinkClass('dashboard.index', 'active', 'inactive') }}">
                        <svg class="mr-3 h-6 w-6 {{ navLinkClass('dashboard.index', 'text-blue-300', 'text-blue-400') }}

                        group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('dashboard/nav.index') }}
                    </a>
                    @can('manage', \App\Models\Transaction::class)
                    <a href="{{ route('dashboard.order_request.index') }}" class="mt-1 group nav-link-mobile {{ navLinkClass('dashboard.order_request', 'active', 'inactive') }}">
                        <svg class="mr-4 h-6 w-6 {{ navLinkClass('dashboard.order_request', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        {{ __('dashboard/nav.orders') }}
                    </a>
                    @endcan

                    @can('manage', \App\Models\User::class)
                    <a href="{{ route('dashboard.users.index') }}" class="mt-1 group nav-link {{ navLinkClass('dashboard.users', 'active', 'inactive') }}">
                        <svg class="mr-3 h-6 w-6 {{ navLinkClass('dashboard.users', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        {{ __('dashboard/nav.users') }}
                    </a>
                    @endcan

                    {{--<a href="#" class="mt-1 group nav-link {{ navLinkClass('dashboard.reports', 'active', 'inactive') }}">--}}
                        {{--<svg class="mr-3 h-6 w-6 {{ navLinkClass('dashboard.reports', 'text-blue-300', 'text-blue-400') }} group-hover:text-blue-300 group-focus:text-blue-300 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                            {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>--}}
                        {{--</svg>--}}
                        {{--Reports--}}
                    {{--</a>--}}
                </nav>
            </div>
        </div>
    </div>
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative flex-shrink-0 flex h-16 bg-white shadow">
            <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden"
                    @click="sidebarOpen = true"
                    aria-label="Open sidebar">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    {{--<form class="w-full flex md:ml-0" action="#" method="GET">--}}
                        {{--<label for="search_field" class="sr-only">{{ __('common.search') }}</label>--}}
                        {{--<div class="relative w-full text-blue-400 focus-within:text-gray-600">--}}
                            {{--<div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">--}}
                                {{--<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">--}}
                                    {{--<path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />--}}
                                {{--</svg>--}}
                            {{--</div>--}}
                            {{--<input id="search_field" class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="{{ __('common.search') }}" type="search" />--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>
                <div class="ml-4 flex items-center md:ml-6">
                    {{--<button class="p-1 text-blue-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500" aria-label="Notifications">--}}
                        {{--<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">--}}
                            {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />--}}
                        {{--</svg>--}}
                    {{--</button>--}}

                    <!-- Profile dropdown -->
                    <div @click.away="userMenuOpen = false" x-data="{ userMenuOpen: false }" class="ml-3 relative">
                        <div>
                            <button @click="userMenuOpen = !userMenuOpen"
                                    class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"
                                    id="user-menu" aria-label="User menu" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full" src="{{ asset('images/user.svg') }}" alt="user avatar" />
                            </button>
                        </div>
                        <!--
                          Profile dropdown panel, show/hide based on dropdown state.

                          Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                          Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div
                                x-show="userMenuOpen" x-cloak
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10">
                            <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical"
                                 aria-labelledby="user-menu">
                                <a href="{{ route('dashboard.settings.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">{{ __('dashboard/nav.account_settings') }}</a>
                                {{--<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Settings</a>--}}
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >{{ __('auth.sign_out') }}</a>
                                <form id="logout-form" action="{{ route('dashboard.logout') }}" method="post" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none" x-data x-init="$el.focus()" tabindex="0" id="app">
            <div class="pt-2 pb-6">
                @section('breadcrumb')
                @show

                @if(config('rms.demo_mode'))
                    <div class="page-container my-4">
                        <div class="rounded-md bg-yellow-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm leading-5 text-yellow-700">
                                        {{ trans('dashboard/demo.text') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @section('content')
                    no content
                @show
            </div>
        </main>
    </div>
</div>

@if(isset($livewire))
    @livewireScripts
@endif

@yield('js')
</body>
</html>
