<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedidos;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedidos::all();
        return response()->json($pedidos);
    }

    public function create(Request $request)
    {
        try {
            $pedido = new Pedidos();
            $pedido->id_cliente = $request->id_cliente;
            $pedido->data_entrega = $request->data_entrega;
            $pedido->valor_pedido = $request->valor_pedido;
            $pedido->valor_frete = $request->valor_frete;
            $pedido->save();

            return response()->json($pedido);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
}
