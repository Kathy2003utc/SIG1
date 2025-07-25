<?php

namespace App\Http\Controllers;

use App\Models\zonaSegura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;

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
            ->route('admin.ZonasSeguras.index')
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
            ->route('admin.ZonasSeguras.index')
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
            'radio.required'          => 'El campo radio es obligatorio.',
            'radio.min'               => 'El radio debe ser mayor que 0.',
            'latitud.required'        => 'El campo latitud es obligatorio.',
            'latitud.between'         => 'La latitud debe estar entre -90 y 90.',
            'longitud.required'       => 'El campo longitud es obligatorio.',
            'longitud.between'        => 'La longitud debe estar entre -180 y 180.',
        ]
    )->validate();
    }


    public function create()
    {
        return view('admin.ZonasSeguras.nuevo'); // Asegúrate que esta vista exista
    }

    public function store(Request $request)
    {
        $this->validar($request);

        zonaSegura::create($request->only([
            'nombre',
            'tipo_seguridad',
            'radio',
            'latitud',
            'longitud'
        ]));

        return redirect()
            ->route('admin.ZonasSeguras.index')
            ->with('success', 'Zona segura creada correctamente.');
    }

    public function mapa()
    {
        $zonas = zonaSegura::all();
        return view('admin.ZonasSeguras.mapa', compact('zonas'));
    }
    

    public function reporte()
    {
        $zonas = zonaSegura::all();
        
        $mapa_url = URL::to('/zonas-seguras/mapa');
        $qrCodeB64 = base64_encode(QrCode::format('png')->size(150)->generate($mapa_url));

        return view('admin.ZonasSeguras.reporte', compact('zonas', 'mapa_url', 'qrCodeB64'));
    }

    public function mapaPublico()
    {
        $zonas = zonaSegura::all();
        return view('mapas_QR.mapa_seguro', compact('zonas'));
    }



}
