<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>{{ config('app.name', 'Toothfairy') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        
        .font-sans {
            font-family: figtree, sans-serif;
        }

        .text-gray-700 {
            color: rgba(55, 65, 81, 1);
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        .absolute {
            position: absolute;
        }

        .left {
            left: 10px;
        }

        .top {
            top: 110px;
        }

        .bottom {
            bottom: 10px;
        }

        .right {
            right: 10px;
        }

        .table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #5795d7;
            margin-top: 160px
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td,
        th {
            border: 1px solid #5795d7;
            padding: 8px;
            text-align: right
        }

        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            border: 1px solid #000000;
            background-color: #43a5eb;
            color: white;
        }
        .relative {
            position: relative;
        }
        .total
        {
            padding-top: 30px;
            margin-left: auto;
            text-align: right;
        }
        .total div
        {
            padding: 2px;
        }
    </style>
</head>

<body>

    <div class="font-sans text-gray-700 antialiased">
        {{ $slot }}
    </div>
</body>

</html>
