build:
	docker-compose build

build-mix:
	docker-compose -f build-mix.yml build

run:
	make build
	make build-mix
	docker-compose up -d --force-recreate

reload:
	docker-compose restart

init:
	docker-compose exec -T php sh -c "php composer.phar install"
	docker-compose exec -T php sh -c "php artisan key:generate"
	docker-compose exec -T php sh -c "php artisan migrate"
	docker-compose exec -T php sh -c "php artisan db:seed"

install:
	docker-compose exec -T php sh -c "php composer.phar install"

migrate:
	docker-compose exec -T php sh -c "php artisan migrate --force"

clean:
	docker-compose exec -T php sh -c "php artisan optimize:clear"

destroy:
	docker-compose down
