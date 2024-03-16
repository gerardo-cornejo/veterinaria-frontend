<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UsuarioController extends BaseController
{
    public function login()
    {
        return view("login", ["redirect" => site_url("/")]);
    }

    public function listar()
    {
        return view("usuario/listar");
    }
}
