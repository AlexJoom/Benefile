@extends('layouts.login-register-layout')

@section('title')
    <title>Awaiting Activation</title>
@stop

@section('log-content')
    <div id="reset">
        <div class="panel-body">
           <div class="reset-password-text margin-bottom-50">Η εγγραφή σας ολοκληρώθηκε επιτυχώς!</div>
           <div class="reset-password-text">
               <b>Αναμείνατε έγκριση από τον διαχειριστή του συστήματος.</b>
           </div>

           <div class="white">
               <div class="bottomDiv" >
                  Χρειάζεστε βοήθεια; <a class="white" href="#"><b>Επικοινωνήστε εδώ.</b></a>
              </div>
          </div>
        </div>
    </div>
@stop