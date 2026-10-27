@extends('layouts.app')

@section('title', 'Dashboard Stok - MBG Smart Stok')

@section('content')

    {{-- Judul Halaman --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Dashboard Stok</h1>
            <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Ringkasan kondisi bahan pangan &amp; aktivitas persediaan.</p>
        </div>

        <div class="mt-[40px] flex gap-3 pr-[27px]">
            <button type="button" class="h-8 w-[100px] rounded-[10px] border border-[#E5E7EB] bg-white text-[12px] font-bold text-[#787878]">Admin</button>
            <button type="button" class="h-8 w-[100px] rounded-[10px] border border-[#E5E7EB] bg-white text-[12px] font-bold text-[#787878]">Gudang</button>
            <button type="button" class="h-8 w-[100px] rounded-[10px] border border-[#E5E7EB] bg-white text-[12px] font-bold text-[#787878]">Pengawas</button>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="mt-[31px] grid grid-cols-3 gap-[48px]">
        <div class="relative h-[103px] rounded-[15px] bg-white shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
            <div class="pl-[14px] pt-[12px]">
                <p class="text-[15px] leading-[18.2px] font-bold text-black">Total Jenis Bahan</p>
                <p class="mt-[18px] text-[30px] leading-[36.3px] font-bold text-black">{{ $totalBahan }}</p>
            </div>
            <svg class="absolute top-[28px] right-[28px]" width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M45 5.625C45 4.13316 44.4074 2.70242 43.3525 1.64752C42.2976 0.592632 40.8668 0 39.375 0L5.625 0C4.13316 0 2.70242 0.592632 1.64752 1.64752C0.592632 2.70242 0 4.13316 0 5.625L0 16.875H1.875V45H43.125V16.875H45V5.625ZM3.75 5.625C3.75 5.12772 3.94754 4.65081 4.29917 4.29917C4.65081 3.94754 5.12772 3.75 5.625 3.75H39.375C39.8723 3.75 40.3492 3.94754 40.7008 4.29917C41.0525 4.65081 41.25 5.12772 41.25 5.625V13.125H3.75V5.625ZM39.375 41.25H5.625V16.875H39.375V41.25Z" fill="#0088FF"/>
                <path d="M29.9995 22.5H14.9995V26.25H29.9995V22.5Z" fill="#0088FF"/>
            </svg>
        </div>

        <div class="relative h-[103px] rounded-[15px] bg-white shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
            <div class="pl-[14px] pt-[12px]">
                <p class="text-[15px] leading-[18.2px] font-bold text-black">Stok Rendah</p>
                <p class="mt-[18px] text-[30px] leading-[36.3px] font-bold text-black">{{ $stokRendah }}</p>
            </div>
            <svg class="absolute top-[28px] right-[30px]" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 18V26M24 34H24.02M20.58 7.72L3.64004 36C3.29078 36.6048 3.10598 37.2906 3.10402 37.989C3.10206 38.6875 3.28302 39.3743 3.62889 39.981C3.97477 40.5878 4.47349 41.0935 5.07546 41.4477C5.67742 41.8019 6.36164 41.9923 7.06004 42H40.94C41.6384 41.9923 42.3227 41.8019 42.9246 41.4477C43.5266 41.0935 44.0253 40.5878 44.3712 39.981C44.7171 39.3743 44.898 38.6875 44.8961 37.989C44.8941 37.2906 44.7093 36.6048 44.36 36L27.42 7.72C27.0635 7.13221 26.5615 6.64624 25.9624 6.30897C25.3634 5.97169 24.6875 5.79451 24 5.79451C23.3126 5.79451 22.6367 5.97169 22.0377 6.30897C21.4386 6.64624 20.9366 7.13221 20.58 7.72Z" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke="#E11D48"/>
            </svg>
        </div>

        <div class="relative h-[103px] rounded-[15px] bg-white shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
            <div class="pl-[14px] pt-[12px]">
                <p class="text-[15px] leading-[18.2px] font-bold text-black">Transaksi Hari Ini</p>
                <p class="mt-[18px] text-[30px] leading-[36.3px] font-bold text-black">{{ $transaksiHariIni }}</p>
            </div>
            <svg class="absolute top-[28px] right-[26px]" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 41.9524V-0.0476227H0V41.9524C0 43.5437 0.632141 45.0698 1.75736 46.195C2.88258 47.3202 4.4087 47.9524 6 47.9524H48V43.9524H6C5.46957 43.9524 4.96086 43.7417 4.58579 43.3666C4.21071 42.9915 4 42.4828 4 41.9524V41.9524Z" fill="#059669"/>
                <path d="M45 7.95207H34L39.586 13.5381L31 22.1241L27 18.1241L12.562 32.5621L15.4 35.4001L27.01 23.8001L31.01 27.8001L42.424 16.3861L48 21.9521V10.9521C48 10.1564 47.6839 9.39336 47.1213 8.83075C46.5587 8.26814 45.7957 7.95207 45 7.95207V7.95207Z" fill="#059669"/>
            </svg>
        </div>
    </div>

    {{-- Tabel Ringkasan Stok--}}
    <div class="mt-[37px] rounded-[15px] bg-white pb-2 shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
        <div class="flex h-[58px] items-center pl-3 pr-[26px]">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.0004 4.00031H7.00037V6.0003H24.0004V4.00031Z" fill="#0088FF"/>
                <path d="M24.0004 10.9997H7.00037V12.9997H24.0004V10.9997Z" fill="#0088FF"/>
                <path d="M24.0004 18H7.00037V20H24.0004V18Z" fill="#0088FF"/>
                <path d="M2 6.99999C3.10457 6.99999 4 6.10456 4 5C4 3.89543 3.10457 3 2 3C0.89543 3 0 3.89543 0 5C0 6.10456 0.89543 6.99999 2 6.99999Z" fill="#0088FF"/>
                <path d="M2 14.0003C3.10457 14.0003 4 13.1049 4 12.0003C4 10.8957 3.10457 10.0003 2 10.0003C0.89543 10.0003 0 10.8957 0 12.0003C0 13.1049 0.89543 14.0003 2 14.0003Z" fill="#0088FF"/>
                <path d="M2 20.9997C3.10457 20.9997 4 20.1043 4 18.9997C4 17.8951 3.10457 16.9997 2 16.9997C0.89543 16.9997 0 17.8951 0 18.9997C0 20.1043 0.89543 20.9997 2 20.9997Z" fill="#0088FF"/>
            </svg>
            <h2 class="ml-[10px] text-[20px] leading-[24.2px] font-bold text-black">Ringkasan Stok Bahan Pangan</h2>
            <a href="{{ route('bahan.index') }}" class="ml-auto font-poppins text-[15px] leading-[22.5px] font-bold text-[#0088FF]">Lihat Semua</a>
        </div>

        <table class="w-full table-fixed font-poppins">
            <thead>
                <tr class="h-[57px] bg-[#E5E7EB] text-left text-[15px] leading-[22.5px] font-bold text-[#787878]">
                    <th class="w-[210px] pl-[28px] font-bold">Kode</th>
                    <th class="w-[218px] font-bold">Nama Bahan</th>
                    <th class="w-[227px] font-bold">Jumlah Stok</th>
                    <th class="w-[179px] font-bold">Satuan</th>
                    <th class="w-[216px] text-center font-bold">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bahan as $item)
                    <tr class="h-[57px] text-[15px] leading-[22.5px]">
                        <td class="pl-[28px] font-normal text-[#959595]">{{ $item['kode'] }}</td>
                        <td class="font-bold text-[#787878]">{{ $item['nama'] }}</td>
                        <td class="font-bold {{ $item['status'] === 'Stok Rendah' ? 'text-[#EC221F]' : 'text-[#787878]'}}">{{ $item['stok'] }}</td>
                        <td class="font-bold text-[#787878]">{{ $item['satuan'] }}</td>
                        <td class="text-center">
                            @if ($item['status'] === 'Stok Rendah')
                                <span class="inline-flex h-8 w-[120px] items-center justify-center rounded-[10px] bg-[#FFF1F2] font-bold text-[#E11D48]">
                                    Stok Rendah
                                </span>
                            
                            @else
                            <span class="inline-flex h-8 w-[120px] items-center justify-center rounded-[10px] bg-[#ECFDF5] font-bold text-[#059669]">
                                Aman
                            </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

