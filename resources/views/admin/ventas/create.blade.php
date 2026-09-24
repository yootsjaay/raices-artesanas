<x-app-layout>
    @section('title', 'Nueva Venta')

    <div class="px-6 py-4" x-data="posSystem()">
        <div class="flex flex-col md:flex-row gap-6">
            
            <div class="md:w-2/3">
                <div class="mb-4">
                    <input type="text" x-model="search" placeholder="Buscar artesanía por nombre o código..." 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-300 dark:bg-gray-700 dark:text-gray-200 focus:ring-purple-500 shadow-sm">
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 overflow-y-auto h-[calc(100vh-250px)] pr-2">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addToCart(product)" 
                            class="bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-transparent hover:border-purple-500 cursor-pointer transition-all">
                            <img :src="product.img_url ? '/storage/' + product.img_url : '/img/no-image.png'" 
                                class="w-full h-32 object-cover rounded-lg mb-2">
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-200" x-text="product.nombre"></p>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-purple-600 font-bold" x-text="'$' + product.precio_venta"></span>
                                <span class="text-[10px] px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-gray-500" x-text="'Stock: ' + product.stock"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="md:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-gray-700 flex flex-col h-[calc(100vh-180px)]">
                    <h3 class="text-lg font-black text-gray-800 dark:text-gray-100 mb-4 border-b pb-2">RESUMEN DE VENTA</h3>
                    
                    <div class="flex-grow overflow-y-auto space-y-4 mb-4">
                        <template x-for="(item, index) in cart" :key="index">
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg">
                                <div class="flex-grow">
                                    <p class="text-xs font-bold dark:text-gray-200" x-text="item.nombre"></p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <button @click="decreaseQty(index)" class="w-6 h-6 bg-white rounded shadow text-xs">-</button>
                                        <span class="text-xs font-mono" x-text="item.cantidad"></span>
                                        <button @click="increaseQty(index)" class="w-6 h-6 bg-white rounded shadow text-xs">+</button>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-purple-600" x-text="'$' + (item.precio_venta * item.cantidad).toFixed(2)"></p>
                                    <button @click="removeFromCart(index)" class="text-[10px] text-red-500 underline">Quitar</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal Productos:</span>
                            <span class="font-bold dark:text-gray-200" x-text="'$' + subtotal.toFixed(2)"></span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm text-gray-500">Envío/Transporte:</span>
                            <input type="number" x-model.number="monto_transporte" class="w-24 text-right border-gray-300 rounded-lg text-sm">
                        </div>
                        <div class="flex justify-between text-xl font-black text-purple-600 border-t pt-2">
                            <span>TOTAL:</span>
                            <span x-text="'$' + totalFinal.toFixed(2)"></span>
                        </div>

                        <form action="{{ route('ventas.store') }}" method="POST">
                            @csrf
                            <template x-for="(item, index) in cart" :key="index">
                                <div>
                                    <input type="hidden" :name="'productos['+index+'][id]'" :value="item.id">
                                    <input type="hidden" :name="'productos['+index+'][cantidad]'" :value="item.cantidad">
                                </div>
                            </template>
                            <input type="hidden" name="monto_transporte" :value="monto_transporte">

                            <button type="submit" :disabled="cart.length === 0"
                                class="w-full mt-4 py-4 bg-purple-600 text-white rounded-xl font-black hover:bg-purple-700 disabled:opacity-50 transition-all shadow-lg">
                                <i class="fas fa-check-circle mr-2"></i> PROCESAR VENTA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        function posSystem() {
            return {
                search: '',
                monto_transporte: 0,
                products: @json($productos), // Pasamos los productos desde el controlador
                cart: [],
                
                get filteredProducts() {
                    if (this.search === "") return this.products;
                    return this.products.filter(p => 
                        p.nombre.toLowerCase().includes(this.search.toLowerCase()) ||
                        p.codigo.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                addToCart(product) {
                    const found = this.cart.find(item => item.id === product.id);
                    if (found) {
                        if (found.cantidad < product.stock) found.cantidad++;
                    } else {
                        if (product.stock > 0) {
                            this.cart.push({ ...product, cantidad: 1 });
                        }
                    }
                },

                increaseQty(index) {
                    if (this.cart[index].cantidad < this.cart[index].stock) {
                        this.cart[index].cantidad++;
                    }
                },

                decreaseQty(index) {
                    if (this.cart[index].cantidad > 1) {
                        this.cart[index].cantidad--;
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.precio_venta * item.cantidad), 0);
                },

                get totalFinal() {
                    return this.subtotal + parseFloat(this.monto_transporte || 0);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>