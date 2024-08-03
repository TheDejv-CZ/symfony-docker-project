# PHP Symfony Docker project

## Overview
This simple application will allow you to show list of Posts and Comments


## Setup and Configuration
1. **Install Dependencies:** <br>
    ```
    composer install
    ```
2. **Build and run Docker:** <br>
    ```
    docker-compose up --build
    ```
3. **Run Migration:** <br>
   ```
   docker-compose exec apache php bin/console doctrine:migrations:migrate
   ```
4. **Import Data:** <br>
   ```
   docker-compose exec apache php bin/console app:import-data
   ```
5. **Allow Cache to be writable:** <br>
   ```
   docker exec symforny-project-apache-1 /bin/bash -c "chmod -R 777 /var/www/html/var/cache"
   ```
If symforny-project-apache-1 will not exists, you have to find proper name for your container by running command:
    ```
    docker container ls
    ```