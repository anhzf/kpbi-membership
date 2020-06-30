@extends('layouts.app')

@section('content')
    
<div class="flex flex-col justify-start items-center w-full h-screen p-10">
    <div class="flex flex-col w-3/4 h-full shadow-2xl relative">
        @include('dashboard.nav')
        <main class="py-5 grid grid-cols-3 justify-center overflow-y-auto h-full bg-white">
            @yield('page')
        </main>
        {{-- <div class="absolute bg-white bottom-0 px-5 flex items-end m-2" style="right: 5rem">
            <a href="" class="py-3 px-6 bg-blue-500 hover:bg-blue-600 text-white border border-gray-300 first:rounded-l-lg last:rounded-r-lg shadow-md">Save</a>
            <a href="" class="py-3 px-6 bg-white hover:bg-gray-200 border border-gray-300 first:rounded-l-lg last:rounded-r-lg shadow-md">Sompan  </a>
        </div> --}}
    </div>
</div>

@endsection