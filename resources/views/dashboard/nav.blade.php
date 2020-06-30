@php
$default_theme = 'flex items-center bg-blue-600 hover:bg-blue-700';
$menus = [
    __('dashboard.nav.myProfile') => [
        'auth' => 'auth',
        'link' => route('profile'),
        'class' => $default_theme
    ],
    __('dashboard.nav.myAccount') => [
        'auth' => 'auth',
        'link' => route('account'),
        'class' => $default_theme
    ],
    __('dashboard.nav.login') => [
        'auth' => 'guest',
        'link' => route('login'),
        'class' => $default_theme.' ml-auto self-end',
    ],
];
$nav = function ($label, $link, $classes) {
    return "<a href='{$link}' class='btn {$classes}'>{$label}</a>";
};
@endphp

<nav class="flex justify-start items-stretch bg-blue-600 text-white">

    <a href='{{ route('home') }}' class='btn bg-blue-600 hover:bg-blue-700 flex'>
        <img src="{{ asset('img/ICON_KPBI_no-text.png') }}" class="w-12" alt="[icon_kpbi]">
        <span class="my-auto px-3 text-xl">KPBI</span>
    </a>

    @foreach ($menus as $name => list(
            'auth' => $auth,
            'link' => $link,
            'class' => $classes,
        ))
        @switch($auth)
            @case('auth')
                @auth {!! $nav($name, $link, $classes) !!} @endauth @break
            @case('guest')
                @guest {!! $nav($name, $link, $classes) !!} @endguest @break
            @default
                {!! $nav($name, $link, $classes) !!}
        @endswitch
    @endforeach

    @auth <form action="{{ route('logout') }}" method="POST" class="ml-auto h-full self-end">@csrf
            <button type="submit" class="btn {{ $default_theme }} h-full">{{ __('dashboard.nav.logout') }}</button>
    </form> @endauth

</nav>