
@extends('layouts.app')

@section('content')

<style>
    .rp-page {
        min-height: 85vh;
        background: #f3f4f6;
        padding: 40px 30px;
    }

    .rp-container {
        max-width: 1280px;
        margin: auto;
    }

    .rp-heading {
        margin-bottom: 30px;
        text-align: left;
    }

    .rp-heading h1 {
        font-size: 26px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .rp-heading p {
        color: #6b7280;
        font-size: 14px;
    }

    .rp-alert {
        padding: 14px 18px;
        border-radius: 9px;
        margin-bottom: 22px;
    }

    .rp-success {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .rp-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .rp-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 25px;
        align-items: start;
    }

    .rp-card {
        background: white;
        border-radius: 13px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    .rp-card-header {
        background: #316594;
        color: white;
        padding: 21px 25px;
    }

    .rp-card-header h2 {
        font-size: 19px;
        font-weight: 700;
    }

    .rp-card-header p {
        color: #dbeafe;
        font-size: 13px;
        margin-top: 5px;
    }

    .rp-card-body {
        padding: 25px;
    }

    .rp-subtitle {
        font-size: 15px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 18px;
    }

    .rp-permissions {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .rp-permission {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        cursor: pointer;
        background: #fff;
        transition: 0.2s;
        min-width: 0;
    }

    .rp-permission:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .rp-permission input {
        width: 16px;
        height: 16px;
        margin-top: 2px;
        accent-color: #316594;
        flex-shrink: 0;
        cursor: pointer;
    }

    .rp-permission span {
        font-size: 13px;
        color: #4b5563;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .rp-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .rp-save {
        background: #e7f0fa;
        color: #245b91;
        border: none;
        border-radius: 9px;
        padding: 11px 22px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s;
    }

    .rp-save:hover {
        background: #d5e5f5;
    }

    .rp-empty {
        background: white;
        padding: 25px;
        border-radius: 12px;
        color: #6b7280;
    }

    .rp-footer {
        text-align: center;
        color: #9ca3af;
        font-size: 13px;
        margin-top: 30px;
    }

    @media (max-width: 900px) {
        .rp-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .rp-page {
            padding: 25px 15px;
        }

        .rp-permissions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="rp-page">
    <div class="rp-container">

        <!-- JUDUL -->
        <div class="rp-heading">
            <h1>Role & Permission</h1>
            <p>
                Atur dan kelola hak akses Admin, Petugas, dan Siswa
                pada sistem perpustakaan.
            </p>
        </div>

        <!-- NOTIFIKASI -->
        @if (session('success'))
            <div class="rp-alert rp-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rp-alert rp-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- DAFTAR ROLE -->
        <div class="rp-grid">

            @forelse ($roles as $role)

                <div class="rp-card">

                    <div class="rp-card-header">
                        <h2>Role {{ ucfirst($role->name) }}</h2>
                        <p>Pengaturan hak akses pengguna {{ $role->name }}.</p>
                    </div>

                    <form action="{{ route('admin.role-permission.update', $role->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="rp-card-body">

                            <h3 class="rp-subtitle">
                                Daftar Hak Akses
                            </h3>

                            <div class="rp-permissions">

                                @forelse ($permissions as $permission)

                                    <label class="rp-permission">

                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        >

                                        <span>
                                            {{ ucfirst($permission->name) }}
                                        </span>

                                    </label>

                                @empty

                                    <p>Belum ada permission.</p>

                                @endforelse

                            </div>

                            <div class="rp-actions">
                                <button type="submit" class="rp-save">
                                    Simpan Perubahan
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            @empty

                <div class="rp-empty">
                    Belum ada role yang tersedia.
                </div>

            @endforelse

        </div>

        <div class="rp-footer">
            © {{ date('Y') }} Pustaka Kita — Sistem Perpustakaan Digital
        </div>

    </div>
</div>

@endsection
