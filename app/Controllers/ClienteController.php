<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteController extends BaseController
{
    public function clientes()
    {
        return view("clientes");
    }
}
