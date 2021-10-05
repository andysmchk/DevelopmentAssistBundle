phpunit:
	vendor/bin/phpunit
	#docker run -it --rm --name dev-tools-phpunit -w /var/tests/ --read-only -v `pwd`:/var/tests php:7.4-cli php vendor/bin/phpunit
