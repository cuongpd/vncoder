<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<link rel="shortcut icon" href="{{backend('images/favicon.png')}}">
<title>{{$__metaData->title}}</title>
<meta name='description' content='VnCoder CMS'/>
<meta name="robots" content="nofollow"/>
<meta name="copyright" content="VnCoder"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<base href="{{url('/')}}">
{!! $__extraHeaderCSS !!}
<script>const BASE_URL = "{{url('/')}}",  BACKEND_URL = "{{backend('/')}}", CURRENT_URL = "{{$__currentUrl}}", MEDIA_LOADER_URL = "{{backend('media.loader')}}", TIME_NOW = {{TIME_NOW}}, CSRF_TOKEN = "{{csrf_token()}}";</script>
{!! $__extraHeaderJS !!}
{!! $__extraHeader !!}
<script>$.ajaxSetup({headers: {"X-CSRF-TOKEN": "{{csrf_token()}}"}});</script>
@stack('header')