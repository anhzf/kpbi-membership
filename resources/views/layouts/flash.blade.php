@php
    $animationDelay = 0;
    $theme = [
        'success' => 'bg-teal-400',
        'error' => 'bg-red-600 text-white',
        'warning' => 'bg-yellow-400',
        'info' => 'bg-indigo-300',
        'other' => 'bg-white border-4 border-gray-900'
    ];
@endphp

@if (Session::get('flash') || $errors->all())
<div class="z-50 fixed left-0 bottom-0 w-full flex flex-col-reverse items-stretch">
    @if ($flashes = Session::get('flash'))
        @foreach ($flashes as [$type, $msg])
            <div class="flash py-5 px-10 {{ $theme[$type] }} flex justify-between" style="animation-delay: {{ $animationDelay }}s">
                <span>
                    {{ $msg }}
                </span>
                <span class="material-icons cursor-pointer center" onclick="this.parentElement.remove()">cancel</span>
            </div>
            @php $animationDelay += .8; @endphp
        @endforeach
    @endif

    @foreach ($errors->all() as $error)
        <div class="flash py-5 px-10 {{ $theme['error'] }} flex justify-between" style="animation-delay: {{ $animationDelay }}s">
            <span>{{ $error }}</span>
            <span class="material-icons cursor-pointer center" onclick="this.parentElement.remove()">cancel</span>
        </div>
        @php $animationDelay += .8; @endphp
    @endforeach

</div>
@endif
