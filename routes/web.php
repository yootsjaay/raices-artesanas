<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\Client\WelcomeController;
use App\Http\Controllers\Client\CarritoController;
use App\Http\Controllers\Client\CheckoutController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', [WelcomeController::class, 'index'])->name('tienda.index');
Route::get('/productos/{id}', [WelcomeController::class, 'show'])->name('productos.show');
Route::get('/artesano/{id}', [WelcomeController::class, 'artisanShow'])->name('artesanos.show');
Route::get('/ubicacion', fn() => view('cliente.ubicacion'))->name('tienda.ubicacion');

/*
|--------------------------------------------------------------------------
| CARRITO (sesión pública)
|--------------------------------------------------------------------------
*/
Route::prefix('carrito')->name('carrito.')->group(function () {
    Route::get('/load', [CarritoController::class, 'load'])->name('load');
    Route::post('/agregar', [CarritoController::class, 'add'])->name('add');
    Route::post('/actualizar', [CarritoController::class, 'update'])->name('update');
    Route::post('/eliminar', [CarritoController::class, 'remove'])->name('remove');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard con redirección por rol
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('administrador|artesano')) {
            return redirect()->route('administrador.productos.index');
        }
        return redirect()->route('tienda.index');
    })->name('dashboard');

    // Checkout requiere login
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'store'])->name('store');
    });

    // Perfil (todos los roles autenticados)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [Admin\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [Admin\ProfileController::class, 'update'])->name('update');
        Route::delete('/', [Admin\ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN + ARTESANO
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:administrador|artesano'])
        ->prefix('administrador')
        ->name('administrador.')
        ->group(function () {
            Route::resource('productos', Admin\ProductoController::class);
            Route::resource('categorias', Admin\CategoriaController::class);
            Route::resource('presentaciones', Admin\PresentacionesController::class);

            // Solo administrador
            Route::resource('roles', Admin\RolController::class)
                ->middleware('role:administrador');
           Route::resource('paquetes', Admin\PaqueteController::class)
            ->only(['index', 'store', 'update','show', 'destroy'])
            ->middleware('role:administrador');
        });
        

    /*
    |--------------------------------------------------------------------------
    | CLIENTE (pedidos, historial — cuando los implementes)
    |--------------------------------------------------------------------------
    */
    // Route::middleware(['role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    //     Route::resource('pedidos', Client\PedidoController::class)->only(['index', 'show']);
    // });

});

require __DIR__.'/auth.php';