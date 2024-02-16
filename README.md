### Books API
This is a simple application the shows api functionality as a library resource example.
It has api endpoints built with apiResource: GET, POST, PUT/PATCH, DELETE. 
Check swagger for more information.

### Steps for Improving
It does not have search functionality. Will be added in the future.

## To run the local dev environment:
- Navigate to `project` folder
- Run `make install`
  - It will install composer dependencies, run migration, seeders, run tests
- Visit swagger to check api methods: `http://localhost/swagger`

- Main files are:
  - `app/Http/Controllers/BookController.php`
  - `app/Repositories/EloquentBookRepository.php`
  - `tests/Unit/BookControllerTest.php`
