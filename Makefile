testUnit:
	@echo -e '\e[1;31mTesting...\e[0m'
	docker run --rm -w /app -v `pwd`:/app php bin/phpunit
