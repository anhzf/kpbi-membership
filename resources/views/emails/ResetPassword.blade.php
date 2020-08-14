@component('mail::message')
    Silahkan klik tombol berikut untuk me-reset password akun member KPBI anda!
    @component('mail::button', ['url' => $link]) Reset Password @endcomponent
    atau silahkan salin link berikut kemudian tempel/buka di browser
    {{ $link }}
@endcomponent