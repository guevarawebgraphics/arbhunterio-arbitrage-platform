<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="{!! $seo_meta['description'] !!}">
    <meta name="author" content="{!! $seo_meta['author'] !!}">
    <meta name="robots" content="{!! $seo_meta['robots'] !!}">
    <meta name="keywords" content="{!! $seo_meta['keywords'] !!}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{!! $seo_meta['title'] !!}">
    <meta property="og:description" content="{!! $seo_meta['description'] !!}">
    <meta property="og:url" content="{!! url('') !!}">
    <meta property="og:site_name" content="{!! $seo_meta['name'] !!}">
    <title>{!! $seo_meta['title'] !!}</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Bootstrap Core Css -->
    @section('css')
        {{ Html::style('public/bsbmd/plugins/bootstrap/css/bootstrap.css') }}
        {{ Html::style('public/bsbmd/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}
        {{ Html::style('public/bsbmd/plugins/node-waves/waves.css') }}
        {{ Html::style('public/bsbmd/plugins/animate-css/animate.css') }}
        {{ Html::style('public/bsbmd/plugins/morrisjs/morris.css') }}
        {{ Html::style('public/bsbmd/css/style.css') }}
        {{ Html::style('public/bsbmd/css/themes/all-themes.css') }}
        {{ Html::style('public/bsbmd/plugins/bootstrap-select/css/bootstrap-select.css') }}

         <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
 
    @show

    @yield('extra-css')
</head>

<body class="theme-red">
    @include('admin.layouts.partials.loader')
    <div class="overlay"></div>
    @include('admin.layouts.partials.header')
    @include('admin.layouts.partials.sidebar')

    <section class="content">
        @yield('content')
    </section>
    <script>
        var sBaseURI = '{{ url('/') }}';
        var sAdminBaseURI = '{{ url('admin') }}';
    </script>
    
    @section('script')
        {{Html::script('public/bsbmd/plugins/jquery/jquery.min.js')}}
        {{Html::script('public/bsbmd/plugins/bootstrap/js/bootstrap.js')}}
        {{Html::script('public/bsbmd/plugins/bootstrap-select/js/bootstrap-select.js')}}
        {{Html::script('public/bsbmd/plugins/jquery-slimscroll/jquery.slimscroll.js')}}
        {{Html::script('public/bsbmd/plugins/node-waves/waves.js')}}
        {{Html::script('public/bsbmd/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
    @show    
    @yield('extra-script')
    @section('script-bottom')
        {{Html::script('public/bsbmd/js/admin.js')}}
        {{Html::script('public/bsbmd/js/demo.js')}}
    @show

    @if (session()->has('flash_message'))
        <script>
            swal({
                title: "{!! session('flash_message.title') !!}",
                text: "{!! session('flash_message.message') !!}",
                type: "{!! session('flash_message.type') !!}",
                html: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
            }, function () {

            });
        </script>
    @endif
</body>

</html>