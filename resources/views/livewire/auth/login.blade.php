<div>

<form wire:submit.prevent="login" class="space-y-6">

  <!-- Email -->
  <div>
    <label class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
    <input
      type="email"
      placeholder="nama@email.com"
      class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition"
      required wire:model="email"
    />
    @error('email')
    <span class="text-red-500 text-sm">{{ $message }}</span>
  @enderror
  </div>


  <!-- Password -->
  <div>
    <label class="block text-sm font-semibold text-gray-900 mb-2">Kata Sandi</label>

    <div class="relative">
      <input
        id="password"
        type="password"
        placeholder="••••••••"
        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none transition pr-10"
        required wire:model="password"

      />


      <!-- Tombol mata -->
      <button
        type="button"
        id="togglePassword"
        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
        aria-label="Toggle password visibility"
      >
        <svg
          id="eyeIcon"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
          <circle cx="12" cy="12" r="3" />
        </svg>
      </button>

    </div>
    @error('password')
        <span class="text-red-500 text-sm">{{ $message }}</span>
      @enderror
  </div>

 
  <button
    type="submit"
    class="btn-primary w-full text-white py-3 rounded-xl font-bold text-lg bg-purple-600 hover:bg-purple-700 transition"
  >
    Masuk
  </button>
</form>

