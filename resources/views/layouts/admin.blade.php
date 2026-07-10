<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50/50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - E-Commerce</title>

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
    </style>

  
<script>
document.addEventListener('DOMContentLoaded', () => {

    window.userId = {{ auth()->id() ?? 'null' }};
    console.log(window.Echo);

    if (!window.Echo) {
        console.error('Echo not initialized');
        return;
    }

    loadUnreadNotifications();

    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notification) => {
            //console.log(notification);

            loadUnreadNotifications();

        });

});
</script>

</head>
<body class="h-full text-slate-800 antialiased">

<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm transition-opacity hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar Container -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-white px-6 py-5 transition-transform duration-300 -translate-x-full lg:static lg:translate-x-0">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/30">
                <i class="fa-solid fa-bag-shopping text-lg"></i>
            </div>
            <div>
                <h1 class="text-base font-semibold text-slate-900 leading-none">Apex Cart</h1>
                <span class="text-xs font-medium text-slate-400">Admin Control</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-8 flex flex-1 flex-col gap-7">
            <div>
                <span class="px-3 text-2xs font-semibold tracking-wider text-slate-400 uppercase">Core Management</span>
                <ul class="mt-3 space-y-1">
                    <li>
                        <a href="#" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-chart-pie text-lg w-5 text-center text-slate-400 group-hover:text-slate-900"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-boxes-stacked text-lg w-5 text-center text-slate-400"></i>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.import') }}" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-semibold transition-colors {{ Request::routeIs('products.import') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i class="fa-solid fa-file-import text-lg w-5 text-center {{ Request::routeIs('products.import') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                            Import Products
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <span class="px-3 text-2xs font-semibold tracking-wider text-slate-400 uppercase">Sales & Customers</span>
                <ul class="mt-3 space-y-1">
                    <li>
                        <a href="#" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-cart-shopping text-lg w-5 text-center text-slate-400"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-users text-lg w-5 text-center text-slate-400"></i>
                            Customers
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-auto border-t border-slate-100 pt-5">
                <ul>
                    <li>
                        <a href="#" class="flex items-center gap-3.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-sliders text-lg w-5 text-center text-slate-400"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex flex-1 flex-col overflow-hidden">
        <!-- Header -->
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button -->
                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 lg:hidden" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="hidden sm:block">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" placeholder="Search product catalogue..." class="w-64 md:w-80 rounded-xl border border-slate-200 py-1.5 pl-9 pr-4 text-sm outline-none transition-all placeholder:text-slate-400 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100">
                    </div>
                </div>
            </div>

            <!-- Profile Info & Notifications -->
            <div class="flex items-center gap-4">

                <!--button type="button" class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 hover:bg-slate-50">
                    <i class="fa-regular fa-bell text-base"></i>
                    <span class="absolute right-2.5 top-2.5 flex h-2 w-2 rounded-full bg-indigo-600"></span>
                </button-->

                <div class="relative inline-block text-left">

                    <!-- Notification Button -->
                    <button style="cursor: pointer;" id="notificationBtn"
                        class="relative inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                        <i class="fa-regular fa-bell text-lg"></i>

                        <!-- Notification Count -->
                        <span  id="notificationCount"
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                            3
                        </span>
                    </button>

                    <!-- Dropdown -->
                    <div id="notificationList"
                        class="hidden absolute right-0 mt-3 w-96 origin-top-right rounded-xl border border-slate-200 bg-white shadow-2xl overflow-hidden z-50">

                       
                    </div>

                </div>


                <div class="h-6 w-px bg-slate-200"></div>

                <div class="relative">
                    <button type="button" id="profileDropdownBtn" class="flex items-center gap-3 focus:outline-none select-none cursor-pointer">
                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-indigo-50" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100&h=100" alt="Admin user avatar">
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-2xs font-medium text-slate-400">Super Administrator</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs hidden md:block transition-transform duration-200" id="profileChevron"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileDropdown" class="absolute right-0 mt-2.5 w-52 origin-top-right rounded-xl border border-slate-200 bg-white p-2.5 shadow-xl shadow-slate-100/50 ring-1 ring-black/5 focus:outline-none z-50 hidden opacity-0 scale-95 transition-all duration-150">
                        <div class="px-2.5 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-2xs font-medium text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-left text-sm font-semibold text-red-600 hover:bg-red-50/50 transition-colors cursor-pointer">
                                <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Viewport Content -->
        <main class="flex-1 overflow-y-auto bg-slate-50/50 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dropdownBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdown');
        const chevron = document.getElementById('profileChevron');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = dropdownMenu.classList.contains('hidden');
                
                if (isHidden) {
                    dropdownMenu.classList.remove('hidden');
                    dropdownMenu.offsetHeight; // force reflow
                    dropdownMenu.classList.remove('opacity-0', 'scale-95');
                    if (chevron) chevron.classList.add('rotate-180');
                } else {
                    dropdownMenu.classList.add('opacity-0', 'scale-95');
                    if (chevron) chevron.classList.remove('rotate-180');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 150);
                }
            });

            document.addEventListener('click', (e) => {
                if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                    if (!dropdownMenu.classList.contains('hidden')) {
                        dropdownMenu.classList.add('opacity-0', 'scale-95');
                        if (chevron) chevron.classList.remove('rotate-180');
                        setTimeout(() => {
                            dropdownMenu.classList.add('hidden');
                        }, 150);
                    }
                }
            });
        }
    });
</script>
</body>
</html>