<footer class="bg-gray-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-4 gap-8">

        <div>
            <h3 class="text-white font-black mb-3">Raíces Artesanas</h3>
            <p class="text-sm">
                Conectamos artesanos con el mundo.
            </p>
        </div>

        <div>
            <h4 class="font-bold text-white mb-3">Enlaces</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors duration-200">Inicio</a></li>
                <li><a href="" class="hover:text-white transition-colors duration-200">Productos</a></li>
                <li><a href="" class="hover:text-white transition-colors duration-200">Contacto</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-white mb-3">Legal</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="" class="hover:text-white transition-colors duration-200">Privacidad</a></li>
                <li><a href="" class="hover:text-white transition-colors duration-200">Términos</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-white mb-3">Síguenos</h4>
            <div class="flex gap-4">
                <a href="https://facebook.com/raicesartesanas" target="_blank" rel="noopener noreferrer"
                   aria-label="Facebook" class="hover:text-white transition-colors duration-200">
                    <i class="fab fa-facebook text-2xl"></i>
                </a>
                <a href="https://instagram.com/raicesartesanas" target="_blank" rel="noopener noreferrer"
                   aria-label="Instagram" class="hover:text-white transition-colors duration-200">
                    <i class="fab fa-instagram text-2xl"></i>
                </a>
                <a href="https://wa.me/521XXXXXXXXXX" target="_blank" rel="noopener noreferrer"
                   aria-label="WhatsApp" class="hover:text-white transition-colors duration-200">
                    <i class="fab fa-whatsapp text-2xl"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="text-center text-xs py-4 border-t border-gray-700">
        © {{ date('Y') }} Raíces Artesanas
    </div>
</footer>