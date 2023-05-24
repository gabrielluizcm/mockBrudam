<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedidos extends Model
{
    use HasFactory;

    public static function getLista()
    {
        $query = "SELECT p.id,
            c.nome as cliente,
            DATE_FORMAT(p.data_entrega, '%d/%m/%Y') as data_entrega,
            p.valor_pedido,
            p.valor_frete,
            DATE_FORMAT(p.created_at, '%d/%m/%Y') as data_criacao,
            DATE_FORMAT(p.updated_at, '%d/%m/%Y') as data_atualizacao
            FROM pedidos p
            JOIN clientes c ON c.id = p.id_cliente
            ORDER BY p.id asc
        ";
        return DB::select(DB::raw($query));
    }
}
