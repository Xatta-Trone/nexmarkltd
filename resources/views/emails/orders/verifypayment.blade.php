@component('mail::message')
Hello {{ $orderdata->name }}!

The payment for order {{ "NMS".sprintf('%05d', $orderdata->id)}} of total taka {{ $orderdata->total_amount}} is
received.
Your payment method is {{ $orderdata->trx_type }} & trx id is {{ $orderdata->trx_id }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent