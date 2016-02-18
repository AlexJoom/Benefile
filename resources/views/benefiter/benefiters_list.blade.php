@extends('layouts.mainPanel')

@section('main-window-content')

    <div class="no-margin pos-relative" id="results-to-activate">
        <div class="display padding-20">
            <table id="usersTable-to-activate" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ΕΠΩΝΥΜΟ</th>
                    <th>ΟΝΟΜΑ</th>
                    <th>ΡΟΛΟΣ</th>
                    <th>ΗΜ. ΕΓΓΡΑΦΗΣ</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ΕΠΩΝΥΜΟ</th>
                    <th>ΟΝΟΜΑ</th>
                    <th>ΡΟΛΟΣ</th>
                    <th>ΗΜ. ΕΓΓΡΑΦΗΣ</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    @if($user['activation_status'] == 0 && $user['is_deactivated'] == 0)
                        <tr>
                            <td>{{ $user['lastname'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            @if($user['user_role_id'] == 2)
                                <td>{{$user['role']['role']}} ({{$user['subrole']['subrole']}})</td>
                            @else
                                <td>{{$user['role']['role']}}</td>
                            @endif
                            <td>{{substr($user['created_at'], 0,11)}}</td>

                            <td>
                                <form method="post" action="{{action('MainPanel\UsersController@UserStatusUpdate')}}">
                                    <input type="hidden" name="user_id" value={{$user['id']}}>
                                    <button class="lighter-green-background">ΕΝΕΡΓΟΠΟΙΗΣΗ</button>
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