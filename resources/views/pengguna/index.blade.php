@extends('layouts.app')

@section('title', 'Pengguna - MBG Smart Stock')

@section('content')
    @php
        $roleList = $pengguna->pluck('role')->unique()->sort()->values();
    @endphp

    @if (session('success'))
        <div class="mb-4 rounded-[10px] border border-[#B7E4CD] bg-[#EDF7F1] px-4 py-3 text-[12px] font-semibold text-[#257A59]">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-[10px] border border-[#F3C7C7] bg-[#FFF0F0] px-4 py-3 text-[12px] font-semibold text-[#D94E4E]">
            {{ session('error') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-[15px] border border-[#D9E1EB] bg-white shadow-[0_2px_5px_rgba(28,47,74,0.03)]">
        <div class="flex min-h-[90px] items-center justify-between gap-[18px] px-[26px] pt-[22px] pb-[16px] max-[800px]:px-[18px] max-[560px]:min-h-0 max-[560px]:flex-col max-[560px]:items-start max-[560px]:p-[19px_16px]">
            <div>
                <p class="text-[17px] font-bold tracking-[-0.025em] text-[#182230]">Daftar Pengguna</p>
                <p class="mt-[5px] text-[14px] leading-[1.45] text-[#6D7B90]">Kelola akun pengelola sistem dan hak aksesnya</p>
            </div>

            <div class="flex items-center gap-3 max-[560px]:w-full">
                <span class="inline-flex h-[32px] items-center rounded-full bg-[#EDF4FF] px-[14px] text-[12px] font-semibold whitespace-nowrap text-[#2D76D6]">
                    {{ $pengguna->count() }} Akun
                </span>

                <button type="button" data-pengguna-tambah class="inline-flex h-[42px] items-center justify-center gap-2 rounded-[10px] bg-[#397BD8] px-4 text-[12px] font-semibold whitespace-nowrap text-white shadow-[0_4px_9px_rgba(45,105,190,0.22)] transition-all hover:-translate-y-px hover:bg-[#2869C2]">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    Tambah Pengguna
                </button>
            </div>
        </div>

        <div class="flex gap-[15px] px-[26px] pt-[5px] pb-[24px] max-[800px]:px-[18px] max-[560px]:flex-col max-[560px]:items-stretch max-[560px]:px-4 max-[560px]:pb-[18px]">
            <label class="flex h-[45px] min-w-0 flex-1 items-center gap-[11px] rounded-[9px] border border-[#D9E1EB] bg-[#F7F9FC] px-[14px] text-[#6D7B90] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21 21-4.34-4.34"></path>
                    <circle cx="11" cy="11" r="8"></circle>
                </svg>

                <input id="pengguna-search" type="search" placeholder="Cari berdasarkan nama atau username..." aria-label="Cari pengguna" class="min-w-0 flex-1 bg-transparent text-[14px] text-[#182230] outline-none placeholder:text-[#9BA6B6]">
            </label>

            <label class="relative flex h-[45px] w-[180px] items-center rounded-[9px] border border-[#D9E1EB] bg-white px-[13px] text-[#182230] focus-within:border-[#86AFE6] focus-within:shadow-[0_0_0_3px_rgba(57,123,216,0.09)] max-[560px]:w-full">
                <select id="pengguna-role" aria-label="Filter role" class="h-full w-full appearance-none bg-transparent pr-5 text-[14px] outline-none">
                    <option>Semua Role</option>
                    @foreach ($roleList as $role)
                        <option>{{ $role }}</option>
                    @endforeach
                </select>

                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute right-3" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg>
            </label>
        </div>

        <div class="mx-[26px] mb-[26px] overflow-x-auto rounded-[12px] border border-[#D9E1EB] max-[800px]:mx-[18px] max-[560px]:mx-4 max-[560px]:mb-4">
            <table class="w-full min-w-[1050px] border-collapse">
                <thead>
                    <tr>
                        <th class="h-[47px] w-[60px] bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">No</th>
                        <th class="h-[47px] bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Nama Lengkap</th>
                        <th class="h-[47px] bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Username</th>
                        <th class="h-[47px] bg-[#F8FAFC] px-5 text-left text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Email</th>
                        <th class="h-[47px] bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Role / Peran</th>
                        <th class="h-[47px] bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Status</th>
                        <th class="h-[47px] w-[130px] bg-[#F8FAFC] px-5 text-center text-[12px] font-bold tracking-[0.02em] whitespace-nowrap text-[#627087] uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pengguna as $item)
                        @php
                            $roleStyle = match ($item->role) {
                                'Admin' => 'border-[#A855F7] bg-[#E9D5FF] text-[#7E22CE]',
                                'Petugas Gudang' => 'border-[#3B82F6] bg-[#BFDBFE] text-[#1D4ED8]',
                                'Pengawas' => 'border-[#F59E0B] bg-[#FDE68A] text-[#B45309]',
                                default => 'border-[#D1D5DB] bg-[#F3F4F6] text-[#374151]',
                            };
                            $isAktif = $item->status === 'Aktif';
                        @endphp

                        <tr data-pengguna-row data-nama="{{ strtolower($item->name) }}" data-username="{{ strtolower($item->username) }}" data-role="{{ $item->role }}">
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] text-[#6D7B90]">{{ $loop->iteration }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-bold whitespace-nowrap text-[#182230]">{{ $item->name }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] font-semibold whitespace-nowrap text-[#2677DF]">{{ $item->username }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap text-[#6D7B90]">{{ $item->email }}</td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span class="inline-flex min-h-[23px] items-center rounded-full border px-[10px] py-[3px] text-[10px] font-semibold whitespace-nowrap {{ $roleStyle }}">
                                    {{ $item->role }}
                                </span>
                            </td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-center text-[12px] whitespace-nowrap">
                                <span class="inline-flex items-center gap-[6px] font-semibold {{ $isAktif ? 'text-[#257A59]' : 'text-[#D94E4E]' }}">
                                    <span class="h-[7px] w-[7px] rounded-full {{ $isAktif ? 'bg-[#257A59]' : 'bg-[#D94E4E]' }}"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="h-[68px] border-t border-[#D9E1EB] px-5 text-[12px] whitespace-nowrap">
                                <div class="flex items-center justify-center gap-[9px]">
                                    <button type="button"
                                        data-pengguna-edit
                                        data-id="{{ $item->id }}"
                                        data-nama="{{ $item->name }}"
                                        data-username="{{ $item->username }}"
                                        data-email="{{ $item->email }}"
                                        data-role="{{ $item->role }}"
                                        data-status="{{ $item->status }}"
                                        title="Edit {{ $item->name }}"
                                        class="grid h-[34px] w-[34px] place-items-center rounded-[8px] bg-[#EDF4FF] text-[#2D76D6] transition-transform hover:-translate-y-px">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                            <path d="m15 5 4 4"></path>
                                        </svg>
                                    </button>

                                    <form method="POST" action="{{ route('pengguna.destroy', $item) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus {{ $item->name }}" class="grid h-[34px] w-[34px] place-items-center rounded-[8px] bg-[#FFF0F0] text-[#D94E4E] transition-transform hover:-translate-y-px">
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
                            <td colspan="7" class="h-[220px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[220px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                        </svg>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Belum ada data pengguna</p>
                                        <span class="mt-[5px] block text-[10px]">Akun pengelola akan tampil di sini.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if ($pengguna->isNotEmpty())
                        <tr id="pengguna-filter-empty" class="hidden">
                            <td colspan="7" class="h-[220px] border-t border-[#D9E1EB] px-5 text-center">
                                <div class="grid min-h-[220px] place-items-center text-[#98A4B4]">
                                    <div>
                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mx-auto" aria-hidden="true">
                                            <path d="m21 21-4.34-4.34"></path>
                                            <circle cx="11" cy="11" r="8"></circle>
                                        </svg>
                                        <p class="mt-3 text-[12px] font-semibold text-[#182230]">Pengguna tidak ditemukan</p>
                                        <span class="mt-[5px] block text-[10px]">Coba gunakan kata kunci atau role lain.</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Tambah --}}
    <div id="modal-pengguna-tambah" data-pengguna-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-white/10 p-4 backdrop-blur-[3px]">
        <div class="w-full max-w-[606px] overflow-hidden rounded-[15px] bg-white shadow-[0_20px_60px_rgba(7,30,63,0.25)]">
            <div class="flex h-[50px] items-center justify-between bg-[#E5E7EB] px-[26px]">
                <h2 class="font-poppins text-[18px] leading-[27px] font-bold text-[#1D1D1D]">Tambah Pengguna Baru</h2>
                <button type="button" data-pengguna-modal-close aria-label="Tutup" class="cursor-pointer text-[#1D1D1D] transition-opacity hover:opacity-60">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M4 4L14 14M14 4L4 14" stroke="#1D1D1D" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('pengguna.store') }}" method="POST" class="px-[26px] pt-[20px] pb-[28px] font-poppins">
                @csrf

                <div>
                    <label for="tambah-name" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Nama Lengkap</label>
                    <input type="text" id="tambah-name" name="name" value="{{ old('name') }}" required class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('name') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('name') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="tambah-username" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Username</label>
                        <input type="text" id="tambah-username" name="username" value="{{ old('username') }}" required class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('username') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('username') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tambah-email" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Email</label>
                        <input type="email" id="tambah-email" name="email" value="{{ old('email') }}" required class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF] {{ $errors->has('email') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                        @error('email') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="tambah-role" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Role / Peran</label>
                        <select id="tambah-role" name="role" required class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none focus:border-[#0088FF] {{ $errors->has('role') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                            <option value="Admin" @selected(old('role') === 'Admin')>Admin</option>
                            <option value="Petugas Gudang" @selected(old('role') === 'Petugas Gudang')>Petugas Gudang</option>
                            <option value="Pengawas" @selected(old('role') === 'Pengawas')>Pengawas</option>
                        </select>
                        @error('role') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tambah-status" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Status</label>
                        <select id="tambah-status" name="status" required class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none focus:border-[#0088FF] {{ $errors->has('status') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                            <option value="Aktif" @selected(old('status') === 'Aktif')>Aktif</option>
                            <option value="Nonaktif" @selected(old('status') === 'Nonaktif')>Nonaktif</option>
                        </select>
                        @error('status') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-[14px]">
                    <label for="tambah-password" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Password</label>
                    <input type="password" id="tambah-password" name="password" required autocomplete="new-password" class="h-[34px] w-full rounded-[8px] border px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#0088FF] {{ $errors->has('password') ? 'border-[#E11D48]' : 'border-[#E5E7EB]' }}">
                    @error('password') <p class="mt-[4px] text-[11px] text-[#E11D48]">{{ $message }}</p> @enderror
                </div>

                <div class="mt-[24px] flex items-center justify-end gap-[14px]">
                    <button type="button" data-pengguna-modal-close class="h-[34px] cursor-pointer rounded-[8px] border border-[#FFF1F2] px-[22px] text-[14px] font-bold text-[#E11D48] transition-colors hover:bg-[#FFF1F2]">Batal</button>
                    <button type="submit" class="h-[34px] cursor-pointer rounded-[8px] bg-[#0088FF] px-[22px] text-[14px] font-bold text-white transition-colors hover:bg-[#0077E6]">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modal-pengguna-edit" data-pengguna-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-white/10 p-4 backdrop-blur-[3px]">
        <div class="w-full max-w-[606px] overflow-hidden rounded-[15px] bg-white shadow-[0_20px_60px_rgba(7,30,63,0.25)]">
            <div class="flex h-[50px] items-center justify-between bg-[#E5E7EB] px-[26px]">
                <h2 class="font-poppins text-[18px] leading-[27px] font-bold text-[#1D1D1D]">Edit Pengguna</h2>
                <button type="button" data-pengguna-modal-close aria-label="Tutup" class="cursor-pointer text-[#1D1D1D] transition-opacity hover:opacity-60">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M4 4L14 14M14 4L4 14" stroke="#1D1D1D" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form id="form-pengguna-edit" method="POST" data-action="{{ route('pengguna.update', '__ID__') }}" class="px-[26px] pt-[20px] pb-[28px] font-poppins">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit-name" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Nama Lengkap</label>
                    <input type="text" id="edit-name" name="name" required class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#0088FF]">
                </div>

                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="edit-username" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Username</label>
                        <input type="text" id="edit-username" name="username" required class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#0088FF]">
                    </div>

                    <div>
                        <label for="edit-email" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Email</label>
                        <input type="email" id="edit-email" name="email" required class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors focus:border-[#0088FF]">
                    </div>
                </div>

                <div class="mt-[14px] grid grid-cols-2 gap-x-[14px]">
                    <div>
                        <label for="edit-role" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Role / Peran</label>
                        <select id="edit-role" name="role" required class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none focus:border-[#0088FF]">
                            <option value="Admin">Admin</option>
                            <option value="Petugas Gudang">Petugas Gudang</option>
                            <option value="Pengawas">Pengawas</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit-status" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Status</label>
                        <select id="edit-status" name="status" required class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none focus:border-[#0088FF]">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-[14px]">
                    <label for="edit-password" class="mb-[6px] block text-[12px] leading-[18px] font-bold text-[#787878]">Password Baru</label>
                    <input type="password" id="edit-password" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak diubah" class="h-[34px] w-full rounded-[8px] border border-[#E5E7EB] px-[13px] text-[13px] text-[#1D1D1D] outline-none transition-colors placeholder:text-[#9CA3AF] focus:border-[#0088FF]">
                </div>

                <div class="mt-[24px] flex items-center justify-end gap-[14px]">
                    <button type="button" data-pengguna-modal-close class="h-[34px] cursor-pointer rounded-[8px] border border-[#FFF1F2] px-[22px] text-[14px] font-bold text-[#E11D48] transition-colors hover:bg-[#FFF1F2]">Batal</button>
                    <button type="submit" class="h-[34px] cursor-pointer rounded-[8px] bg-[#0088FF] px-[22px] text-[14px] font-bold text-white transition-colors hover:bg-[#0077E6]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection