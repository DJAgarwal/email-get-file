@component('mail::message')
# Your File Download Link

Click the button below to download your file. This link will expire in 120 seconds.

@component('mail::button', ['url' => url('files/download/' . $downloadLink)])
Download File
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent