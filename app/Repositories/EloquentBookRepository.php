<?php
/**
 * Created by PhpStorm.
 * User: Denis Kostaev
 * Date: 15/02/2024
 * Time: 10:20
 */

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentBookRepository implements BookRepositoryInterface
{
    /**
     * Get all books.
     *
     * @return Collection|static[]
     */
    public function all(): Collection|static
    {
        return Book::all();
    }

    /**
     * Create a new book.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return Book::create($data);
    }

    /**
     * Update the specified book.
     *
     * @param $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data): Model
    {
        $book = $this->find($id);
        $book->update($data);

        return $book;
    }

    /**
     * Find a book by ID.
     *
     * @param $id
     * @return Model
     */
    public function find($id): Model
    {
        return Book::findOrFail($id);
    }

    /**
     * Delete the specified book.
     *
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $book = $this->find($id);
        $book->delete();
    }
}
