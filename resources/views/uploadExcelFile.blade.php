<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/uploadExcelPage.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/dropzone.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/uploadExcelPage.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/common/common.css')}} rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Upload Excel file here</div>
                <div>
                    <form action="{{action('UploadFileController@excelUpload')}}" id="dropzone" class="dropzone">
                        <div>
                            <div class="dz-message needsclick">
                                <strong>
                                    Drop files here or click to upload.<br><br>
                                    Only csv files are accepted.
                                </strong>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                    <button class="importButton" onclick="refreshPage()">Add another file</button>
                </div>
            </div>
        </div>


    </body>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src={{ asset('js/dropzone.js')}}></script>
    <script>
        Dropzone.options.dropzone = {
        acceptedFiles: ".csv",
        maxFiles: 1
        }
    </script>
    <script>
    function refreshPage() {
        location.reload();
    }
    </script>


</html>
