<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notes')->insert([
            [
                'title' => 'My Recipe',
                'content' => 'This is my Recipe.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'My Task',
                'content' => 'This is my Task',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The LOML',
                'content' => 'Gak Ada AOKWAOWKOAKOAWK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
