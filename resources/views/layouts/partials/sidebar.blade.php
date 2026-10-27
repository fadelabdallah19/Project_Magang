<aside class="sticky top-0 flex w-[281px] shrink-0 flex-col bg-[#071E49]">

    {{-- Logo --}}
    <div class="px-[27px] pt-[43px] font-poppins">
        <p class="text-[25px] leading-[37.5px] font-bold text-white">MBG Smart Stock</p>
        <p class="text-[20px] leading-[30px] font-normal text-white">Project Magang</p>
    </div>

    {{-- Menu --}}
    @php
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Bahan Pangan', 'route' => 'bahan.index'],
        ['label' => 'Barang Masuk', 'route' => 'barang-masuk.index'],
        ['label' => 'Barang Keluar', 'route' => 'barang-keluar.index'],
        ['label' => 'Stok Opname', 'route' => null],
        ['label' => 'Laporan', 'route' => null],
        ['label' => 'Pengguna', 'route' => null],
    ];
    @endphp

    <nav class="mt-[44px] space-y-[17px] px-[34px] font-poppins text-[15px] font-bold text-white">
        @foreach ($navItems as $item)
            @php($isActive = $item['route'] && request()->routeIs($item['route']))
            
            <a href="{{ $item['route'] ? route($item['route']) : '#' }}"
            class="flex h-[37px] items-center justify-center rounded-[10px] border transition-colors {{ $isActive ? 'border-white/50' : 'border-white/20 bg-white/10 backdrop-blur-sm hover:bg-white/15'}}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Kartu Pengguna --}}
    <div class="mt-auto px-[19px] pb-[41px]">
        <div class="flex h-[70px] items-center rounded-[10px] border border-white/15 bg-white/10 pl-4 pr-4 backdrop-blur-sm">
            <div class="flex h-[50px] w-[50px] shrink-0 items-center justify-center rounded-full bg-[#071E49] text-[20px] font-bold text-white">
                AD
            </div>

            <div class="ml-[6px] min-w-0">
                <p class="truncate text-[15px] leading-[18.2px] font-bold text-white">Administrator</p>
                <p class="text-[10px] leading-[12.1px] text-white">Hak semua akses</p>
            </div>

            <form method="POST" action="{{ route('logout')}}" class="ml-auto">
                @csrf
                <button type="submit" class="block cursor-pointer" title="Keluar" aria-label="Keluar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9M16 7L21 12L16 17M21 12H9"
                              stroke="#EC221F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>