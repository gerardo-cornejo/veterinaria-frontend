<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConfiguracionController extends BaseController
{
    public function propiedades()
    {
        return view("configuracion/propiedades");
    }
    public function usuarios()
    {
        return view("configuracion/usuarios");
    }
}
