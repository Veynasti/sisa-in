
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-green-600">
                    Sisa.in
                </h1>

                <p class="mt-2 text-gray-500">
                    Selamatkan makanan, hemat pengeluaran.
                </p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Buat Akun
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar untuk mulai menemukan surplus food.
                    </p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">

                    @csrf

                    <!-- Name -->
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required
                        >

                        @error('name')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required
                        >

                        @error('email')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Password
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password', 'eyeIcon1', this)"
                                aria-label="Tampilkan password"
                                class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-green-600"
                            >
                                <svg
                                    id="eyeIcon1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation', 'eyeIcon2', this)"
                                aria-label="Tampilkan password"
                                class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-green-600"
                            >
                                <svg
                                    id="eyeIcon2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition duration-200"
                    >
                        Daftar
                    </button>

                </form>

                <!-- Login -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        Sudah punya akun?

                        <a
                            href="{{ route('login') }}"
                            class="font-semibold text-green-600 hover:text-green-700"
                        >
                            Masuk
                        </a>
                    </p>
                </div>

            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Sisa.in
            </p>

        </div>

    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword(inputId, iconId, button) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

                button.setAttribute('aria-label', 'Sembunyikan password');

                eyeIcon.innerHTML = `
                    <path d="M3 3l18 18"/>
                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5
                        c6.4 0 10 7 10 7a15.5 15.5 0 0 1-4 4.7"/>
                    <path d="M6.2 6.2C3.5 8 2 12 2 12
                        s3.6 7 10 7a10 10 0 0 0 3.2-.5"/>
                `;
            } else {
                passwordInput.type = 'password';

                button.setAttribute('aria-label', 'Tampilkan password');

                eyeIcon.innerHTML = `
                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>

</body>
</html>
