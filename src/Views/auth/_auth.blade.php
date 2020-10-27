
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{$title}}</title>
    <link rel="shortcut icon" href="{{getConfig('favicon')}}">
    <meta content="{{$title}} - VnCoder CMS" name="description" />
    <meta content="Cuong Pham" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="{{core_assets('css/codebase.min.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{core_assets('js/jquery.min.js')}}"></script>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('{{core_assets('images/login.jpg')}}');">
            <div class="row mx-0 bg-black-op">
                <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                    <div class="p-30 invisible" data-toggle="appear">
                        <p class="font-size-h3 font-w600 text-white">
                            Get Inspired and Create.
                        </p>
                        <p class="font-italic text-white-op">
                            Copyright &copy; <span class="js-year-copy"></span> by VnCoder
                        </p>
                    </div>
                </div>
                <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                    <div class="content content-full">
                        <div class="px-30 py-10">
                            <a class="link-effect font-w700" href="{{url('/')}}">
                                <img src="{{getConfig('logo_dark')}}" class="w-75">
                            </a>
                            <h1 class="h3 font-w700 mt-30 mb-10">{{getConfig('name')}}</h1>
                            <h2 class="h5 font-w400 text-muted mb-0">{{$title}}</h2>
                        </div>
                        @if (session('message'))
                            <p class="text-muted text-center">{!! session('message') !!}</p>
                        @endif
                        @includeIf($views)
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script type="text/javascript" src="{{core_assets('js/core.min.js')}}"></script>
<script type="text/javascript" src="{{core_assets('js/app.min.js')}}"></script>
@stack('footer')

</body>
</html>