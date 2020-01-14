@component('mail::message')
Hello {{ $orderName }}!
Please pay the total amount of {{ $orderPrice }} BDT for order {{ $orderId }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent