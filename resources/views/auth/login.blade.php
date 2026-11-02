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
<body class="font-inter">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#0B1624] px-4 py-8">

        {{-- background --}}
        <img src="{{ asset('images/login-bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0" style="background: linear-gradient(155deg, rgba(13,38, 64, 0.90) 0%, rgba(10, 16, 25, 0.94%) 100%);"></div>

        {{-- card --}}
        <main class="relative z-10 grid w-full max-w-[850px] overflow-hidden rounded-[24px] bg-white shadow-[0_30px_80px_rgba(0,0,0,0.45)] ring-1 ring-white/15 lg:min-h-[641px] lg:grid-cols-[45%_55%]">

            {{-- panel kiri card login --}}
            <section class="flex flex-col justify-between bg-[#142B46] px-[28px] pt-[28px] pb-[32px] lg:px-[40px] lg:pt-[40px] lg:pb-[104px]">

                {{-- logo --}}
                <div class="flex items-center gap-[14px]">
                    {{-- <span class="flex h-[40px] w-[40px] shrink-0 items-center justify-center rounded-[12px] bg-[#1677E8]">
                         <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 22 16 8" />
                            <path d="M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z" />
                            <path d="M7.47 8.53 9 7l1.53 1.53a3.5 3.5 0 0 1 0 4.94L9 15l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z" />
                            <path d="M11.47 4.53 13 3l1.53 1.53a3.5 3.5 0 0 1 0 4.94L13 11l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z" />
                            <path d="M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4Z" />
                            <path d="M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z" />
                            <path d="M15.47 13.47 17 15l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L9 15l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z" />
                            <path d="M19.47 9.47 21 11l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L13 11l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z" />
                        </svg> --}}
                    </span>

                    <div>
                        <p class="text-[24px] leading-[20px] font-bold text-white">MBG Smart Stock</p>
                        <p class="mt-[4px] text-[16px] leading-[16px] text-[#99A3AF]">Stok Pangan Terintegrasi</p>
                    </div>
                </div>

                {{-- copyright --}}
                <div class="mt-[40px] lg:mt-0">
                    <p class="text-[10px] leading-[14px] font-bold tracking-[2px] text-[#75B8FF]">SISTEM OPERASIONAL MBG</p>
                    <h1 class="mt-[18px] max-w-[290px] text-[28px] leading-[34px] font-bold text-white lg:text-[30px]" >Kelola stok pangan dengan lebih pasti</h1>
                </div>
            </section>

            {{-- panel kanan --}}
            <section class="flex flex-col bg-white">

                {{-- form login --}}
                <form action="{{ route('login.store') }}" method="POST" class="flex-1 px-[28px] pt-[32px] pb-[28px] lg:px-[48px] lg:pt-[136px] lg:pb-[112px]">
                    @csrf
                    <h2 class="text-[24px] leading-[32px] font-bold text-[#1F2937]">Selamat datang</h2>
                    <p class="mt-[10px] text-[13px] leading-[20px] text-[#64748B]">Silahkan login untuk mendapatkan akses</p>

                    <div class="mt-[30px]">
                        <label for="username" class="block text-[12px] leading-[18px] font-semibold text-[#1F2937]">
                            Username
                        </label>

                        <div class="relative mt-[8px]">
                            <span class="pointer-events-none absolute top-1/2 left-[16px] -translate-y-1/2 text-[#94A3B8]">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </svg>
                            </span>

                            <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Masukkan username" autocomplete="username" autofocus required class="h-[46px] w-full rounded-[10px] border bg-white pr-[48px] pl-[46px] text-[14px] text-[#1F2937] outline-none transition-colors placeholder:text-[#94A3B8] focus:border-[#1677E8] {{ $errors->has('username') ? 'border-[#E11D48]' : 'border-[#DCE4EE]' }}">
                        </div>

                        @error('username')
                            <p class="mt-[6px] text-[12px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- password --}}
                    <div class="mt-[18px]">
                        <label for="password" class="block text-[12px] leading-[18px] font-semibold text-[#1F2937]">
                            Password
                        </label>

                        <div class="relative mt-[8px]">
                            <span class="pointer-events-none absolute top-1/2 left-[16px] -translate-y-1/2 text-[#94A3B8]">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            </span>

                            <input type="password" name="password" id="password" placeholder="Masukkan Password" autocomplete="current-password" required class="h-[46px] w-full rounded-[10px] border bg-white pr-[48px] pl-[46px] text-[14px] text-[#1F2937] outline-none transition-colors placeholder:text-[#94A3B8] focus:border-[#1677E8] {{ $errors->has('password') ? 'border-[#E11D48]' : 'border-[#DCE4EE]' }}">

                            <button type="button" data-toggle-password aria-label="Tampilkan password" class="absolute top-1/2 right-[14px] -translate-y-1/2 cursor-pointer text-[#94A3B8] transition-colors hover:text-[#64748B]">
                                 <svg data-icon-eye width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                 <svg data-icon-eye-off class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                    <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                    <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                    <path d="m2 2 20 20" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-[6px] text-[12px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- tombol login --}}
                    <button type="submit" class="mt-[24px] flex h-[47px] w-full cursor-pointer items-center justify-center gap-[8px] rounded-[10px] bg-[#142B46] text-[14px] font-semibold text-white transition-colors hover:bg-[#1B3A5C] focus:ring-2 focus:ring-[#142B46]/30 focus:ring-offset-2 focus:outline-none">
                        Masuk ke sistem
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </form>

                {{-- akses demo --}}
                <footer class="border-t border-[#DCE4EE] px-[28px] py-[18px] lg:px-[48px]">
                    <div class="flex flex-col gap-[12px] sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-[13px] leading-[18px] font-bold text-[#1F2937]">Akses demo</p>
                            <p class="mt-[2px] text-[11px] leading-[16px] text-[#64748B]">Akses login cepat</p>
                        </div>
                        
                        <div class="flex flex-warp items-center gap-[8px]">
                            <button type="button" data-demo-username="admin.mbg" class="h-[27px] transition-colors hover:border-[#1677E8] hover:text-[#1677E8]">
                                Admin
                            </button>
                            <button type="button" data-demo-username="petugas.gudang" class="h-[27px] transition-colors hover:border-[#1677E8] hover:text-[#1677E8]">
                                Petugas Gudang
                            </button>
                            <button type="button" data-demo-username="pimpinan" class="h-[27px] transition-colors hover:border-[#1677E8] hover:text-[#1677E8]">
                                Pimpinan
                            </button>
                        </div>
                    </div>
                </footer>
            </section>
        </main>
    </div>
</body>
</html>