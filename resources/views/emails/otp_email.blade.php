@component('mail::message')
# Your OTP for logging in is : {{$otp}}

The OTP will expire in 10 minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent