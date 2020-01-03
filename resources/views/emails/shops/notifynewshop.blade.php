@component('mail::message')
# Introduction
Hello, {{ $userdata->name }}
The body of your message.




email: {{ $userdata->email }}<br />
pass: {{ $userdata->password }}

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent