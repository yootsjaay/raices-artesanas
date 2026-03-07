<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Importamos los controladores por sus nuevos Namespaces
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\Client as Client;

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    return view('welcome');
});

// --- RUTA DEL CATÁLOGO (Para el Cliente - Pública o Logueada) ---
Route::get('/catalogo', [Client\CatalogoController::class, 'index'])->name('catalogo.index');

// --- RUTAS PROTEGIDAS (Requieren Auth) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- GRUPO ADMINISTRADOR ---
    // URL: /admin/...  | Nombre: admin.categorias.index
    Route::middleware(['role:Admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('categorias', Admin\CategoriaController::class);
            Route::resource('presentaciones', Admin\PresentacionesController::class);
            Route::resource('marcas', Admin\MarcaController::class);
        });

    // --- GRUPO ARTESANO ---
    // URL: /artesano/... | Nombre: artesano.productos.index
    Route::middleware(['role:Artesano|Admin'])
        ->prefix('artesano')
        ->name('artesano.')
        ->group(function () {
            Route::resource('productos', Admin\ProductoController::class);
            Route::resource('ventas', Admin\VentaController::class);
            Route::resource('presentaciones', Admin\PresentacionesController::class);

        });

    // --- PERFIL ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';