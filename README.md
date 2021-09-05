# Recruitment task for Macopedia.

## Installation
- Clone this repository: `git clone git@github.com:ktomaszewski/recruitment-macopedia.git ktomaszewski-recruitment`
- Change directory: `cd ktomaszewski-recruitment`
- Create local docker-compose file: `cp docker-compose.dist.yml docker-compose.yml`
- Run docker: `docker-compose up --build`

Next steps must be done inside the *recruitment-database* container.
To enter the container run: `docker exec -it recruitment-database bash`
- Create database (password: *root*): `mysql -u root -p -e "CREATE DATABASE recruitment CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"` (this query can be found in *config/database* directory)

Next steps must be done inside the *recruitment-application* container.
To enter the container run: `docker exec -it recruitment-application bash`
- Run composer: `composer install`
- Run migrations: `php bin/console doctrine:migrations:migrate`
- Clear cache: `php bin/console c:c`

## Run
Open your browser and go to [this page](https://localhost/index.php/product/import).

Ignore security warning if occurred - it's because of self-signed certificate.

## Products import
*docs/product* directory contains sample products import file.
