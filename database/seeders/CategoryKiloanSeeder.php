<?php

namespace Database\Seeders;

use App\Models\CategoryKiloan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryKiloanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CategoryKiloan::insert([
        //     ['id' => 1, 'name' => 'Kiloan', 'created_at' => now(), 'updated_at' => now()]
        //     // ['id' => 2, 'name' => 'Satuan', 'created_at' => now(), 'updated_at' => now()]
        // ]);
        DB::table('categories_kiloan')->insert([
            'id' => 2,
            'name' => 'Kiloan',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
