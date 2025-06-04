<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceType::insert([
            ['id' => 1, 'name' => 'Regular Service', 'description' => 'Layanan reguler dengan lama waktu pengerjaan 3 hari', 'cost' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Express Service', 'description' => 'Layanan express dengan waktu pengerjaan 2 hari', 'cost' => 10000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Kilat Service', 'description' => 'Layanan Kilat dengan waktu pengerjaan 1 hari', 'cost' => 20000, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
