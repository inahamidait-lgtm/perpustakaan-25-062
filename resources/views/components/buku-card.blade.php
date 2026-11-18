@props(['buku'])

<div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-orange-100 flex flex-col group">
    
    <div class="relative h-48 overflow-hidden bg-orange-50">
        <img src="{{ $gambar ?? 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80' }}" 
             alt="{{ $judul ?? 'Sampul Buku' }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        
        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-amber-800 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
            {{ $kategori ?? 'Novel' }}
        </span>
    </div>
    
    <div class="p-5 flex flex-col flex-grow justify-between space-y-4">
        
        <div class="space-y-1.5">
            <h3 class="font-lora text-lg font-bold text-gray-900 group-hover:text-amber-800 transition-colors line-clamp-1">
                {{ $judul ?? 'Judul Buku' }}
            </h3>
            <p class="text-sm font-medium text-gray-600">
                {{ $penulis ?? 'Nama Penulis' }}
            </p>
            <p class="text-xs text-gray-400">
                Tahun terbit: {{ $tahun ?? '2023' }}
            </p>
        </div>

        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500 flex items-center gap-1">
                📚 Pustaka Kita
            </span>
            
            <a href="{{ $url ?? '#' }}" class="inline-flex items-center justify-center bg-amber-800 hover:bg-amber-900 text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-sm">
                Lihat Detail →
            </a>
        </div>

    </div>
</div>