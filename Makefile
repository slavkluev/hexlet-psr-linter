install:
	composer install

autoload:
	composer dump-autoload

lint:
	composer exec 'phpcs --standard=PSR2 --ignore=tests/Fixtures/* src tests'
	./bin/psrlint tests/

test:
	composer exec 'phpunit tests'