<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('phones')->insert([
            'id'=>'1',
            'model'=> 'gramedia',
            'year'=> '2002',
            'book_id'=> '1',
        ]);
    }
}
