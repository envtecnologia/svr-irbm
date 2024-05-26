<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function auth(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Autenticação bem-sucedida, redirecione para a página de destino
            return redirect()->route('home');
        } else {
            // Autenticação falhou, exiba uma mensagem de erro ou redirecione de volta para o formulário de login
            return redirect()->back()->with('error', 'E-mail ou senha inválidos.');
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
