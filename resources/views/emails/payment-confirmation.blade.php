@component('mail::message')

Assalamu Alaikum, \
Greetings from Dreamers Academy.

Your payment for your child has been completed.

@component('mail::button', ['url' => {{ $payment->invoice_url }} ])
Download Invoice
@endcomponent

For further queries, please contact us at: +880 1897-717780; +880 1897-717781.

Thanks,<br>
{{ config('app.name') }}
@endcomponent