@component('mail::message')
# Welcome

Please confirm your email address.

@component('mail::button', ['url' => url('/register/confirm?token='.$user->confirmation_token)])
confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
