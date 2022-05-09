<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Position::insert([
            ['name' => 'Security'],
            ['name' => 'Designer'],
            ['name' => 'Content manager'],
            ['name' => 'Lawyer'],
        ]);
    }
}
