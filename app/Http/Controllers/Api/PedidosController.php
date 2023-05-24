<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedidos::getLista();
        return response()->json($pedidos);
    }

    public function create(Request $request)
    {
        try {
            if ($request->valor_pedido < 0 || $request->valor_frete < 0)
                throw new \Exception('Verifique os valores: ambos devem ser maiores ou iguais a zero');

            $pedido = new Pedidos();
            $pedido->id_cliente = $request->id_cliente;
            $pedido->data_entrega = $request->data_entrega;
            $pedido->valor_pedido = $request->valor_pedido;
            $pedido->valor_frete = $request->valor_frete;
            $pedido->save();

            return response()->json($pedido, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
