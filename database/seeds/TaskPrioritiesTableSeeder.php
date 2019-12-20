<?php

use Illuminate\Database\Seeder;

class TaskPrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_priorities')->insert([[
            'id' => 1,
            'order' => 1,
            'name' => 'Low'
        ], [
            'id' => 2,
            'order' => 2,
            'name' => 'Normal'
        ], [
            'id' => 3,
            'order' => 3,
            'name' => 'High'
        ]]);
    }
}
