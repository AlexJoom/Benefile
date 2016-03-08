<?php
    $p = 'upload_excel.';
?>

@extends('layouts.mainPanel')

    @section('panel-headLinks')
        <link href={{asset('css/uploadExcel/uploadExcelPage.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/dropzone.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/uploadExcelPage.css')}} rel="stylesheet" type="text/css">
    @stop

    @section('panel-title')
        @lang($p.'upload_excel')
    @stop

    @section('main-window-content')
        <div class="title">Upload Excel file here</div>
        <div>
            <form action="{{url('new-benefiter/uploadCSV')}}" id="dropzone" class="dropzone">
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
    @stop

    @section('panel-scripts')
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
    @stop

