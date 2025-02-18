# Variáveis
LARAVEL_CONTAINER=backend

# Construir as imagens do Docker e rodar composer install e key:generate
build:
	docker compose up -d --build
	docker compose exec $(LARAVEL_CONTAINER) cp .env.example .env
	docker compose exec $(LARAVEL_CONTAINER) composer install
	docker compose exec $(LARAVEL_CONTAINER) php artisan key:generate
	docker compose exec $(LARAVEL_CONTAINER) php artisan optimize:clear

migrate:
	docker compose exec $(LARAVEL_CONTAINER) php artisan migrate --seed

up:
	docker compose up -d

make stop:
	docker compose down