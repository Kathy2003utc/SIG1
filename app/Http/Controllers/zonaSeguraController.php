<?php

namespace App\Http\Controllers;

use App\Models\zonaSegura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class zonaSeguraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonasSeguras = zonaSegura::orderBy('nombre')->get();
        return view('admin.ZonasSeguras.index', compact('zonasSeguras'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zona = zonaSegura::findOrFail($id);
        return view('admin.ZonasSeguras.editar', compact('zona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validar($request);

        $zona = zonaSegura::findOrFail($id);

        $zona->update($request->only([
            'nombre',
            'tipo_seguridad',
            'radio',
            'latitud',
            'longitud'
        ]));

        return redirect()
            ->route('ZonasSeguras.index')
            ->with('success', 'Zona segura actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zona = zonaSegura::findOrFail($id);
        $zona->delete();

        return redirect()
            ->route('ZonasSeguras.index')
            ->with('success', 'Zona segura eliminada.');
    }

    /**
     * Validación de los datos.
     */
    private function validar(Request $request): void
    {
        Validator::make(
            $request->all(),
            [
                'nombre'         => 'required|string|max:255',
                'tipo_seguridad' => 'required|in:Pública,Privada,Refugio,Zona de evacuación,Centro de salud',
                'radio'          => 'required|numeric|min:1',
                'latitud'        => 'required|numeric|between:-90,90',
                'longitud'       => 'required|numeric|between:-180,180',
            ],
            [
                'nombre.required'         => 'El nombre es obligatorio.',
                'tipo_seguridad.required' => 'Debe seleccionar un tipo de seguridad.',
                'radio.min'               => 'El radio debe ser mayor que 0.',
                'latitud.between'         => 'La latitud debe estar entre -90 y 90.',
                'longitud.between'        => 'La longitud debe estar entre -180 y 180.',
            ]
        )->validate();
    }
}
