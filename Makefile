DOCKER_COMPOSE  = docker-compose --env-file .env.local

EXEC_PHP        = $(DOCKER_COMPOSE) exec -T php
EXEC_JS        = $(DOCKER_COMPOSE) exec -T php

SYMFONY         = $(EXEC_PHP) bin/console
COMPOSER        = $(EXEC_PHP) composer
YARN            = $(EXEC_JS) yarn
NPM				= $(EXEC_JS) npm
EXEC_CURL		= curl -X POST -H 'Content-type: application/json' https://hooks.slack.com/services/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 --data

##
## Project
## -------
##

build:
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --pull

kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

install: ## Install and start the project
install: .env.local networks build start assets success

reset: ## Stop and start a fresh install of the project
reset: kill install

networks:
	 -docker network create loto_network

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

clean: ## Stop the project and remove generated files
clean: kill
	rm -rf .env.local vendor node_modules

success:
	@echo '\033[1;32mInstall done\033[0m';

cache:
cache:
	@$(EXEC_PHP) php -r 'echo "Wait mysql database...\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"], ($$u["port"] ?? 3306))) { break; }}'
	-$(SYMFONY) cache:clear --no-warmup

mysql: ## Reset the database and load fixtures
mysql: .env.local vendor
	@$(EXEC_PHP) php -r 'echo "Wait mysql database...\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"], ($$u["port"] ?? 3306))) { break; }}'
	-$(SYMFONY) doctrine:database:drop --if-exists --force
	-$(SYMFONY) doctrine:database:create --if-not-exists
	-$(SYMFONY) doctrine:schema:create
	-$(SYMFONY) messenger:setup-transports
	# $(SYMFONY) doctrine:migrations:migrate --no-interaction --allow-no-migration

migration: ## Generate a new doctrine migration
migration: vendor
	$(SYMFONY) doctrine:migrations:diff

assets: ## Run Webpack Encore to compile assets
#assets: node_modules
assets: vendor
	$(SYMFONY) assets:install public

update-composer: ## update-composer
update-composer:
	$(COMPOSER) update

.PHONY: mongo mysql migration assets jwt jwt-override update-composer deploy-dev deploy-pp deploy-prod

# rules based on files
composer.lock: composer.json
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

package-lock.json: package.json
	$(NPM) upgrade

node_modules: package-lock.json
	$(NPM) install
	$(NPM) run dev
	@touch -c node_modules

npm_watch:
	$(NPM) run watch

npm_dev:
	$(NPM) run dev

.env.local: .env
	@if [ -f .env.local ]; \
	then\
		echo '\033[1;41m/!\ The .env file has changed. Please check your .env.local file.\033[0m';\
		diff .env .env.local;\
		touch .env.local;\
		exit 1;\
	else\
		echo cp .env .env.local;\
		cp .env .env.local;\
	fi

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
