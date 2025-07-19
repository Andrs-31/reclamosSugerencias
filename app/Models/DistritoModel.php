<?php
namespace App\Models;
use CodeIgniter\Model;

class DistritoModel extends Model
{
    protected $table = 'distrito';
    protected $primaryKey = 'codigo'; // campo completo como identificador
    protected $allowedFields = ['codigo_provincia', 'codigo_distrito', 'codigo', 'nombre_distrito'];
}
