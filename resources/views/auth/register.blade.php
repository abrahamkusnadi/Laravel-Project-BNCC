<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Meksiko Inc.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

<div class="flex min-h-screen">
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-white">
        <div class="max-w-md w-full">
            <div class="mb-8 text-center lg:text-left">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Create account</h1>
                <p class="text-gray-500 mt-2">Join us to start your premium shopping experience</p>
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

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email (@gmail.com)</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@gmail.com" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08..." required 
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" placeholder="6-12 chars" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-semibold py-3.5 rounded-xl hover:bg-black transition duration-200 shadow-lg mt-4">
                    Create Account
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:underline">Login here</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-700 to-indigo-900 items-center justify-center relative overflow-hidden p-12">
        <div class="absolute w-96 h-96 border-2 border-white/10 rounded-3xl rotate-45 -top-20 -right-20"></div>
        <div class="absolute w-80 h-80 border-2 border-white/5 rounded-full -bottom-10 -left-10"></div>
        
        <div class="relative z-10 text-center max-w-lg text-white">
            <h2 class="text-4xl font-bold mb-4">Shopping, elevated.</h2>
            <p class="text-indigo-100 text-lg opacity-90 leading-relaxed">
                Join thousands of customers who trust Meksiko Inc. to discover top-tier products with a seamless, intuitive experience.
            </p>
        </div>
    </div>
</div>

</body>
</html>