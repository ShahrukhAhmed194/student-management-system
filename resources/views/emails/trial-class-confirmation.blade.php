@component('mail::message')

Assalamu Alaikum, \
Greetings from Dreamers Academy.

### Your trial class registration date/time is as follows: {{ $trialClass->date }} and {{ $trialClass->time }}.

Your meeting link is as follows: {{ $trialClass->zoom_link }}

If your child's age is 7 or 8 years, then please download the following software and install in your computer before the class: https://www.bluestacks.com/apps/educational/scratchjr-on-pc.html

Please, check your mic and speakers before coming.

For further queries, please contact us at: +880 1897-717780; +880 1897-717781.

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent