
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Sisa.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50">

    {{-- NAVBAR --}}
    @include('components.customer-navbar')

    <main class="max-w-5xl mx-auto px-6 py-10">

        <a href="{{ route('dashboard', ['section' => 'produk']) }}#produk"
        class="inline-flex items-center gap-2 rounded-lg border border-[#174b35]/20 bg-white px-4 py-2.5 text-sm font-semibold text-[#174b35] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#174b35] hover:bg-[#edf7f0] hover:shadow-md">

            <svg xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M19 12H5"/>
                <path d="m12 19-7-7 7-7"/>
            </svg>

            Kembali ke Beranda
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mt-5">
            Konfirmasi Pemesanan
        </h1>
        <p class="text-gray-500 mt-1 mb-8">
            Periksa produk dan jumlah pesanan sebelum melanjutkan.
        </p>

        @if (session('error'))
            <div class="mb-5 rounded-xl bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl bg-red-100 p-4 text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('orders.store', $product->id) }}"
              method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">

                    <div class="flex flex-col sm:flex-row gap-5">

                        <div class="w-full sm:w-44 h-40 rounded-xl bg-gray-100 overflow-hidden shrink-0">
                            @if ($product->photo)
                                <img
                                    src="{{ asset('storage/' . $product->photo) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="h-full flex items-center justify-center text-gray-400">
                                    Tidak ada foto
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-500">
                                {{ $product->merchant->business_name }}
                            </p>

                            <h2 class="text-xl font-bold text-gray-800 mt-1">
                                {{ $product->name }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $product->category->name ?? 'Tanpa kategori' }}
                            </p>

                            <div class="mt-3">
                                <span class="text-2xl font-bold text-green-700">
                                    Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-400 line-through ml-2">
                                    Rp{{ number_format($product->normal_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    <label for="quantity"
                           class="block font-semibold text-gray-800 mb-2">
                        Jumlah Pesanan
                    </label>

                    <div class="flex items-center gap-3">
                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity', 1) }}"
                            min="1"
                            max="{{ $product->stock }}"
                            required
                            class="w-28 rounded-xl border border-gray-300 px-4 py-3
                                   focus:border-green-600 focus:outline-none"
                        >

                        <span class="text-sm text-gray-500">
                            Stok tersedia: {{ $product->stock }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-xl bg-green-50 p-4">
                        <p class="font-semibold text-green-800">
                            Informasi Pengambilan
                        </p>
                        <p class="text-sm text-green-700 mt-2">
                            Jam pengambilan:
                            {{ \Carbon\Carbon::parse($product->pickup_start)->format('H:i') }}
                            –
                            {{ \Carbon\Carbon::parse($product->pickup_end)->format('H:i') }}
                        </p>
                        <p class="text-xs text-green-700 mt-2">
                            Pastikan kamu dapat mengambil makanan pada waktu tersebut.
                        </p>
                    </div>

                </div>

                <div class="h-fit bg-white rounded-2xl p-6 shadow-sm">

                    <h2 class="text-lg font-bold text-gray-800">
                        Ringkasan Pesanan
                    </h2>

                    <div class="flex justify-between gap-3 mt-6 text-sm">
                        <span class="text-gray-500">Harga satuan</span>
                        <span>
                            Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-3 mt-3 text-sm">
                        <span class="text-gray-500">Jumlah</span>
                        <span id="summary-quantity">1</span>
                    </div>

                    <div class="border-t border-gray-100 my-5"></div>

                    <div class="flex justify-between items-center gap-3">
                        <span class="font-semibold text-gray-700">
                            Total Harga
                        </span>
                        <span id="summary-total"
                              class="text-xl font-bold text-green-700">
                            Rp{{ number_format($product->surplus_price, 0, ',', '.') }}
                        </span>
                    </div>


                    <button
                        type="submit"
                        id="order-submit"
                        class="group w-full mt-7 flex items-center justify-center gap-2
                            rounded-xl bg-[#174b35] px-5 py-3.5
                            font-semibold text-white shadow-md
                            transition-all duration-200
                            hover:-translate-y-0.5 hover:bg-[#103b29] hover:shadow-lg
                            active:translate-y-0
                            disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        <span id="order-button-text">Buat Pesanan</span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </button>


                    <p class="text-xs text-gray-400 text-center mt-3">
                        Pastikan jumlah dan waktu pengambilan sudah benar.
                    </p>

                </div>

            </div>
        </form>

    </main>

    <script>
        const quantityInput = document.getElementById('quantity');
        const summaryQuantity = document.getElementById('summary-quantity');
        const summaryTotal = document.getElementById('summary-total');

        const price = {{ (float) $product->surplus_price }};

        function updateSummary() {
            let quantity = parseInt(quantityInput.value) || 1;

            if (quantity < 1) quantity = 1;
            if (quantity > {{ $product->stock }}) {
                quantity = {{ $product->stock }};
            }

            summaryQuantity.textContent = quantity;

            summaryTotal.textContent = 'Rp' +
                new Intl.NumberFormat('id-ID').format(price * quantity);
        }

        quantityInput.addEventListener('input', updateSummary);
        updateSummary();
        document.querySelector('form').addEventListener('submit', function () {
            const button = document.getElementById('order-submit');
            const buttonText = document.getElementById('order-button-text');

            button.disabled = true;
            buttonText.textContent = 'Memproses Pesanan...';
        });
    </script>

</body>
</html>
