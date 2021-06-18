# dc-test

### Requirements
```
* php 7.4+
```

### Dev requirements
```
* Docker
* Docker-compose
```

### Setup
#### Build containers
```
git clone https://github.com/kahur/dc-test.git
cd dc-test
docker-compose up --build
```
----------------------------------
#### Execute migrations
Windows:
```shell
winpty docker-compose exec php-api php bin/console doctrine:migrations:migrate
```
Unix:
```shell
docker-compose exec php-api php bin/console doctrine:migrations:migrate
```
------------------------------------------
#### Execute Fixtures
Windows:
```shell
winpty docker-compose exec php-api php bin/console doctrine:fixtures:load
```
Unix:
```shell
docker-compose exec php-api php bin/console doctrine:fixtures:load
```

### DONE! 
Open browser: http://localhost for frontend

Open browser: http://localhost:8080/api for api

### Testing user
**email:** jonhy@bravo.tld

**password**: 1234
