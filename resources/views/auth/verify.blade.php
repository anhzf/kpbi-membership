@extends('layouts.app')

@section('content')

<div class="h-screen flex flex-col items-center">
    <div class="card m-5 p-4 bg-white flex flex-col justify-between items-stretch rounded-lg shadow">
        <div class="card-header border-b-2 px-4 pb-2 border-gray-400">
            <h2 class="text-xl">{{ __('Verifikasi email anda') }}</h2>
        </div>
        <div class="card-body p-4 flex flex-col">
            @if (session('resent'))
                <div class="bg-green-400 text-white">
                    <span>{{ __('Link verifikasi yang baru telah dikirim ke email anda') }}</span>
                </div>
            @endif
            <p class="leading-normal">{{ __('Untuk melanjutkan silahkan verifikasi email anda melalui link yang kami kirim ke email anda') }}</p>
            <p class="leading-normal">{{ __('Jika anda tidak menerima email dari kami silahkan klik tombol berikut') }},</p>
            <form class="self-end" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <span class="bg-red-200 text-xs text-gray-800 italic">Mohon maaf, terkadang diperlukan beberapa waktu untuk bisa menerima email</span>
                <button type="submit" class="btn m-4 mb-0">{{ __('Klik disini untuk mengirim') }}</button>
            </form>
        </div>
    </div>
</div>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifikasi email anda') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link verifikasi yang baru telah dikirim ke email anda') }}
                        </div>
                    @endif

                    {{ __('Untuk melanjutkan silahkan verifikasi email anda melalui link yang kami kirim ke email anda') }}
                    {{ __('Jika anda tidak menerima email dari kami silahkan') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik disini untuk mengirim') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
