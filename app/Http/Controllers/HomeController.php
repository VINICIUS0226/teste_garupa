<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class HomeController
 *
 * Este controlador é responsável pela lógica de exibição da página inicial (dashboard) do sistema.
 * Ele usa o middleware `auth` para garantir que apenas usuários autenticados possam acessar as páginas protegidas.
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Cria uma nova instância do controlador.
     *
     * Aplica o middleware 'auth', garantindo que o usuário esteja autenticado antes de acessar qualquer método do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Exibe o dashboard da aplicação.
     *
     * Este método retorna a view 'home' que serve como página principal após o login do usuário.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
