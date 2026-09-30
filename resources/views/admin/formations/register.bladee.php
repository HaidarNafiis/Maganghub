{{-- Formasi --}}
<div>
    <label
        for="formation_id"
        class="block text-sm font-medium text-gray-700 mb-2"
    >
        Formasi
    </label>

    <select
        id="formation_id"
        name="formation_id"
        required
        class="w-full rounded-lg border border-gray-300 px-4 py-3 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
    >
        <option value="">
            Pilih Formasi
        </option>

        @foreach($formations as $formation)
            <option
                value="{{ $formation->id }}"
                {{ old('formation_id') == $formation->id ? 'selected' : '' }}
            >
                {{ $formation->name }}
            </option>
        @endforeach
    </select>

    @error('formation_id')
        <p class="text-sm text-red-600 mt-1">
            {{ $message }}
        </p>
    @enderror
</div>