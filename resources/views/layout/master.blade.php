<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PT Meksiko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    
    {{-- Navbar dengan tambahan sticky agar tetap di atas saat di-scroll --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center mr-8">
                        {{-- Saya jadikan logo ini bisa diklik untuk kembali ke home --}}
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900 tracking-tight">Meksiko Inc.</a>
                    </div>
                    
                    {{-- Navigation Links (Perhatikan penambahan h-full agar garis bawah pas di ujung border) --}}
                    <div class="hidden sm:flex sm:space-x-8 h-full">
                        
                        {{-- Dashboard (Hanya muncul jika sudah login) --}}
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('dashboard') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                        @endauth

                        {{-- Products (Public - Muncul untuk semua orang) --}}
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('products.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                            Products
                        </a>

                        @auth
                            {{-- Categories (Hanya muncul untuk Admin) --}}
                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('categories.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                                    Categories
                                </a>
                            @endif

                            {{-- My Invoices (Hanya muncul untuk User biasa) --}}
                            @if(auth()->user()->role == 'user')
                                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('invoices.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                                    My Invoices
                                </a>
                            @endif
                        @endauth

                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center gap-6">
                    @auth
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-2">
                            @if (auth()->user()->role === 'admin')
                                Hello, Admin {{ Auth::user()->name ?? 'User' }}
                            @else
                                Hello, {{ Auth::user()->name ?? 'User' }}
                            @endif
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 flex items-center">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 px-4 py-1.5 rounded-md">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                            Register
                        </a>
                    @endauth
            </div>
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
</body>
</html>