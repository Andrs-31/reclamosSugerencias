<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario', 'email', 'password', 'rol_id', 'provincia_id', 'distrito_id', 'corregimiento_id', 'nombre'];

    protected bool $allowEmptyInserts = false;
    //protected bool $updateOnlyChanged = true;

    //protected array $casts = [];
    //protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // O comenta esta línea
    // protected $deletedField  = 'deleted_at';


    //FUNCION PARA VALIDAR EL USUARIO
    public function validateUser($usernameOrEmail, $password)
    {
        $user = $this->where('usuario', $usernameOrEmail)
                     ->orWhere('email', $usernameOrEmail)
                     ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
