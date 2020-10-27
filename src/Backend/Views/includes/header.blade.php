<div class="content-header">
    <div class="content-header-section">
        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-navicon"></i>
        </button>
        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
            <i class="fa fa-search"></i>
        </button>
    </div>
    <div class="content-header-section">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar img-avatar32" src="{{$__userData->avatar}}" alt="Admin {{$__userData->name}}">
                <span class="d-none d-sm-inline-block text-dark">{{$__userData->name}}</span>
                <i class="fa fa-angle-down ml-5"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                <div class="h6 text-center py-10 mb-5 border-b text-uppercase">ADMIN</div>
                <a class="dropdown-item" href="#">
                    <i class="si si-user mr-5"></i> Profile
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_inbox.php">
                    <span><i class="si si-envelope-open mr-5"></i> Inbox</span>
                    <span class="badge badge-primary">3</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="si si-note mr-5"></i> Invoices
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                    <i class="si si-wrench mr-5"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('auth.logout')}}">
                    <i class="si si-logout mr-5"></i> Sign Out
                </a>
            </div>
        </div>
        <button type="button" class="btn btn-circle" id="debugbar-loader">
            <i class="fa fa-bug"></i>&#160 Debug {{$__debugbar}}
        </button>
    </div>
</div>

<div id="page-header-search" class="overlay-header">
    <div class="content-header content-header-fullrow">
        <form action="#" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <!-- Close Search Section -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                        <i class="fa fa-times"></i>
                    </button>
                    <!-- END Close Search Section -->
                </div>
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- END Header Search -->

<!-- Header Loader -->
<!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
<div id="page-header-loader" class="overlay-header bg-primary">
    <div class="content-header content-header-fullrow text-center">
        <div class="content-header-item">
            <i class="fa fa-sun-o fa-spin text-white"></i>
        </div>
    </div>
</div>
<!-- END Header Loader -->

{{--
<div class="header-items">
    <div class="custom-search">
        <form action="{{ request()->url() }}" id="search-form" method="put" accept-charset="utf-8">
        <input type="text" class="search-query" name="_query" placeholder="Search here ..." required="required" value="{{$__query}}">
        <i class="icon-search1" id="submit-query" onclick="document.getElementById('search-form').submit();"></i>
        </form>
    </div>

    @if($__query)
        @push('footer')
            <script src="{{url('core/js/mark.min.js')}}"></script>
            <script>
                const context = document.querySelector(".main-container");
                const instance = new Mark(context);
                instance.mark("{{$__query}}");
            </script>

        @endpush
    @endif

    <ul class="header-actions">

        <li class="dropdown">
            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                <span class="user-name">{{$__userData['name']}}</span>
                <span class="avatar">
                    <img src="{{$__userData['avatar']}}" alt="avatar">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                <div class="header-profile-actions">
                    <div class="header-user-profile">
                        <div class="header-user">
                            <img src="{{$__userData['avatar']}}" alt="Admin {{$__userData['name']}}">
                        </div>
                        <h5>{{$__userData['name']}}</h5>
                        <p>Admin</p>
                    </div>
                    <a href="{{backend('user/profile')}}"><i class="icon-user1"></i> My Profile</a>
                    <a href="{{backend('setting')}}"><i class="icon-settings1"></i> Settings</a>
                    <a href="{{route('auth.logout')}}"><i class="icon-log-out1"></i> Sign Out</a>
                </div>
            </div>
        </li>
    </ul>
</div>
@if (session('message'))
    <div class="notify notify-notes" role="alert">
        <div class="note note-success">
            <div class="content"><strong class="title">Thông báo!</strong>{{session('message')}}</div>
            <button type="button" class="remove"><i class="icon-close"></i></button>
        </div>
    </div>
@endif

--}}
