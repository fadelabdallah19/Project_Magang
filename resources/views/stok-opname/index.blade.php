@extends('layouts.app')

@section('title', 'Stok Opname - MBG Smart Stock')

@section('content')
    <div>
        <h1 class="text-[25px] ;eadomg-[30.3px] font-bold text-black">Penyesuaian Stok</h1>
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
        
    @endforeach
@endsection