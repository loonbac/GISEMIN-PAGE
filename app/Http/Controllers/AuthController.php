<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Procesar el login
     */
    public function authenticate(Request $request)
    {
        // Validar datos del formulario
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario por email
        $user = User::where('email', $credentials['email'])->first();

        // Verificar si existe y la contraseña es correcta
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Autenticación exitosa
            session([
                'authenticated' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);

            return redirect()->route('admin.certificados.agregar');
        }

        // Autenticación fallida
        return back()
            ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
            ->withInput($request->only('email'));
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        // Eliminar datos de sesión
        $request->session()->forget(['authenticated', 'user_id', 'user_name', 'user_email']);
        $request->session()->flush();

        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
