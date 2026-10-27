
@extends('layouts.app')

@section('title', 'Pengeluaran Bahan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @role('admin|gudang')
    <div class="bg-white p-5 rounded-2xl border">
        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Tujuan Pengeluaran</label>
                <select name="tujuan" class="form-select">
                    <option value="Produksi Makan Siang">Produksi Makan Siang</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Pilih Bahan</label>
                <select name="bahan_id" class="form-select">
                    @foreach($bahanList as $bahan)
                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary">Simpan Transaksi</button>
        </form>
    </div>
    @endrole

    <div class="lg:col-span-2">
        <table class="w-full">
            <!-- Table Content -->
        </table>
    </div>
</div>
@endsection