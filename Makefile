make.DEFAULT_GOAL := help

help:
	@echo ""
	@echo "Available tasks:"
	@echo "    start          [HOST] Run docker-compose"
	@echo "    startf         [HOST] Run docker-compose dettached"
	@echo "    stop           [HOST] Stop detached docker-compose"
	@echo "    status         [HOST] Info about running docker containers"
	@echo "    install        [DOCK] Install project dependencies inside container"
	@echo "    ssh-php        [DOCK] Access the PHP container shell"
	@echo "    metrics        [DOCK] Generate phpmetrics on tests/_output/phpmetrics/"
	@echo "    lint-dev       [DOCK] Run linter, code style, mess detector, ignoring fails"
	@echo "    lint           [DOCK] Run linter, code style, mess detector, stops on fails"
	@echo "    tests          [DOCK] Run linter and unit tests, run make up/d before"
	@echo "    all            [DOCK] Build, install dependencies, run linter and unit tests"
	@echo ""

start:
	docker-compose up

startf:
	docker-compose up -d

stop:
	docker-compose stop

rm: stop
	docker-compose rm


status:
	docker-compose ps

build:
	docker-compose build

php-install:
# 	docker-compose exec php-fpm composer install --prefer-dist && bin/phpunit install
#	docker-compose exec php-fpm bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php-fpm /usr/bin/make jwt-rsa

install: build upd php-install stop

ssl-self-signed:
		docker-compose run --rm nginx openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt

jwt-rsa-from-host:
	docker-compose exec php-fpm /usr/bin/make jwt-rsa

jwt-rsa:
	openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:${JWT_PASSPHRASE}
	openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:${JWT_PASSPHRASE}

ssh-php:
	docker-compose exec php-fpm /bin/sh

ssh-nginx:
	docker-compose exec nginx /bin/sh

metrics:
	docker-compose run --rm php-fpm vendor/bin/phpmetrics --junit=./tests/_output/junit.xml --report-html=tests/_output/phpmetrics --exclude=bin,docker,build,templates,tests,translations,var,DataFixtures,vendor .

lint-dev:
	@echo "****************************************************"
	@echo "*                  LINT                            *"
	@echo "****************************************************"
	docker-compose run --rm php-fpm vendor/bin/parallel-lint --exclude vendor --exclude var . || exit 0
	@echo " "
	@echo " "
	@echo "****************************************************"
	@echo "*              CODING STANDARDS                    *"
	@echo "****************************************************"
	docker-compose run --rm php-fpm vendor/bin/phpcbf --standard=psr2 ./src || exit 0
	docker-compose run --rm php-fpm vendor/bin/phpcs --ignore=DataFixtures ./src || exit 0
	@echo " "
	@echo " "
	@echo "****************************************************"
	@echo "*               MESS DETECTOR                      *"
	@echo "****************************************************"
	docker-compose run --rm php-fpm vendor/bin/phpmd src text cleancode,codesize,controversial,design,naming,unusedcode || exit 0

lint:
	docker-compose run --rm php-fpm vendor/bin/parallel-lint --exclude vendor --exclude var .
	docker-compose run --rm php-fpm vendor/bin/simple-phpunit --coverage-html ./tests/_output/phpunit_coverage --coverage-xml ./tests/_output
	docker-compose run --rm php-fpm vendor/bin/phpcbf --standard=psr2 ./src
	docker-compose run --rm php-fpm vendor/bin/phpcs --standard=psr2 ./src
	docker-compose run --rm php-fpm vendor/bin/phpmd src html cleancode,codesize,controversial,design,naming,unusedcode --reportfile ./tests/_output/phpmd.html --exclude DataFixtures,AmqpExt

tests:
	docker-compose stop php-collector
	docker-compose exec php-fpm bin/console hautelook:fixtures:load --no-interaction
	docker-compose run --rm php-fpm vendor/bin/simple-phpunit tests/ --coverage-html ./tests/_output/phpunit_coverage --log-junit ./tests/_output/junit.xml || exit 0

all: install jwt-certs tests lint

.PHONY: help install lint tests all up upd stop lint-dev ps jwt-certs metrics status jwt-rsa
