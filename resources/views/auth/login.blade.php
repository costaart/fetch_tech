<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <title>FetchTech | Login</title>
</head>
<body class="font-[Archivo] bg-[#FBFBFB] min-h-screen flex items-center justify-center">

<div class="flex flex-col md:flex-row bg-white shadow-xl rounded-lg overflow-hidden">
    
    <!-- IMAGEM -->
    <div class="relative hidden md:flex items-center justify-center bg-[#ECECFE] p-8">
        <img src="{{ asset('images/page.jpg') }}" alt="Login Illustration" 
            class="w-[500px] h-[600px] object-cover">
    </div>

    <!-- LOGIN -->
    <div class="flex items-center justify-center p-8 md:p-12 bg-white">
        <div class="w-full max-w-md">
            
            <!-- HEADER -->
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-20 h-20 mb-4">
                <h1 class="text-2xl font-bold mb-2">Welcome Back!</h1>
                <p class="text-[#8C8D8B] mb-6 text-center">
                    Sign in to your account to get the latest tech news.
                </p>
            </div>

            <!-- MESSAGE SUCCESS -->
            @if(session('success'))
                <div class="bg-[#ECECFE] border border-[#636AE8] text-[#4b52c9] px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
                @csrf

                <!-- EMAIL -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">E-mail</label>
                    <input 
                        type="email" 
                        name="email"
                        placeholder="your.email@example.com"
                        value="{{ old('email') }}"
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                    @error('email')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">Password</label>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="******"
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- FORGOT PASSWORD -->
                <div class="flex justify-end">
                    <a href="#" class="text-sm text-[#8C8D8B] font-semibold hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <button 
                    type="submit" 
                    class="bg-[#636AE8] hover:bg-[#4b52c9] text-white rounded px-4 py-2 font-semibold transition">
                    Login
                </button>
            </form>

            <!-- FOOTER -->
            <div class="mt-6 text-center">
                <a href="{{ route('register') }}" class="text-sm text-[#8C8D8B] hover:underline">
                    Don't have an account? <span class="font-semibold">Register</span>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
