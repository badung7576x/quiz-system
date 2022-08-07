build:
	docker-compose build

run:
	make build
	docker-compose up -d --force-recreate

reload:
	docker-compose restart

init:
	docker-compose exec -T php sh -c "php composer.phar install"
	docker-compose exec -T php sh -c "php artisan key:generate"
	docker-compose exec -T php sh -c "php artisan migrate"
	docker-compose exec -T php sh -c "php artisan db:seed"
	docker-compose exec -T php sh -c "php artisan scout:import 'App\Models\QuestionBank'"
	
install:
	docker-compose exec -T php sh -c "php composer.phar install"

migrate:
	docker-compose exec -T php sh -c "php artisan migrate --force"

clean:
	docker-compose exec -T php sh -c "php artisan optimize:clear"

destroy:
	docker-compose down

docker-view:
	docker-compose ps -a

index:
	docker-compose exec -T php sh -c "php artisan scout:import 'App\Models\QuestionBank'"
