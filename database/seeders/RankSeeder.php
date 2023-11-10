<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ranks')->insert([
            [
                'title' => 'Новичок',
                'points' => 0
            ],

            [
                'title' => 'Знаток',
                'points' => 100
            ],

            [
                'title' => 'Профи',
                'points' => 500
            ],

            [
                'title' => 'Мудрец',
                'points' => 1000
            ],

            [
                'title' => 'Оракул',
                'points' => 2500
            ],

            [
                'title' => 'Вассерман',
                'points' => 5000
            ],
        ]);
    }
}
