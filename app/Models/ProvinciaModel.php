<?php
namespace App\Models;
use CodeIgniter\Model;

class ProvinciaModel extends Model
{
    protected $table = 'provincia';
    protected $primaryKey = 'codigo_provincia';
    protected $allowedFields = ['codigo_provincia', 'nombre_provincia'];
}
