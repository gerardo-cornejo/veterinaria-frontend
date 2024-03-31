<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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

    public function mi_perfil()
    {
        return view("configuracion/miperfil");
    }
}
