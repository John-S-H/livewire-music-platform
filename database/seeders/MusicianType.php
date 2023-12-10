<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MusicianType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Bassist', 'Blokfluitist', 'Cellist', 'Componist', 'Rapper',
            'Drummer', 'Fluitist', 'Gitarist', 'Harpist', 'Hoboïst',
            'Hoornist', 'Klavecinist', 'Klarinettist', 'Organist',
            'Percussionist', 'Pianist', 'Saxofonist', 'Toetsenist',
            'Trombonist', 'Trompettist', 'Tubaïst', 'Violist', 'Zanger',
        ];

        foreach ($types as $type) {
            DB::table('musician_types')->insert(['name' => $type]);
        }
    }
}
