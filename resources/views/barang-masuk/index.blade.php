@extends('layouts.app')

@section('title', 'Barang Masuk - MBG Smart Stock')

@section('content')
    {{-- Judul Halaman --}}
    <div>
        <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Penerimaan Stok (Barang Masuk)</h1>
        <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Catat Penerimaan Barang Masuk</p>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mt-[20px] rounded-[8px] bg-[#ECFDF5] px-[16px] py-[10px] font-poppins text-[13px] leading-[19.5px] font-bold text-[#059669]">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-[48px] grid grid-cols-1 gap-[32px] font-poppins lg:grid-cols-[380px_minmax(0,1fr)]">

        {{-- Form Penerimaan --}}
        <div class="overflow-hidden rounded-[12px] bg-white shadow-[0_2px_8px_rgba(0,0,0,0.06)]">
            <div class="flex h-[36px] items-center gap-[10px] bg-[#D9D9D9] px-[16px]">
                 <span class="flex h-[18px] w-[18px] items-center justify-center rounded-[4px] bg-[#059669]">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1V9M1 5H9" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </span>
                <h2 class="text-[14px] leading-[21px] font-bold text-black">Form Penerimaan</h2>
            </div>

            <form action="{{ route('barang-masuk.store') }}" method="POST" class="px-[16px] pt-[14px] pb-[18px]">
                @csrf
                <input type="hidden" name="_modal" id="masuk">
                
                {{-- Nama Bahan Pangan --}}
                <div>
                    <label for="bahan" class="mb-[6px] block text-[13px] leading-[19.5px] font-medium text-[#374151]">
                        Nama Bahan Pangan
                    </label>

                    <input type="text" name="nama" id="bahan" value="{{ old('nama') }}" list="daftar-bahan" autocomplete="off" placeholder="Contoh: Beras / Minyak Sayur" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#059669] {{ $errors->has('nama') ? 'border-[#E11D48]' : 'border-[#D9D9D9]'}}">
                    
                    @error('nama')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah Masuk --}}
                <div class="mt-[14px]">
                    <label for="jumlah" class="mb-[6px] block text-[13px] leading-[19.5px] font-medium text-[#374151]">
                        Jumlah Masuk
                    </label>

                    <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#059669] {{ $errors->has('jumlah') ? 'border-[#E11D48]' : 'border-[#D9D9D9]' }}">

                    @error('jumlah')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan Pemasok --}}
                <div class="mt-[14px]">
                    <label for="supplier" class="mb-[6px] block text-[13px] leading-[19px] font-medium text-[#374151]">
                        Keterangan / Pemasok
                    </label>

                    <input type="text" name="supplier" id="supplier" value="{{ old('supplier') }}" placeholder="Contoh: Pengiriman Gudang Utama" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#059669] {{ $errors->has('supplier') ? 'border-[#E11D48]' : 'border-[#D9D9D9]' }}">

                    @error('supplier')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <button type="submit" class="mt-[18px] h-[36px] w-full cursor-pointer rounded-[8px] bg-[#059669] text-[14px] font-bold text-white transition-colors hover:bg-[#047857]">
                    Simpan Penerimaan
                </button>
            </form>
        </div>

        {{-- Riwayat Barang Masuk --}}
        <div class="overflow-hidden rounded-[12px] bg-white shadow-[0_2px_8px_rgba(0,0,0,0.06)]">
            <div class="flex h-[36px] items-center px-[16px]">
                <h2 class="text-[15px] leading-[22.5px] font-bold text-black">Riwayat Barang Masuk</h2>
            </div>

            <table class="w-full table-fixed">
                <thead>
                    <tr class="h-[38px] bg-[#D9D9D9] text-left text-[13px] leading-[19.5px] font-bold text-[#787878]">
                        <th class="w-[23%] pl-[16px] font-bold">Waktu</th>
                        <th class="w-[24%] font-bold">Bahan Pangan</th>
                        <th class="w-[20%] font-bold">Jumlah</th>
                        <th class="w-[32%] font-bold">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangMasuk as $item)
                        <tr class="h-[44px] text-[13px] leading-[19.5px]">
                            <td class="pl-[16px] text-[#959595]">{{ $item['waktu'] ?? $item['tanggal'] }}</td>
                            <td class="text-[#787878]">{{ $item['nama']}}</td>
                            <td class="font-bold text-[#059669]">+ {{ $item['jumlah'] }} {{ $item['satuan'] }}</td>
                            <td class="pr-[16px] text-[#959595]">{{ $item['supplier'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-[24px] text-center text-[13px] text-[#9CA3AF]">
                                Belum Ada Riwayat Barang Masuk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection