<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('user.puntos.index', compact('usuarios'));
    }

    public function create()
    {
        return view('user.puntos.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'responsable' => 'required|string|max:255',
        ]);

        PuntoEncuentro::create($request->all());

        return redirect()->route('puntos.index')->with('success', 'Punto de encuentro creado correctamente.');
    }

    public function edit(User $usuario)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        return view('user.puntos.editar', compact('punto'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'responsable' => 'required|string|max:255',
        ]);

        $punto = PuntoEncuentro::findOrFail($id);
        $punto->update($request->all());

        return redirect()->route('puntos.index')->with('success', 'Punto de encuentro actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        $punto->delete();

        return redirect()->route('puntos.index')->with('success', 'Punto de encuentro eliminado correctamente.');
    }

    public function show($id)
    {
        
    }
}

