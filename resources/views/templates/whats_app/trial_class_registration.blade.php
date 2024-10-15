@php
use Carbon\Carbon;
@endphp

Greetings from Dreamers Academy

Dear {{ $trialClass->gurdian_name }},

Your child's ({{ $trialClass->student_name }}) Coding for Kids trial class is scheduled for {{ Carbon::parse($trialClass->schedule->date)->format('jS F') }} at "{{  date('h:i A', strtotime($trialClass->schedule->time)) }}"({{ $country_shortname }} Standard Time).

Here is the class details to join:
Link: {{ $trialClass->schedule->teacher->value_a }}
Class Login Details: {{ $trialClass->schedule->teacher->class_login_details }}

Note: You must join from a PC and require an internet connection. Please check your microphone, speaker and video camera 5 minutes before the class for a better experience. We will record the class for quality purposes.

For any queries, please feel free to contact us at:
{{ $support_phone }}