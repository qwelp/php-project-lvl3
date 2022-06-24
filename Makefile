start:
	php artisan serve --host 0.0.0.0

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan migrate

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test --testsuite=Feature --stop-on-failure

test-coverage:
	XDEBUG_MODE=coverage php artisan test --testsuite=Feature --coverage-clover build/logs/clover.xml

deploy:
	git push heroku

lint:
	composer exec phpcs -- --standard=PSR12 app routes tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app routes tests
