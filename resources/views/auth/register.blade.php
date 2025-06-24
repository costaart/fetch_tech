<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
    <title>Register | FetchTech</title>
</head>
<body class="font-[Archivo] bg-[#FBFBFB] min-h-screen flex items-center justify-center">

<div class="flex flex-col md:flex-row bg-white shadow-xl rounded-lg overflow-hidden">
    
    <!-- IMAGEM -->
    <div class="relative hidden md:flex items-center justify-center bg-[#ECECFE] p-8">
        <img src="{{ asset('images/page.jpg') }}" alt="Register Illustration" 
            class="w-[500px] h-[600px] object-cover">
    </div>

    <!-- REGISTER -->
    <div class="flex items-center justify-center p-8 md:p-12 bg-white">
        <div class="w-full max-w-md">
            
            <!-- HEADER -->
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-20 h-20 mb-4">
                <h1 class="text-2xl font-bold mb-2">Create an Account</h1>
                <p class="text-[#8C8D8B] mb-6 text-center">
                    Join us to get the latest tech news and updates.
                </p>
            </div>
            
            <!-- FORM -->
            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
                @csrf

                <!-- NAME -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">Name</label>
                    <input 
                        type="text" 
                        name="name"
                        placeholder="Your Name" 
                        value="{{ old('name') }}"
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

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

                <!-- LANGUAGE SELECT -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">News Language</label>
                    <select id="language" name="language"
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                        <option value="pt" {{ old('language') == 'pt' ? 'selected' : '' }}>🇧🇷 Português</option>
                        <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
                    </select>
                    @error('language')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">Password</label>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="Password" 
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="flex flex-col">
                    <label class="text-sm mb-1 text-[#4B5563]">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        placeholder="Confirm Password" 
                        class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#636AE8]">
                </div>

                <!-- BUTTON -->
                <button 
                    type="submit" 
                    class="bg-[#636AE8] hover:bg-[#4b52c9] text-white rounded px-4 py-2 font-semibold transition">
                    Register
                </button>
            </form>

            <!-- FOOTER -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#8C8D8B] hover:underline">
                    Already have an account? <span class="font-semibold">Login</span>
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
