<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'APM') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Подключение скриптов DataTables и их плагинов -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- иконки --}}
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <!-- icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Toastr CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>

<body>
    <div id="app">
        {{-- Header --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'APM') }}
                </a>
                <div class="headerMenu d-flex align-items-center gap-5">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="{{ route('home') }}"
                                class="nav-link @if (Request::is('home')) active @endif">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('baseRisks') }}"
                                class="nav-link @if (Request::is('base-risks')) active @endif">База рисков</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rco') }}"
                                class="nav-link @if (Request::is('register-commercial-offers')) active @endif">Реестр КП</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('project-maps') }}"
                                class="nav-link @if (Request::is('project-maps/all')) active @endif">Карты проекта</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-4">
                        @guest
                            {{-- unauthorized --}}
                            @if (Route::has('login'))
                                <div class="LogInBtn">
                                    <a type="button" class="btn btn-primary"
                                        href="{{ route('login') }}">{{ __('Вход') }}</a>
                                    </li>
                            @endif
                            {{-- authorized  --}}
                        @else
                            <div class="userName">
                                <a>
                                    {{ Auth::user()->name }}
                                </a>
                            </div>
                            <div class="LogOutBtn">
                                <a type="button" class="btn btn btn-secondary btn-rounded" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Выход') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        {{-- Content --}}
        <main class="mainPage">
            @yield('content')
        </main>
    </div>
</body>

</html>
