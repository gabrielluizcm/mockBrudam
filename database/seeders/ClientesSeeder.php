<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert(
            [
                [
                    'nome' => 'Guilherme Matheus Moraes',
                    'cep' => '63036310',
                    'numero' => '231',
                    'complemento' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'nome' => 'Severino Gabriel Giovanni Fogaça',
                    'cep' => '20766810',
                    'numero' => '734',
                    'complemento' => 'Casa 38',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'nome' => 'Giovana Isabel Heloise da Paz',
                    'cep' => '56326017',
                    'numero' => '852',
                    'complemento' => 'Bloco 14 AP 405',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]
        );
    }
}
