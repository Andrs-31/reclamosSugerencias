<?php
namespace App\Models;
use CodeIgniter\Model;

class CorregimientoModel extends Model
{
    protected $table = 'corregimiento';
    protected $primaryKey = 'codigo'; // campo completo como identificador
    protected $allowedFields = ['codigo_provincia', 'codigo_distrito', 'codigo', 'codigo_corregimiento', 'nombre_corregimiento'];
}
