<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\zonaSegura;
use App\Models\puntoEncuentro;

class UserController extends Controller
{
    public function index()
    {
        $zonasSeguras = ZonaSegura::all();
        return view('user.puntos.index', compact('zonasSeguras'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function edit(User $usuario)
    {
        
    }

    public function update(Request $request, User $usuario)
    {
        
    }

    public function destroy(User $usuario)
    {
        
    }

    public function show($id)
    {
        
    }

    public function userPuntos()
    {
        $puntoEncuentros=puntoEncuentro::all();
        return view('user.usuarioPuntos', compact('puntoEncuentros'));
    }

    public function userZonas() 
    {
        $puntosSeguros=ZonaSegura::all();
        return view('user.usuarioSeguros', compact('puntosSeguros'));
    }
}

