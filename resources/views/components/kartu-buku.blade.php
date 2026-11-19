@props(['id', 'judul', 'penulis', 'tahun'])

<article class="kartu-buku">
    @isset($kategori)
        <p class="kartu-kategori">{{ $kategori }}</p>
    @endisset

    <h3 class="kartu-judul">{!! $judul !!}</h3>
    <!-- <h3 class="kartu-judul">{{ $judul }}</h3> -->
    <p class="kartu-penulis">{{ $penulis }}</p>
    <p class="kartu-tahun">{{ $tahun }}</p>

    {{ $slot }}

    <a href="{{ route('buku.show', $id) }}" class="btn btn-ghost btn-small">Lihat Detail</a>
</article>
