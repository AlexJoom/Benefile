<?php
    $p = 'upload_excel.';
?>

@extends('layouts.mainPanel')

    @section('panel-headLinks')
        <link href={{asset('css/uploadExcel/uploadExcelPage.css')}} rel="stylesheet" type="text/css">
        <link href={{asset('css/uploadExcel/dropzone.css')}} rel="stylesheet" type="text/css">
        <link href="{{ asset('css/records/validation_errors.css') }}" rel="stylesheet" type="text/css">
    @stop

    @section('panel-title')
        @lang($p.'upload_excel')
    @stop

    @section('main-window-content')
        {{-- Dropzone --}}
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12">
                    <form action="{{url('new-benefiter/uploadCSV')}}" id="dropzone" class="dropzone margin-5per custom-style relPos">
                        <div class="col-xs-12 adsPos-height100per">
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

            {{-- Progress Bar (NOT FOR NOW) --}}
            {{--<div class="row margin-0per-5per-0per-5per">--}}
                {{--<div class="col-xs-12">--}}
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

            <div>
                <ul id="error-list">
                </ul>
            </div>

            {{-- Refresh button --}}
            <div class="row">
                <div class="col-xs-12 text-align-center">
                    <button class="importButton btn btn-warning" onclick="refreshPage()">@lang($p.'add-another')</button>
                </div>
            </div>

            {{-- Imported files info --}}
            @if(count($importedCSVFiles_basic_info) != 0)
            <div class="row margin-top-20 margin-bottom-100">
                <h3 class="text-align-center">@lang($p.'already-uploaded')</h3>
                <div class="col-xs-6 col-centered">
                     <table id="imported-info" style="width:100%">
                      <thead>
                          <tr>
                              <th>Α/Α</th>
                              <th>@lang($p.'filename')</th>
                              <th>@lang($p.'import-date')</th>
                          </tr>
                      </thead>
                      <tbody>
                          @for($i=0 ; $i<count($importedCSVFiles_basic_info) ; $i++)
                              <tr>
                                  <td>{{ $i+1 }}</td>
                                  <td>{{ $importedCSVFiles_basic_info[$i]['csv_name'] }}</td>
                                  <td>{{ substr($importedCSVFiles_basic_info[$i]['created_at'], 0, -8) }}</td>
                              </tr>
                          @endfor
                      </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    @stop

    @section('panel-scripts')
        <script src={{ asset('js/dropzone.js')}}></script>
        <script src="{{asset('js/records/selectImportCSV.js')}}"></script>
        <script src="{{asset('js/importCSV/importCSV.js')}}"></script>
    @stop

