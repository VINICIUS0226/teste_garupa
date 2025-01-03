<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * Esta classe serve como controlador base para todos os controladores do sistema.
 * Ela herda de `BaseController` e inclui os traços de autorização e validação fornecidos pelo Laravel.
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
