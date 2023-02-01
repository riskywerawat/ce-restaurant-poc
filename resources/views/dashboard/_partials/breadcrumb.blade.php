<div class="page-container mt-4 mb-4 breadcrumb">
    @include('dashboard._partials.breadcrumb_home')
    @if(isset($breadcrumbs))
    @foreach($breadcrumbs as $title => $link)
        @include('dashboard._partials.breadcrumb_item', ['link' => $link, 'name' => $title])
    @endforeach
    @endif
    @include('dashboard._partials.breadcrumb_separator')
    <span class="text-gray-600">{{ $pageTitle }}</span>
</div>
