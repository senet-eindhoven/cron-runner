help:
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up: ## Start container
	docker-compose up -d
	make install

down: ## Stop container
	docker-compose down

install: ## Install dependencies
	docker-compose exec -T app composer install
	docker-compose exec -T app composer bin all install --no-interaction

login: ## Login to the container
	docker-compose exec app sh

test: ## Run PHPunit
	docker-compose exec -T app vendor/bin/phpunit

test-coverage: ## Run PHPunit with coverage
	docker-compose exec -e XDEBUG_MODE=coverage -T app vendor/bin/phpunit --colors=always --coverage-html reports/phpunit/html --coverage-clover reports/phpunit/clover.xml --log-junit reports/phpunit/junit.xml

phpstan: ## Run PHPStan
	docker-compose exec -T app vendor/bin/phpstan

phpcs: ## Run PHPCS
	docker-compose exec -T app vendor/bin/phpcs --parallel=4

phpcs-fix: ## Run PHPCS
	docker-compose exec -T app vendor/bin/phpcbf --parallel=4

security-check: ## Run security-checker
	docker run -v $(shell pwd):/app --pull always symfonycorp/cli security:check --dir=/app

