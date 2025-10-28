<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evermore - Il Ricordo Diventa Conversazione</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gold-gradient-text {
            background-image: linear-gradient(to right, #fde047, #facc15, #eab308);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
    @livewireStyles
</head>
<body class="antialiased bg-gray-900 text-gray-300 font-[Inter]">
<div class="flex flex-col min-h-screen">

    {{-- Usiamo la nostra navbar semplice per le pagine pubbliche --}}
    <x-navbar />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

</div>
@livewireScripts
</body>
</html>
