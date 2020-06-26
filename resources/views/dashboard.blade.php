@extends('layouts.app')

@section('content')
    
<div class="flex flex-col justify-start items-center w-full h-screen p-10">
    <div class="flex flex-col w-3/4 h-full shadow-2xl">
        @include('dashboard.nav')
        <main class="py-5 grid grid-cols-3 justify-center overflow-y-auto h-full bg-white">

            @yield('page')

        </main>
    </div>
</div>

@endsection