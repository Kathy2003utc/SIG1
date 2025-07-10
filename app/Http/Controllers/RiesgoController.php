<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riesgo;

class RiesgoController extends Controller
{
    /**
     * Muestra el listado de riesgos.
     */
    public function index()
    {
        $riesgos = Riesgo::all();
        return view('admin.ZonasRiesgo.index', compact('riesgos'));
    }

    /**
     * Muestra el formulario para crear un nuevo riesgo.
     */
    public function create()
    {
        return view('admin.ZonasRiesgo.nuevo');
    }

    /**
     * Almacena un nuevo riesgo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'nivel' => 'required|string',
            'latitud1' => 'required|numeric',
            'longitud1' => 'required|numeric',
            'latitud2' => 'required|numeric',
            'longitud2' => 'required|numeric',
            'latitud3' => 'required|numeric',
            'longitud3' => 'required|numeric',
            'latitud4' => 'required|numeric',
            'longitud4' => 'required|numeric',
        ]);

        Riesgo::create($request->all());

        return redirect()->route('riesgos.index')->with('message', 'Zona creada exitosamente');
    }

    /**
     * Muestra el formulario para editar un riesgo existente.
     */
    public function edit($id)
    {
        $riesgo = Riesgo::findOrFail($id);
        return view('admin.ZonasRiesgo.editar', compact('riesgo'));
    }

    /**
     * Actualiza un riesgo existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'nivel' => 'required|string',
            'latitud1' => 'required|numeric',
            'longitud1' => 'required|numeric',
            'latitud2' => 'required|numeric',
            'longitud2' => 'required|numeric',
            'latitud3' => 'required|numeric',
            'longitud3' => 'required|numeric',
            'latitud4' => 'required|numeric',
            'longitud4' => 'required|numeric',
        ]);

        $riesgo = Riesgo::findOrFail($id);
        $riesgo->update($request->all());

        return redirect()->route('riesgos.index')->with('success', 'Zona actualizada correctamente');
    }

    /**
     * Elimina un riesgo de la base de datos.
     */
    public function destroy($id)
    {
        $riesgo = Riesgo::findOrFail($id);
        $riesgo->delete();

        return redirect()->route('riesgos.index')->with('success', 'Zona eliminada correctamente');
    }
}
