<?php

namespace App\Services;

use App\Models\Author;
use App\Models\AuthorBook;
use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookDependencyService
{
    public static Request|null $request = null;
    public static Book|null $book = null;
    public static function handle(Request $request, Book $book)
    {
        self::$request = $request;
        self::$book = $book;
        self::createAuthorBook();
        self::createBookGenre();
    }

    public static function createAuthorBook(): void
    {
        $authors = self::$request->get('authors');

        if(isset($authors)) {
            $authorBookAll = AuthorBook::where('book_id', self::$book->id)->get();
            foreach ($authorBookAll as $authorBook) $authorBook->delete();
            foreach ($authors as $authorId) {
                $author = Author::where('id', $authorId)->first();
                if(!isset($author)) {
                    throw ValidationException::withMessages([
                        'authors' => 'A non-existent author ID was specified'
                    ]);
                }

                AuthorBook::create([
                    'book_id' => self::$book->id,
                    'author_id' => $authorId
                ]);
            }
        }
    }

    public static function createBookGenre(): void
    {
        $genres = self::$request->get('genres');

        if(isset($genres)) {
            $bookGenreAll = BookGenre::where('book_id', self::$book->id)->get();
            foreach ($bookGenreAll as $bookGenre) $bookGenre->delete();
            foreach ($genres as $genreId) {
                $genre = Genre::where('id', $genreId)->first();
                if(!isset($genre)) {
                    throw ValidationException::withMessages([
                        'genres' => 'A non-existent genre ID was specified'
                    ]);
                }

                BookGenre::create([
                    'book_id' => self::$book->id,
                    'genre_id' => $genreId
                ]);
            }
        }

    }
}
