.DEFAULT_GOAL := help
COMPOSE_FILES=docker-compose.yaml

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up:
	docker-compose -f $(COMPOSE_FILES) up -d
	docker-compose -f $(COMPOSE_FILES) exec php bin/console make:migration
	docker-compose -f $(COMPOSE_FILES) exec php bin/console doctrine:migrations:migrate

build:
	docker-compose -f $(COMPOSE_FILES) up -d --build --force-recreate

down:
	docker-compose -f $(COMPOSE_FILES) down

update:
	docker-compose -f $(COMPOSE_FILES) exec php composer install --optimize-autoloader

status:
	docker-compose -f $(COMPOSE_FILES) ps

destroy:
	docker-compose -f $(COMPOSE_FILES) down --remove-orphans

shell:
	docker-compose -f $(COMPOSE_FILES) exec php sh

prepare:
	docker-compose -f $(COMPOSE_FILES) exec php bin/console doctrine:schema:update -f
	docker-compose -f $(COMPOSE_FILES) exec app php bin/console cache:clear

run-tests:
	docker-compose -f $(COMPOSE_FILES) exec php bin/phpunit
