<!DOCTYPE html>
<html>
    <head>
    <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    @yield('headLinks')
    </head>
    <body>
        <div class="container">
            <div class="content">
                @yield('mainBody')
            </div>
        </div>


    </body>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    @yield('scripts')
</html>
