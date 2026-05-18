<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

// Controlador que maneja el inicio y cierre de sesión, así como
// el auto-registro de emprendedores en la aplicación.
class AuthController extends Controller
{
    // Muestra el formulario de inicio de sesión.
    // Permite preseleccionar el rol (admin o emprendedor) vía query string.
    public function showLogin(Request $request)
    {
        $rolSeleccionado = $request->query('rol', 'emprendedor');

        return view('auth.login', [
            'rolSeleccionado' => in_array($rolSeleccionado, ['admin', 'emprendedor'], true)
                ? $rolSeleccionado
                : 'emprendedor',
        ]);
    }

    // Procesa el inicio de sesión validando email, contraseña y rol seleccionado.
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'rol'      => ['required', Rule::in(['admin', 'emprendedor'])],
        ]);

        // Intenta autenticar al usuario verificando además que su rol coincida
        $autenticado = Auth::attempt([
            'email'    => $credenciales['email'],
            'password' => $credenciales['password'],
            'rol'      => $credenciales['rol'],
        ], $request->boolean('remember'));

        if (! $autenticado) {
            return back()
                ->withInput($request->only('email', 'rol'))
                ->withErrors(['email' => 'Credenciales inválidas para el rol seleccionado.']);
        }

        $request->session()->regenerate();

        // Redirige según el rol del usuario
        return $request->user()->esAdmin()
            ? redirect()->route('emprendedores.index')
            : redirect()->route('programas.index');
    }

    // Cierra la sesión del usuario actual.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('success', 'Sesión cerrada correctamente.');
    }

    // Muestra el formulario de auto-registro de emprendedor.
    public function showRegister()
    {
        return view('auth.register');
    }

    // Crea un emprendedor + su usuario asociado en una sola transacción.
    public function register(Request $request)
    {
        $datos = $request->validate([
            'nombre'              => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion'           => 'required|string|max:255',
            'telefono'            => 'required|string|max:20',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
        ]);

        // Crea emprendedor + usuario de forma atómica para evitar registros huérfanos
        $usuario = DB::transaction(function () use ($datos) {
            $emprendedor = Emprendedor::create([
                'nombre'              => $datos['nombre'],
                'actividad_economica' => $datos['actividad_economica'],
                'ubicacion'           => $datos['ubicacion'],
                'telefono'            => $datos['telefono'],
                'email'               => $datos['email'],
                'estado'              => 'activo',
            ]);

            return User::create([
                'name'           => $datos['nombre'],
                'email'          => $datos['email'],
                'password'       => Hash::make($datos['password']),
                'rol'            => 'emprendedor',
                'emprendedor_id' => $emprendedor->id,
            ]);
        });

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('programas.index')
            ->with('success', 'Registro exitoso. Bienvenido a Impulsa Local.');
    }
}
