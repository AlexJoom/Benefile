<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href={{asset('css/common/mainLayout.css')}} rel="stylesheet" type="text/css">
    <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
    @yield('log-headLinks')
</head>
<body id="main-layout">
    <div class="panel-container">
        {{-- User name row --}}
        <div class="row no-margin purple-background height-6per" id="header">
            @if (Auth::guest())
            {{-- do nothing --}}
            @else
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            @endif
        </div>

        {{-- sidebar --}}
        <div class="newCont">
            <div class="row table-row">
                {{-- sidebar --}}
                <div class="col-sm-2 dark-green-background no-float" id="sidebar">
                    dgheg
                </div>
                {{-- main window --}}
                <div class="col-sm-10 no-float" id="main-window">
                                {{-- actions refering to users --}}

                                {{-- columns with details --}}

                                {{-- results list --}}
                        <h2>wergfwt24f2</h2>
                </div>
            </div>
        </div>

    </div>


    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    @yield('log-scripts')
</body>

</html>
