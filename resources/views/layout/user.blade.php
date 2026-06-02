<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Meksiko Inc.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">
    
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="bg-blue-600 text-white px-4 py-2 text-sm flex justify-between items-center z-[60] relative">
                <span class="flex items-center gap-2 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    You are currently viewing the user site in <strong>Admin Preview Mode</strong>
                    <a href="{{ route('admin.dashboard') }}" class="ml-auto bg-white text-blue-600 hover:bg-blue-50 px-4 py-1 rounded-md font-semibold transition-colors shadow-sm">
                        Return to Admin Dashboard
                    </a>
                </span>
            </div>
        @endif
    @endauth

    {{-- User Navigation Bar --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center mr-10">
                        <span class="text-xl font-bold text-gray-900 tracking-tight">Meksiko Inc.</span>
                    </div>
                    
                    <div class="hidden sm:flex sm:space-x-8 h-full">
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('user.dashboard') ? 'border-gray-900 text-gray-900 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-900' }} text-sm transition-colors">
                            Dashboard
                        </a>
                        <a href="{{ route('user.catalog') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('user.catalog') ? 'border-gray-900 text-gray-900 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-900' }} text-sm transition-colors">
                            Catalog
                        </a>
                        <a href="{{ route('user.invoices.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ Route::is('user.invoices.*') ? 'border-gray-900 text-gray-900 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-900' }} text-sm transition-colors gap-2">
                            My Invoices
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    {{-- Cart Icon --}}
                    <a href="{{ route('user.cart') }}" class="relative text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @php
                            $hasPendingCart = \App\Models\Invoice::where('user_id', auth()->id())
                                                                        ->where('status', 'pending')
                                                                        ->exists();
                        @endphp

                        @if ($hasPendingCart)
                            <span class="absolute -top-1.5 -right-2 bg-gray-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                                !
                            </span>                        
                        @endif

                    </a>

                    <span class="text-sm font-medium text-gray-600 border-l border-gray-200 pl-6">
                        Hello, {{ Auth::user()->name ?? 'User' }}
                    </span>
                    
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>