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

        <main class="min-w-0 flex-1 pt-[58px] pb-10 pl-[55px] pr-[54px]">
            <div class="mx-auto max-w-[1050px]">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>