<?php
    $p = 'users/users-list.';
?>
@extends('layouts.mainPanel')

@section('panel-title')
    @lang($p.'users_list')
@endsection

@section('main-window-content')
    {{-- actions refering to users --}}
    <div class="no-margin light-green-background width-100-percent" id="actions">
        <div class="width-100-percent row">
            <div class="col-md-4 userStatus">
                <div id="to-activate" class="height-70 active white bold pink-border-bottom">
                   @lang($p.'to_activate')
                </div>
            </div>

            <div class="col-md-4 userStatus">
                <div id="active" class="height-70">
                    @lang($p.'active')
                </div>
            </div>

            <div class="col-md-4 userStatus">
                <div id="inactive" class="height-70">
                    @lang($p.'deactivated')
                </div>
            </div>
        </div>
    </div>



    {{-- TO BE ACTIVATED USERS --}}
    <div class="no-margin pos-relative" id="results-to-activate">
        <div class="display padding-20">
            <table id="usersTable-to-activate" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    @if($user['activation_status'] == 0 && $user['is_deactivated'] == 0)
                        <tr>
                            <td>{{ $user['lastname'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            @if($user['user_role_id'] == 2)
                                <td>{{$user['role']['role']}} ({{$user['subrole']['subrole']}})</td>
                            @else
                                <td>{{$user['role']['role']}}</td>
                            @endif
                            <td>{{substr($user['created_at'], 0,11)}}</td>

                            <td>
                                <form method="post" action="{{action('MainPanel\UsersController@UserStatusUpdate')}}">
                                    <input type="hidden" name="user_id" value={{$user['id']}}>
                                    <button class="lighter-green-background">@lang($p.'activation')</button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ACTIVE USERS --}}
    <div class="no-margin pos-relative" id="results-active">
        <div class="display padding-20">
            <table id="usersTable-active" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    @if($user['activation_status'] == 1 && $user['is_deactivated'] == 0)
                        <tr>
                            <td>{{ $user['lastname'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            @if($user['user_role_id'] == 2)
                                <td>{{$user['role']['role']}} ({{$user['subrole']['subrole']}})</td>
                            @else
                                <td>{{$user['role']['role']}}</td>
                            @endif
                            <td>{{substr($user['created_at'], 0,11)}}</td>
                            <td>
                                <form method="post" action="{{action('MainPanel\UsersController@UserStatusUpdate')}}">
                                    <input type="hidden" name="user_id" value={{$user['id']}}>
                                    <button class="light-red-background">@lang($p.'deactivation')</button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- DEACTIVATED USERS --}}
    <div class="no-margin pos-relative" id="results-deactiveted">
        <div class="display padding-20">
            <table id="usersTable-deactivated" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>@lang($p.'lastname')</th>
                    <th>@lang($p.'name')</th>
                    <th>@lang($p.'email')</th>
                    <th>@lang($p.'role')</th>
                    <th>@lang($p.'register_date')</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    @if($user['activation_status'] == 0 && $user['is_deactivated'] == 1)
                        <tr>
                            <td>{{ $user['lastname'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            @if($user['user_role_id'] == 2)
                                <td>{{$user['role']['role']}} ({{$user['subrole']['subrole']}})</td>
                            @else
                                <td>{{$user['role']['role']}}</td>
                            @endif
                            <td>{{substr($user['created_at'], 0,11)}}</td>
                            <td>
                                <form method="post" action="{{action('MainPanel\UsersController@UserStatusUpdate')}}">
                                    <input type="hidden" name="user_id" value={{$user['id']}}>
                                    <button class="lighter-green-background">@lang($p.'activation')</button>
                                    {{ csrf_field() }}
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('panel-scripts')
    <script src="{{asset('js/main-panel/users-list.js')}}"></script>
@stop
