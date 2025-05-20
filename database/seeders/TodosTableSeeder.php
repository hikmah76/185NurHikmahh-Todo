<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TodosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('todos')->insert([
            'user_id' => 5,
            'title' => 'Non Voluptas Voluptate Et.',
            'is_done' => 1,
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
