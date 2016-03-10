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
                            <h1 class="dropzone-title">@lang($p.'upload_here')</h1>
                        </div>
                        <div class="row button-row-style">
                            <div class="dz-message needsclick dropzone-button-custom-style">
                                <strong>@lang($p.'choose-file')</strong>
                            </div>
                        </div>
                    </div>

                    {{ csrf_field() }}
                </form>
            </div>
        </div>

        {{-- Progress Bar --}}
        {{--<div class="row margin-0per-5per-0per-5per">--}}
            {{--<div class="col-md-12">--}}
                {{--<div class="row progress progress-custom">--}}
                <?php
                     // $percent = 100;
                    //  echo '<div class="progress-bar progress-bar-custom progress-bar-success" role="progressbar" aria-valuenow="70" ';
                    //  echo 'aria-valuemin="0" aria-valuemax="100" style="width:'. $percent .'%;">';
                    //  echo $percent.'% Complete (success)';
                    //  echo '</div>';
                  ?>
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{-- Status messages --}}
        <div class="padding-left-right-15 success-message">
            @lang($p.'success_upload')
        </div>
        <div class="padding-left-right-15 unsuccess-message">
            @lang($p.'unsuccess_upload')
        </div>

        <div class="row">
            <div class="col-md-12 text-align-center">
                <button class="importButton btn btn-warning" onclick="refreshPage()">@lang($p.'add-another')</button>
            </div>
        </div>
    @stop

    @section('panel-scripts')
        <script src={{ asset('js/dropzone.js')}}></script>
        <script src="{{asset('js/records/selectImportCSV.js')}}"></script>
        <script src="{{asset('js/importCSV/importCSV.js')}}"></script>
    @stop

