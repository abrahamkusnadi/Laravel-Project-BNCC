<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Meksiko Inc.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

<div class="flex min-h-screen">
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-white">
        <div class="max-w-md w-full">
            <div class="mb-10">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Welcome back</h1>
                <p class="text-gray-500 mt-2">Sign in to your account to continue</p>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-semibold py-3.5 rounded-xl hover:bg-black transition duration-200 shadow-lg">
                    Sign In
                </button>
            </form>

            <p class="text-center mt-8 text-sm text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-gray-900 hover:underline">Register here</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-700 to-blue-900 items-center justify-center relative overflow-hidden p-12">
        <div class="absolute w-96 h-96 border-2 border-white/10 rounded-3xl rotate-45 -top-20 -right-20"></div>
        <div class="absolute w-80 h-80 border-2 border-white/5 rounded-full -bottom-10 -left-10"></div>
        <div class="absolute w-64 h-64 border-2 border-white/10 rounded-3xl rotate-12 top-1/4 left-10"></div>

        <div class="relative z-10 text-center max-w-lg">
            <h2 class="text-3xl font-bold text-white mb-4">Inventory, simplified.</h2>
            <p class="text-indigo-100 text-lg leading-relaxed opacity-90">
                Everything you need to manage your daily business operations, wrapped in a clean, fast, and intuitive interface</p>
        </div>
    </div>
</div>

</body>
</html>