<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>MY CMS</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>
        body {
            background: #dedede;
        }
        .page-wrap {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="page-wrap d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <span class="display-1 d-block">@yield('code')</span>
                    <div class="mb-4 lead">@yield('message')</div>
                    <a href="{{ url('/') }}" class="btn btn-link">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>