<div class="sidebar-content">
    <div class="content-header content-header-fullrow pt-2">
        <div class="content-header-section sidebar-mini-visible-b">
            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                <span class="text-dual-primary-dark">V</span><span class="text-primary">C</span>
            </span>
        </div>
        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                <i class="fa fa-times text-danger"></i>
            </button>
            <div class="content-header-item">
                <a class="link-effect font-w700" href="{{backend('/')}}">
                    <i class="si si-fire text-primary"></i>
                    <span class="font-size-xl text-dual-primary-dark">VnCoder</span><span class="font-size-xl text-primary">CMS</span>
                </a>
            </div>
        </div>
    </div>

    <div class="content-side content-side-full content-side-user px-10 align-parent">
        <div class="sidebar-mini-visible-b align-v animated fadeIn">
            <img class="img-avatar img-avatar32" src="{{$__userData->avatar}}" alt="">
        </div>
        <div class="sidebar-mini-hidden-b text-center">
            <a class="img-link" href="#">
                <img class="img-avatar" src="{{$__userData->avatar}}" alt="">
            </a>
            <ul class="list-inline mt-10">
                <li class="list-inline-item">
                    <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="#">{{$__userData->name}}</a>
                </li>
                <li class="list-inline-item">
                    <span id="debugbar-loader" title="Debug Mode"><i class="fa fa-bug"></i>&#160{{$__debugbar}}</span>
                </li>
                <li class="list-inline-item">
                    <a class="link-effect text-dual-primary-dark" title="Đăng xuất" href="{{route('auth.logout')}}"><i class="si si-power"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content-side content-side-full pt-0">
        <ul class="nav-main">
            @foreach($__backendMenu as $menus)
                @if(isset($menus['heading']))
                    <li class="nav-main-heading">{!! $menus['heading'] !!}</li>
                @endif

                @if($menus['submenu'])
                    <li @if($menus['active']) class="open" @endif>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="{{$menus['icon']}}"></i><span class="sidebar-mini-hide">{{$menus['name']}}</span>
                        </a>
                        <ul>
                            @foreach($menus['submenu'] as $menu)
                                <li>
                                    <a href="{{$menu['url']}}" @if(isset($menu['active'])) class="active" @endif>
                                        {{$menu['name']}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{$menus['url']}}" @if($menus['active']) class="active" @endif>
                            @if($menus['icon']) <i class="{{$menus['icon']}}"></i> @endif
                            <span class="menu-text">{{$menus['name']}}</span>
                        </a>
                    </li>
                @endif

            @endforeach
        </ul>
    </div>
</div>