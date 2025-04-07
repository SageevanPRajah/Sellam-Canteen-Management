<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                
            </style>
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex"
     style="background-image: url('/icons/sdvs.jpg'); background-repeat: repeat; background-size: auto; background-position: center; min-height: 100vh;">
            <div class="rounded-md px-3 py-2 bg-white relative flex items-center justify-center"
            style="height: 50vh; margin: auto; width: 50%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <img src="{{ asset('/icons/logo.png') }}" alt="Logo" class="block h-20 w-auto ml-5">
                    </div>
                    <div class="flex lg:justify-center lg:col-start-2">
                        <img src="{{ asset('/icons/name.png') }}" alt="Logo" class="block h-30 w-auto ml-5">
                    </div>
                    <a href="{{ url('/sellam') }}"
                        class="rounded-md px-3 py-2 bg-black text-white ring-1 ring-black transition hover:bg-black/80 focus:outline-none focus-visible:ring-[#FF2D20] dark:bg-white dark:text-black dark:hover:bg-gray-300 dark:focus-visible:ring-white">
                        Sellam
                    </a>
                </header>

                <main class="mt-6">
                    <h1 class="text-center text-xl font-semibold">Welcome to your Sellam Premier 3D Digital Cinema</h1>
                    <div class="text-center"><a href="https://maps.app.goo.gl/axBRPNXomTUvucmS6"
                            class="text-center text-l font-semibold">Locate in Chenkalady, Batticaloa</a></div>
                </main>


            </div>
        </div>
    </div>
</body>

</html>
