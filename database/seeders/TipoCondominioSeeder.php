<?php

namespace Database\Seeders;

use App\Models\TipoCondominio;
use Illuminate\Database\Seeder;

class TipoCondominioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Edificio residencial',
            'Torre de apartamentos',
            'Casa o townhouse',
            'Complejo de casas',
            'Condominio horizontal',
            'Condominio vertical',
            'Mixto (residencial y comercial)',
        ];

        foreach ($tipos as $nombre) {
            TipoCondominio::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
