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
                <div class="col-md-6 text-center">
                    <span class="display-1 d-block">ACCESS RESTRICTED</span>
                    <br>
                    <div class="mb-4 lead">
                        {{  
                            Form::open([
                                'method' => 'POST',
                                'id' => 'form-restricted',
                                'route' => ['site_restricted'],
                                'class' => 'form-horizontal'
                            ])
                        }}
                        <input type="password" id="access_code" name="access_code" class="form-control input-lg" placeholder="Enter access code">
                        @if ($errors->has('access_code'))
                            <span id="access_code-error" class="text-danger">
                                {{ $errors->first('access_code') }}
                            </span>
                            <br>
                        @endif
                        <br>
                        <button type="submit" class="btn btn-sm btn-secondary"><i class="fa fa-angle-right"></i> Submit </button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>