.PHONY: install test analyze fix help

help:
	@echo "Dostępne komendy:"
	@echo "  make install  - Pełna konfiguracja projektu"
	@echo "  make test     - Uruchomienie testów PHPUnit"
	@echo "  make analyze  - Statyczna analiza kodu (PHPStan)"
	@echo "  make fix      - Naprawa stylu kodu (PHP CS Fixer)"

setup:
	composer install
	rm -rf var/cache/*
	php bin/console lexik:jwt:generate-keypair --skip-if-exists
	php bin/console doctrine:database:drop --force --if-exists
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate -n
	php bin/console doctrine:fixtures:load -n
	php bin/console doctrine:database:create --env=test --if-not-exists
	php bin/console doctrine:schema:update --env=test --force

test:
	php bin/phpunit

analyze:
	vendor/bin/phpstan analyse --memory-limit=1G

fix:
	vendor/bin/php-cs-fixer fix --allow-risky=yes