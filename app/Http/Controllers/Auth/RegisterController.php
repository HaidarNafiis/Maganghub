<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegister()
    {
        $formations = Formation::where('active', true)
            ->orderBy('name')
            ->get();

        return view('auth.register', compact('formations'));
    }

    public function register(Request $request)
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
                'min:4',
                'max:50',
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
                'confirmed',
            ],

        ], [
            'name.required' => 'Nama wajib diisi.',

            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.unique' => 'Username sudah digunakan.',

            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'formation_id.required' => 'Formasi wajib dipilih.',
            'formation_id.exists' => 'Formasi tidak tersedia atau sudah tidak aktif.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'formation_id' => $validated['formation_id'],
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }
}