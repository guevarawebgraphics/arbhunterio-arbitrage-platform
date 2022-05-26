<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    @section('css')
        {{ Html::style('public/bsbmd/plugins/bootstrap/css/bootstrap.css') }}
        {{ Html::style('public/bsbmd/plugins/node-waves/waves.css') }}
        {{ Html::style('public/bsbmd/plugins/animate-css/animate.css') }}
        {{ Html::style('public/bsbmd/plugins/morrisjs/morris.css') }}
        {{ Html::style('public/bsbmd/css/style.css') }}
        {{ Html::style('public/bsbmd/css/themes/all-themes.css') }}

         <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    @show
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>BSB</b></a>
            <small>Admin BootStrap Based - Material Design</small>
        </div>
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

    @section('script')
        {{Html::script('public/bsbmd/plugins/jquery/jquery.min.js')}}
        {{Html::script('public/bsbmd/plugins/bootstrap/js/bootstrap.js')}}
        {{Html::script('public/bsbmd/plugins/node-waves/waves.js')}}
        {{Html::script('public/bsbmd/plugins/jquery-validation/jquery.validate.js')}}
        {{Html::script('public/bsbmd/js/admin.js')}}
        {{Html::script('public/bsbmd/js/pages/examples/sign-in.js')}}
    @show

</body>

</html>