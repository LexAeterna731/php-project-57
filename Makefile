start:
	php artisan serve

install:
	composer install
	cp -n .env.example .env
	php artisan key:gen

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 routes

test:
	php artisan test

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml