<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ThemeController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'theme' => 'required|in:light,dark,system',
        ]);

        // Guardar la preferencia en la base de datos si el usuario está autenticado
        if (Auth::check()) {
            User::find(Auth::id())->update([
                'theme_preference' => $request->theme,
            ]);
        }
        return redirect()->back()
            ->with('theme_updated', 'Preferencia de tema actualizada correctamente.')
            ->cookie(
                'theme_preference',
                $request->theme,
                60 * 24 * 365
            );
    }
}
