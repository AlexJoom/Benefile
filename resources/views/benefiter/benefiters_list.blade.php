@extends('layouts.mainPanel')

<?php
    $p = "benefiters_list.";
?>

@section('panel-headLinks')
    <link href="{{asset('css/main-panel/benefiters-list.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('main-window-content')

    <div class="no-margin pos-relative" id="results-to-activate">
        <div class="display padding-20">
            <table id="usersTable-to-activate" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ΑΡΙΘΜΟΣ ΦΑΚΕΛΟΥ</th>
                    <th>ΟΝΟΜΑ</th>
                    <th>ΕΠΙΘΕΤΟ</th>
                    <th>ΕΠΙΚΟΙΝΩΝΙΑ</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ΑΡΙΘΜΟΣ ΦΑΚΕΛΟΥ</th>
                    <th>ΟΝΟΜΑ</th>
                    <th>ΕΠΙΘΕΤΟ</th>
                    <th>ΕΠΙΚΟΙΝΩΝΙΑ</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($benefiters as $benefiter)
                        <tr>
                            <td>{{ $benefiter['folder_number'] }}</td>
                            <td>{{ $benefiter['name'] }}</td>
                            <td>{{ $benefiter['lastname'] }}</td>
                            <td>{{ $benefiter['telephone'] }}</td>
                            <td>
                                {!! Form::open(array('url' => 'benefiter/'. $benefiter['id'] .'/basic-info', 'method' => 'get')) !!}
                                    {!! Form::hidden('benefiter_id', $benefiter['id']) !!}
                                    {!! Form::submit('Επεξεργασία', array('class' => 'edit-button lighter-green-background')) !!}
                                    @if(\Auth::user()->user_role_id == 1)
                                    <a href="{{ url('/benefiter/'.$benefiter['id'].'/delete') }}" class="display-inline margin-left-10px gray" title="@lang($p."delete_benefiter")"><span class="glyphicon glyphicon-trash"></span></a>
                                    @endif
                                {!! Form::close() !!}
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
    <script src="{{asset('js/main-panel/selectBenefitersListInMainPanel.js')}}"></script>
@stop
