<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function auth(Request $request) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Autenticação bem-sucedida, redirecione para a página de destino
            return redirect()->route('home');
        } else {

            return redirect()->back()->with('error', 'Nome de usuário ou senha inválidos.')->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
