.PHONY: docker-build docker-up composer-install migrate seed install down

# Build
docker-build:
	cp .env.example .env

# Start Docker Compose
docker-up:
	docker-compose up -d

# Install Composer dependencies
composer-install:
	docker-compose exec app composer install

# Run migrations
migrate:
	docker-compose exec app php artisan migrate

# Run seeders
seed:
	docker-compose exec app php artisan db:seed

# Run tests
test:
	docker-compose exec app php artisan test

#run frontend
frontend:
	npm run dev

# Stop
down:
	docker-compose down

# Install dependencies, run Docker Compose, migrations, and seeders
install: docker-build docker-up composer-install migrate seed test frontend
