@extends('dashboard._layouts.app')
<?php $pageTitle = trans('dashboard/user.page_title.edit').": ".$user->present()->name; ?>
@section('title', $pageTitle)

@section('breadcrumb')
    @include('dashboard._partials.breadcrumb', ['breadcrumbs' =>
        [
            trans('dashboard/user.page_title.index') => route('dashboard.users.index'),
            $user->present()->name => $user->dashboardUrl()
        ],
        'pageTitle' => trans('dashboard/user.page_title.edit')
    ])
@endsection

@section('content')
    <div class="form-container">
        <div class="flex flex-wrap justify-between px-4 sm:px-0">
            <h1 class="text-2xl">{{ $pageTitle }}</h1>
            @can('delete', $user)
            <button type="button"
                    {{--aria-label="ลบ {{ $user->present()->name }}"--}}
                    {{--v-on:click="deleteModalShowing = true; yoyo(); alert('abc')">--}}
                            class="button button-outline-danger flex items-center"
                    @click="deleteModalShowing = true">
                <svg class="h-4 w-4 fill-current inline-block mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/></svg>
                <span>{{ trans('dashboard/user.page_title.delete') }}</span>
            </button>
            @endcan
        </div>

        <form class="bg-white shadow px-4 py-5 sm:rounded-lg sm:px-6 my-6" method="post"
              {{--enctype="multipart/form-data"--}}
              action="{{ route('dashboard.users.update', $user) }}">
            @csrf
            @method('patch')
            <div>
                @include('dashboard.users._form')
            </div>
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <button type="submit" class="button button-primary flex">
                        @include('dashboard._partials.icon_save')
                        {{ trans('dashboard/user.page_title.edit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <card-modal :showing="deleteModalShowing" @close="deleteModalShowing = false">
        @include('dashboard._partials.delete_modal', [
            'title' => 'ยืนยันการลบ '.$user->name,
            'description' => 'บัญชีผู้ใช้นี้จะถูกลบ',
            'button' => 'ลบบัญชีผู้ใช้ '.$user->name,
            'route' => route('dashboard.users.destroy', $user),
            'showKey' => 'deleteModalShowing'
        ])
    </card-modal>
@endsection

@section('js')
    <script>
      // initial scroll set, used when refresh page and browser auto scroll to bottom
      document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
      // listener when user scroll
      window.addEventListener('scroll', () => {
        document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}px`);
      });
    </script>
    <script src="{{ mix('js/dashboard/manifest.js') }}"></script>
    <script src="{{ mix('js/dashboard/vendor.js') }}"></script>
    <script src="{{ mix('js/dashboard/genericDeleteModel.js') }}"></script>
@endsection
