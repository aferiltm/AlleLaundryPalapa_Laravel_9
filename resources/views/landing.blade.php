<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'Kantil Laundry') }}</title>
    {{-- <link href="{{ asset('/img/dashboard/favicon.png') }}" rel="icon" type="image/png"> --}}
    <link rel="icon" type="image/png" href="https://laravel.com/img/favicon/favicon.ico">

    <!-- Bootstrap core CSS -->
    {{-- <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Javascript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind CSS --}}
    <script defer src="https://cdn.tailwindcss.com"></script>
    {{-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link defer href="https://cdn.jsdelivr.net/npm/daisyui@4.12.24/dist/full.min.css" rel="stylesheet"
        type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- DaisyUI --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}

</head>

<body class="bg-white">

    <!-- Navigation -->
    <div class="w-full bg-white pt-3 pb-3 -mt-24">
        <div x-data="{ open: false }"
            class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
            <div class="p-4 flex flex-row items-center justify-between">
                <a href="#"
                    class="text-lg font-semibold tracking-widest text-blue-600 uppercase rounded-lg focus:outline-none focus:shadow-outline">Kantil
                    Laundry

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
                <a class="px-4 py-2 mt-2 text-sm font-semibold rounded-lg md:mt-0 bg-blue-900 text-white border-blue-900 hover:bg-white border-2 hover:border-blue-600 hover:text-blue-600"
                    href="{{ url('login') }}">Masuk / Daftar</a>

            </nav>
        </div>
    </div>

    <section class="relative h-[90vh] bg-cover bg-center flex items-center justify-center"
        style="background-image: url('{{ asset('img/landing/Banner.jpg') }}');">
        <!-- Overlay gelap semi transparan agar teks lebih jelas -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <!-- Konten teks -->
        <div class="relative text-center text-white px-6">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Kantil Laundry</h1>
            <h2 class="text-3xl md:text-4xl font-semibold text-blue-300 mb-2">Dry Cleaning</h2>
            <p class="text-lg md:text-xl mb-6">"Segar, Bersih, Wangi – Laundry Tanpa Worry!"</p>
            <a href="#"
                class="bg-blue-600 hover:bg-blue-800 transition px-6 py-3 text-lg rounded-full font-semibold">
                Selengkapnya
            </a>
        </div>
    </section>


    {{-- <div class="bg-red-600 h-auto pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="md:ml-20 md:mr-10 md:p-1 mt-14 mb-14 md:mt-15 md:mb-15 text-left md:pt-20 md:pb-10">
                <h1 class="text-5xl font-extrabold tracking-widest text-gray-900 rounded-lg focus:outline-none focus:shadow-outline"
                    data-aos="fade-up">Kantil Laundry</h1>
                <h1 class="text-5xl font-bold tracking-widest text-white rounded-lg focus:outline-none focus:shadow-outline"
                    data-aos="fade-up">Dry Cleaning</h1>
                <p class="font-poppins text-lg mt-3 mb-10 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                    data-aos="fade-up">
                    "Segar, Bersih, Wangi – Laundry Tanpa Worry!"
                </p>

                <a href="#games"
                    class="font-poppins bg-blue-900 hover:bg-black duration-200 text-white rounded-full py-3 px-24 md:py-3 md:px-20 w-auto text-2xl md:text-xl"
                    data-aos="zoom-out">Selengkapnya</a>
            </div>

            <div class="w-full pt-6 px-10 md:px-20 md:h-full md:pt-20 md:pb-10 order-first md:order-last"
                data-aos="fade-left">
                <img src="{{ asset('img/landing/Banner.jpg') }}" alt="wallpaper" />
            </div>
        </div>
    </div> --}}

    {{-- <section class="promo section" id="promo">
        <div class="bg-white h-auto">
            <div class="mx-auto pb-10 pt-8">
                <h1 class="font-semibold text-2xl text-cyan-600 text-center pb-3 sm:pb-3 md:pb-3 lg:pb-8">!!! PROMO !!!
                </h1>

                <p class="text-center text-sm text-gray-400 pb-4">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Geser untuk lihat promo lain
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </p>

                <div class="carousel flex w-full overflow-x-auto space-x-4 px-4 md:px-10">
                    @foreach ($vouchers as $voucher)
                        <div class="carousel-item flex-shrink-0 w-64">
                            <div class="flex flex-col justify-between items-center text-center h-full border border-gray-300 rounded-lg bg-gray-200 shadow-md p-4 hover:border-blue-600 hover:text-blue-600 text-gray-600"
                                data-aos="fade-up">
                                <h1 class="font-semibold text-sm md:text-md text-black mb-4">
                                    {{ $voucher->details }}
                                </h1>
                                @guest
                                    <a href="{{ route('login.show') }}"
                                        class="bg-blue-900 hover:bg-black transition-colors duration-200 text-white rounded-full py-2 px-6 text-sm md:text-base">
                                        Klaim
                                    </a>
                                @endguest

                                @auth
                                    <a href="{{ route('member.points.index') }}"
                                        class="bg-blue-900 hover:bg-black transition-colors duration-200 text-white rounded-full py-2 px-6 text-sm md:text-base">
                                        Klaim
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="text-center text-sm text-gray-400 pt-6">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Geser untuk lihat promo lain
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </p>
            </div>
        </div>
    </section> --}}

    <div class="px-6 py-8">
        <h2 class="text-center text-2xl font-bold text-cyan-600 mb-4">!!! PROMO !!!</h2>
        <p class="text-center text-gray-400 mb-8">Geser untuk lihat promo lain</p>

        <!-- Wrapper scroll horizontal -->
        <div class="flex space-x-6 overflow-x-auto pb-4 w-full">

            <!-- Promo Card 1 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo1.png') }}')">
            </div>

            <!-- Promo Card 2 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo2.png') }}')">
            </div>

            <!-- Promo Card 3 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo3.png') }}')">
            </div>

            <!-- Promo Card 4 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo4.png') }}')">
            </div>

            <!-- Promo Card 5 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo5.png') }}')">
            </div>

            <!-- Promo Card 6 -->
            <div class="min-w-[300px] h-64 rounded-xl shadow overflow-hidden bg-cover bg-center flex items-end justify-center text-white relative"
                style="background-image: url('{{ asset('img/landing/promo6.png') }}')">
            </div>

        </div>
    </div>

    <div class="bg-cyan-600 h-auto pb-20">
        <div class="container mx-auto pt-10 px-4">

            <h1 class="text-center text-4xl font-extrabold font-poppins pb-10">
                <strong class="tracking-widest text-gray-900 dark:text-white">
                    Kenapa memilih layanan laundry kami?
                </strong>
            </h1>

            <!-- Section 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10 mb-16">
                <div>
                    <h5 class="text-2xl font-bold text-gray-900 mb-4" data-aos="fade-up">
                        Peralatan Lengkap dan Canggih
                    </h5>
                    <p class="text-white text-lg leading-relaxed" data-aos="fade-up">
                        Laundry kami menggunakan peralatan yang cukup lengkap dan canggih.
                        Peralatan kami memungkinkan baju tidak perlu dijemur dan mengurangi debu pada baju.
                    </p>
                </div>
                <div data-aos="fade-left">
                    <img src="{{ asset('img/landing/1.jpg') }}" alt="peralatan laundry"
                        class="w-full h-[300px] object-cover rounded-xl" />
                </div>
            </div>

            <!-- Section 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10 mb-16">
                <div data-aos="fade-left">
                    <img src="{{ asset('img/landing/2.jpg') }}" alt="segala pakaian"
                        class="w-full h-[300px] object-cover rounded-xl" />
                </div>
                <div>
                    <h5 class="text-2xl font-bold text-gray-900 mb-4" data-aos="fade-up">
                        Segala Tipe Pakaian
                    </h5>
                    <p class="text-white text-lg leading-relaxed" data-aos="fade-up">
                        Laundry kami menerima segala tipe pakaian mulai dari baju, celana, jas, dan selimut.
                    </p>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">
                <div>
                    <h5 class="text-2xl font-bold text-gray-900 mb-4" data-aos="fade-up">
                        Pelayanan Laundry Yang Cepat
                    </h5>
                    <p class="text-white text-lg leading-relaxed" data-aos="fade-up">
                        Kami menghadirkan layanan laundry cepat, bersih, dan wangi dengan kualitas terbaik,
                        memastikan pakaian Anda selalu segar dan siap pakai.
                    </p>
                </div>
                <div data-aos="fade-left">
                    <img src="{{ asset('img/landing/3.jpg') }}" alt="pelayanan cepat"
                        class="w-full h-[300px] object-cover rounded-xl" />
                </div>
            </div>

        </div>
    </div>

    <section class="pakaian section" id="pakaian">
        <div class="bg-white py-0">

            <!-- Banner Full Width -->
            <div class="w-full">
                <img src="{{ asset('img/landing/laundry-banner.png') }}" alt="Banner Kantil Laundry"
                    class="w-full h-auto" />
            </div>

        </div>
    </section>

    <div class="bg-blue-600 h-auto pb-20">
        <div class="mx-auto pb-10 pt-8">
            <h1 class="font-semibold text-2xl text-white text-center">Temukan Kami!</h1>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="md:ml-20 md:mr-10 mt-14 mb-14 md:mt-15 md:mb-15 text-left md:pt-16 md:pb-10">
                    <h1 class="text-2xl font-extrabold tracking-widest text-gray-900 rounded-lg focus:outline-none focus:shadow-outline"
                        data-aos="fade-up">Alamat</h1>
                    <p class="font-poppins text-lg mt-1 mb-10 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        Jl. H. Sulaiman No.21, RT.4/RW.1, Petukangan Utara, Kec. Pesanggrahan, Kota Jakarta Selatan,
                        Daerah Khusus Ibukota Jakarta 12260
                    </p>

                    <h1 class="text-2xl font-extrabold tracking-widest text-gray-900 rounded-lg focus:outline-none focus:shadow-outline"
                        data-aos="fade-up">Kontak</h1>
                    {{-- <p class="font-poppins text-lg mt-1 mb-2 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        cleanlaundry@gmail.com
                    </p> --}}
                    {{-- <p class="font-poppins text-lg mt-2 mb-2 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        (0361)123456
                    </p> --}}
                    <p class="font-poppins text-lg mt-2 mb-10 mr-5 md:ml-0 md:mr-0 tracking-widest text-white"
                        data-aos="fade-up">
                        <a href="https://wa.me/6281383004378" target="_blank">(+62) 812 1347 1726 </a>
                    </p>
                </div>

                <div class="w-full pt-6 px-10 md:px-20 md:h-full md:pt-20 md:pb-10" data-aos="fade-left">
                    {{-- <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.987975718024!2d110.80675027455068!3d-7.576286774840404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1677724790d5%3A0x8165748f42e56384!2sJl.%20Bhayangkara%2C%20Tipes%2C%20Kec.%20Serengan%2C%20Kota%20Surakarta%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1704006961476!5m2!1sid!2sid"
                        width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe> --}}
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.1115509372237!2d106.745491744705!3d-6.23429478310189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f0b8c71de9fd%3A0x40cb5f95c1e08581!2sJl.%20H.%20Sulaiman%20No.21%2C%20RT.4%2FRW.1%2C%20Petukangan%20Utara%2C%20Kec.%20Pesanggrahan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012260!5e0!3m2!1sid!2sid!4v1750875558399!5m2!1sid!2sid"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                &copy; <a href="#" class="text-white hover:text-blue-600">Kantil Laundry</a> <i
                    class="fa-solid fa-gamepad text-blue-600"></i></i>
            </p>
        </div>
    </footer>

    {{-- ================================================================================================================================================================= --}}

    {{-- <nav class="navbar navbar-expand-sm navbar-dark bg-dark
    fixed-top">
        <div class="container">
            <a class="navbar-brand" href="">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-success bg-green-600 text-white"
                            href="{{ url('login') }}">@lang('landing.loginOrRegister')</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> --}}

    <!-- Header -->
    {{-- <header class="py-5 position-relative">
        <div class="background-blur"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 text-white mt-5 mb-2 with-border">@lang('landing.welcome')</h1>
                    <p class="lead mb-5 text-white text-center">@lang('landing.tagline')</p>
                </div>
            </div>
        </div>
    </header> --}}

    {{-- <section class="p-5 text-center">
        <h3>@lang('landing.why')</h3>
    </section> --}}

    <!-- Page Content -->
    {{-- <section class="kelebihan bg-blue text-white">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Peralatan Lengkap dan Canggih</h4>
                    <p>Laundry kami menggunakan peralatan yang cukup lengkap dan canggih. Peralatan kami memungkinkan
                        baju tidak perlu dijemur dan mengurangi debu pada baju</p>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid d-none d-lg-block" src="{{ asset('img/landing/alat.png') }}"
                        alt="" srcset="">
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="kelebihan bg-blue text-white">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-6">
                    <img class="img-fluid d-none d-lg-block" src="{{ asset('img/landing/tipebaju.png') }}"
                        alt="" srcset="">
                </div>
                <div class="col-lg-6">
                    <h4>Segala Tipe Pakaian</h4>
                    <p>Laundry kami menerima segala tipe pakaian mulai dari baju, celana, jas, dan
                        selimut.</p>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="kelebihan bg-blue text-white">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Pegawai Profesional</h4>
                    <p>Laundry kami terdiri dari pegawai-pegawai yang profesional yang mampu bekerja dalam tim dengan
                        cukup baik dan handal di bidangnya sehingga membuat laundry kami minim kesalahan</p>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid d-none d-lg-block" src="{{ asset('img/landing/pegawai.png') }}"
                        alt="" srcset="">
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="text-center p-5">
        <h3>Apa saja yang bisa kami laundry?</h3>
    </section> --}}

    {{-- <section class="bg-blue p-5 text-center">
        <div class="container">
            <div class="row flex-row flex-nowrap kategori">
                <div class="col-4 mb-2">
                    <div class="card">
                        <img src="{{ asset('img/landing/Baju.jpg') }}" class="card-img-top" alt="">
                        <div class="card-body d-none d-lg-block">
                            <p class="card-text">Baju</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="card">
                        <img src="{{ asset('img/landing/Celana.jpg') }}" class="card-img-top" alt="">
                        <div class="card-body d-none d-lg-block">
                            <p class="card-text">Celana</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="card">
                        <img src="{{ asset('img/landing/Jas.jpg') }}" class="card-img-top" alt="">
                        <div class="card-body d-none d-lg-block">
                            <p class="card-text">Jas</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-2">
                    <div class="card">
                        <img src="{{ asset('img/landing/Selimut.jpg') }}" class="card-img-top" alt="">
                        <div class="card-body d-none d-lg-block">
                            <p class="card-text">Selimut</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="text-center p-5">
        <h3>Temukan kami!</h3>
    </section> --}}

    {{-- <section class="text-white bg-blue">
        <div class="container p-5">
            <div class="row">
                <div class="col-md-6 mb-4 mb-sm-0">
                    <h5>Alamat</h5>
                    <p>Tipes, Kec. Serengan, Kota Surakarta, Jawa Tengah</p>
                    <br>
                    <h5>Kontak</h5>
                    <p>cleanlaundry@gmail.com</p>
                    <p>(0361)123456</p>
                    <p>081234567890</p>
                </div>
                <div class="col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.987975718024!2d110.80675027455068!3d-7.576286774840404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1677724790d5%3A0x8165748f42e56384!2sJl.%20Bhayangkara%2C%20Tipes%2C%20Kec.%20Serengan%2C%20Kota%20Surakarta%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1704006961476!5m2!1sid!2sid"
                        width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- /.container -->

    <!-- Footer -->
    {{-- <footer class="py-5 bg-dark">
        <div class="container"> --}}
    {{-- <p class="m-0 text-center text-white">Terima Kasih Telah Memilih {{ config('app.name') }} Sebagai
                Kebersihan Pakaian Anda</p> --}}
    {{-- </div> --}}
    <!-- /.container -->
    {{-- </footer> --}}

    {{-- JavaScript --}}
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}


</body>

</html>
