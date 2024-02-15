<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class BookController extends Controller
{

    /**
     * @var BookRepositoryInterface
     */
    protected BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get a list of all books.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $books = $this->bookRepository->all();

        return response()->json($books);
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  CreateBookRequest  $request
     * @return mixed
     */
    public function store(CreateBookRequest $request): mixed
    {
        return $this->bookRepository->create($request->validated());
    }

    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = $this->handleBookRequest($id);

        return response()->json($book);
    }

    /**
     * Handle book request.
     *
     * @param  int  $id
     * @return JsonResponse|mixed
     */
    protected function handleBookRequest(int $id)
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return response()->json(404);
        }

        return $book;
    }

    /**
     * Update the specified book in database.
     *
     * @param  UpdateBookRequest  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(UpdateBookRequest $request, int $id): mixed
    {
        $this->handleBookRequest($id);

        return $this->bookRepository->update($id, $request->validated());
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->handleBookRequest($id);
        $this->bookRepository->delete($id);

        return response()->json('The book has been deleted');
    }
}
