@extends('home')

@section('form')

<div class="border-box p-6 lg:p-10 w-full max-w-screen-sm bg-white rounded shadow-md">

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <x-input.select name="jenjang" label="Jenjang" :choices="['S1', 'S2', 'S3']" value="{{ old('jenjang') }}"></x-input.select>
        <x-input.text name="nama_prodi" label="Nama Prodi" placeholder="Nama Prodi" value="{{ old('nama_prodi') }}"></x-input.text>
        <div class="group-input flex-no-wrap">
            <x-input.text name="pt[lengkap]" label="Nama PT Lengkap" placeholder="Nama PT Lengkap" class="w-3/4" value="{{ old('pt.lengkap') }}"></x-input.text>
            <x-input.text name="pt[singkat]" label="Singkat" placeholder="(misal UNS)" class="w-1/4" value="{{ old('pt.singkat') }}"></x-input.text>
        </div>
        <x-input.text name="email_prodi" type="email" label="Email Prodi" placeholder="Alamat email Prodi" value="{{ old('email_prodi') }}"></x-input.text>
        <x-input.text name="email_kaprodi" type="email" label="Email Kaprodi" placeholder="Alamat email Kaprodi" value="{{ old('email_kaprodi') }}"></x-input.text>

        <div class="input-action-container flex justify-end px-10 w-full">
            <span class="text-sm ml-auto mx-3 md:mt-3 self-center">
                {{ __('kpbi.hasAccount') }}
                <a href="{{ route('login') }}" class="text-blue-500">{{ __('kpbi.clickHere') }}</a>
            </span>
            <button type="submit" class="mx-3 md:mt-3 btn">{{ __('kpbi.btn.register') }}</button>
        </div>

    </form>

</div>

@endsection
