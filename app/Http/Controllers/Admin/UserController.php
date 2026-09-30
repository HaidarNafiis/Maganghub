<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $currentUser = auth()->user();

        // Admin hanya melihat user biasa
        if ($currentUser->role === 'admin') {
            $users = User::with('formation')
                ->where('role', 'user')
                ->latest()
                ->get();
        } else {
            // Super Admin dapat melihat semua akun
            $users = User::with('formation')
                ->latest()
                ->get();
        }

        return view('admin.users.index', compact('users'));
    }


    /**
     * Halaman tambah user.
     */
    public function create()
    {
        $formations = Formation::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.users.create', compact('formations'));
    }


    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'formation_id' => [
                'required',
                Rule::exists('formations', 'id')
                    ->where(function ($query) {
                        $query->where('active', true);
                    }),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'formation_id' => $validated['formation_id'],
            'password' => Hash::make($validated['password']),

            // User yang dibuat dari halaman ini selalu menjadi user
            'role' => 'user',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }


    /**
     * Menampilkan halaman edit user.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();

        // Admin hanya boleh mengedit user biasa
        if ($currentUser->role === 'admin' && $user->role !== 'user') {
            abort(403, 'Admin hanya dapat mengelola user biasa.');
        }

        // Ambil formasi yang aktif
        $formations = Formation::where('active', true)
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact(
            'user',
            'formations'
        ));
    }


    /**
     * Memperbarui user.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'admin') {

            // Admin hanya boleh mengubah user biasa
            if ($user->role !== 'user') {
                abort(403, 'Admin tidak dapat mengubah akun Admin atau Super Admin.');
            }

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')
                        ->ignore($user->id),
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],

                'formation_id' => [
                    'required',
                    Rule::exists('formations', 'id')
                        ->where(function ($query) {
                            $query->where('active', true);
                        }),
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                ],
            ]);


            $user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'] ?? null,
                'formation_id' => $validated['formation_id'],
            ]);


            // Password hanya diubah jika diisi
            if (!empty($validated['password'])) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }


            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Data user berhasil diperbarui.');
        }


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        if ($currentUser->role === 'superadmin') {

            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')
                        ->ignore($user->id),
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],

                'formation_id' => [
                    'required',
                    Rule::exists('formations', 'id')
                        ->where(function ($query) {
                            $query->where('active', true);
                        }),
                ],

                'role' => [
                    'required',
                    'in:user,admin,superadmin',
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                ],
            ]);


            /*
             * Mencegah Super Admin mengubah role dirinya sendiri
             * agar tidak tidak sengaja kehilangan akses.
             */
            if ($user->id === $currentUser->id) {

                if ($validated['role'] !== 'superadmin') {
                    return back()
                        ->withInput()
                        ->with('error', 'Anda tidak dapat mengubah role akun Super Admin yang sedang digunakan.');
                }
            }


            $user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'] ?? null,
                'formation_id' => $validated['formation_id'],
                'role' => $validated['role'],
            ]);


            // Password hanya diubah jika diisi
            if (!empty($validated['password'])) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }


            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Data user berhasil diperbarui.');
        }


        abort(403, 'Anda tidak memiliki akses.');
    }


    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();


        // Admin hanya dapat menghapus user biasa
        if ($currentUser->role === 'admin') {

            if ($user->role !== 'user') {
                abort(403, 'Admin hanya dapat menghapus user biasa.');
            }
        }


        // Super Admin tidak dapat menghapus dirinya sendiri
        if ($currentUser->role === 'superadmin') {

            if ($user->id === $currentUser->id) {
                return back()
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
            }
        }


        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}