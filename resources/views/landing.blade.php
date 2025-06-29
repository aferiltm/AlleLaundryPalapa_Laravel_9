<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Laundry Berkualitas dan Terpercaya di Palapa">
    <meta name="author" content="Alle Laundry Palapa">
    <title>Alle Laundry Palapa</title>
    <link rel="icon" href="{{ asset('/img/dashboard/logo_alle.jpg') }}" type="image/png">

    <!-- Tailwind & DaisyUI -->
    <script defer src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.24/dist/full.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="font-[Nunito] bg-white text-gray-800 overflow-x-hidden">
    <!-- Navigation -->
    <div class="w-full bg-white pt-3 pb-3 -mt-24">
        <div x-data="{ open: false }"
            class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
            <div class="p-4 flex flex-row items-center justify-between">
                <a href="#"
                    class="text-lg font-semibold tracking-widest text-blue-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">Alle
                    Laundry Palapa
                </a>
                <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path x-show="!open" fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{ 'flex': open, 'hidden': !open }"
                class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
                <a class="px-4 py-2 mt-2 text-sm font-semibold rounded-lg md:mt-0 bg-blue-900 text-white border-blue-900 hover:bg-white border-2 hover:border-blue-900 hover:text-blue-900"
                    href="{{ url('login') }}">Masuk / Daftar</a>

            </nav>
        </div>
    </div>


    <!-- Hero Section -->
    <section class="bg-blue-600 py-20 text-white">
        <div class="grid md:grid-cols-2 gap-10 items-center max-w-7xl mx-auto px-6 md:px-12">
            <div data-aos="fade-up" class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-widest leading-tight">Alle Laundry Palapa</h1>
                <h2 class="text-3xl md:text-4xl font-bold tracking-wide">Layanan Dry Cleaning Profesional</h2>
                <p class="text-lg italic max-w-xl">"Segar, Bersih, Wangi – Laundry Tanpa Worry!"</p>
                <a href="#promo"
                    class="inline-block bg-white text-blue-700 hover:bg-black hover:text-white transition font-semibold px-10 py-3 rounded-full shadow-md">Lihat
                    Promo</a>
            </div>
            <div data-aos="fade-left" class="flex justify-center md:justify-end">
                <img src="{{ asset('img/landing/illustrator.png') }}" alt="Laundry Illustration"
                    class="w-full max-w-md drop-shadow-lg" />
            </div>
        </div>
    </section>

    <section id="promo" class="promo section py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul --}}
            <h2 class="text-center text-3xl font-bold text-cyan-600 mb-2">🎉 PROMO MENARIK 🎉</h2>
            <p class="text-center text-sm text-gray-500 mb-6 flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Geser untuk lihat promo lainnya
                <i class="fa-solid fa-arrow-right"></i>
            </p>

            {{-- Carousel Promo --}}
            <div
                class="flex gap-4 overflow-x-auto snap-x snap-mandatory pb-4 px-2 md:px-6 lg:px-10
                    scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent ">
                @foreach ($vouchers as $voucher)
                    @php
                        $isNew = \Carbon\Carbon::parse($voucher->created_at)->diffInDays(now()) <= 7;
                    @endphp

                    <div
                        class="card w-72 bg-white shadow-lg hover:shadow-xl transition-all duration-300 snap-center flex-shrink-0 border border-blue-200 hover:scale-105 transition-transform duration-300 mt-5">
                        <div class="card-body items-center text-center ">
                            {{-- Badge jika baru --}}
                            @if ($isNew)
                                <div class="badge badge-error mb-2 animate-pulse">Baru!</div>
                            @endif
                            <h3
                                class="card-title text-base-content leading-snug text-md md:text-lg font-semibold text-black">
                                {{ $voucher->details }}
                            </h3>
                            <div class="mt-4">
                                @guest
                                    <a href="{{ route('login.show') }}" class="btn btn-sm btn-outline btn-info">
                                        Login untuk Klaim
                                    </a>
                                @endguest

                                @auth
                                    <a href="{{ route('member.points.index') }}" class="btn btn-sm btn-primary">
                                        Klaim Sekarang
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Petunjuk Swipe Bawah --}}
            <p class="text-center text-sm text-gray-500 mt-8 flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Geser untuk lihat promo lainnya
                <i class="fa-solid fa-arrow-right"></i>
            </p>
        </div>
    </section>

    <section class="bg-cyan-600 py-20">
        <div class="container mx-auto px-6">
            <!-- Heading -->
            <h2 class="text-center text-4xl font-extrabold text-white mb-16">Kenapa Memilih Layanan Kami?</h2>

            <!-- Keunggulan -->
            <div class="grid md:grid-cols-3 gap-10">
                <div data-aos="fade-up" class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-3">Peralatan Lengkap &amp; Canggih</h3>
                    <p class="text-gray-600">Kami menggunakan mesin modern yang mengurangi debu dan mempercepat proses
                        pengeringan tanpa
                        jemur.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-3">Semua Jenis Pakaian</h3>
                    <p class="text-gray-600">Dari baju harian hingga jas dan selimut tebal – semua kami tangani dengan
                        teliti.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-3">Pelayanan Kilat</h3>
                    <p class="text-gray-600">Layanan express tersedia agar pakaian Anda selalu siap pakai tepat waktu.
                    </p>
                </div>
            </div>

            <!-- Price List -->
            <div class="mt-20" data-aos="fade-up">
                <h2 class="text-center text-3xl font-bold text-white mb-10">Daftar Harga</h2>
                <div class="grid md:grid-cols-2 gap-10">
                    <!-- Kiloan -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Pesanan Kiloan</h3>
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-blue-700 border-b">
                                    <th class="py-2">Berat</th>
                                    <th class="py-2 text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kiloanPrices ?? [] as $item)
                                    <tr class="border-b last:border-none text-gray-600">
                                        <td class="py-2">{{ $item->name }}</td>
                                        <td class="py-2 text-right font-semibold">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}/kg</td>
                                    </tr>
                                @endforeach

                                @if (empty($kiloanPrices))
                                    {{-- <tr class="border-b text-gray-600">
                                        <td class="py-2">Reguler (2 Hari)</td>
                                        <td class="py-2 text-right font-semibold">Rp 8.000/kg</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Express (24 Jam)</td>
                                        <td class="py-2 text-right font-semibold">Rp 10.000/kg</td>
                                    </tr> --}}
                                    <tr class="text-gray-600">
                                        <td class="py-2 text-gray-600">1 kg</td>
                                        <td class="py-2 text-right font-semibold">Rp 6.000</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Satuan -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Pesanan Satuan</h3>
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-blue-700 border-b">
                                    <th class="py-2">Item</th>
                                    <th class="py-2 text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($satuanPrices ?? [] as $item)
                                    <tr class="border-b last:border-none text-gray-600">
                                        <td class="py-2">{{ $item->name }}</td>
                                        <td class="py-2 text-right font-semibold">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                @if (empty($satuanPrices))
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Baju/Celana</td>
                                        <td class="py-2 text-right font-semibold">Rp 5.000</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Kemeja</td>
                                        <td class="py-2 text-right font-semibold">Rp 6.000</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Sweater</td>
                                        <td class="py-2 text-right font-semibold">Rp 20.000</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Jas</td>
                                        <td class="py-2 text-right font-semibold">Rp 35.000</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Gaun/Kebaya</td>
                                        <td class="py-2 text-right font-semibold">Rp 40.000</td>
                                    </tr>
                                    <tr class="text-gray-600">
                                        <td class="py-2 text-gray-600">Jaket</td>
                                        <td class="py-2 text-right font-semibold">Rp 12.000</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Tipe Service -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        {{-- <h3 class="text-xl font-semibold text-blue-800 mb-4">Jenis Layanan</h3> --}}
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-blue-700 border-b">
                                    <th class="py-2">Jenis Layanan</th>
                                    <th class="py-2 text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kiloanPrices ?? [] as $item)
                                    <tr class="border-b last:border-none text-gray-600">
                                        <td class="py-2">{{ $item->name }}</td>
                                        <td class="py-2 text-right font-semibold">Rp
                                            {{ number_format($item->price, 0, ',', '.') }}/kg</td>
                                    </tr>
                                @endforeach

                                @if (empty($kiloanPrices))
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Reguler (3 Hari)</td>
                                        <td class="py-2 text-right font-semibold">Rp 0</td>
                                    </tr>
                                    <tr class="border-b text-gray-600">
                                        <td class="py-2">Express (2 Hari)</td>
                                        <td class="py-2 text-right font-semibold">Rp 10.000</td>
                                    </tr>
                                    <tr class="text-gray-600">
                                        <td class="py-2 text-gray-600">Kilat (1 hari)</td>
                                        <td class="py-2 text-right font-semibold">Rp 15.000/kg</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pakaian section" id="pakaian">
        <div class="bg-white h-auto">
            <div class="mx-auto pb-10 pt-8">
                <h1 class="font-semibold text-2xl text-cyan-600 text-center pb-3 sm:pb-3 md:pb-3 lg:pb-8">Apa saja yang
                    bisa kami laundry?</h1>
                <!-- Narutanaka AKA Aferil -->
                <p class="text-center text-sm text-gray-400 pb-2"><i class="fa-solid fa-arrow-left"></i>
                    Geser untuk lihat jenis pakaian lain <i class="fa-solid fa-arrow-right"></i></p>

                <div class="flex md:flex justify-center">
                    <div class="carousel rounded w-96 md:w-full gap-2 ml-1 mr-1 sm:ml-0 sm:mr-0 md:ml-7 md:mr-5">
                        <div class="carousel-item w-1/2 md:w-1/3">
                            <div class="border border-gray-200 dark:border-slate-300 rounded bg-gray-200 shadow-lg w-46 hover:border-blue-600 hover:text-blue-600 text-gray-500"
                                data-aos="fade-up">
                                <img src="{{ asset('img/landing/Baju.jpg') }}" alt="game"
                                    class="rounded-t w-46" />
                                <h1 class="mt-2 font-semibold text-center text-sm md:text-md text-black">Baju</h1>
                            </div>
                        </div>
                        <div class="carousel-item w-1/2 md:w-1/3">
                            <div class="border border-gray-200 dark:border-slate-300 rounded bg-gray-200 shadow-lg w-46 hover:border-blue-600 hover:text-blue-600 text-gray-500"
                                data-aos="fade-up">
                                <img src="{{ asset('img/landing/Celana.jpg') }}" alt="game"
                                    class="rounded-t w-46" />
                                <h1 class="mt-2 mb-2 font-semibold text-center text-sm md:text-md text-black">Celana
                                </h1>
                            </div>
                        </div>
                        <div class="carousel-item w-1/2 md:w-1/3">
                            <div class="border border-gray-200 dark:border-slate-300 rounded bg-gray-200 shadow-lg w-46 hover:border-blue-600 hover:text-blue-600 text-gray-500"
                                data-aos="fade-up">
                                <img src="{{ asset('img/landing/Selimut.jpg') }}" alt="game"
                                    class="rounded-t w-46" />
                                <h1 class="mt-2 mb-2 font-semibold text-center text-sm md:text-md text-black">Selimut
                                </h1>
                            </div>
                        </div>
                        <div class="carousel-item w-1/2 md:w-1/3">
                            <div class="border border-gray-200 dark:border-slate-300 rounded bg-gray-200 shadow-lg w-46 hover:border-blue-600 hover:text-blue-600 text-gray-500"
                                data-aos="fade-up">
                                <img src="{{ asset('img/landing/Jas.jpg') }}" alt="game"
                                    class="rounded-t w-46" />
                                <h1 class="mt-2 mb-2 font-semibold text-center text-sm md:text-md text-black">Jas</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-400 pb-2 pt-2"><i class="fa-solid fa-arrow-left"></i> Geser
                    untuk lihat jenis pakaian lain <i class="fa-solid fa-arrow-right"></i></p>
            </div>
        </div>
    </section>

    <div class="bg-blue-600 h-auto pb-20">
        <div class="mx-auto pb-10 pt-8">
            <h1 class="font-semibold text-2xl text-white text-center">Temukan Kami!</h1>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="ml-7 md:ml-20 md:mr-10 mt-14 mb-14 md:mt-15 md:mb-15 text-left md:pt-16 md:pb-10">
                    <h1 class="text-2xl font-extrabold tracking-widest text-gray-900 rounded-lg focus:outline-none focus:shadow-outline"
                        data-aos="fade-up">Alamat</h1>
                    <p class="font-poppins text-lg mt-1 mb-10 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        Jl. Palapa Raya, RT.4/RW.1, Kedoya Sel., Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus
                        Ibukota Jakarta 11520
                    </p>
                    <h1 class="text-2xl font-extrabold tracking-widest text-gray-900 rounded-lg focus:outline-none focus:shadow-outline"
                        data-aos="fade-up">Kontak</h1>
                    <p class="font-poppins text-lg mt-2 mb-10 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        <a href="https://wa.me/6281383004378" target="_blank">(+62) 815-1315-3355 </a>
                    </p>
                </div>

                <div class="w-full pt-6 px-6 md:px-20 md:h-full md:pt-20 md:pb-10" data-aos="fade-left">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6385369508425!2d106.76107227545018!3d-6.179114493808332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f707449fca05%3A0x2ed8153d5bb2598b!2sAll%C3%A9%20Laundry!5e0!3m2!1sid!2sid!4v1750609919456!5m2!1sid!2sid"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="rounded-lg shadow-md"></iframe>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-blue-900 h-auto">
        <div class="container mx-auto font-poppins">
            <p class="text-white text-center pt-5 pb-5">
                Copyright
                <script>
                    document.write(new Date().getFullYear());
                </script>
                &copy; <a href="#" class="text-white hover:text-blue-600">Alle Laundry Palapa</a>
            </p>
        </div>
    </footer>

    {{-- JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
