build:
	@docker-compose build
 
up:
	@docker-compose up -d

stop:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml stop

setup-dev:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec rs_filegator npm install && composer install --ignore-platform-reqs

dev:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up -d

phpunit:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec rs_filegator vendor/bin/phpunit

logs:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml logs

bash:
	@docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec rs_filegator bash