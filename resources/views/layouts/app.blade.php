<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'MBG Smart Stock')</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter">
    <div class="flex min-h-screen bg-[#F4F7FB]">
        @include('layouts.partials.sidebar')

        {{-- overlay sidebar mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/40 backdrop-blur-[2px] lg:hidden"></div>
        <main class="min-w-0 flex-1 px-4 pt-[80px] pb-10 lg:pt-[58px] lg:pl-[55px] lg:pr-[54px]">

            {{-- bar atas --}}
            <header class="fixed inset-x-0 top-0 z-30 flex h-[56px] items-center gap-3 bg-[#071E49] px-4 shadow-[0_2px_10px_rgba(7,30,73,0.25)] lg:hidden">
                <button type="button" data-sidebar-toggle aria-label="Buka menu" aria-expanded="false" class="grid h-9 w-9 place-items-center rounded-[8px] text-white transition-colors hover:bg-white/10">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 6h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 18h16"></path>
                    </svg>
                </button>

                <span class="font-poppins text-[15px] font-bold text-white">
                    MBG Smart Stock
                </span>
            </header>

            <div class="mx-auto max-w-[1050px]">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>