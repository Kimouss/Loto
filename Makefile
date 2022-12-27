DOCKER_COMPOSE  = docker-compose

EXEC_PHP        = $(DOCKER_COMPOSE) exec -T php
EXEC_JS        = $(DOCKER_COMPOSE) exec -T php

SYMFONY         = $(EXEC_PHP) bin/console
COMPOSER        = $(EXEC_PHP) composer
YARN            = $(EXEC_JS) yarn
NPM				= $(EXEC_JS) npm
EXEC_CURL		= curl -X POST -H 'Content-type: application/json' https://hooks.slack.com/services/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 --data


build:
	@$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --pull

kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

install: ## Install and start the project
install: .env.local networks build start mysql assets success

reset: ## Stop and start a fresh install of the project
reset: kill install

networks:
	 -docker network create kiwi_network

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

clean: ## Stop the project and remove generated files
clean: kill
	rm -rf .env.local vendor node_modules

success:
	@echo '\033[1;32mInstall done\033[0m';

.PHONY: networks build kill install reset start stop clean success

##
## Utils
## -----
##
cache: ## Reset cache
cache:
	@$(SYMFONY) cache:clear --no-warmup

mysql: ## Reset the database and load fixtures
mysql: .env.local vendor
	-$(SYMFONY) doctrine:database:drop --if-exists --force
	-$(SYMFONY) doctrine:database:create --if-not-exists
	-$(SYMFONY) doctrine:migrations:migrate --no-interaction --allow-no-migration

migration: ## Generate a new doctrine migration
migration: vendor
	-$(SYMFONY) doctrine:migrations:diff

assets: vendor
	$(SYMFONY) assets:install public

update-composer: ## update-composer
update-composer:
	$(COMPOSER) update

.PHONY: mongo mysql migration assets jwt jwt-override update-composer deploy-dev deploy-pp deploy-prod

# rules based on files
composer.lock: ## Update composer
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: composer.lock
	$(COMPOSER) install

package-lock.json: package.json
	$(NPM) upgrade

node_modules: package-lock.json
	$(NPM) install
	$(NPM) run dev
	@touch -c node_modules

npm_watch: ## Run npm watcher
npm_watch:
	$(NPM) run watch

npm_dev: ## Build npm
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


##
## IMPORT DATA ##
##
success_import:
	@echo '\033[1;32mAll imported\033[0m';

import: import_loto import_euromillions import_superloto import_extraloto success_import

import_loto:
	$(SYMFONY) app:import:csv data/loto_197605.csv
	$(SYMFONY) app:import:csv data/loto_200810.csv
	$(SYMFONY) app:import:csv data/loto_201703.csv
	$(SYMFONY) app:import:csv data/loto_201902.csv
	$(SYMFONY) app:import:csv data/loto_201911.csv

import_euromillions:
	$(SYMFONY) app:import:csv data/euromillions_200402.csv
	$(SYMFONY) app:import:csv data/euromillions_201105.csv
	$(SYMFONY) app:import:csv data/euromillions_201402.csv
	$(SYMFONY) app:import:csv data/euromillions_201609.csv
	$(SYMFONY) app:import:csv data/euromillions_201902.csv
	$(SYMFONY) app:import:csv data/euromillions_202002.csv

import_superloto:
	$(SYMFONY) app:import:csv data/superloto_199605.csv
	$(SYMFONY) app:import:csv data/superloto_200810.csv
	$(SYMFONY) app:import:csv data/superloto_201703.csv
	$(SYMFONY) app:import:csv data/superloto_201907.csv

import_extraloto:
	$(SYMFONY) app:import:csv data/grandloto_201912.csv
	$(SYMFONY) app:import:csv data/lotonoel_201703.csv

mysql_data: mysql import

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help
