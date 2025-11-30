<div>
    <div class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100">
    <div class="w-full max-w-2xl">
        <!-- Card Container -->
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/60 overflow-hidden">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h2 class="text-3xl font-bold">Profil Member</h2>
                    </div>
                    <p class="text-indigo-100 text-sm">Kelola informasi pribadi Anda</p>
                </div>
            </div>

            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="mx-8 mt-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form Section -->
            <form wire:submit.prevent="save" class="p-8 space-y-6">

                <!-- NIM Field -->
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        NIM
                    </label>
                    <input type="text"
                           wire:model="nim"
                           placeholder="Masukkan NIM Anda"
                           class="w-full border-2 border-gray-200 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200 hover:border-gray-300">
                    @error('nim')
                        <span class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Nama Field -->
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Nama Lengkap
                    </label>
                    <input type="text"
                           wire:model="name"
                           placeholder="Masukkan nama lengkap"
                           class="w-full border-2 border-gray-200 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all duration-200 hover:border-gray-300">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Nomor HP
                    </label>
                    <input type="text"
                           wire:model="phone"
                           placeholder="08xx-xxxx-xxxx"
                           class="w-full border-2 border-gray-200 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-all duration-200 hover:border-gray-300">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Alamat
                    </label>
                    <textarea wire:model="address"
                              rows="4"
                              placeholder="Masukkan alamat lengkap"
                              class="w-full border-2 border-gray-200 rounded-xl p-3 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200 hover:border-gray-300 resize-none"></textarea>
                    @error('address')
                        <span class="text-red-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Profil</span>
                </button>

            </form>

        </div>

        <!-- Footer Info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>Data Anda aman dan terenkripsi 🔒</p>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>

</div>
