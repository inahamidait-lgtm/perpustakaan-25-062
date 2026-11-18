@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8 mb-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Tambah Pengguna
        </h1>

        <p class="text-gray-500 mb-6">
            Masukkan data akun pengguna perpustakaan.
        </p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Nama Pengguna
                </label>
                <input type="text" name="nama"
                       value="{{ old('nama') }}"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Masukkan nama"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Email
                </label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Masukkan email"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Password
                </label>
                <input type="password" name="password"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Minimal 8 karakter"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Role Pengguna
                </label>
                <select name="role"
                        class="w-full border-gray-300 rounded-lg"
                        required>
                    <option value="">-- Pilih Role --</option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 border rounded-lg text-gray-600">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
