<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="image/x-icon" rel="shortcut icon" href="{{ URL::asset('storage/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'APM | КСТ | Главная страница')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss'])

    <!-- Подключение скриптов DataTables и их плагинов -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


    <!-- Подключаем скрипты Bootstrap Table -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/extensions/export/bootstrap-table-export.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table-locale-all.min.js"></script>


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
            <div class="logo__pages d-flex gap-4">
                <img src="{{ asset('/storage/apm_apm.png') }}" alt="лого вход">
                {{-- <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'APM') }}
                </a> --}}
            </div>
            <div class="headerMenu d-flex align-items-center gap-5">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="{{ route('home') }}"
                           class="nav-link @if (Request::is('home')) active @endif">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('baseRisks') }}"
                           class="nav-link @if (Request::is('base-risks')) active @endif">Реестр рисков и
                            возможностей</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rco') }}"
                           class="nav-link @if (Request::is('register-commercial-offers')) active @endif">Реестр КП</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('project-maps') }}"
                           class="nav-link @if (Request::is('project-maps/all')) active @endif">Карты проекта</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contractStorage') }}"
                           class="nav-link @if (Request::is('contractStorage')) active @endif">Хранилище договоров</a>
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
                                        <div class="userName_info">
                                            почта: {{ Auth::user()->email }}
                                        </div>
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
        </div>
    </nav>

    {{-- Content --}}
    <main class="mainPage">
        @yield('content')
        <button onclick="topFunction()" id="scrollToTopBtn" title="Подняться наверх">
            <i class="fas fa-arrow-up"></i>
        </button>
    </main>
    <style>
        #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 15px;
            z-index: 99;
            font-size: 24px;
            border: none;
            border-radius: 10%;
            padding: 4px 10px;
            outline: none;
            background-color: #6b99d9;
            color: #fff;
            cursor: pointer;
        }
    </style>

    <script>
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("scrollToTopBtn").style.display = "block";
            } else {
                document.getElementById("scrollToTopBtn").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</div>
</body>

</html>
