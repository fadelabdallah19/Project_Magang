@extends('layouts.app')

@section('title', 'Laporan - MBG Smart Stock')

@section('content')
    <div>
        <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Laporan Ringkasan Persediaan</h1>
        <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Cetak dan unduh ringkasan transaksi serta status fisik persediaan</p>
    </div>

    {{-- Kartu Laporan --}}
    <div class="mt-[44px] rounded-[12px] bg-white px-6 pt-[24px] pb-[48px] shadow-[0_6px_20px_rgba(15,23,42,0.10)] md:px-[48px]">

        {{-- Header Ringkasan --}}
        <div class="flex items-center justify-between gap-[16px] pb-[20px]">
            <h2 class="text-[20px] leading-[30px] font-bold text-black">Ringkasan Eksekutif Stock Pangan</h2>

            <a href="{{ route('laporan.export') }}"
               class="flex h-[28px] shrink-0 items-center gap-[5px] rounded-[4px] bg-[#071E49] px-[11px] text-[11px] font-bold text-white transition-colors hover:bg-[#0B2B63]">
                <svg class="h-[11px] w-[11px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v12" />
                    <path d="m7 10 5 5 5-5" />
                    <path d="M5 21h14" />
                </svg>
                Unduh Laporan
            </a>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-y-[20px] rounded-[10px] bg-[#E5E7EB] px-[12px] py-[11px] md:grid-cols-[25.5%_29.5%_25.5%_19.5%]">
            <div class="flex w-fit flex-col items-center">
                <p class="whitespace-nowrap text-[12px] leading-[18px] font-bold text-black">Total Jenis Barang</p>
                <p class="mt-[4px] text-[20px] leading-[30px] font-bold text-[#1D1D1D]">{{ $ringkasan['jenis'] }}</p>
            </div>

            <div class="flex w-fit flex-col items-center">
                <p class="whitespace-nowrap text-[12px] leading-[18px] font-bold text-black">Total Transaksi Masuk</p>
                <p class="mt-[4px] text-[20px] leading-[30px] font-bold text-[#059669]">{{ $ringkasan['masuk'] }}</p>
            </div>

            <div class="flex w-fit flex-col items-center">
                <p class="whitespace-nowrap text-[12px] leading-[18px] font-bold text-black">Total Transaksi Keluar</p>
                <p class="mt-[4px] text-[20px] leading-[30px] font-bold text-[#D97706]">{{ $ringkasan['keluar'] }}</p>
            </div>

            <div class="flex w-fit flex-col items-center">
                <p class="whitespace-nowrap text-[12px] leading-[18px] font-bold text-black">Status Ketersediaan</p>
                <p class="mt-[4px] text-[20px] leading-[30px] font-bold text-[#0088FF]">{{ $ringkasan['status'] }}</p>
            </div>
        </div>

        {{-- Detail Posisi Stok --}}
        <h3 class="mt-[22px] mb-[11px] text-[14px] leading-[21px] font-bold text-black">Detail Posisi Stok Baru</h3>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] table-fixed border border-[#BDBDBD] text-[14px] leading-[21px] text-[#787878]">
                <thead>
                    <tr class="h-[44px] bg-[#E5E7EB] text-left">
                        <th class="w-[18.5%] px-[24px] font-bold">Kode</th>
                        <th class="w-[25.5%] px-[24px] font-bold">Nama Bahan</th>
                        <th class="w-[21%] px-[24px] font-bold">Kategori</th>
                        <th class="w-[21%] px-[24px] font-bold">Stok Akhir</th>
                        <th class="w-[14%] px-[24px] font-bold">Satuan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($laporan as $item)
                        <tr class="h-[50px]">
                            <td class="px-[24px]">{{ $item['kode'] }}</td>
                            <td class="px-[24px] font-bold">{{ $item['nama'] }}</td>
                            <td class="px-[24px]">{{ $item['kategori'] }}</td>
                            <td class="px-[24px]">{{ $item['stok'] }}</td>
                            <td class="px-[24px]">{{ $item['satuan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-[24px] text-center text-[13px] text-[#9CA3AF]">
                                Belum ada data laporan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
