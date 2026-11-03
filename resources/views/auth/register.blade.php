
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sisa.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f8faf8]">

    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- LEFT: BRANDING -->
        <section class="hidden lg:flex flex-col justify-between bg-[#174b35] text-white p-10 xl:p-14 relative overflow-hidden">

            <!-- Decorative Circle -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-green-400/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-green-300/10 rounded-full blur-3xl"></div>

            <!-- Logo -->
            <div class="relative z-10">
                <h1 class="text-3xl font-bold tracking-tight">
                    Sisa<span class="text-green-300">.in</span>
                </h1>

                <p class="text-sm text-green-100 mt-1">
                    Save Food, Save Money.
                </p>
            </div>

            <!-- Image -->
            <div class="relative z-10 mt-10">
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

            <!-- Bottom Text -->
            <div class="relative z-10 mt-10">
                <p class="text-green-100 text-sm leading-relaxed max-w-md">
                    Bergabunglah dengan Sisa.in dan jadilah bagian dari gerakan
                    mengurangi limbah makanan dengan cara yang lebih mudah dan terjangkau.
                </p>

                <p class="text-xs text-green-200/70 mt-8">
                    © {{ date('Y') }} Sisa.in. All rights reserved.
                </p>
            </div>

        </section>

        <!-- RIGHT: REGISTER FORM -->
        <section class="flex items-center justify-center px-5 py-10 sm:px-8 lg:px-12">

            <div class="w-full max-w-lg">

                <!-- Mobile Logo -->
                <div class="text-center mb-8 lg:hidden">
                    <h1 class="text-3xl font-bold text-[#174b35]">
                        Sisa<span class="text-green-500">.in</span>
                    </h1>

                    <p class="text-sm text-gray-500 mt-2">
                        Selamatkan makanan, hemat pengeluaran.
                    </p>
                </div>

                <!-- Register Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-7 sm:p-9">

                    <!-- Heading -->
                    <div class="mb-7">
                        <p class="text-sm font-semibold text-green-600 mb-2">
                            MULAI BERSAMA KAMI
                        </p>

                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                            Buat Akun
                        </h2>

                        <p class="text-sm text-gray-500 mt-2">
                            Daftar sekarang untuk mulai menggunakan Sisa.in.
                        </p>
                    </div>

                    <!-- General Error -->
                    @if ($errors->any())
                        <div class="mb-5 rounded-xl bg-red-50 border border-red-100 p-4">
                            <p class="text-sm font-medium text-red-700">
                                Periksa kembali data pendaftaran kamu.
                            </p>
                        </div>
                    @endif

                    <!-- Register Form -->
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">

                        @csrf

                        <!-- Account Type -->
                        <div>
                            <label for="account_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Daftar Sebagai
                            </label>

                            <select
                                id="account_type"
                                name="account_type"
                                required
                                onchange="toggleMerchantFields()"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                            >
                                <option value="customer" {{ old('account_type', 'customer') == 'customer' ? 'selected' : '' }}>
                                    Customer - Pembeli
                                </option>

                                <option value="merchant" {{ old('account_type') == 'merchant' ? 'selected' : '' }}>
                                    Merchant - Penjual
                                </option>
                            </select>

                            @error('account_type')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                required
                            >

                            @error('name')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username
                            </label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Contoh: andreas123"
                                autocomplete="username"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                required
                            >

                            @error('username')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="contoh@email.com"
                                autocomplete="email"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                required
                            >

                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>

                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
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
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>

                            <div class="relative">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
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

                        <!-- Merchant Information -->
                        <div
                            id="merchantFields"
                            class="space-y-4 border-t border-gray-100 pt-5 mt-5"
                            hidden
                        >

                            <div>
                                <h3 class="text-base font-semibold text-gray-800">
                                    Informasi Toko
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Lengkapi informasi toko untuk mendaftar sebagai merchant.
                                </p>
                            </div>

                            <!-- Business Name -->
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Toko
                                </label>

                                <input
                                    type="text"
                                    id="business_name"
                                    name="business_name"
                                    value="{{ old('business_name') }}"
                                    placeholder="Contoh: Kantin Sejahtera"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                                >

                                @error('business_name')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon Toko
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Contoh: 081234567890"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                                >

                                @error('phone')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Toko
                                </label>

                                <textarea
                                    id="address"
                                    name="address"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap toko"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                                >{{ old('address') }}</textarea>

                                @error('address')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Toko
                                    <span class="text-gray-400 font-normal">(Opsional)</span>
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="Ceritakan secara singkat tentang toko kamu"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Verification Information -->
                            <div class="rounded-xl bg-green-50 border border-green-100 p-4">
                                <p class="text-sm text-green-800 leading-relaxed">
                                    <strong>Informasi:</strong>
                                    Pendaftaran merchant akan diperiksa terlebih dahulu oleh admin Sisa.in.
                                    Kamu baru bisa mengakses dashboard merchant setelah pendaftaran disetujui.
                                </p>
                            </div>

                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full bg-[#174b35] hover:bg-[#103b29] text-white font-semibold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-green-900/10 mt-2"
                        >
                            Daftar Sekarang
                        </button>

                    </form>

                    <!-- Login Link -->
                    <div class="text-center mt-7">
                        <p class="text-sm text-gray-500">
                            Sudah punya akun?

                            <a
                                href="{{ route('login') }}"
                                class="font-semibold text-green-700 hover:text-green-800"
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

        </section>

    </div>

    <!-- JavaScript -->
    <script>

        // Toggle password visibility
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

        // Show or hide merchant fields
        function toggleMerchantFields() {
            const accountType = document.getElementById('account_type');
            const merchantFields = document.getElementById('merchantFields');

            const businessName = document.getElementById('business_name');
            const phone = document.getElementById('phone');
            const address = document.getElementById('address');

            const isMerchant = accountType.value === 'merchant';

            merchantFields.hidden = !isMerchant;

            businessName.required = isMerchant;
            phone.required = isMerchant;
            address.required = isMerchant;
        }

        // Initialize form
        document.addEventListener('DOMContentLoaded', function () {
            toggleMerchantFields();
        });

    </script>

</body>
</html>
