<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            ['title' => 'видения'],
            ['title' => 'новелла'],
            ['title' => 'ода'],
            ['title' => 'эпические'],
            ['title' => 'басня'],
            ['title' => 'былина'],
            ['title' => 'баллада'],
            ['title' => 'миф'],
            ['title' => 'фарс'],
            ['title' => 'драма'],
            ['title' => 'ужасы'],
            ['title' => 'трагедия'],
            ['title' => 'комедия'],
            ['title' => 'поэма'],
            ['title' => 'сказка'],
            ['title' => 'рассказ'],
            ['title' => 'повесть'],
        ]);
    }
}
