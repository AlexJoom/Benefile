<div style="text-align: center; padding: 30px;">
    <img alt="Benefile logo" class="img-responsive logo-padding" width="300px"  src={{asset('images/BeneFile-Logo.png')}}>
</div>
<div style="text-align: center">
    <h2>Ένα αίτημα επαναφοράς του προσωπικού σας κωδικού στάλθηκε στην πλατφόρμα του Benefile.</h2>
    <p>
        Πατήστε&nbsp;<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">εδώ</a>
        &nbsp;ώστε να ορίσεται νέο κωδικό για τον λογαριασμό σας.
    </p>
</div>