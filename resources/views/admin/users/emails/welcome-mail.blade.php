@component('mail::message')
# Account created

Hello {{ $user->name }}!

@component('mail::button', ['url' => route('login') ])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent