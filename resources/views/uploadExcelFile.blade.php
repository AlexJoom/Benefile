<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/uploadExcel.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/dropzone.css')}} rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Upload Excel file here</div>
                <div>
                    <form action="{{url('/upload')}}" class="dropzone" id="dropzone">
                        <div class="dz-message needsclick">
                            Drop files here or click to upload.<br>
                            (Selected files are <strong>not</strong> actually uploaded.)
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>

            </div>
        </div>
    </body>
    <script src={{ asset('js/dropzone.js')}}></script>
    <script type="text/javascript">
       Dropzone.options.dropzone = {
            accept: function(file, done) {
                console.log(file);
                if (file.type != "image/jpeg" && file.type != "image/png") {
                    done("Error! Files of this type are not accepted");
                }
                else { done(); }
            }
        }
     </script>
</html>
