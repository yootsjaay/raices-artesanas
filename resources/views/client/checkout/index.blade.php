<x-tienda-layout>
    <x-slot name="title">Finalizar Compra - Raíces Artesanas</x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900" x-data="{ step: 1 }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Barra de Progreso --}}
            <div class="mb-12">
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 w-full h-0.5 bg-gray-200 dark:bg-gray-700 -z-10"></div>
                    
                    {{-- Paso 1 --}}
                    <div class="flex flex-col items-center">
                        <div :class="step >= 1 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" 
                             class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors">1</div>
                        <span class="text-xs mt-2 font-bold dark:text-gray-400">Envío</span>
                    </div>

                    {{-- Paso 2 --}}
                    <div class="flex flex-col items-center">
                        <div :class="step >= 2 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" 
                             class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors">2</div>
                        <span class="text-xs mt-2 font-bold dark:text-gray-400">Paquetería</span>
                    </div>

                    {{-- Paso 3 --}}
                    <div class="flex flex-col items-center">
                        <div :class="step >= 3 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" 
                             class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors">3</div>
                        <span class="text-xs mt-2 font-bold dark:text-gray-400">Pago</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- PASO 1: DATOS DE ENVÍO --}}
                <div x-show="step === 1" x-transition>
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tighter">Datos de Entrega</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-full">
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2 ml-1">Nombre Completo de quien recibe</label>
                                <input type="text" name="nombre" required class="w-full rounded-2xl border-gray-100 dark:bg-gray-900 dark:text-white focus:ring-purple-500 py-4">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2 ml-1">Teléfono de contacto</label>
                                <input type="tel" name="telefono" required class="w-full rounded-2xl border-gray-100 dark:bg-gray-900 dark:text-white py-4">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2 ml-1">Municipio (Oaxaca)</label>
                                <select name="municipio" class="w-full rounded-2xl border-gray-100 dark:bg-gray-900 dark:text-white py-4">
                                    <option>Santa María Tlahuitoltepec</option>
                                    <option>Oaxaca de Juárez</option>
                                    {{-- Aquí podrías iterar tus municipios --}}
                                </select>
                            </div>

                            <div class="col-span-full">
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2 ml-1">Dirección Exacta y Referencias</label>
                                <textarea name="direccion" rows="3" placeholder="Ej: Calle Independencia #10, frente a la escuela primaria..." 
                                          class="w-full rounded-2xl border-gray-100 dark:bg-gray-900 dark:text-white py-4"></textarea>
                            </div>
                        </div>

                        <button type="button" @click="step = 2" 
                                class="mt-8 w-full py-4 bg-purple-600 text-white rounded-2xl font-bold hover:bg-purple-700 transition shadow-xl">
                            Continuar a Paquetería
                        </button>
                    </div>
                </div>

                {{-- PASO 2: SELECCIÓN DE PAQUETERÍA --}}
                <div x-show="step === 2" x-transition style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tighter">Selecciona el envío</h3>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border-2 border-gray-100 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-purple-600 transition">
                                <input type="radio" name="paqueteria" value="correos" class="text-purple-600 focus:ring-purple-500">
                                <div class="ml-4">
                                    <span class="block font-bold dark:text-white">Correos de México (Económico)</span>
                                    <span class="text-xs text-gray-500">7-10 días hábiles - $90.00</span>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-100 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-purple-600 transition">
                                <input type="radio" name="paqueteria" value="dhl" class="text-purple-600 focus:ring-purple-500">
                                <div class="ml-4">
                                    <span class="block font-bold dark:text-white">DHL / Estafeta (Express)</span>
                                    <span class="text-xs text-gray-500">1-3 días hábiles - $250.00</span>
                                </div>
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <button type="button" @click="step = 1" class="py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 rounded-2xl font-bold">Atrás</button>
                            <button type="button" @click="step = 3" class="py-4 bg-purple-600 text-white rounded-2xl font-bold hover:bg-purple-700 shadow-xl transition">Método de Pago</button>
                        </div>
                    </div>
                </div>

                {{-- PASO 3: MÉTODO DE PAGO --}}
                <div x-show="step === 3" x-transition style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tighter">Finalizar Pago</h3>
                        
                        <div class="mb-6 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-2xl border border-purple-100 dark:border-purple-800">
                            <div class="flex justify-between font-bold">
                                <span class="text-gray-600 dark:text-gray-400">Total a pagar:</span>
                                <span class="text-purple-600">$1,450.00 MXN</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button type="submit" class="w-full py-4 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-2xl font-bold flex items-center justify-center gap-3">
                                <i class="fas fa-university"></i> Transferencia o Depósito OXXO
                            </button>
                            <button type="button" class="w-full py-4 bg-purple-600 text-white rounded-2xl font-bold opacity-50 cursor-not-allowed">
                                <i class="fab fa-stripe"></i> Pago con Tarjeta (Próximamente)
                            </button>
                        </div>

                        <button type="button" @click="step = 2" class="mt-4 w-full text-sm font-bold text-gray-400">Regresar a paquetería</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-tienda-layout>