<?php

namespace Database\Seeders;

use App\Models\Tipemobil;
use Illuminate\Database\Seeder;

class TipemobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipemobil::updateOrCreate(
            ['name' => 'UMUM'],
            ['photo' => null]
        );
    }
}
