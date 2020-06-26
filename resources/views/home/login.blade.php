@extends('home')

@section('form')
    
<div class="border-box p-6 lg:p-10 w-full max-w-screen-sm bg-white rounded shadow-md">
    <form action="{{ route('login') }}" method="post">
        @csrf

        <x-input.text name="name" label="user" placeholder="Username" value="{{ old('login') }}" />
        <x-input.text name="password" type="password" label="password" placeholder="Password" value="{{ old('login') }}" />

        <div class="md:flex md:items-center mb-6">
            <label class="md:w-2/3 block text-gray-500 font-semibold">
                <input class="leading-tight" name="remember" type="checkbox">
                <span class="text-sm">Tetap login</span>
            </label>
        </div>

        <div class="input-action-container flex justify-end px-10 w-full">
            <a href="{{ route('register') }}" class="btn bg-gray-300 text-gray-700 ml-auto mx-3 md:mt-3 hover:bg-gray-400">Daftar</a>
            <button type="submit" class="btn mx-3 md:mt-3">Login</button>
        </div>
    </form>
</div>

@endsection