<x-app-layout>


    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Dashboard') }} - Resumen de Raíces Artesanas
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <i class="fa-solid fa-users fa-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Maestros Artesanos
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        12 {{-- Aquí luego pondrás {{ $totalArtesanos }} --}}
                    </p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <i class="fa-solid fa-shirt fa-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Piezas en Inventario
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        45 {{-- Aquí luego pondrás {{ $totalProductos }} --}}
                    </p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <i class="fa-solid fa-cart-shopping fa-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Ventas Totales
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        $ 15,400.00
                    </p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <i class="fa-solid fa-file-signature fa-xl"></i>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Validaciones Pendientes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        3
                    </p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Ventas Mensuales</h4>
                <canvas id="line"></canvas>
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Categorías más vendidas</h4>
                <canvas id="pie"></canvas>
            </div>
        </div>
    </div>

    @push('js')
        {{-- Cargamos Chart.js solo aquí para no tener errores en otras páginas --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="{{ asset('js/charts-lines.js') }}" defer></script>
        <script src="{{ asset('js/charts-pie.js') }}" defer></script>
    @endpush
</x-app-layout>