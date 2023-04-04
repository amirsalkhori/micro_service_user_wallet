# Develop Setup
The easier way of running the app is to use docker and docker compose.

The steps for initial setup are:
-    `docker-compose up -d`
-    `docker-compose exec php composer install`
-    `docker-compose exe php sh`
-    `php bin/console make:migration and php bin/console doctrine:migration:migrate`
     `OR`
-    `php bin/console doctrine:schema:update -f`
-    `docker-compose exec php bin/phpunit`

From next time you can just go with `docker-compose up` and when you need migration or seed, just run the necessary commands.
Then just open [localhost:8080](http://localhost:8080) to access the app.

### Makefile commands
For ease of use when working with docker, we have created several make commands as following:
- `make up`: Build and run the containers
- `make down`: Stop the containers
- `make shell`: short for `docker-compose exec php sh`
- `make update`: Short for `composer install`
- `make status`: Short for `docker-compose ps`
- `make destroy`: Remove all orphaned containers
- `make prepare`: Migrate and clear the app cache
- `make run-tests`: Run PHPUnit tests
