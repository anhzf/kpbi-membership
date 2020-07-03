@extends('layouts.app')

@section('content')

<div class="grid grid-cols-6 gap-5 p-5 items-center">
    <header class="col-start-3 col-span-2 flex justify-center items-start">
        <a href="{{ route('home') }}">
            <img class="w-40 p-10 box-content" src="{{ asset('img/ICON_KPBI.png') }}" alt="ICON KPBI">
        </a>
    </header>
    <main class="col-start-2 col-span-4 grid grid-cols-2 gap-4">
        @guest
        <div class="shadow-md h-64 grid grid-cols-1 grid-rows-2 items-center">
            <a href="{{ route('login') }}" class="w-full h-full grid bg-white hover:bg-gray-400 hover:shadow-2xl hover:z-10 focus:shadow-inner transition ease duration-200   ">
                <span class="m-auto text-2xl font-bold font-mono">Login</span>
            </a>
            <a href="{{ route('register') }}" class="w-full h-full grid bg-white hover:bg-gray-400 hover:shadow-2xl hover:z-10 focus:shadow-inner transition ease duration-200   ">
                <span class="m-auto text-2xl font-bold font-mono">Daftar</span>
            </a>
        </div>
        @endguest
        @auth
        <a href="{{ route('profile') }}" class="w-full h-64 shadow-md grid bg-white group hover:bg-gray-400 hover:shadow-2xl hover:z-10 focus:shadow-inner transition ease duration-200">
            <span class="m-auto text-3xl font-bold font-mono">
                <p>Profil</p>
                <p class="text-center text-xs font-sans font-thin bg-gray-300 group-hover:bg-white rounded-md">{{ Auth::user()->name }}</p>
            </span>
        </a>
        @endauth
        <a href="{{ route('memberList') }}" class="w-full h-64 shadow-md grid bg-white hover:bg-gray-400 hover:shadow-2xl hover:z-10 focus:shadow-inner transition ease duration-200   ">
            <span class="m-auto text-3xl font-bold font-mono">Anggota KPBI</span>
        </a>
    </main>
</div>

@endsection
