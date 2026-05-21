<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel Meksiko Inc.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">
    
    {{-- Navbar Khusus Admin --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center mr-8">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-900 tracking-tight">
                            Meksiko Inc. <span class="text-blue-600 text-sm font-normal ml-1">Admin</span>
                        </a>
                    </div>
                    
                    {{-- Navigation Links Admin --}}
                    <div class="hidden sm:flex sm:space-x-8 h-full">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('admin.dashboard') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('admin.products.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                            Products
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('admin.categories.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }} text-sm font-medium transition-colors">
                            Categories
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center gap-6">
                    <span class="text-sm font-medium text-gray-600 flex items-center gap-2">
                        Hello, {{ Auth::user()->name ?? 'User' }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 flex items-center">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 px-4 py-1.5 rounded-md">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    {{-- Main Content Wrapper --}}
    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

</body>
</html>