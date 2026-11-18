@extends('layouts.app')

@section('title', 'Laporan Gudang - MBG Smart Stock')

@section('content')
    @php
        $stokMinimum = \App\Models\Bahan::STOCK_MINIMUM;
        $adaStokRendah = collect($laporan)->contains(fn ($item) => $item['stok'] <= $stokMinimum);
        $statusKetersediaan = $adaStokRendah ? 'Stok Rendah' : 'Aman';
        $statusAman = $statusKetersediaan === 'Aman';
    @endphp

    @php
        $quickRanges = [
            'Hari Ini' => [now()->toDateString(), now()->toDateString()],
            '7 Hari Terakhir' => [now()->subDays(6)->toDateString(), now()->toDateString()],
            'Bulan Ini' => [now()->startOfMonth()->toDateString(), now()->toDateString()],
        ];
    @endphp
    
    {{-- filter laporan --}}
    <section class="mt-6 rounded-[15px] border border-[#D9E1EB] bg-white p-5 shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
        <div class="mb-4 flex flex-wrap items-center gap-2">
            <span class="text-[12px] font-semibold text-[#6D7B90]">Rekap Laporan</span>
            @foreach ($quickRanges as $label => [$quickDari, $quickSampai])
                <a href="{{ route('laporan.index', array_filter([
                'dari' => $quickDari,
                'sampai'=> $quickSampai,
                'kategori' => $kategori,
                ])) }}"
                class="inline-flex h-[32px] items-center rounded-full border px-3 text-[11px] font-semibold transition-colors {{ $dari === $quickDari && $sampai === $quickSampai ? 'border-[#397BD8] bg-[#EDF4FF] text-[#2D76D6]' : 'border-[#D9E1EB] bg-white text-[#485A70] hover:bg-[#F7F9FC]'}}">{{ $label }}</a>
            @endforeach
        </div>
        <form action="{{ route('laporan.index') }}" method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1fr_auto] lg:items-end">

            <div>
                <label for="dari" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                    Dari Tanggal
                </label>

                <input type="date" id="dari" name="dari" value="{{ old('dari', $dari) }}" class="h-[43px] w-full rounded-[9px] border border-[#D9E1EB] px-3 text-[12px] text-[#182230] outline-none transition-colors focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                @error('dari')
                    <p class="mt-[4px] text-[12px] text-[#D94E4E]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sampai" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                    Sampai Tanggal
                </label>

                <input type="date" id="sampai" name="sampai" value="{{ old('sampai', $sampai) }}" class="h-[43px] w-full rounded-[9px] border border-[#D9E1EB] px-3 text-[12px] text-[#182230] outline-none transition-colors focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]" >
                @error('sampai')
                    <p class="mt-[4px] text-[12px] text-[#D94E4E]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori" class="mb-[7px] block text-[12px] font-semibold text-[#485A70]">
                    Kategori
                </label>

                <select name="kategori" id="kategori" class="h-[43px] w-full appearance-none rounded-[9px] border border-[#D9E1EB] border border-[#D9E1EB] bg-white px-3 text-[12px] text-[#182230] outline-none transition-colors focus:border-[#86AFE6] focus:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $itemKategori)
                        <option value="{{ $itemKategori }}" @selected(old('kategori', $kategori) === $itemKategori)>{{ $itemKategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex h-[43px] flex-1 items-center justify-center rounded-[9px] bg-[#397BD8] px-4 text-[12px] font-semibold whitespace-nowrap text-white shadow-[0_4px_9px_rgba(45,105,190,0.22)]">
                    Terapkan
                </button>

                <a href="{{ route('laporan.index') }}" class="inline-flex h-[43px] items-center justify-center rounded-[9px] border border-[#D9E1EB] bg-white px-4 text-[12px] font-semibold whitespace-nowrap text-[#485A70] transition-colors hover:bg-[#F7F9FC]">
                    Reset
                </a>
            </div>
        </form>

        <p class="mt-3 text-[11px] text-[#6D7B90]">
            Menampilkan periode {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
        </p>
    </section>

    {{-- Ringkasan --}}
    <div class="mt-5 grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-5">
        <article class="flex items-center justify-between rounded-[15px] border border-[#D9E1EB] bg-white p-5 shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold tracking-[0.02em] text-[#6D7B90] uppercase">Total Jenis Barang</p>
                <p class="mt-[5px] text-[22px] font-bold text-[#182230]">{{ $ringkasan['jenis'] }}</p>
            </div>

            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-[10px] bg-[#EDF4FF] text-[#2D76D6]">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m7.5 4.27 9 5.15"></path>
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                    <path d="m3.3 7 8.7 5 8.7-5"></path>
                    <path d="M12 22V12"></path>
                </svg>
            </div>
        </article>

        <article class="flex items-center justify-between rounded-[15px] border border-[#D9E1EB] bg-white p-5 shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold tracking-[0.02em] text-[#6D7B90] uppercase">Transaksi Masuk</p>
                <p class="mt-[5px] text-[22px] font-bold text-[#257A59]">{{ $ringkasan['masuk'] }}</p>
            </div>

            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-[10px] bg-[#EDF7F1] text-[#257A59]">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 17V3"></path>
                    <path d="m6 11 6 6 6-6"></path>
                    <path d="M19 21H5"></path>
                </svg>
            </div>
        </article>

        <article class="flex items-center justify-between rounded-[15px] border border-[#D9E1EB] bg-white p-5 shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold tracking-[0.02em] text-[#6D7B90] uppercase">Transaksi Keluar</p>
                <p class="mt-[5px] text-[22px] font-bold text-[#C57822]">{{ $ringkasan['keluar'] }}</p>
            </div>

            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-[10px] bg-[#FFF5E9] text-[#C57822]">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m18 9-6-6-6 6"></path>
                    <path d="M12 3v14"></path>
                    <path d="M5 21h14"></path>
                </svg>
            </div>
        </article>

        <article class="flex items-center justify-between rounded-[15px] border border-[#D9E1EB] bg-white p-5 shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold tracking-[0.02em] text-[#6D7B90] uppercase">Status Ketersediaan</p>
                <p class="mt-[5px] text-[22px] font-bold {{ $statusAman ? 'text-[#257A59]' : 'text-[#D94E4E]' }}">
                    {{ $statusKetersediaan }}
                </p>
            </div>

            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-[10px] {{ $statusAman ? 'bg-[#EDF7F1] text-[#257A59]' : 'bg-[#FFF0F0] text-[#D94E4E]' }}">
                @if ($statusAman)
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.5 3.8 17 5 19 5a1 1 0 0 1 1 1z"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                @else
                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                @endif
            </div>
        </article>
    </div>

    {{-- Detail stok --}}
    <section class="mt-6 overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
        <div class="flex min-h-[90px] items-center justify-between gap-[18px] px-[26px] pt-[22px] pb-4 max-[560px]:min-h-0 max-[560px]:flex-col max-[560px]:items-start max-[560px]:p-[19px_16px]">
            <div>
                <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">Detail Posisi Stok</p>
                <p class="mt-[5px] text-[10px] leading-[1.45] text-[#6D7B90]">
                    Posisi stok akhir seluruh bahan pangan
                </p>
            </div>

            <a href="{{ route('laporan.export', request()->only('dari', 'sampai', 'kategori')) }}" class="inline-flex h-[42px] items-center justify-center gap-2 rounded-[10px] bg-[#397BD8] px-4 text-[12px] font-semibold whitespace-nowrap text-white shadow-[0_4px_9px_rgba(45,105,190,0.22)] transition-all hover:-translate-y-px hover:bg-[#2869C2] max-[560px]:w-full">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 3v12"></path>
                    <path d="m7 10 5 5 5-5"></path>
                    <path d="M5 21h14"></path>
                </svg>
                Export CSV
            </a>
        </div>

        <div class="mx-[26px] mb-[26px] overflow-x-auto rounded-[12px] border border-[#D9E1EB] max-[800px]:mx-[18px] max-[560px]:mx-4 max-[560px]:mb-4">
            <table class="w-full min-w-[760px] table-fixed border-collapse">
                <thead>
                    <tr>
                        <th class="h-[47px] w-[16%] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Kode</th>
                        <th class="h-[47px] w-[30%] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Nama Bahan</th>
                        <th class="h-[47px] w-[20%] whitespace-nowrap bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Kategori</th>
                        <th class="h-[47px] w-[18%] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Stok Akhir</th>
                        <th class="h-[47px] w-[16%] whitespace-nowrap bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] text-[#627087] uppercase">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($laporan as $item)
                        @php
                            $stokRendahItem = $item->stok <= $stokMinimum;
                        @endphp

                        <tr>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-semibold whitespace-nowrap text-[#2677DF]">
                                {{ $item->kode }}
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-bold whitespace-nowrap text-[#182230]">
                                {{ $item->nama }}
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap text-[#6D7B90]">
                                {{ $item->kategori }}
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span class="font-bold text-[#182230]">{{ number_format($item->stok, 0, ',', '.') }}</span>
                                <span class="ml-1 text-[10px] text-[#6D7B90]">{{ $item->satuan }}</span>
                            </td>

                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span class="inline-flex min-h-[23px] items-center rounded-full px-[10px] py-[3px] text-[9px] font-semibold whitespace-nowrap {{ $stokRendahItem ? 'bg-[#FFF0F0] text-[#D94E4E]' : 'bg-[#EDF7F1] text-[#257A59]' }}">
                                    {{ $stokRendahItem ? 'Stok Rendah' : 'Aman' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="h-[220px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[220px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <path d="M14 2v6h6"></path>
                                            <path d="M16 13H8"></path>
                                            <path d="M16 17H8"></path>
                                            <path d="M10 9H8"></path>
                                        </svg>
                                        <p class="mt-3 text-[14px] font-semibold text-[#182230]">Belum ada data laporan</p>
                                        <span class="mt-[5px] block text-[12px]">Data laporan persediaan akan muncul di sini.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
