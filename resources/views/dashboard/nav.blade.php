@php
$default_theme = 'bg-blue-600 hover:bg-blue-700';
$menus = [
    __('dashboard.nav.myProfile') => [
        'auth' => 'auth',
        'link' => route('profile'),
        'class' => $default_theme
    ],
    __('dashboard.nav.member') => [
        'auth' => 'all',
        'link' => route('memberList'),
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

<nav class="flex justify-start bg-blue-600 text-white">


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

    @auth <form action="{{ route('logout') }}" method="POST" class="ml-auto self-end">@csrf
            <button type="submit" class="btn {{ $default_theme }}">{{ __('dashboard.nav.logout') }}</button>
    </form> @endauth

</nav>