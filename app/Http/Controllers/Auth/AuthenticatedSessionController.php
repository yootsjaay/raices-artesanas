<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\CarritoItem; 
class AuthenticatedSessionController extends Controller
{
    /**
     * Lógica de redirección personalizada por Rol.
     */
 protected function authenticated(Request $request, $user)
{
    $sessionId = session()->getId();

    // Buscamos items anónimos con la sesión actual
    $itemsAnonimos = CarritoItem::where('session_id', $sessionId)
                        ->whereNull('user_id')
                        ->get();

    foreach ($itemsAnonimos as $item) {
        // Verificamos si el usuario ya tenía ese mismo producto en su carrito guardado
        $itemExistente = CarritoItem::where('user_id', $user->id)
                            ->where('producto_id', $item->producto_id)
                            ->first();

        if ($itemExistente) {
            $itemExistente->increment('cantidad', $item->cantidad);
            $item->delete();
        } else {
            $item->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        }
    }

    // Redirecciones por rol que ya teníamos...
    if ($user->hasRole('administrador') || $user->hasRole('artesano')) {
        return redirect()->intended(route('dashboard'));
    }
    return redirect()->intended(route('tienda.index'));
}

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // IMPORTANTE: Llamamos a authenticated() manualmente o dejamos que el trait lo haga.
        // En Breeze, simplemente movemos el redirect aquí o llamamos a la función:
        return $this->authenticated($request, Auth::user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}