<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Locations;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Locations::factory()
                ->count(10)
                ->create();
    }
}
