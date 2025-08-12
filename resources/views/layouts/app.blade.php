<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- bootstrap -->
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flowbite.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <style>
        .scroll-x-hidden {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* Firefox */
        }

        .scroll-x-hidden::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        .custom-radio .form-check-input {
            width: 20px;
            height: 20px;
            margin-left: auto;
            margin-top: 0.5rem;
            border: 2px solid #000;
        }

        .custom-radio .form-check-input:checked {
            background-color: #000;
            border-color: #000;
        }

        .custom-radio .form-check-input:focus {
            box-shadow: none;
        }

        .bg-main {
            background-color: #989898;
        }

        .bg-main2 {
            background-color: #2b2b2b;
        }

        .bg-main3 {
            background-color: #535353;
        }

        .bg-main:hover {
            background-color: #989898;
            opacity: 0.8;
        }

        .bg-main2:hover {
            background-color: #2b2b2b;
            opacity: 0.8;
        }

        .bg-main3:hover {
            background-color: #535353;
            opacity: 0.8;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .category-item {
            transition: all 0.3s ease;
            min-width: 80px;
        }

        .category-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .category-item.active {
            background-color: #535353 !important;
            color: white !important;
        }

        .category-item.active span {
            color: white !important;
        }

        .product-item {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .product-item.hidden {
            display: none;
        }

        .scroll-x-hidden {
            overflow-x: auto;
        }

        .scroll-x-hidden::-webkit-scrollbar {
            height: 6px;
        }

        .scroll-x-hidden::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scroll-x-hidden::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .scroll-x-hidden::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div id="Content-Container" class="position-relative d-flex flex-column w-100 mx-auto min-vh-100 bg-white overflow-hidden" style="max-width: 512px;">
        @yield('content')
    </div>


    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
</body>

</html>