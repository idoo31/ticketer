<x-layout :hideNavbar="true" :hideFooter="true">
    <div class="min-h-screen flex flex-col justify-between bg-[#fcfcfc]">
        <x-navbar />
        
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[2rem] max-w-md w-full shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <svg class="h-16 w-16 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 5v2"></path>
                        <path d="M15 11v2"></path>
                        <path d="M15 17v2"></path>
                        <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2z"></path>
                    </svg>
                </div>

                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-sm text-gray-600">Masuk untuk mengelola pesanan anda</p>
                </div>

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="admin@contoh.com">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold text-gray-700 tracking-wide uppercase">Kata Sandi</label>
                            <a href="#" class="text-xs font-semibold text-gray-600 hover:text-blue-600">Lupa sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-[#fafafa]" placeholder="masukkan kata sandi anda">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Masuk <span class="ml-2">&rarr;</span>
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-600">
                        Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:text-blue-600">Buat Akun</a>
                    </p>
                </div>
            </div>
        </div>

        <x-footer />
    </div>
</x-layout>
