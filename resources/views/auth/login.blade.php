<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apex Cart Admin</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .mesh-gradient {
            background-color: #0b0f19;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0.3) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(263,40%,25%,0.35) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(222,47%,11%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(222,47%,11%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="mesh-gradient flex min-h-screen items-center justify-center p-4 sm:p-6 text-slate-100 antialiased overflow-hidden relative">

    <!-- Background glowing blobs -->
    <div class="absolute top-1/4 left-1/4 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 translate-x-1/2 translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md z-10">
        <!-- Logo -->
        <div class="flex flex-col items-center gap-3 mb-8 text-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-xl shadow-indigo-600/30">
                <i class="fa-solid fa-bag-shopping text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white tracking-tight">Apex Cart</h1>
                <p class="text-xs text-slate-400 font-medium mt-1">Sign in to control your storefront</p>
            </div>
        </div>

        <!-- Glassmorphism Card -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-8 backdrop-blur-xl shadow-2xl">
            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Session Status / Errors -->
                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-xs text-red-400">
                        <div class="flex gap-2">
                            <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-400"></i>
                            <ul class="list-disc pl-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <i class="fa-regular fa-envelope text-base"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="admin@example.com"
                               class="w-full rounded-xl border border-slate-800 bg-slate-950/50 py-3 pl-11 pr-4 text-sm text-slate-100 placeholder:text-slate-600 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-base"></i>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-xl border border-slate-800 bg-slate-950/50 py-3 pl-11 pr-4 text-sm text-slate-100 placeholder:text-slate-600 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-800 bg-slate-950/50 text-indigo-600 focus:ring-indigo-500/20 focus:ring-offset-slate-900 focus:ring-2 h-4 w-4">
                        <span class="ms-2 text-xs font-medium text-slate-400">Remember my session</span>
                    </label>
                </div>

                <!-- Action Button -->
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 hover:shadow-indigo-600/35 transition-all duration-200 cursor-pointer active:scale-[0.98]">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <p class="text-center text-xs text-slate-600 mt-8">
            &copy; {{ date('Y') }} Apex Cart. All rights reserved.
        </p>
    </div>

</body>
</html>
