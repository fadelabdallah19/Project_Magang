@extends('layouts.app')

@section('title', 'Dashboard - MBG Smart Stock')

@section('content')
    @php
        $stokMinimum = \App\Models\Bahan::STOCK_MINIMUM;
        $aktivitas = $aktivitas ?? collect();
        $bahanDashboard = $bahan->take(5);
    @endphp

    {{-- judul halaman --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-[25px] leading-[30.3px] font-bold text-[#1F2937]">Dashboard</h1>
            <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#64748B]">Ringkasan aktivitas dan stok pangan</p>
        </div>
    </div>

    {{-- statistik --}}
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-4">

        {{-- total bahan aktif --}}
        <article class="flex items-center justify-between rounded-2xl border border-[#DCE4EE] bg-white p-5 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-[0.02em] text-[#64748B] uppercase">Total Bahan Aktif</p>
                <h3 class="mt-1 text-2xl font-bold text-[#1F2937]">{{ $totalBahan }}</h3>
            </div>

            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#e8F1FD] text-[#1677E8]">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"></path>
                    <path d="m7 16.5-4.74-2.85"></path>
                    <path d="m7 16.5 5-3"></path>
                    <path d="M7 16.5v5.17"></path>
                    <path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"></path>
                    <path d="m17 16.5-5-3"></path>
                    <path d="m17 16.5 4.74-2.85"></path>
                    <path d="M17 16.5v5.17"></path>
                    <path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"></path>
                    <path d="M12 8 7.26 5.15"></path>
                    <path d="m12 8 4.74-2.85"></path>
                    <path d="M12 13.5V8"></path>
                </svg>
            </div>
        </article>


        <article class="flex items-center justify-between rounded-2xl border border-[#DCE4EE] bg-white p-5 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-[0.02em] text-[#64748B] uppercase">Stok Rendah</p>
                <h3 class="mt-1 text-2xl font-bold text-[#D64545]">{{ $stokRendah }}</h3>
            </div>

            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#FBECEC] text-[#D64545]">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                </svg>
            </div>
        </article>

        <article class="flex items-center justify-between rounded-2xl border border-[#DCE4EE] bg-white p-5 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-[0.02em] text-[#64748B] uppercase">Penerimaan Hari Ini</p>
                <h3 class="mt-1 text-2xl font-bold text-[#1F2937]">{{ $penerimaanHariIni }}</h3>
            </div>

            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#e8F1FD] text-[#1677E8]">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 17V3"></path>
                    <path d="m6 11 6 6 6-6"></path>
                    <path d="M19 21H5"></path>
                </svg>
            </div>
        </article>

        <article class="flex items-center justify-between rounded-2xl border border-[#DCE4EE] bg-white p-5 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            <div class="min-w-0">
                <p class="text-[11px] font-semibold tracking-[0.02em] text-[#64748B] uppercase">Pengeluaran Hari Ini</p>
                <h3 class="mt-1 text-2xl font-bold text-[#1F2937]">{{ $pengeluaranHariIni }}</h3>
            </div>

            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#e8F1FD] text-[#1677E8]">
                 <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m18 9-6-6-6 6"></path>
                    <path d="M12 3v14"></path>
                    <path d="M5 21h14"></path>
                </svg>
            </div>
        </article>
    </div>

    {{-- konten utama --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- status bahan pangan --}}
        <div class="rounded-2xl border border-[#DCE4EE] bg-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)] lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-bold text-[#1F2937]">Status Bahan Pangan</h2>
                <a href="{{ route('bahan.index') }}" class="text-xs font-semibold text-[#1677E8] hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="border-b border-[#DCE4EE] bg-slate-50 text-xs font-semibold text-[#64748B] uppercase">
                            <th class="rounded-l-lg px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama Bahan</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3 text-right">Stok Tersedia</th>
                            <th class="rounded-r-lg px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>        
                    
                    <tbody class="divide-y divide-[#DCE4EE]">
                        @forelse ($bahanDashboard as $item)
                            @php
                                $stokRendahItem = $item->stok <= $stokMinimum;
                            @endphp

                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-4 py-3.5 font-medium whitespace-nowrap text-[#1F2937]">{{ $item->kode }}</td>
                                <td class="px-4 py-3.5 font-semibold whitespace-nowrap text-[#1F2937]">{{ $item->nama }}</td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-[#64748B]">{{ $item->kategori }}</td>
                                <td class="px-4 py-3.5 text-center font-bold whitespace-nowrap text-[#1F2937]">{{ number_format($item->stok, 0, ',','.') }} {{ $item->satuan }}</td>
                                <td class="px-4 py-3.5 text-center"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $stokRendahItem ? 'bg-[#FBECEC] text-[#D64545]' : 'bg-[#E8F3F0] text-[#16845B]'}}">{{ $stokRendahItem ? 'Stok Rendah' : 'Aman'}}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-[#64748B]">Belum ada data bahan pangan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- aktivitas terakhir --}}
        <div class="flex flex-col rounded-2xl border border-[#DCE4EE] bg-white p-6 shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base font-bold text-[#1F2937]">Aktivitas Terakhir</h2>
                <span class="text-xs text-[#64748B]">Hari ini</span>
            </div>

            <div class="flex-1 space-y-4">
                @forelse ($aktivitas as $activity)
                    @php
                        $waktu = $activity['waktu'];
                        $labelWaktu = $waktu->isToday()
                        ? $waktu->format('H:i')
                        : ($waktu->isYesterday() ? 'Kemarin' : $waktu->format('d M'));
                    @endphp

                    <div class="flex items-start gap-3 border-b border-[#DCE4EE] pb-3 last:border-b-0 last:pb-0">
                        <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full {{ $activity['ikon'] === 'masuk' ? 'bg-[#E8F3F0] text-[#16845B]' : ($activity['ikon'] === 'keluar' ? 'bg-[#F9F1E7] text-[#C77712]' : 'bg-[#E8F1FD] text-[#1677E8]') }}">
                            @if ($activity['ikon'] === 'masuk')
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 5v14"></path>
                                    <path d="m19 12-7 7-7-7"></path>
                                </svg>
                            @elseif ($activity['ikon'] === 'keluar')
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m5 12 7-7 7 7"></path>
                                    <path d="M12 19V5"></path>
                                </svg>
                            @else
                                 <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                    <path d="m9 14 2 2 4-4"></path>
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex justify-between gap-2">
                                <p class="text-xs font-bold text-[#1F2937]">{{ $activity['judul'] }}</p>
                                <span class="shrink-0 text-[10px] text-[#64748B]">{{ $labelWaktu }}</span>
                            </div>
                            <p class="mt-0.5 text-[#64748B]">{{ $activity['deskripsi'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="flex min-h-[180px] flex-col items-center justify-center text-center">
                        <div class="grid h-9 w-9 place-items-center rounded-full bg-[#F4F7FB] text-[#64748B]">
                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                <path d="M3 3v5h5"></path>
                                <path d="M12 7v5l4 2"></path>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-bold text-[#1F2937]">Belum ada aktivitas</p>
                        <p class="mt-1 text-xs text-[#64748B]">Transaksi terbaru akan muncul di sini</p>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('barang-keluar.index') }}" class="mt-4 block w-full rounded-xl bg-[#F4F7FB] py-2 text-center text-xs font-bold text-[#1F2937] transition-colors hover:bg-slate-200">Lihat Semua Pengeluaran</a>
        </div>
    </div>
@endsection
