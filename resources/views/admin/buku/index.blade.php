@extends('layouts.app')

@section('title', 'Kelola Buku - Pustaka Kita')

@section('content')

<div style="max-width: 1100px; margin: 40px auto; padding: 20px;">

    <h2>Kelola Data Buku</h2>

    <a href="{{ route('admin.buku.create') }}">
        + Tambah Buku
    </a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10" cellspacing="0"
        width="100%" style="margin-top: 20px;">

        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($bukus as $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $buku->judul }}</td>

                    <td>{{ $buku->kategori->nama ?? '-' }}</td>

                    <td>{{ $buku->penulis }}</td>

                    <td>{{ $buku->tahun_terbit }}</td>

                    <td>
                        <a href="{{ route('admin.buku.edit', $buku->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('admin.buku.destroy', $buku->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus buku?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data buku.</td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>

@endsection
