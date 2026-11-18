
@extends('layouts.app')

@section('content')

<style>
    .users-page {
        background: #f3f4f6;
        min-height: 85vh;
        padding: 40px 30px;
    }

    .users-container {
        max-width: 1280px;
        margin: 0 auto;
    }

    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        text-align: left;
    }

    .users-title {
        font-size: 25px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .users-description {
        color: #6b7280;
        font-size: 15px;
    }

    .btn-add-user {
        display: inline-block;
        background: #316594;
        color: white;
        padding: 12px 22px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.2s;
    }

    .btn-add-user:hover {
        background: #244e76;
    }

    .users-alert {
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .users-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .users-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .users-table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        border: 1px solid #e5e7eb;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .users-table thead {
        background: #316594;
        color: white;
    }

    .users-table th {
        padding: 17px 20px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .users-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .users-table tbody tr:hover {
        background: #eff6ff;
    }

    .users-table tbody tr:last-child td {
        border-bottom: none;
    }

    .role-badge {
        display: inline-block;
        background: #dbeafe;
        color: #1e40af;
        padding: 5px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .btn-edit {
    background: #e7f0fa;
    color: #245b91;
    padding: 12px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-edit:hover {
    background: #d5e5f5;
}

.btn-delete {
    background: #fdeaea;
    color: #dc2626;
    padding: 12px 22px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-delete:hover {
    background: #fbd5d5;
}

    .users-footer {
        text-align: center;
        color: #9ca3af;
        font-size: 13px;
        margin-top: 28px;
    }

    @media (max-width: 700px) {
        .users-page {
            padding: 25px 15px;
        }

        .users-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .users-table-card {
            overflow-x: auto;
        }

        .users-table {
            min-width: 750px;
        }
    }
</style>

<div class="users-page">

    <div class="users-container">

        <!-- JUDUL DAN TOMBOL -->
        <div class="users-header">

            <div style="background: linear-gradient(135deg, #2f6090, #3b78ad); color: white; padding: 28px; border-radius: 15px; margin-bottom: 25px;">
                <h2 style="margin: 0 0 8px;">Kelola Data Pengguna</h2>
                <p style="margin: 0;">Mengelola akun dan hak akses pengguna perpustakaan.</p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="btn-add-user">
                + Tambah Pengguna
            </a>

        </div>

        <!-- NOTIFIKASI -->
        @if (session('success'))
            <div class="users-alert users-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="users-alert users-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- TABEL -->
        <div class="users-table-card">

            <table class="users-table">

                <thead>
                    <tr>
                        <th style="width: 7%;">No</th>
                        <th style="width: 24%;">Nama</th>
                        <th style="width: 29%;">Email</th>
                        <th style="width: 18%;">Role</th>
                        <th style="width: 22%; text-align: center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($users as $user)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td style="font-weight: 600;">
                                {{ $user->nama }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                @forelse ($user->roles as $role)
                                    <span class="role-badge">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @empty
                                    <span style="color: #9ca3af;">
                                        Belum memiliki role
                                    </span>
                                @endforelse
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px;">
                                Belum ada data pengguna.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- FOOTER -->
        <div class="users-footer">
            © {{ date('Y') }} Pustaka Kita — Sistem Perpustakaan Digital
        </div>

    </div>

</div>

@endsection
