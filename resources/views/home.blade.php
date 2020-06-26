@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row mx-5 lg:mx-20">
    <div class="m-auto my-5 p-1 sm:p-10 w-full md:w-1/2">
        <h1 class="mb-3 md:mb-5 text-3xl md:text-5xl">@yield('title', config('app.name'))</h1>
        @yield('form')
    </div>
    
    <div class="flex order-first md:order-none md:w-1/2 justify-center items-center md:sticky md:top-0 md:self-start">
        <img class="w-1/2 lg:w-full max-w-md p-10 sm:p-0 md:p-24" src="{{ asset('img/ICON_KPBI.png') }}" alt="ICON KPBI">
    </div>
</div>

@endsection
