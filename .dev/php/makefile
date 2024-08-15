vendor: composer.json composer.lock
	@composer install

php-fix: vendor
	@vendor/bin/php-cs-fixer fix

test: vendor
	@vendor/bin/phpunit tests