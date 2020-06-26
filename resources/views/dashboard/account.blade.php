@extends('dashboard')

@section('title', $user->name.' - Akun KPBI')

@section('page')

<div class="col-span-2 p-16 pt-5">
    
    <form action="{{ route('account') }}" method="POST" class="flex flex-col">
        @csrf

        <x-input.text name="email" type="email" label="Email" value="{{ $user->email }}" />
        <x-input.text name="username" type="text" label="Username" value="{{ $user->name }}" />
                                    
        <button type="submit" class="btn self-end m-5">{{ __('dashboard.save') }}</button>
        
    </form>

    <div class="w-full p-5 flex flex-col shadow-lg bg-gray-100">
        <h1 class="text-lg mx-2 mb-2">{{ __('Change Password') }}</h1>
        <form action="{{ route('account:change-password') }}" method="POST" class="flex flex-col">
            @csrf
            
            <x-input.text name="passwordChange" type="password" label="Password" value="" />
            <x-input.text name="passwordChange_confirmation" type="password" label="Ulangi Password" value="" />
            <button type="submit" class="btn self-end m-5" onclick="return confirm('{{ __('dashboard.password.change_alert') }}')">{{ __('dashboard.password.change') }}</button>
            @error('passwordChange')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
            
        </form>
    </div>

</div>

<img class="rounded-full bg-gray-200 max-w-4/5 mx-auto" style="width: 25vh; height: 25vh;" src="" alt="">

@endsection