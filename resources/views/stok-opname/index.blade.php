@extends('layouts.app')

@section('title', 'Stok Opname - MBG Smart Stock')

@section('content')

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mt-4 rounded-[10px] border border-[#B7E4CD] bg-[#EDF7F1] px-4 py-3 text-[12px] font-semibold text-[#257A59]">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-4 rounded-[10px] border border-[#F3C7C7] bg-[#FFF0F0] px-4 py-3 text-[12px] font-semibold text-[#D94E4E]">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Form tersembunyi per baris --}}
    @foreach ($stok as $i => $item)
        <form action="{{ route('stok-opname.store') }}" id="opname-form-{{ $i }}" method="POST">
            @csrf
            <input type="hidden" name="bahan_id" value="{{ $item->id }}">
        </form>
    @endforeach

    {{-- Kartu stok opname --}}
    <section class="mt-6 overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">

        {{-- Header kartu --}}
        <div class="flex min-h-[90px] items-center justify-between gap-[18px] px-[26px] pt-[22px] pb-4 max-[560px]:min-h-0 max-[560px]:flex-col max-[560px]:items-start max-[560px]:p-[19px_16px]">
            <div>
                <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">
                    Daftar Stok Opname
                </p>
                <p class="mt-[5px] text-[12px] leading-[1.45] text-[#6D7B90]">
                    Masukkan jumlah fisik gudang, lalu sesuaikan stok sistem.
                </p>
            </div>

            <span class="inline-flex h-[30px] items-center rounded-full bg-[#EDF4FF] px-[12px] text-[14px] font-semibold whitespace-nowrap text-[#2D76D6]">
                {{ count($stok) }} Bahan
            </span>
        </div>

        {{-- Pencarian --}}
        <div class="px-[26px] pb-[24px] max-[800px]:px-[18px] max-[560px]:px-4 max-[560px]:pb-[18px]">
            <label class="flex h-[45px] items-center gap-[11px] rounded-[9px] border border-[#D9E1EB] bg-[#F7F9FC] px-[14px] text-[#6D7B90] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21 21-4.34-4.34"></path>
                    <circle cx="11" cy="11" r="8"></circle>
                </svg>

                <input id="opname-search" type="search" placeholder="Cari bahan pangan..." aria-label="Cari bahan pangan" class="min-w-0 flex-1 bg-transparent text-[12px] text-[#182230] outline-none placeholder:text-[#9BA6B6]">
            </label>
        </div>

        {{-- Tabel --}}
        <div class="mx-[26px] mb-[26px] overflow-x-auto rounded-[12px] border border-[#D9E1EB] max-[800px]:mx-[18px] max-[560px]:mx-4 max-[560px]:mb-4">
            <table class="w-full min-w-[820px] table-fixed border-collapse">
                <thead>
                    <tr>
                        <th class="h-[47px] w-[30%] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[11px] font-bold tracking-[0.02em] text-[#627087] uppercase">Bahan Pangan</th>
                        <th class="h-[47px] w-[14%] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[11px] font-bold tracking-[0.02em] text-[#627087] uppercase">Stok Sistem</th>
                        <th class="h-[47px] w-[20%] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[11px] font-bold tracking-[0.02em] text-[#627087] uppercase">Stok Fisik Gudang</th>
                        <th class="h-[47px] w-[14%] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[11px] font-bold tracking-[0.02em] text-[#627087] uppercase">Selisih</th>
                        <th class="h-[47px] w-[22%] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[11px] font-bold tracking-[0.02em] text-[#627087] uppercase">Aksi Penyesuaian</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stok as $i => $item)
                        <tr data-opname-row data-cari="{{ strtolower($item->nama . ' ' . $item->kode) }}">
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap">
                                <p class="font-bold text-[#182230]">{{ $item->nama }}</p>
                                <span class="mt-[3px] block text-[11px] text-[#6D7B90]">
                                    {{ $item->kode }} · Satuan {{ $item->satuan }}
                                </span>
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] font-bold whitespace-nowrap text-[#182230]">
                                {{ number_format($item->stok, 0, ',', '.') }}
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5">
                                <input type="number" name="stok_fisik" min="0" required form="opname-form-{{ $i }}" placeholder="{{ $item->stok }}" data-stok-fisik data-row="{{ $i }}" data-sistem="{{ $item->stok }}" aria-label="Stok fisik {{ $item->nama }}" class="h-[43px] w-[120px] rounded-[9px] border border-[#D9E1EB] px-3 text-[12px] text-[#182230] outline-none transition-colors placeholder:text-[#9BA6B6] focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span id="selisih-{{ $i }}" class="inline-flex min-h-[23px] items-center rounded-full bg-[#F4F6FA] px-[10px] py-[3px] text-[12px] font-semibold whitespace-nowrap text-[#6D7B90]">-</span>
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center">
                                <button type="submit" form="opname-form-{{ $i }}" class="inline-flex h-[34px] items-center justify-center rounded-[8px] bg-[#EDF4FF] px-[14px] text-center text-[12px] font-semibold whitespace-nowrap text-[#2D76D6] transition-all hover:-translate-y-px hover:bg-[#DDEBFF]">
                                    Sesuaikan
                                </button>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="h-[200px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[200px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Belum ada data stok</p>
                                        <span class="mt-[5px] block text-[10px]">Data stok bahan akan muncul di sini.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if (count($stok) > 0)
                        <tr id="opname-filter-empty" class="hidden">
                            <td colspan="5" class="h-[200px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[200px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="m21 21-4.34-4.34"></path>
                                            <circle cx="11" cy="11" r="8"></circle>
                                        </svg>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Data stok tidak ditemukan</p>
                                        <span class="mt-[5px] block text-[10px]">Coba gunakan kata kunci lain.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection