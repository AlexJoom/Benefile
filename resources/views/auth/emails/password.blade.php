<?php
    $p = 'auth/emails/password.';
?>

<div style="text-align: center; padding: 30px;">
    <img alt="Benefile logo" class="img-responsive logo-padding" width="300px"  src={{asset('images/BeneFile-Logo.png')}}>
</div>
<div style="text-align: center">
    <h2>@lang($p.'message_start')</h2>
    <p>
        @lang($p.'click')
        &nbsp;
        <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">@lang($p.'here')</a>
        &nbsp;
        @lang($p.'message_end')
    </p>
</div>