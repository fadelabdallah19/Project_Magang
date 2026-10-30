@extends('layouts.app')

@section('title', 'Pengguna - MBG Smart Stock')

@section('content')
    <div>
        <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Manajemen Pengguna</h1>
        <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Daftar akun pengelola (tampilan khusus administrator)</p>
    </div>

    {{-- Tabel Pengguna --}}
    <div class="mt-[44px] overflow-hidden rounded-[15px] bg-white pb-[18px] shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
        <table class="w-full table-fixed">
            <thead>
                <tr class="h-[56px] bg-[#E5E7EB] text-left text-[15px] leading-[22.5px] font-bold text-[#787878]">
                    <th class="w-[300px] pl-[28px] font-bold">Nama Lengkap</th>
                    <th class="w-[270px] pl-[28px] font-bold">Username</th>
                    <th class="w-[280px] pl-[28px] font-bold">Role / Peran</th>
                    <th class="w-[200px] pl-[28px] font-bold">Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="4" class="h-[12px]"></td>
                </tr>

                @foreach ($pengguna as $item)
                    @php
                        $roleStyle = match ($item['role']) {
                            'Admin' => 'border-[#A855F7] bg-[#E9D5FF] text-[#7E22CE]',
                            'Petugas Gudang' => 'border-[#3B82F6] bg-[#BFDBFE] text-[#1D4ED8]',
                            'Pengawas' => 'border-[#F59E0B] bg-[#FDE68A] text-[#B45309]',
                            default => 'border-[#D1D5DB] bg-[#F3F4F6] text-[#374141]',
                        };
                    @endphp

                    <tr class="h-[42px] text-[15px] leading-[22.5px] text-[#787878]">
                        <td class="pl-[28px]">{{ $item['nama'] }}</td>
                        <td class="pl-[28px]">{{ $item['username'] }}</td>
                        <td class="pl-[28px]">
                            <span class="inline-flex h-[24px] min-w-[100px] items-center justify-center rounded-full border px-[20px] text-[14px] font-bold {{ $roleStyle }}">
                                {{ $item['role'] }}
                            </span>
                        </td>
                        <td class="pl-[28px] font-bold {{ $item['status'] === 'Aktif' ? 'text-[#059669]' : 'text-[#E11D48]'}}">{{ $item['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection