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
    <link href={{asset('bootstrap-3.3.6/dist/css/bootstrap.min.css')}} rel="stylesheet" type="text/css">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link href={{asset('css/common/mainLayout.css')}} rel="stylesheet" type="text/css">
    <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">

    @yield('panel-headLinks')
</head>
<body id="main-layout">
    <div class="panel-container">
        {{-- User name row --}}
        <div class="no-margin purple-background pos-relative height-6per" id="header">
            @if (Auth::guest())
            {{-- do nothing --}}
            @else
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
            <div class="userName">
                <a href="#" class="white" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                </a>
            </div>
            @endif
        </div>

        <div class="newCont table-display">
            <div class="table-row height-100per">
                {{-- sidebar --}}
                <div class="col-md-2 dark-green-background no-padding table-cell height-100per" id="sidebar">

                    {{-- NGO logo --}}
                    <div class="logo-ngo" id="ngo-logo">
                        <img width="35%" alt="Benefile logo" class="img-responsive" src={{asset('images/logo-praksis.png')}}>
                    </div>

                    {{-- Search bar --}}
                    <div class="" id="search-bar">
                        <div class="">
                            <form>
                                <input type="text" class="searchField dark-green-background" name="search" placeholder="Αναζήτηση ωφελουμένου">
                                <button type="submit" class="glyphicon glyphicon-search searchButton"></button>
                            </form>
                        </div>
                    </div>

                    {{-- Menu --}}
                    <div class="margin-top-60 white" id="menu">
                        <ul id="menu-first-layer">
                            <li id="register-benefiter">
                                <button class="buttonMenu no-padding">Εγγραφή <i class="glyphicon glyphicon-chevron-right"></i></button>
                            </li>
                            <li id="child-1" class="child hide">
                                <a>Νέα εγγραφή</a>
                            </li>
                            <li id="child-2" class="child hide">
                                <a>Φόρτωση αρχείου</a>
                            </li>
                            <li>
                                <a>Αναφορά</a>
                            </li>
                            <li>
                                <a href="{{url('main-panel/users-list')}}">Χρήστες</a>
                            </li>
                            <li>
                                <a href="{{ url('auth/logout') }}">Έξοδος</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Benefile logo --}}
                    <div class="bottomLogo">
                        <img alt="Benefile logo" class="img-responsive" src={{asset('images/BeneFile-logo.png')}}>
                    </div>
                </div>

                {{-- main window --}}
                <div class="col-md-10 table-cell height-100per no-padding" id="main-window">
                    @yield('main-window-content')
                </div>
            </div>
        </div>

    </div>


    <!-- JavaScripts -->
    <script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('bootstrap-3.3.6/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/main-panel/common.js')}}"></script>

    @yield('panel-scripts')
</body>

</html>