<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            RankSeeder::class,
            GenreSeeder::class
        ]);

        User::factory(10)->create();
        Author::factory(21)->create();
        Book::factory(30)->create();
        AuthorBook::factory(30)->create();
        BookGenre::factory(45)->create();
        Review::factory(5)->create();
    }
}
