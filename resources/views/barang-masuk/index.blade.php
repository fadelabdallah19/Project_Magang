@extends('layouts.app')

@section('title', 'Penerimaan Bahan - MBG Smart Stock')

@section('content')
    {{-- Judul halaman --}}
    {{-- <div>
        <h1 class="text-[20px] leading-[1.3] font-bold tracking-[-0.025em] text-[#182230]">
            Penerimaan Bahan
        </h1>
        <p class="mt-[3px] text-[11px] text-[#6D7B90]">
            Catat dan verifikasi seluruh bahan pangan yang masuk
        </p>
    </div> --}}

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mt-4 rounded-[10px] border border-[#B7E4CD] bg-[#EDF7F1] px-4 py-3 text-[12px] font-semibold text-[#257A59]">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-[10px] border border-[#F3C7C7] bg-[#FFF0F0] px-4 py-3 text-[12px] font-semibold text-[#D94E4E]">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 items-start gap-5 lg:grid-cols-[380px_minmax(0,1fr)]">

        {{-- Form Penerimaan --}}
        <section class="overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="flex min-h-[90px] items-center gap-3 border-b border-[#D9E1EB] px-[26px] pt-[22px] pb-4">
                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-[9px] bg-[#EDF7F1] text-[#257A59]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 17V3"></path>
                        <path d="m6 11 6 6 6-6"></path>
                        <path d="M19 21H5"></path>
                    </svg>
                </div>

                <div>
                    <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">Form Penerimaan</p>
                    <p class="mt-[3px] text-[12px] text-[#6D7B90]">Catat bahan yang masuk ke gudang</p>
                </div>
            </div>

            <form action="{{ route('barang-masuk.store') }}" method="POST" class="space-y-[14px] p-[20px_26px_26px]">
                @csrf

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                        Tanggal Penerimaan
                    </label>

                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="h-[43px] w-full rounded-[9px] border px-3 text-[12px] text-[#182230] outline-none transition-colors focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] {{ $errors->has('tanggal') ? 'border-[#D94E4E]' : 'border-[#D9E1EB]' }}">

                    @error('tanggal')
                        <p class="mt-[4px] text-[10px] text-[#D94E4E]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bahan Pangan --}}
                <div>
                    <label for="bahan" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                        Bahan Pangan
                    </label>

                    <div class="relative">
                        <select name="kode" id="bahan" class="h-[43px] w-full appearance-none rounded-[9px] border bg-white px-3 pr-9 text-[12px] text-[#182230] outline-none transition-colors focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] {{ $errors->has('kode') ? 'border-[#D94E4E]' : 'border-[#D9E1EB]' }}">
                            <option value="">Pilih bahan pangan...</option>
                            @foreach ($bahan as $item)
                                <option value="{{ $item->kode }}" data-satuan="{{ $item->satuan }}" @selected(old('kode') === $item->kode)>
                                    {{ $item->nama }} — {{ $item->kode }}
                                </option>
                            @endforeach
                        </select>

                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-[#6D7B90]" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </div>

                    @error('kode')
                        <p class="mt-[4px] text-[12px] text-[#D94E4E]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah & Satuan --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="jumlah" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                            Jumlah Masuk
                        </label>

                        <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah') }}" placeholder="0" class="h-[43px] w-full rounded-[9px] border px-3 text-[12px] text-[#182230] outline-none transition-colors placeholder:text-[#9BA6B6] focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] {{ $errors->has('jumlah') ? 'border-[#D94E4E]' : 'border-[#D9E1EB]' }}">

                        @error('jumlah')
                            <p class="mt-[4px] text-[10px] text-[#D94E4E]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="satuan" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                            Satuan
                        </label>

                        <input type="text" id="satuan" name="satuan" value="{{ old('satuan') }}" readonly placeholder="Otomatis" class="h-[43px] w-full cursor-default rounded-[9px] border bg-[#F8FAFC] px-3 text-[12px] text-[#6D7B90] outline-none {{ $errors->has('satuan') ? 'border-[#D94E4E]' : 'border-[#D9E1EB]' }}">

                        @error('satuan')
                            <p class="mt-[4px] text-[12px] text-[#D94E4E]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Pemasok --}}
                <div>
                    <label for="supplier" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                        Pemasok / Keterangan
                    </label>

                    <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}" placeholder="Contoh: PT Pangan Sejahtera" class="h-[43px] w-full rounded-[9px] border px-3 text-[12px] text-[#182230] outline-none transition-colors placeholder:text-[#9BA6B6] focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] {{ $errors->has('supplier') ? 'border-[#D94E4E]' : 'border-[#D9E1EB]' }}">

                    @error('supplier')
                        <p class="mt-[4px] text-[12px] text-[#D94E4E]">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="mt-1 inline-flex h-[42px] w-full items-center justify-center gap-2 rounded-[10px] bg-[#397BD8] text-[12px] font-semibold text-white shadow-[0_4px_9px_rgba(45,105,190,0.22)] transition-all hover:-translate-y-px hover:bg-[#2869C2]">
                    Simpan Penerimaan
                </button>
            </form>
        </section>

        {{-- Riwayat Penerimaan --}}
        <section class="overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="flex min-h-[90px] items-center justify-between gap-4 px-[26px] pt-[22px] pb-4">
                <div>
                    <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">Riwayat Penerimaan</p>
                    <p class="mt-[3px] text-[12px] text-[#6D7B90]">
                        {{ count($barangMasuk) }} transaksi tercatat
                    </p>
                </div>
            </div>

            <div class="px-[26px] pb-5">
                <label class="flex h-[45px] items-center gap-[11px] rounded-[9px] border border-[#D9E1EB] bg-[#F7F9FC] px-[14px] text-[#6D7B90] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21 21-4.34-4.34"></path>
                        <circle cx="11" cy="11" r="8"></circle>
                    </svg>

                    <input id="masuk-search" type="search" placeholder="Cari no. penerimaan, bahan, atau pemasok..." aria-label="Cari riwayat penerimaan" class="min-w-0 flex-1 bg-transparent text-[12px] text-[#182230] outline-none placeholder:text-[#9BA6B6]">
                </label>
            </div>

            <div class="mx-[26px] mb-[26px] overflow-x-auto rounded-[12px] border border-[#D9E1EB]">
                <table class="w-full min-w-[560px] border-collapse">
                    <thead>
                        <tr>
                            <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Tanggal</th>
                            <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Bahan Pangan</th>
                            <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Jumlah</th>
                            <th class="h-[47px] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($barangMasuk as $item)
                            <tr data-masuk-row data-cari="{{ strtolower($item->no_transaksi . ' ' . $item->bahan->kode . ' ' . $item->bahan->nama . ' ' . ($item->supplier ?? '') . ' ' . $item->tanggal->format('d M Y')) }}">
                                <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap">
                                    <p class="font-semibold text-[#182230]">{{ $item->tanggal->format('d M Y') }}</p>
                                    <span class="mt-[3px] block text-[10px] text-[#98A4B4]">{{ $item->no_transaksi }}</span>
                                </td>

                                <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap">
                                    <p class="font-semibold text-[#182230]">{{ $item->bahan->nama }}</p>
                                    <span class="mt-[3px] block text-[10px] text-[#6D7B90]">{{ $item->bahan->kode }} . {{ $item->supplier ?? 'Tanpa pemasok' }}</span>
                                </td>

                                <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-bold whitespace-nowrap text-center text-[#257A59]">
                                    + {{ number_format($item->jumlah, 0, ',', '.') }} {{ $item->satuan }}
                                </td>

                                <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] text-center whitespace-nowrap">
                                    <span class="inline-flex min-h-[23px] items-center rounded-full bg-[#EDF7F1] px-[20px] py-[3px] text-[12px] font-semibold whitespace-nowrap text-[#357A59]">Diterima</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="h-[200px] border-t border-[#D9E1EB] px-5 text-center">
                                    <div class="grid min-h-[200px] place-items-center text-[#98A4B4]">
                                        <div>
                                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                                <path d="M12 17V3"></path>
                                                <path d="m6 11 6 6 6-6"></path>
                                                <path d="M19 21H5"></path>
                                            </svg>

                                            <p class="mt-3 text-[12px] font-semibold text-[#182230]">Belum ada riwayat</p>
                                            <span class="mt-[5px] block text-[10px]">Penerimaan yang dicatat akan muncul disini.</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        @if (count($barangMasuk) > 0)
                            <tr id="masuk-filter-empty" class="hidden">
                                <td colspan="4" class="h-[200px] border-t border-[#D9E1EB] px-5 text-center">
                                    <div class="grid min-h-[200px] place-items-center text-[#98A4B4]">
                                        <div>
                                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                                <path d="m21 21-4.34-4.34"></path>
                                                <circle cx="11" cy="11" r="8"></circle>
                                            </svg>
                                            <p class="mt-3 text-[12px] font-semibold text-[#182230]">Data penerimaan tidak ditemukan</p>
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
    </div>
@endsection