<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Groningen', 'Friesland', 'Drenthe', 'Overijssel', 'Gelderland',
            'Flevoland', 'Utrecht', 'Noord-Holland', 'Zuid-Holland',
            'Zeeland', 'Noord-Brabant', 'Limburg'
        ];

        foreach ($types as $type) {
            DB::table('provinces')->insert(['title' => $type]);
        }
    }
}
