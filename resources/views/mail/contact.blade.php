@component('mail::message')
<pre>Hi Admin,

My name is {{ $contact->name }}, i am visitor, my email is <a href="mailto:{{ $contact->email }}" target="_blank">{{ $contact->email }}</</a>,
    
I have some feedback for you about <span class="message">{{ $contact->message }}.</span>
</pre>
{{-- @component('mail::button', ['url' => "mailto:{{ $contact->email }}", 'color' => 'success'])
Link To My Email
@endcomponent --}}

Thanks,{{ $contact->name }}
@endcomponent