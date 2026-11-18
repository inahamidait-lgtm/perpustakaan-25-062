@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">

    <!-- Judul halaman -->
    <div class="bg-white px-6 py-8 shadow-sm">
        <div class="bg-green-100 border-l-4 border-green-600 rounded-r-lg px-6 py-5">
            <h1 class="text-2xl font-bold text-green-900">
                Pengelolaan Data Pengguna
            </h1>
        </div>
    </div>

    <!-- Form edit pengguna -->
    <div class="px-6 py-10 sm:px-10 lg:px-10 mt-12">

        <div class="bg-green-50 border border-green-200 rounded-xl p-6 sm:p-8">

            <h2 class="text-xl font-bold text-green-900 mb-6">
                Form Edit Pengguna
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-5">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-5">
                    <label for="nama" class="block text-gray-700 mb-2">
                        Nama Pengguna:
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $user->nama) }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required
                    >
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 mb-2">
                        Email:
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-gray-700 mb-2">
                        Password Baru:
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengganti password"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                    >
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-gray-700 mb-2">
                        Role Pengguna:
                    </label>
                    <select
                        id="role"
                        name="role"
                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required
                    >
                        <option value="">-- Pilih Role --</option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-3 pt-5 border-t border-green-200">

                    <a href="{{ route('admin.users.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg">
                        Batal
                    </a>

                    <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-5 py-2.5 rounded-lg">
                        Simpan Perubahan
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection
