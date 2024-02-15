<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\BookController;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    protected $bookRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mocking the BookRepositoryInterface
        $this->bookRepositoryMock = Mockery::mock(BookRepositoryInterface::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Release the mocked objects to avoid memory leaks
        Mockery::close();
    }

    public function testIndex()
    {
        // Arrange
        $books = ['book1', 'book2'];
        $this->bookRepositoryMock->shouldReceive('all')->andReturn($books);
        $controller = new BookController($this->bookRepositoryMock);

        // Act
        $response = $controller->index();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($books, $responseData);
    }

    public function testStore()
    {
        // Arrange
        $requestData = ['title' => 'Test Book'];
        $this->bookRepositoryMock->shouldReceive('create')->with($requestData)->once()->andReturn(true);
        $controller = new BookController($this->bookRepositoryMock);
        $requestMock = Mockery::mock(CreateBookRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($requestData);

        // Act
        $response = $controller->store($requestMock);

        // Assert
        $this->assertTrue($response);
    }

    public function testShow()
    {
        // Arrange
        $book = 'test book';
        $this->bookRepositoryMock->shouldReceive('find')->with(1)->andReturn($book);
        $controller = new BookController($this->bookRepositoryMock);

        // Act
        $response = $controller->show(1);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($book, json_decode($response->getContent(), true));
    }

    public function testUpdate()
    {
        // Arrange
        $requestData = ['title' => 'Updated Book'];
        $this->bookRepositoryMock->shouldReceive('find')->with(1)->andReturn(true);
        $this->bookRepositoryMock->shouldReceive('update')->with(1, $requestData)->once()->andReturn(true);
        $controller = new BookController($this->bookRepositoryMock);
        $requestMock = Mockery::mock(UpdateBookRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($requestData);

        // Act
        $response = $controller->update($requestMock, 1);

        // Assert
        $this->assertTrue($response);
    }

    public function testDestroy()
    {
        // Arrange
        $this->bookRepositoryMock->shouldReceive('find')->with(1)->andReturn(true);
        $this->bookRepositoryMock->shouldReceive('delete')->with(1)->once();
        $controller = new BookController($this->bookRepositoryMock);

        // Act
        $response = $controller->destroy(1);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('"The book has been deleted"', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShowBookNotFound()
    {
        $bookId = 999; // ID of a book that does not exist
        $this->bookRepositoryMock->shouldReceive('find')->with($bookId)->andReturn(null);
        $controller = new BookController($this->bookRepositoryMock);

        $response = $controller->show($bookId);

        // here we have original 404 response but 200
        $responseData = json_decode($response->getContent(), true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $responseData['original']);
    }
}
