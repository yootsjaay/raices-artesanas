<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-3xl font-black mb-8 text-gray-900 dark:text-white">
            Piezas destacadas
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($productos->take(3) as $item)
                <div class="relative rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/'.$item->img_url) }}" class="w-full h-80 object-cover">

                    <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                        <div>
                            <h3 class="text-white font-bold text-xl">{{ $item->nombre }}</h3>
                            <p class="text-purple-300 font-bold">${{ $item->precio_venta }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>