<!DOCTYPE html>
<html lang="en" class="no-focus">
<head>
    @include('backend::includes.page_begin')
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll">
        <nav id="sidebar">@include('backend::includes.sidebar')</nav>
        <main id="main-container">
            <div class="block-header bg-gray-light" id="title-info">
                <button type="button" class="d-md-none d-lg-none btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle"><i class="fa fa-navicon"></i></button>
                <h2 class="block-title"><strong>{{$__metaData->title}}</strong></h2>
                <div class="block-options">
                    @stack('topMenu')
                </div>
                @if($__showSearchForm)
                <div class="block-options">
                    <form method="PUT" accept-charset="utf-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-input" name="_query" placeholder="Tìm kiếm" value="{{$__query}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
            <div class="content pt-0">
                <div class="block">
                    <div class="block-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <footer id="page-footer" class="opacity-0">
            @include('backend::includes.footer')
        </footer>
    </div>
    @include('backend::includes.page_end')
</body>
</html>