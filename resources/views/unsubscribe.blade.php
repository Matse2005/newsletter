<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | Nieuwsbrief / Newsletter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-100">
    <main class="flex flex-col items-center max-w-lg p-10 mx-auto mt-12 bg-white shadow-lg rounded-3xl">
        <img src="/images/unsubscribe.svg" alt="Unsubscribe Icon" class="w-32 mb-8">
        <h1 class="mb-4 text-4xl font-extrabold text-gray-900">
            {{ json_decode($language->translations)->pages->unsubscribe->title }}</h1>
        <h2 class="mb-6 text-xl font-semibold tracking-wider text-red-600 uppercase">
            {{ json_decode($language->translations)->pages->unsubscribe->unsubscribe }}</h2>

        <p class="px-6 py-3 mb-6 text-center text-red-800 shadow-md bg-red-50 rounded-xl">{{ $email }}</p>

        <p class="mb-4 leading-relaxed text-center text-gray-700">
            {{ json_decode($language->translations)->pages->unsubscribe->description }}
        </p>

        <a href="{{ json_decode($language->translations)->pages->unsubscribe->url->subscribe_again }}"
            class="px-6 py-3 text-white transition-all duration-300 ease-in-out transform bg-red-600 shadow-lg rounded-xl hover:bg-red-700">
            {{ json_decode($language->translations)->pages->unsubscribe->subscribe_again }}
        </a>
    </main>
</body>

</html>
