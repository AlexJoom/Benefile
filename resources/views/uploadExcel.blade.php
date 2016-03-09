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
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('new-benefiter/uploadCSV')}}" id="dropzone" class="dropzone margin-5per custom-style relPos">
                    <div class="col-md-12 adsPos-height100per">
                        <div class="row title-row-style">
                            <h1 class="dropzone-title">Σύρετε εδώ το αρχείο προς φόρτωση</h1>
                        </div>
                        <div class="row button-row-style">
                            <div class="dz-message needsclick dropzone-button-custom-style">
                                <strong>Επιλέξτε αρχείο</strong>
                            </div>
                        </div>
                    </div>

                    {{ csrf_field() }}
                </form>
                <button class="importButton" onclick="refreshPage()">Add another file</button>
            </div>
        </div>
    @stop

    @section('panel-scripts')
        <script src={{ asset('js/dropzone.js')}}></script>
        <script src="{{asset('js/records/selectImportCSV.js')}}"></script>
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

