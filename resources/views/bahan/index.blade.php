@extends('layouts.app')

@section('title', 'Data Bahan Pangan - MBG Smart Stock')

@section('content')
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-[25px] leading-[30.3px] font-bold text-black">Data Bahan Pangan</h1>
            <p class="mt-[4px] text-[15px] leading-[18.2px] text-[#959595]">Inventaris Persediaan Pangan</p>
        </div>

        <button type="button" data-modal-open class="mt-[22px] inline-flex h-[30px] cursor-pointer items-center gap-[6px] rounded-[5px] bg-[#0088FF] px-[13px] font-poppins text-[15px] leading-[22.5px] font-normal text-white hover:bg-[#0077E6]">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.00016 3.33333V8M8.00016 8V12.6667M8.00016 8H3.3335M8.00016 8H12.6668"
                stroke="#FFFFFF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Tambah Bahan Pangan
        </button>
    </div>

    {{-- Tabel --}}
    <div class="mt-[46px] overflow-hidden rounded-[15px] bg-white pb-1 shadow-[5px_5px_5px_rgba(0,0,0,0.25)]">
        <table class="w-full table-fixed font-poppins">
            <thead>
                <tr class="h-[47px] bg-[#E5E7EB] text-left text-[15px] leading-[22.5px] font-bold text-[#787878]">
                    <th class="w-[163px] pl-[31px] font-bold">Kode</th>
                    <th class="w-[202px] font-bold">Nama Bahan</th>
                    <th class="w-[179px] font-bold">Kategori</th>
                    <th class="w-[113px] font-bold">Stok</th>
                    <th class="w-[136px] font-bold">Satuan</th>
                    <th class="w-[137px] text-center font-bold">Status</th>
                    <th class="w-[120px] text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bahan as $item)
                    <tr class="h-[57px] text-[15px] leading-[22.5px]">
                        <td class="pl-[31px] font-normal text-[#787878]">{{ $item['kode']}}</td>
                        <td class="font-bold text-[#787878]">{{ $item['nama']}}</td>
                        <td class="font-bold text-[#787878]">{{ $item['kategori']}}</td>
                        <td class="font-bold {{ $item['status'] === 'Stok Rendah' ? 'text-[#E11D48]' : 'text-[#787878]'}}">{{ $item['stok']}}</td>
                        <td class="font-bold text-[#787878]">{{ $item['satuan']}}</td>
                        <td class="text-center">
                            <span class="inline-flex h-8 w-[120px] items-center justify-center rounded-[10px] font-bold {{ $item['status'] === 'Stok Rendah' ? 'bg-[#FFF1F2] text-[#E11D48]' : 'bg-[#ECFDF5] text-[#059669]'}}">{{ $item['status']}}</span></td>
                        <td>
                            <div class="flex items-center justify-center gap-[14px]">
                                {{-- Tombol Edit --}}
                                  <button type="button"
                                    data-modal-edit
                                    data-kode="{{ $item['kode'] }}"
                                    data-nama="{{ $item['nama'] }}"
                                    data-kategori="{{ $item['kategori'] }}"
                                    data-stok="{{ $item['stok'] }}"
                                    data-satuan="{{ $item['satuan'] }}"
                                    title="Edit {{ $item['nama'] }}"
                                    aria-label="Edit {{ $item['nama'] }}"
                                    class="cursor-pointer">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.16699 15.8331H7.84533L19.2145 4.46396C19.7015 3.97577 19.975 3.31436 19.975 2.6248C19.975 1.93523 19.7015 1.27382 19.2145 0.785629C18.7192 0.312207 18.0605 0.0480042 17.3753 0.0480042C16.6902 0.0480042 16.0314 0.312207 15.5362 0.785629L4.16699 12.1548V15.8331ZM5.83366 12.8448L16.7145 1.96396C16.8925 1.79393 17.1292 1.69904 17.3753 1.69904C17.6215 1.69904 17.8582 1.79393 18.0362 1.96396C18.2111 2.13939 18.3094 2.37704 18.3094 2.6248C18.3094 2.87255 18.2111 3.1102 18.0362 3.28563L7.15533 14.1665H5.83366V12.8448Z" fill="#0088FF"/>
                                        <path d="M19.6842 6.35167L18.3333 7.7025V13.3333H13.3333V18.3333H1.66667V2.5C1.66667 2.27899 1.75446 2.06702 1.91074 1.91074C2.06702 1.75446 2.27899 1.66667 2.5 1.66667H12.2983L13.6492 0.315833C13.7708 0.20302 13.8991 0.0975551 14.0333 0L2.5 0C1.83696 0 1.20107 0.263392 0.732233 0.732233C0.263392 1.20107 0 1.83696 0 2.5L0 20H15.345L20 15.345V5.9675C19.9022 6.10155 19.7968 6.22982 19.6842 6.35167V6.35167ZM15 17.9883V15H17.9883L15 17.9883Z" fill="#0088FF"/>
                                    </svg>
                                </button>

                                {{--Tombol Hapus--}}
                                <button type="button" tittle="Hapus {{ $item['nama'] }}" aria-label="Hapus {{ $item['nama'] }}" class="cursor-pointer">
                                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5H4.16667M4.16667 5H17.5M4.16667 5L4.16667 16.6667C4.16667 17.1087 4.34226 17.5326 4.65482 17.8452C4.96738 18.1577 5.39131 18.3333 5.83333 18.3333H14.1667C14.6087 18.3333 15.0326 18.1577 15.3452 17.8452C15.6577 17.5326 15.8333 17.1087 15.8333 16.6667V5.00001M6.66667 5.00001V3.33334C6.66667 2.89131 6.84226 2.46739 7.15482 2.15483C7.46738 1.84227 7.89131 1.66667 8.33333 1.66667H11.6667C12.1087 1.66667 12.5326 1.84227 12.8452 2.15483C13.1577 2.46739 13.3333 2.89131 13.3333 3.33334V5.00001M8.33333 9.16667V14.1667M11.6667 9.16667V14.1667" stroke="#E11D48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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