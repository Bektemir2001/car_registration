none =
current_date = $(shell date +%Y%m%d_%H%M%S)
envPath=./.env
tname =
exec_in_app_container=docker compose exec app

up:
	docker compose up -d

app: up
	$(exec_in_app_container) composer install
	$(exec_in_app_container) php bin/console doctrine:schema:drop --force
	$(exec_in_app_container) php bin/console make:migration
	$(exec_in_app_container) php bin/console doctrine:migrations:migrate
	$(exec_in_app_container) php bin/console cache:clear


