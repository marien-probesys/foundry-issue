.DEFAULT_GOAL := help

USER = $(shell id -u):$(shell id -g)

DOCKER_COMPOSE = docker compose -p webapp -f docker/docker-compose.yml

PHP = ./docker/bin/php
COMPOSER = ./docker/bin/composer

.PHONY: docker-start
docker-start: ## Start a development server
	@echo "Running webserver on http://localhost:8000"
	$(DOCKER_COMPOSE) up

.PHONY: docker-build
docker-build: ## Rebuild the Docker containers
	$(DOCKER_COMPOSE) build

.PHONY: docker-clean
docker-clean: ## Clean the Docker stuff
	$(DOCKER_COMPOSE) down

.PHONY: install
install: ## Install the dependencies
	$(COMPOSER) install

.PHONY: db-setup
db-setup: ## Setup the database
	$(PHP) bin/console doctrine:database:create
	$(PHP) bin/console doctrine:migrations:migrate --no-interaction

.PHONY: db-migrate
db-migrate: ## Migrate the database
	$(PHP) bin/console doctrine:migrations:migrate --no-interaction

.PHONY: db-rollback
db-rollback: ## Rollback the database to the previous version
	$(PHP) bin/console doctrine:migrations:migrate --no-interaction prev

.PHONY: db-reset
db-reset: ## Reset the database
ifndef FORCE
	$(error Please run the operation with FORCE=true)
endif
	$(PHP) bin/console doctrine:database:drop --force --if-exists
	$(PHP) bin/console doctrine:database:create
	$(PHP) bin/console doctrine:migrations:migrate --no-interaction
	$(PHP) bin/console cache:clear

.PHONY: test
test: ## Run the test suite
	$(PHP) ./bin/phpunit

.PHONY: help
help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
