<?php
namespace App\Controllers;
use App\Models\ProvinciaModel;
use App\Models\DistritoModel;
use App\Models\CorregimientoModel;

class UbicacionController extends BaseController
{
    public function index()
    {
        $provinciaModel = new ProvinciaModel();
        $provincias = $provinciaModel->findAll();

        return view('ubicacion_form', ['provincias' => $provincias]);
    }

    public function getDistritos($codigo_provincia)
{
    // Mantenemos el formato original con ceros a la izquierda
    $distritoModel = new DistritoModel();
    
    // Asegúrate que el nombre del campo coincida con tu base de datos
    $distritos = $distritoModel->where('codigo_provincia', $codigo_provincia)
                              ->orderBy('nombre_distrito', 'ASC')
                              ->findAll();

    return $this->response->setJSON($distritos);
}

    public function getCorregimientos($codigo_provincia, $codigo_distrito)
    {
        $corregimientoModel = new CorregimientoModel();
        $corregimientos = $corregimientoModel
            ->where('codigo_provincia', $codigo_provincia)
            ->where('codigo_distrito', $codigo_distrito)
            ->findAll();

        return $this->response->setJSON($corregimientos);
    }
}
