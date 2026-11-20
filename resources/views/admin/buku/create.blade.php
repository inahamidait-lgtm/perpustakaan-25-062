@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8 mb-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Tambah Buku
        </h1>

        <p class="text-gray-500 mb-6">
            Masukkan data buku baru ke dalam perpustakaan.
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

        <form action="{{ route('admin.buku.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Judul Buku
                </label>
                <input type="text" name="judul"
                       value="{{ old('judul') }}"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Masukkan judul buku"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Kategori
                </label>
                <select name="kategori_id" class="w-full border-gray-300 rounded-lg" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Penulis
                </label>
                <input type="text" name="penulis"
                       value="{{ old('penulis') }}"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Masukkan nama penulis"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">
                    Tahun Terbit
                </label>
                <input type="number" name="tahun_terbit"
                       value="{{ old('tahun_terbit') }}"
                       class="w-full border-gray-300 rounded-lg"
                       placeholder="Contoh: 2024"
                       min="1000" max="{{ date('Y') }}"
                       required>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
                    Simpan
                </button>
                <a href="{{ route('admin.buku.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
