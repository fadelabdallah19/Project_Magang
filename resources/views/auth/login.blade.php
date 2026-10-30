<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - MBG Smart Stock</title>

    {{-- <link rel="preconnect" href="https://fonts.googleleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet"> --}}
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-poppins">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#071E49] px-4 py-10">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('/images/login-bg.jpg') }}')"></div>

        <div
            class="absolute inset-0"
            style="background-image: linear-gradient(180deg, rgba(7, 30, 73, 0.82) 0%, rgba(7, 30, 73, 0.78) 55%, rgba(255, 255, 255, 0.82) 100%);"
        ></div>

        <main class="relative z-10 w-full max-w-[721px] overflow-hidden rounded-[25px] bg-white shadow-xl">

            {{-- Header --}}
            <header class="bg-[#071E49] px-6 pt-[56px] pb-[74px] text-center">
                    <h1 class="text-[30px] leading-[45px] font-bold text-white">
                        MBG Smart Stock
                    </h1>
                    <p class="mt-[2px] text-[20px] leading-[30px] font-normal text-white">
                        Sistem Manajemen Stok Program Makanan Bergizi Gratis
                    </p>
            </header>

            {{-- Form --}}
            <form method="POST" action="{{ route('login.store') }}"
                class="pt-[27px] pr-[51px] pb-[34px] pl-[39px]">
                @csrf

                <div>
                    <label for="username" class="block text-[24px] leading-[36px] font-normal text-black">
                        username
                    </label>

                    <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" autocomplete="username" autofocus required class="mt-[2px] h-[41px] w-full rounded-[10px] border border-[#1E1E1E] bg-white px-[15px] outline-none">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-[17px]">
                    <label for="password" class="block text-[24px] leading-[36px] font-normal text-black">
                        Password
                    </label>
                    <input for="password" name="password" type="password" placeholder="Masukkan Password" autocomplete="current-password" required class="mt-[2px] h-[41px] w-full rounded-[10px] border border-[#1E1E1E] bg-white px-[15px] outline-none">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message}}</p>
                    @enderror
                </div>

                <button type="submit" class="mt-[20px] w-full h-[60px] rounded-[25px] bg-[#072E49] text-[24px] font-bold text-white transition-colors hover:bg-[#0A2A64] focus:ring-2 focus:ring-[#072E49]/40 focus:ring-offset-2 focus:outline-none">
                    Masuk ke Sistem
                </button>
            </form>
        </main>
    </div>
</body>
</html>