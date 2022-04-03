<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=1000;$i++) {
            DB::table('products')->insert([
                [
                    'name' => Str::random(5),
                    'quantity' => random_int(1, 100),
                    'price' => random_int(1000, 9999),
                    'image' => 'image',
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]);
        }
    }
}
