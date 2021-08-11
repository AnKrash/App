@component('mail::message')
Here is your reset password token.
<h>{{$token}}</h>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
