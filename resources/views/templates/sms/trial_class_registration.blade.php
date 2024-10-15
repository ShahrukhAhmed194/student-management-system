@php
use Carbon\Carbon;
@endphp

[Dreamers] কোডিং ক্লাসে রেজিষ্ট্রেশন সফল হয়েছে। ক্লাসের তারিখ: {{ Carbon::parse($trialClass->schedule->date)->format('jS F') }}, সময়: {{ date('h:i A', strtotime($trialClass->schedule->time)) }}, জুম লিংক: {{ $trialClass->schedule->teacher->value_a }}, ক্লাস লগিন ডিটেইলস: {{ $trialClass->schedule->teacher->class_login_details }}