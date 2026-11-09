@extends('layouts.app')

@section('title', 'Manajemen Bahan Pangan - MBG Smart Stock')

@section('content')
    @php
        $kategoriList = $bahan->pluck('kategori')->unique()->sort()->values();
        $stokMinimum = \App\Models\Bahan::STOCK_MINIMUM;
    @endphp

    {{-- Judul halaman --}}
    {{-- <div class="flex items-start justify-between">
        <div>
            <h1 class="text-[20px] leading-[1.3] font-bold tracking-[-0.025em] text-[#182230]">
                Manajemen Bahan Pangan
            </h1>
            <p class="mt-[3px] text-[11px] text-[#6D7B90]">
                Kelola data master bahan makanan, kategori, dan batas minimum
            </p>
        </div>
    </div> --}}

    @if (session('success'))
        <div class="mt-4 rounded-[10px] border border-[#B7E4CD] bg-[#EDF7F1] px-4 py-3 text-[11px] font-semibold text-[#257A59]">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-[10px] border border-[#F3C7C7] bg-[#FFF0F0] px-4 py-3 text-[11px] font-semibold text-[#D94E4E]">
            {{ session('error') }}
        </div>
    @endif

    {{-- Kartu daftar bahan --}}
    <section class="mt-6 overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">

        {{-- Header kartu --}}
        <div class="flex min-h-[90px] items-center justify-between gap-[18px] px-[26px] pt-[22px] pb-[16px] max-[800px]:px-[18px] max-[560px]:min-h-0 max-[560px]:flex-col max-[560px]:items-start max-[560px]:p-[19px_16px]">
            <div>
                <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">
                    Daftar Bahan Pangan
                </p>
                <p class="mt-[5px] text-[14px] leading-[1.45] text-[#6D7B90]">
                    Kelola master data bahan baku untuk kebutuhan produksi makanan bergizi
                </p>
            </div>

            <button type="button" data-modal-open class="inline-flex h-[42px] items-center justify-center gap-2 rounded-[10px] bg-[#397BD8] px-4 text-[12px] font-semibold whitespace-nowrap text-white shadow-[0_4px_9px_rgba(45,105,190,0.22)] transition-all hover:-translate-y-px hover:bg-[#2869C2] max-[560px]:w-full">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                Tambah Bahan
            </button>
        </div>

        {{-- Search & filter --}}
        <div class="flex gap-[15px] px-[26px] pt-[5px] pb-[24px] max-[800px]:px-[18px] max-[560px]:flex-col max-[560px]:items-stretch max-[560px]:px-4 max-[560px]:pb-[18px]">
            <label class="flex h-[45px] min-w-0 flex-1 items-center gap-[11px] rounded-[9px] border border-[#D9E1EB] bg-[#F7F9FC] px-[14px] text-[#6D7B90] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21 21-4.34-4.34"></path>
                    <circle cx="11" cy="11" r="8"></circle>
                </svg>

                <input id="bahan-search" type="search" placeholder="Cari berdasarkan nama atau kode bahan..." aria-label="Cari bahan pangan" class="min-w-0 flex-1 bg-transparent text-[14px] text-[#182230] outline-none placeholder:text-[#9BA6B6]">
            </label>

            <label class="relative flex h-[45px] w-[180px] items-center rounded-[9px] border border-[#D9E1EB] bg-white px-[13px] text-[#182230] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] max-[560px]:w-full">
                <select id="bahan-kategori" aria-label="Filter kategori"
                    class="h-full w-full appearance-none bg-transparent pr-5 text-[14px] outline-none">
                    <option>Semua Kategori</option>
                    @foreach ($kategoriList as $kategori)
                        <option>{{ $kategori }}</option>
                    @endforeach
                </select>

                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute right-3" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg>
            </label>
        </div>

        {{-- Tabel --}}
        <div class="mx-[26px] mb-[26px] overflow-x-auto rounded-[12px] border border-[#D9E1EB] max-[800px]:mx-[18px] max-[560px]:mx-4 max-[560px]:mb-4">
            <table class="w-full min-w-[930px] border-collapse">
                <thead>
                    <tr>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Kode Bahan</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Nama Bahan</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Kategori</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Satuan</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-right text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Stok Tersedia</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-right text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Stok Minimum</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Status</th>
                        <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bahan as $item)
                        @php
                            $stokRendahItem = $item->stok <= $stokMinimum;
                        @endphp

                        <tr data-bahan-row data-kode="{{ strtolower($item->kode) }}" data-nama="{{ strtolower($item->nama) }}" data-kategori="{{ $item->kategori }}">
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-semibold whitespace-nowrap text-[#2677DF]">{{ $item->kode }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-bold whitespace-nowrap">{{ $item->nama }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap text-[#6D7B90]">{{ $item->kategori }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] text-center whitespace-nowrap">{{ $item->satuan }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-bold whitespace-nowrap text-center">{{ number_format($item->stok, 0, ',', '.') }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap text-center text-[#6D7B90]">{{ number_format($stokMinimum, 0, ',', '.') }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span class="inline-flex min-h-[23px] items-center rounded-full px-[10px] py-[3px] text-[9px] font-semibold whitespace-nowrap {{ $stokRendahItem ? 'bg-[#FFF0F0] text-[#D94E4E]' : 'bg-[#EDF7F1] text-[#257A59]' }}">
                                    {{ $stokRendahItem ? 'Stok Rendah' : 'Aman' }}
                                </span>
                            </td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap">
                                <div class="flex items-center justify-center gap-[9px]">
                                    <button type="button" data-modal-edit data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-kategori="{{ $item->kategori }}" data-stok="{{ $item->stok }}" data-satuan="{{ $item->satuan }}" title="Edit {{ $item->nama }}" aria-label="Edit {{ $item->nama }}" class="grid h-[34px] w-[34px] shrink-0 place-items-center rounded-[8px] bg-[#EDF4FF] text-[#2D76D6] transition-transform hover:-translate-y-px" >
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                            <path d="m15 5 4 4"></path>
                                        </svg>
                                    </button>

                                    <form method="POST" action="{{ route('bahan.destroy', $item->kode) }}" onsubmit="return confirm('Hapus bahan pangan ini?')" class="shrink-0">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="Hapus {{ $item->nama }}" aria-label="Hapus {{ $item->nama }}" class="grid h-[34px] w-[34px] place-items-center rounded-[8px] bg-[#FFF0F0] text-[#D94E4E] transition-transform hover:-translate-y-px">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M10 11v6"></path>
                                                <path d="M14 11v6"></path>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="h-[220px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[220px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="m7.5 4.27 9 5.15"></path>
                                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                            <path d="m3.3 7 8.7 5 8.7-5"></path>
                                            <path d="M12 22V12"></path>
                                        </svg>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Belum ada data bahan pangan</p>
                                        <span class="mt-[5px] block text-[10px]">Tambahkan bahan pangan untuk mulai mengelola persediaan.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if ($bahan->isNotEmpty())
                        <tr id="bahan-filter-empty" class="hidden">
                            <td colspan="8" class="h-[220px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[220px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="m21 21-4.34-4.34"></path>
                                            <circle cx="11" cy="11" r="8"></circle>
                                        </svg>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Data bahan tidak ditemukan</p>
                                        <span class="mt-[5px] block text-[10px]">Coba gunakan kata kunci atau kategori lain.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    {{-- Tambah Bahan Pangan --}}
    <div id="modal-tambah" data-modal data-open-on-error="{{ $errors->any() && old('_modal') === 'tambah' ? 'true' : 'false' }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-white/10 p-4 backdrop-blur-[3px]">
        <div class="w-full max-w-[606px] overflow-hidden rounded-[15px] bg-white shadow-[0_20px_60px_rgba(7,30,63,0.25)]">

            {{-- Header Modal --}}
            <div class="flex h-[50px] items-center justify-between bg-[#E5E7EB] px-[26px]">
                <h2 class="font-poppins text-[18px] leading-[27px] font-bold text-[#1D1D1D]">
                    Tambah Data Bahan Pangan Baru
                </h2>

                <button type="button" data-modal-close aria-label="Tutup" class="cursor-pointer text-[#1D1D1D] transition-opacity hover:opacity-60">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4L14 14M14 4L4 14" stroke="#1D1D1D" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            {{-- Body Modal --}}
            <form action="{{ route('bahan.store') }}" method="POST" class="px-[26px] pt-[20px] pb-[28px] font-poppins">

                @csrf
                <input type="hidden" name="_modal" value="tambah">

                {{-- Kode Bahan --}}
                <div>
                    <label for="kode" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Kode Bahan
                    </label>

                    <input type="text" id="kode" name="kode" value="{{ old('kode') }}" placeholder="Contoh: MBG-001" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('kode') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('kode')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Bahan Pangan --}}
                <div class="mt-[14px]">
                    <label for="nama" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Nama Bahan Pangan
                    </label>

                    <input type="text" id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Contoh: Beras / Minyak Sayur" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transtition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('nama') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('nama')
                        <p class="mt-[4px] text-[11px] text-[#9CA3AF]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mt-[14px]">
                    <label for="kategori" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Kategori
                    </label>

                    <input type="text" name="kategori" id="kategori" placeholder="Contoh: Sembako" value="{{ old('kategori') }}" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('kategori') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('kategori')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok Awal dan Satuan --}}
                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="stok" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                            Stok Awal
                        </label>

                        <input type="number" id="stok" name="stok" min="0" placeholder="120" value="{{ old('stok') }}" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('stok') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('stok')
                            <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="satuan" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                            Satuan
                        </label>

                        <input type="text" id="satuan" name="satuan" placeholder="Contoh: Kg / Liter / Gram" value="{{ old('satuan') }}" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('satuan') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('satuan')
                            <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mt-[24px] flex items-center justify-end gap-[14px]">
                    <button type="button" data-modal-close class="h-[34px] cursor-pointer rounded-[8px] border border-[#FFF1F2] px-[22px] text-[14px] font-bold text-[#E11D48] transition-colors hover:bg-[#FFF1F2]">
                        Batal
                    </button>

                    <button type="submit" class="h-[34px] cursor-pointer rounded-[8px] bg-[#0088FF] px-[22px] text-[14px] font-bold text-white transition-colors hover:bg-[#0077E6]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Bahan Pangan --}}
    <div id="modal-edit" data-modal data-open-on-error="{{ $errors->any() && old('_modal') === 'edit' ? 'true' : 'false' }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-white/10 p-4 backdrop-blur-[3px]">
        <div class="w-full max-w-[600px] overflow-hidden rounded-[15px] bg-white shadow-[0_20px_60px_rgba(7,30,63,0.35)]">

            {{-- Header Modal --}}
            <div class="flex h-[50px] items-center justify-between bg-[#E5E7EB] px-[26px]">
                <h2 class="font-poppins text-[18px] leading-[27px] font-bold text-[#1D1D1D]">
                    Edit Bahan Pangan
                </h2>

                <button type="button" data-modal-close aria-label="Tutup" class="cursor-pointer text-[#1D1D1D] transition-opacity hover:opacity-60">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4L14 14M14 4L4 14" stroke="#1D1D1D" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            {{-- Body Modal --}}
            <form  action="{{ route('bahan.update', old('kode_awal', '__KODE__')) }}" id="form-edit" method="POST" data-action="{{ route('bahan.update', '__KODE__') }}" class="px-[26px] pt-[20px] pb-[28px] font-poppins">

                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="edit">
                <input type="hidden" name="kode_awal" value="{{ old('kode_awal') }}">

                {{-- Kode Bahan --}}
                <div>
                    <label for="edit-kode" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Kode Bahan
                    </label>

                    <input type="text" id="edit-kode" name="kode" value="{{ old('kode') }}" placeholder="Contoh: MBG-001" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('kode') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('kode')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Bahan Pangan --}}
                <div class="mt-[14px]">
                    <label for="edit-nama" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Nama Bahan Pangan
                    </label>

                    <input type="text" id="edit-nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Beras / Minyak Sayur" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('nama') ? 'border-[#E11D48]' : 'border-[#E5E7EB]'}}">
                    @error('nama')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mt-[14px]">
                    <label for="edit-kategori" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                        Kategori
                    </label>

                    <input type="text" name="kategori" id="edit-kategori" value="{{ old('kategori') }}" placeholder="Contoh: Sembako" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('kategori') ? 'border-[#E11D48]' : 'border-[#E5E7EB]'}}">
                    @error('kategori')
                        <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok dan Satuan --}}
                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="edit-stok" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                            Stok
                        </label>

                        <input type="number" name="stok" id="edit-stok" min="0" value="{{ old('stok') }}" placeholder="Contoh: 120" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('stok') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('stok')
                            <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="edit-satuan" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">
                            Satuan
                        </label>

                        <input type="text" id="edit-satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Kg / Liter / Gram" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('satuan') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('satuan')
                            <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mt-[24px] flex items-center justify-end gap-[14px]">
                    <button type="button" data-modal-close class="h-[34px] cursor-pointer rounded-[8px] border border-[#FFF1F2] px-[22px] text-[14px] font-bold text-[#E11D48] transition-colors hover:bg-[#FFF1F2]">
                        Batal
                    </button>

                    <button type="submit" class="h-[34px] cursor-pointer rounded-[8px] bg-[#0088FF] px-[22px] text-[14px] font-bold text-white transition-colors hover:bg-[#0077E6]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection