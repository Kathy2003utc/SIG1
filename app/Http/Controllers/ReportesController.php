<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;
use App\Models\zonaSegura;
use App\Models\Riesgo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    private function generarStaticMapUrl($zonas)
    {
        $apiKey = config('services.google_maps.key');
        $path = '';

        foreach ($zonas as $zona) {
            // Suponiendo que tienes coordenadas para polígono
            $coords = [
                [$zona->latitud1, $zona->longitud1],
                [$zona->latitud2, $zona->longitud2],
                [$zona->latitud3, $zona->longitud3],
                [$zona->latitud4, $zona->longitud4],
            ];

            $path .= 'enc:' . $this->encodePolyline($coords) . '|';
        }

        $path = rtrim($path, '|');

        return "https://maps.googleapis.com/maps/api/staticmap?size=600x400&path=$path&key=$apiKey";
    }

    public function generarImagenMapa()
    {
        $base   = 'https://maps.googleapis.com/maps/api/staticmap';
        $size   = '800x600';
        $apiKey = config('services.google_maps.key');      // o tu clave fija
        $zonas  = Riesgo::all();

        $paths = [];

        foreach ($zonas as $z) {
            // cierra polígono repitiendo 1.ª coordenada
            $coords = [
                "{$z->latitud1},{$z->longitud1}",
                "{$z->latitud2},{$z->longitud2}",
                "{$z->latitud3},{$z->longitud3}",
                "{$z->latitud4},{$z->longitud4}",
                "{$z->latitud1},{$z->longitud1}",
            ];
            $paths[] = 'color:red|weight:2|' . implode('|', $coords);
        }

        return $base . '?size=' . $size .
               '&' . implode('&', array_map(fn ($p) => 'path=' . urlencode($p), $paths)) .
               '&key=' . $apiKey;
    }

    public function generarPDF()
    {
        $zonas     = Riesgo::all();
        $mapa_url  = $this->generarImagenMapa();                    // imagen estática
        $qrCodeB64 = base64_encode(
            \QrCode::format('png')->size(150)->generate(route('admin.mapa.zonas.publico'))
        );

        $pdf = \PDF::loadView(
            'admin.ZonasRiesgo.zonas_pdf',                 // Blade completo
            compact('zonas', 'mapa_url', 'qrCodeB64')
        );

        return $pdf->stream('reporte_zonas.pdf');
    }
}
