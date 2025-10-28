<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Evermore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gold-gradient-text {
            background-image: linear-gradient(to right, #fde047, #facc15, #eab308);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>

</head>
<body class="font-[Inter] antialiased bg-gray-900 text-gray-300">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        <a href="/" wire:navigate>
            <h1 class="text-4xl font-bold gold-gradient-text">Evermore</h1>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-800 border border-gray-700 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
</body>
</html>
