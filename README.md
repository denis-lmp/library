## To run the local dev environment:

### Books API
- Navigate to `project` folder
- Run `make install`
  - It will install composer dependencies, run migration, seeders, run tests
- Visit swagger to check api methods: `http://localhost/swagger`

- Main files are:
  - `app/Http/Controllers/BookController.php`
  - `app/Repositories/EloquentBookRepository.php`
  - `tests/Unit/BookControllerTest.php`
