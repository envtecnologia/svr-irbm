<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){

        $usuario = Auth::user();

        return view('authenticated.meus-dados', [
            'user' => $usuario
        ]);
    }

    public function update(Request $request){

        $user_id = Auth::user()->id;
        $usuario = User::find($user_id);

        $usuario->email = $request->email;
        $usuario->phone = $request->phone;

        $usuario->save();

        return redirect('/meus-dados')->with('success', 'Dados atualizados com sucesso!');
    }

}
