
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f7f8f4]">

    <main class="min-h-screen grid lg:grid-cols-2">

        <!-- LEFT SIDE: BRANDING -->
        <section class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-[#174c35] p-12 xl:p-16 text-white">

            <!-- Background Decoration -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-[#367b50] opacity-30 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-20 w-96 h-96 rounded-full bg-[#8dbb76] opacity-20 blur-3xl"></div>

            <!-- Logo -->
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-white flex items-center justify-center text-[#174c35] font-bold text-2xl">
                        S
                    </div>

                    <span class="text-2xl font-bold tracking-tight">
                        Sisa.in
                    </span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 max-w-xl">

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-sm text-green-100 mb-7">
                    <span class="w-2 h-2 rounded-full bg-[#b9e68c]"></span>
                    Bersama mengurangi food waste
                </div>

                <h1 class="text-5xl xl:text-6xl font-bold leading-tight tracking-tight">
                    Good Food
                    <span class="text-[#b9e68c]">Shouldn't</span>
                    Go to Waste.
                </h1>

                <p class="mt-6 text-lg leading-relaxed text-green-100/80 max-w-lg">
                    Temukan makanan surplus berkualitas dengan harga lebih hemat.
                    Selamatkan makanan, nikmati kebaikannya.
                </p>

                <!-- Food Image -->

                <div class="mt-10 relative">
                    <div class="relative rounded-3xl overflow-hidden border border-white/20 shadow-2xl">
                        <img
                            src="{{ asset('images/image.png') }}"
                            alt="Hidangan makanan segar"
                            class="w-full h-64 xl:h-72 object-cover"
                        >
                        <div class="absolute inset-0 bg-linear-to-t from-[#102f23]/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <p class="text-sm text-green-100">
                                Setiap makanan punya kesempatan kedua.
                            </p>
                            <h3 class="text-2xl font-semibold mt-1">
                                Save Food, Save Money.
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 flex justify-between items-center text-sm text-green-100/60 mt-10">
                <span>© {{ date('Y') }} Sisa.in</span>
                <span>Eat Better, Waste Less.</span>
            </div>

        </section>


        <!-- RIGHT SIDE: LOGIN FORM -->
        <section class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-12">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12 text-center">
                    <a href="/" class="inline-flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-[#174c35] flex items-center justify-center text-white font-bold text-xl">
                            S
                        </div>

                        <span class="text-2xl font-bold text-[#174c35]">
                            Sisa.in
                        </span>
                    </a>
                </div>

                <!-- Heading -->
                <div class="mb-9">
                    {{-- <p class="text-2xl font-bold text-[#43865a] uppercase tracking-widest mb-3">
                        Haloo...
                    </p> --}}

                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                        Selamat Datang!
                    </h2>

                    <p class="mt-3 text-gray-500 leading-relaxed">
                        Masuk ke akun Sisa.in kamu dan temukan makanan favorit dengan harga lebih hemat.
                    </p>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-7 sm:p-9">

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">

                        @csrf

                        <!-- Username -->
                        <div>
                            <label
                                for="username"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Username
                            </label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username kamu"
                                autocomplete="username"
                                class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#43865a]/30 focus:border-[#43865a] transition"
                                required
                            >

                            @error('username')
                                <p class="text-sm text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Password
                            </label>

                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password kamu"
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3.5 pr-12 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#43865a]/30 focus:border-[#43865a] transition"
                                    required
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    id="togglePasswordButton"
                                    aria-label="Tampilkan password"
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-[#43865a] transition"
                                >
                                    <svg
                                        id="eyeIcon"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="21"
                                        height="21"
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
                                <p class="text-sm text-red-500 mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-[#174c35] hover:bg-[#103b29] text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-green-900/10 transition duration-200"
                        >
                            Masuk ke Akun

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>
                        </button>

                    </form>

                    <!-- Register -->
                    <div class="relative my-7">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>

                        <div class="relative flex justify-center">
                            <span class="bg-white px-4 text-xs text-gray-400">
                                BELUM BERGABUNG?
                            </span>
                        </div>
                    </div>

                    <p class="text-center text-sm text-gray-500">
                        Belum punya akun?

                        <a
                            href="{{ route('register') }}"
                            class="font-semibold text-[#43865a] hover:text-[#174c35] transition"
                        >
                            Daftar Sekarang
                        </a>
                    </p>

                </div>

                <!-- Bottom Info -->
                <p class="text-center text-xs text-gray-400 mt-8">
                    Dengan masuk, kamu ikut mendukung gerakan mengurangi pemborosan makanan.
                </p>

                <p class="text-center text-xs text-gray-400 mt-3 lg:hidden">
                    © {{ date('Y') }} Sisa.in
                </p>

            </div>

        </section>

    </main>


    <!-- Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const button = document.getElementById('togglePasswordButton');

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
