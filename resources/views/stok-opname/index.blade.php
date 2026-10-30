@extends('layouts.app')

@section('title', 'Stok Opname - MBG Smart Stock')

@section('content')
    <div>
        <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Penyesuaian Stok</h1>
        <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Sesuaikan jumlah stok pada sistem dengan hitungan fisik di gudang</p>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mt-[20px] rounded-[8px] bg-[#ECFDF5] px-[16px] py-[10px] font-poppins text-[13px] leading-[19.5px] font-bold text-[#059669]">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form tersembunyi perbaris --}}
    @foreach ($stok as $i => $item)
        <form id="opname-form-{{ $i }}" method="POST" action="{{ route('stok-opname.index') }}">
            @csrf
            <input type="hidden" name="nama" value="{{ $item ['nama'] }}">
        </form>
    @endforeach

    {{-- Table Stok Opname --}}
    <div class="mt-[32px] overflow-hidden rounded-[12px] bg-white shadow-[0_2px_8px_rgba(0,0,0,0.06)] font-poppins">
        <table class="w-full table-fixed">
            <thead>
                <tr class="h-[38px] bg-[#D9D9D9] text-[13px] leading-[19.5px] font-bold text-[#787878]">
                    <th class="w-[28%] pl-[16px] text-left font-bold">Bahan Pangan</th>
                    <th class="w-[14%] text-left font-bold">Stok Sistem</th>
                    <th class="w-[20%] text-left">Stok Fisik Gudang</th>
                    <th class="w-[12%] text-left">Selisih</th>
                    <th class="w-[26%] pr-[16px] text-right font-bold">Aksi Penyesuaian</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($stok as $i => $item)
                    <tr class="h-[52px] border-b border-[#F1F5F9] leading-[19.5px] last:border-b-0">
                        <td class="pl-[16px] text-[#787878]">{{ $item['nama'] }}</td>
                        <td class="font-bold text-[#1D1D1D]">{{ $item['sistem'] }}</td>
                        <td>
                            <input type="number" name="stok_fisik" min="0" form="opname-form-{{ $i }}" placeholder="{{ $item['sistem'] }}" data-stok-fisik data-row="{{ $i }}" data-sistem="{{ $item['sistem'] }}" class="h-[34px] w-[88px] rounded-[6px] border border-[#D9D9D9] px-[8px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#2563EB]">
                        </td>
                        <td id="selisih-{{ $i }}" class="font-bold text-[#959595]">-</td>
                        <td class="pr-[16px] text-right">
                            <button type="submit" form="opname-form-{{ $i }}" class="h-[30px] cursor-pointer rounded-[6px] bg-[#2563EB] px-[14px] text-[12px] font-bold text-white transition-colors hover:bg-[#1D4ED8]">
                                Sesuaikan
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-[24px] text-center text-[13px] text-[#9CA3AF]">
                            Belum ada data stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Hitung selisih otomatis --}}

@endsection