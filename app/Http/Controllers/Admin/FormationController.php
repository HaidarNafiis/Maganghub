<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::latest()->get();

        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:formations,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        Formation::create($validated);

        return redirect()
            ->route('admin.formations.index')
            ->with('success', 'Formasi berhasil ditambahkan.');
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:formations,name,' . $formation->id,
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'active' => [
                'required',
                'boolean',
            ],
        ]);

        $formation->update($validated);

        return redirect()
            ->route('admin.formations.index')
            ->with('success', 'Formasi berhasil diperbarui.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();

        return redirect()
            ->route('admin.formations.index')
            ->with('success', 'Formasi berhasil dihapus.');
    }
}