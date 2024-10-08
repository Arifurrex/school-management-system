<?php

namespace Database\Seeders;

use App\Models\day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        day::insert([
            ['name'=>'saturday'],
            ['name'=>'sunday'],
            ['name'=>'monday'],
            ['name'=>'tuesday'],
            ['name'=>'wednesday'],
            ['name'=>'thursday'],
            ['name'=>'friday'],
        ]);
    }
}
