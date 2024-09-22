@php
    $color = app(App\Settings\EmailSetting::class)->primary;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | {{ json_decode($language->translations)->pages->unsubscribe->unsubscribe }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')

    <style>
        .text-custom-primary {
            color: rgb(from {{ $color }} r g b) !important;
        }

        .text-custom-primary:hover {
            color: rgba(from {{ $color }} r g b / 70%);
        }

        .bg-custom-primary {
            background: rgb(from {{ $color }} r g b) !important;
        }

        .bg-custom-primary:hover {
            background: rgba(from {{ $color }} r g b / 70%);
            color: "orange"
        }
    </style>
</head>

<body class="py-12 space-y-6 font-sans antialiased text-center text-gray-800 bg-gray-100">
    <img src="{{ config('app.url') }}/storage/{{ app(App\Settings\EmailSetting::class)->logo }}"
        alt="Dezittere Philac | Logo" class="w-64 mx-auto">
    <main class="flex flex-col items-center max-w-lg p-10 mx-auto bg-white shadow-lg rounded-3xl">
        <h1 class="text-xl font-bold">{{ json_decode($language->translations)->pages->unsubscribe->title }}!</h1>
        <p class="mb-4 leading-relaxed text-center text-gray-700">
            {{ json_decode($language->translations)->pages->unsubscribe->description }}
        </p>
        <a href="{{ json_decode($language->translations)->pages->unsubscribe->urls->store }}"
            class="px-6 py-2 text-white transition-all duration-300 ease-in-out transform shadow-lg bg-custom-primary rounded-xl">
            {{ json_decode($language->translations)->pages->unsubscribe->back }}
        </a>
    </main>
    <div class="w-64 mx-auto">
        <a href="{{ json_decode($language->translations)->pages->unsubscribe->urls->subscribe_again }}"
            class="mx-auto underline transition-all duration-300 ease-in-out transform text-custom-primary">
            {{ json_decode($language->translations)->pages->unsubscribe->mistake }}?
        </a>
    </div>
</body>

</html>
