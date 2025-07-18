<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use PDF; 

class PuntoEncuentroController extends Controller
{
    public function index()
    {
        $puntos = \App\Models\puntoEncuentro::all();
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

        \App\Models\puntoEncuentro::create($request->all());

        return redirect()->route('admin.puntos.index')->with('success', 'Punto de encuentro creado correctamente.');
    }

    public function edit($id)
    {
        $punto = \App\Models\puntoEncuentro::findOrFail($id);
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

        $punto = \App\Models\puntoEncuentro::findOrFail($id);
        $punto->update($request->all());

        return redirect()->route('admin.puntos.index')->with('success', 'Punto de encuentro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $punto = \App\Models\puntoEncuentro::findOrFail($id);
        $punto->delete();

        return redirect()->route('admin.puntos.index')->with('success', 'Punto de encuentro eliminado correctamente.');
    }

    public function show($id)
    {
        // Si necesitas, aquí implementa la lógica para mostrar un punto específico
    }

    public function reporte()
    {
        $puntos = \App\Models\puntoEncuentro::all();

        $url = URL::route('admin.puntos.index');

        $qrCodeB64 = base64_encode(QrCode::format('png')->size(150)->generate($url));

        $mapa_url = "https://maps.googleapis.com/maps/api/staticmap?center=-0.9374805,-78.6161327&zoom=13&size=800x400&maptype=roadmap";

        foreach ($puntos as $punto) {
            $mapa_url .= "&markers=color:green%7Clabel:P%7C{$punto->latitud},{$punto->longitud}";
        }

        $mapa_url .= "&key=" . env('GOOGLE_MAPS_API_KEY');

        return view('admin.puntos.reporte', compact('puntos', 'qrCodeB64', 'mapa_url'));
    }

    public function mapa()
    {
        $puntos = \App\Models\puntoEncuentro::all();
        return view('admin.puntos.mapa', compact('puntos'));
    }

   

    public function reportePdf()
    {
        $puntos = \App\Models\puntoEncuentro::all();


        $data = ['puntos' => $puntos];

        $pdf = PDF::loadView('admin.puntos.reporte-pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download('reporte_puntos_encuentro.pdf');
    }

}
