@extends('layouts.app')

@section('title', 'Barang Keluar - MBG Smart Stock')

@section('content')
    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Pengeluaran Stok (Barang Keluar)</h1>
        <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Catat pemakaian atau distribusi bahan pangan</p>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mt-[20px] rounded-[8px] bg-[#ECFDF5] px-[16px] py-[10px] font-poppins text-[13px] leading-[19.5px] font-bold text-[#059669]">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-[48px] grid grid-cols-1 gap-[32px] font-poppins lg:grid-cols-[380px_minmax(0,1fr)]">
        
        {{-- Form Pengeluaran --}}
        <div class="overflow-hidden rounded-[12px] bg-white shadow-[0_2px_8px_rgba(0,0,0,0.06)]">
            <div class="flex h-[36px] items-center gap-[10px] bg-[#D9D9D9] px-[16px]">
                <span class="flex h-[18px] w-[18px] items-center justify-center rounded-[4px] bg-[#D97706]">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1V9M1 5H9" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>

                <h2 class="text-[14px] leading-[21px] font-bold text-black">Form Pengeluaran</h2>
            </div>

            <form action="{{ route('barang-keluar.store') }}" method="POST" class="px-[16px] pt-[14px] pb-[18px]">

                @csrf
                <input type="hidden" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}">

                {{-- Nama Bahan Pangan --}}
                <div>
                    <label for="nama" class="mb-[6px] block text-[13px] leading-[19.5px] font-medium text-[#374151]">
                        Nama Bahan Pangan
                    </label>

                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" autocomplete="off" placeholder="Contoh: Beras / Minyak Sayur" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#D97706] {{ $errors->has('nama') ? 'border-[#E11D48]' : 'border-[#D9D9D9]' }}">

                    @error('nama')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div class="mt-[14px]">
                    <label for="jumlah" class="mb-[6px] block text-[13px] leading-[19.5px] font-medium text-[#374141]">
                        Jumlah Masuk
                    </label>

                    <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#D97706] {{ $errors->has('jumlah') ? 'border-[#E11D48]' : 'border-[#D9D9D9]' }}">

                    @error('jumlah')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mt-[14px]">
                    <label for="supplier" class="mb-[6px] block text-[13px] leading-[19.5px] font-medium text-[#374151]">
                        Keterangan / Pemasok
                    </label>

                    <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}" placeholder="Contoh: Distribusi Produksi" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] texr-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#D97706] {{ $errors->has('supplier') ? 'border-[#E11D48]' : 'border-[#D9D9D9]'}}">

                    @error('supplier')
                        <p class="mt-[4px] text-[11xpx] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <button type="submit" class="mt-[18px] h-[36px] w-full cursor-pointer rounded-[8px] bg-[#D97706] text-[14px] font-bold text-white transition-colors hover:bg-[#B45309]">
                    Simpan Pengeluaran
                </button>
            </form>
        </div>

        {{-- Riwayat Barang Keluar --}}
        <div class="overflow-hidden rounded-[12px] bg-white shadow-[0_2px_8px_rgba(0,0,0,0.06)]"> 
            <div class="flex h-[36px] items-center px-[16px]">
                <h2 class="text-[15px] leading-[22.5px] font-bold text-black">Riwayat Barang Keluar</h2>
            </div>

            <table class="w-full table-fixed">
                <thead>
                    <tr class="h-[38px] bg-[#D9D9D9] text-left text-[13px] leading-[19.5px] font-bold text-[#787878]">
                        <th class="w-[24%] pl-[16px] font-bold">Waktu</th>
                        <th class="w-[24%] font-bold">Bahan Pangan</th>
                        <th class="w-[20%] font-bold">Jumlah</th>
                        <th class="w-[32%] font-bold">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangKeluar as $item)
                        <tr class="h-[44px] text-[13px] leading-[19.5px]">
                            <td class="pl-[16px] text-[#959595]">{{ $item['waktu'] }}</td>
                            <td class="text-[#787878]">{{ $item['nama'] }}</td>
                            <td class="font-bold text-[#D97706]">- {{ $item['jumlah'] }} {{ $item['satuan'] }}</td>
                            <td class="pr-[16px] text-[#959595]">{{ $item['supplier'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-[24px] text-center text-[13px] text-[#9CA3AF]">
                                Belum ada riwayat barang keluar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection