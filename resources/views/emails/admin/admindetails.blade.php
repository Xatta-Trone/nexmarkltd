@component('mail::message')
# Admin User Details

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

email: {{ $adminData->email }}<br />
pass: {{ $adminData->password }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent