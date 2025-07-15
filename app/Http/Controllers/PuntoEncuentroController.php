<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\puntoEncuentro;

class PuntoEncuentroController extends Controller
{
    public function index()
    {
        $puntos = PuntoEncuentro::all();
        return view('admin.puntos.index', compact('puntos'));
    }

    public function create()
    {
        return view('admin.puntos.create');
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

    public function edit($id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        return view('admin.puntos.edit', compact('punto'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        $punto->delete();

        return redirect()->route('puntos.index')->with('success', 'Punto de encuentro eliminado correctamente.');
    }


    public function show($id)
    {
        
    }

}
