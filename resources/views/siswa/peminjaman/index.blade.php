@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1100px; margin: 35px auto; padding: 20px;">

    <div style="background: linear-gradient(135deg, #2f6090, #3b78ad); color: white; padding: 28px; border-radius: 15px; margin-bottom: 25px;">
        <h2 style="margin: 0 0 8px;">Riwayat Peminjaman</h2>
        <p style="margin: 0;">Berikut adalah daftar peminjaman buku milik kamu.</p>
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 3px 12px rgba(0,0,0,0.07); overflow-x: auto;">

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if($peminjamans->isEmpty())
            <p style="text-align: center; color: #64748b; padding: 25px;">
                Belum ada riwayat peminjaman buku.
            </p>
        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #edf4fb;">
                        <th style="padding: 13px;">No.</th>
                        <th style="padding: 13px;">Judul Buku</th>
                        <th style="padding: 13px;">Tanggal Pinjam</th>
                        <th style="padding: 13px;">Tanggal Kembali</th>
                        <th style="padding: 13px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $peminjaman)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 13px;">{{ $loop->iteration }}</td>
                            <td style="padding: 13px;">{{ $peminjaman->buku->judul ?? '-' }}</td>
                            <td style="padding: 13px;">{{ $peminjaman->tanggal_pinjam }}</td>
                            <td style="padding: 13px;">{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                            <td style="padding: 13px;">
                                @if($peminjaman->tanggal_kembali)
                                    <span style="background: #d1fae5; color: #065f46; padding: 5px 10px; border-radius: 20px;">Sudah Kembali</span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; padding: 5px 10px; border-radius: 20px;">Belum Kembali</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div style="margin-top: 25px;">
            <a href="{{ route('siswa.dashboard') }}" style="background: #315f8c; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none;">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>
@endsection