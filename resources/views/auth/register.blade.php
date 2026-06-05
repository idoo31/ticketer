<x-layout :hideNavbar="true" :hideFooter="true">
    <div class="min-h-screen flex flex-col justify-between bg-[#fcfcfc]">
        <x-navbar />
        
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[2rem] max-w-md w-full shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('logo.svg') }}" alt="Ticketer Logo" class="h-16 w-16 md:h-20 md:w-20">
                </div>

                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Buat Akun Baru</h2>
                    <p class="text-sm text-gray-600">Daftar untuk membeli tiket konser favorit Anda</p>
                </div>

                <form class="space-y-5" action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="block w-full pl-11 pr-3 py-3 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="Nama Lengkap Anda">
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required class="block w-full pl-11 pr-3 py-3 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="email@contoh.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required class="block w-full pl-11 pr-3 py-3 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="Ulangi kata sandi">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Daftar Sekarang <span class="ml-2">&rarr;</span>
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-blue-600">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>

        <x-footer />
    </div>
</x-layout>
