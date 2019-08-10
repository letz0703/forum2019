@component('mail::message')
# Welcome

Please confirm your email address.

@component('mail::button', ['url' => '#'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
