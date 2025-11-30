<div>

 <form wire:submit.prevent="register" class="space-y-5">
    
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Lengkap</label>
                        <input type="text" placeholder="Masukkan nama lengkap" class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition" wire:model="name" required>
                    </div>


                  <!-- Email -->
                       <!-- Email -->
                                <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                                <input type="email" placeholder="nama@email.com"
                                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition" wire:model="email"
                                        required>
                                        @error('email')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Kata Sandi</label>
                                <div class="relative">
                                    <input id="password" type="password"
                                        placeholder="Minimal 4 karakter"
                                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition pr-10" wire:model="password"
                                        required>
                                        @error('password')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror



                                    <!-- tombol mata -->
                                    <button type="button" id="togglePassword"
                                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Gunakan kombinasi huruf, angka, dan simbol</p>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input id="confirmPassword" type="password"
                                        placeholder="Ulangi kata sandi"
                                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition pr-10" wire:model="confirm_password"
                                        required>
                                        @error('confirm_password')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror



                                    <!-- tombol mata -->
                                    <button type="button" id="toggleConfirmPassword"
                                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    </button>
                                </div>
                                </div>

                                            <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-bold text-lg mt-6">
                        Buat Akun
                    </button>
                </form>
</div>
