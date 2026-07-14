<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-10">

        <div class="bg-white shadow rounded-lg p-6">

            <h1 class="text-3xl font-bold text-blue-600">
                Welcome to Laravel 12
            </h1>

            <p class="mt-4 text-gray-700">
                Laravel Version:
                <strong>{{ app()->version() }}</strong>
            </p>

            <p class="mt-2">
                Current Time:
                {{ now()->format('d M Y h:i A') }}
            </p>

            <hr class="my-4">

            <a href="{{ route('login') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="bg-green-600 text-white px-4 py-2 rounded ml-2">
                Register
            </a>

        </div>

    </div>

</body>
</html>