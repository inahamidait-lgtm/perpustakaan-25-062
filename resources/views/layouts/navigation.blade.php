
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Navigasi Desktop -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center shrink-0">
                <a href="{{ auth()->user()->hasRole('admin')
                    ? route('dashboard')
                    : (auth()->user()->hasRole('petugas')
                        ? route('petugas.dashboard')
                        : route('siswa.dashboard')) }}"
                    class="flex items-center gap-2">

                    <x-application-logo class="block h-9 w-auto fill-current text-blue-700" />

                    <span class="font-bold text-lg text-blue-800">
                        Pustaka Kita
                    </span>
                </a>
            </div>

            <!-- Menu Navigasi Tengah -->
            <div class="hidden sm:flex flex-1 justify-center items-center gap-5">

                <!-- Menu Admin -->
                @role('admin')
                    <x-nav-link :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('buku.index')"
                        :active="request()->routeIs('buku.*')">
                        Data Buku
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users.index')"
                        :active="request()->routeIs('admin.users.*')">
                        Data Pengguna
                    </x-nav-link>

                    <x-nav-link :href="route('admin.peminjaman.index')"
                        :active="request()->routeIs('admin.peminjaman.*')">
                        Peminjaman
                    </x-nav-link>

                    <x-nav-link :href="route('admin.laporan.index')"
                        :active="request()->routeIs('admin.laporan.*')">
                        Laporan
                    </x-nav-link>
                @endrole

                <!-- Menu Petugas -->
                @role('petugas')
                    <x-nav-link :href="route('petugas.dashboard')"
                        :active="request()->routeIs('petugas.dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.buku.index')"
                        :active="request()->routeIs('petugas.buku.*')">
                        Data Buku
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.peminjaman.index')"
                        :active="request()->routeIs('petugas.peminjaman.*')">
                        Peminjaman
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.pengembalian.index')"
                        :active="request()->routeIs('petugas.pengembalian.*')">
                        Pengembalian
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.laporan.index')"
                        :active="request()->routeIs('petugas.laporan.*')">
                        Laporan
                    </x-nav-link>
                @endrole

                <!-- Menu Mahasiswa / Siswa -->
                @role('siswa')
                    <x-nav-link :href="route('siswa.dashboard')"
                        :active="request()->routeIs('siswa.dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('buku.index')"
                        :active="request()->routeIs('buku.*')">
                        Daftar Buku
                    </x-nav-link>

                    <x-nav-link :href="route('siswa.peminjaman.index')"
                        :active="request()->routeIs('siswa.peminjaman.*')">
                        Riwayat Peminjaman
                    </x-nav-link>
                @endrole

            </div>

            <!-- Dropdown Akun -->
            <div class="hidden sm:flex sm:items-center shrink-0">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent
                            text-sm leading-4 font-medium rounded-md text-gray-600
                            bg-white hover:text-gray-800 focus:outline-none transition">

                            <div>{{ Auth::user()->nama }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil Saya
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-500 hover:bg-gray-100
                    focus:outline-none transition">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}"
                            class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open}"
                            class="hidden"
                            stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Navigasi Mobile -->
    <div :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden border-t border-gray-100">

        <div class="pt-2 pb-3 space-y-1">

            <!-- Admin -->
            @role('admin')
                <x-responsive-nav-link :href="route('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('buku.index')">
                    Data Buku
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.users.index')">
                    Data Pengguna
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.peminjaman.index')">
                    Peminjaman
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.laporan.index')">
                    Laporan
                </x-responsive-nav-link>
            @endrole

            <!-- Petugas -->
            @role('petugas')
                <x-responsive-nav-link :href="route('petugas.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('petugas.buku.index')">
                    Data Buku
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('petugas.peminjaman.index')">
                    Peminjaman
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('petugas.pengembalian.index')">
                    Pengembalian
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('petugas.laporan.index')">
                    Laporan
                </x-responsive-nav-link>
            @endrole

            <!-- Mahasiswa / Siswa -->
            @role('siswa')
                <x-responsive-nav-link :href="route('siswa.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('buku.index')">
                    Daftar Buku
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('siswa.peminjaman.index')">
                    Riwayat Peminjaman
                </x-responsive-nav-link>
            @endrole

        </div>

        <!-- Informasi Akun Mobile -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->nama }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil Saya
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
