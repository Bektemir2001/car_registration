none =
current_date = $(shell date +%Y%m%d_%H%M%S)
envPath=./.env
tname =
exec_in_app_container=docker compose exec app

up:
	docker compose up -d

check-db:
	$(exec_in_app_container) sh -c 'psql -U admin -d car_registration -c "SELECT 1" > /dev/null 2>&1' || exit 1

app: up
	$(exec_in_app_container) composer install
	# Проверка существования базы данных и выполнение миграций, если она не существует
	$(exec_in_app_container) sh -c 'psql -U admin -d car_registration -c "SELECT 1" > /dev/null 2>&1' || \
		($(exec_in_app_container) php bin/console doctrine:database:create --if-not-exists && \
		$(exec_in_app_container) php bin/console doctrine:migrations:migrate -n)
	$(exec_in_app_container) php bin/console cache:clear


