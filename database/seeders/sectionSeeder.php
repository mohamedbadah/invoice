<?php

namespace Database\Seeders;

use App\Models\section;
use Illuminate\Database\Seeder;

class sectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        section::factory(30)->create();
    }
}
