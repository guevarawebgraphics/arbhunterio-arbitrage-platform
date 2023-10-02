<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
        <link rel="icon" type="image/x-icon" href="public/my_cms_default/assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('public/my_cms_default/css/styles.css') }}" rel="stylesheet" />
        <style>
            form .invalid{
                border: 1px solid #a70000;
                color: #a70000;
            }
            
            ul.errors{
                background-color: #eee;
                padding: 10px;
                color: #a70000;
                list-style-position: inside;
                display: inline-block;
                width: 100%;        
            }
            
            .flash-success{
                background-color: #eee;
                color: #08a700;
                padding: 10px;
                display: inline-block;
                width: 100%;            
            }
        </style>
    </head>
    <body class="d-flex flex-column h-100">

        <main class="flex-shrink-0">
            @include('front.layouts.sections.header')
            @yield('content')
        </main>
        @include('front.layouts.sections.footer')
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('public/my_cms_default/js/scripts.js') }}"></script>
    </body>
</html>
