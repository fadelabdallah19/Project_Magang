<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(Request $request): View
    {
        $pengguna = User::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $keyword = $request->string('q')->toString();

            $query->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', "%{$keyword}%")
                ->orWhere('username', 'like', "%{$keyword}%");
            });
        })
        ->when($request->filled('role'), fn ($query) => $query->where('role', $request->input('role')))
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        $roleList = User::query()
        ->select('role')
        ->distinct()
        ->where('role', '!=', '')
        ->orderBy('role')
        ->pluck('role');

        return view('pengguna.index', compact('pengguna', 'roleList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')],
            'role' => ['required', Rule::in(['Admin', 'Petugas Gudang', 'Pengawas'])],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create($validated);

        return redirect()
        ->route('pengguna.index')
        ->with('success', "Pengguna \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['Admin', 'Petugas Gudang', 'Pengawas'])],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if ($user->role === 'Admin'
            && $validated['role'] !== 'Admin'
            && User::where('role', 'Admin')->count() <= 1) {
                return back()
                ->withErrors(['role' => 'Minimal harus ada satu akun Admin'])
                ->withInput();
            }

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
        ->route('pengguna.index')
        ->with('success', "Pengguna \"{$user->name}\" berhasil diperbarui.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with("error", 'Anda tidak bisa menghapus akun sendiri.');
        }

        if ($user->role === 'Admin' && User::where('role', 'Admin')->count() <= 1) {
            return back()->with('error', 'Minimal haruis ada satu akun Admin.');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()
        ->route('pengguna.index')
        ->with('success', "Pengguna \"{$nama}\" berhasil dihapus.");
    }
}
