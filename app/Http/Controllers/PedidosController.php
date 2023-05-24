<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();
        return view('pedidos', compact('clientes'));
    }
}
