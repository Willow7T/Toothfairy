<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="mt-10">
        <div class="relative h-64">
            <div class=" absolute z-10 bottom-0 p-2 rounded-tr-lg backdrop-blur-lg md:backdrop-blur-xl">
                <div class="text-6xl text-yellow-400 font-postserif">
                    Tooth Fairy Clinic
                </div>
                <div class="relative">
                    <p class="text-xl font-semibold pl-2 pb-4 text-orange-500">One of the best Clinic in the Region.</p>
                    <a class="text-rose-600 font-semibold absolute right-10 bottom-0 font-fira" href="">Get an Appointment
                        Now---></a>
                </div>
            </div>
            <div class="w-20 md:w-64 absolute right-0 md:right-24 overflow-hidden z-0 ">
                <img src="{{ asset('storage/uploads/landing4.png') }}" alt="landing picture"
                    style="width: 100%; height: 100%; object-fit: cover; ">
            </div>
            <div class="absoulute left-0 overflow-hidden h-64">
                <img src="{{ asset('storage/uploads/landing5.png') }}" alt="landing picture"
                style="width: 100%; height: 100%; object-fit: cover; ">
            </div>
        </div>
    </div>
</body>

</html>
