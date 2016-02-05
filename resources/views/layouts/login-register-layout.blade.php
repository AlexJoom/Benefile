<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    <!-- Fonts -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link href={{asset('bootstrap-3.3.6/dist/css/bootstrap.min.css')}} rel="stylesheet" type="text/css">
    <link href={{asset('css/common/loginRegister.css')}} rel="stylesheet" type="text/css">
    <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
    @yield('log-headLinks')
</head>
<body id="login-register-layout">
    <div class="container-fluid table-display">
    	<div class="row table-row">
    	    <div class="col-md-6 no-float table-cell" id="leftCell">
                <img alt="Benefile logo" class="img-responsive logo-padding" src={{asset('images/BeneFile-Logo.png')}}>
    	    </div>
    		<div class="col-md-6 benfile-back-color no-float table-cell" id="rightCell">
    		    @yield('log-content')
    		</div>
    	</div>
    </div>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    {{--<script src={{asset('bootstrap/js/bootstrap.js')}}></script>--}}
    <script src="{{asset('bootstrap-3.3.6/dist/js/bootstrap.min.js')}}"></script>

    @yield('log-scripts')
</body>

</html>
