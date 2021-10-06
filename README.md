# Feitcher API

This project is designed to retrive products and their insurance info from 3rd party API
Project is written in PHP using the following framework: [laravel 7.0](https://laravel.com/docs/7.x/installation#server-requirements)


## Pre-requisites

For development you will need the following packages in your environment

- Docker Desktop [download](https://www.docker.com/products/docker-desktop)

##  Getting started

clone repository

	git clone https://github.com/kozmixb/feItcher-api.git

navigate to project folder

	cd ./feIther-api

create and configure environment file

	cp .env.example .env

set 3rd party api base url in `.env`

	API_BASE_URL=https://something.com/v2/products/

When docker builds the project it will spin up a database container and taking the DB credentials from the `.env` file so make sure that is setup correctly
Recommend you to leave it as it is if you are for working on the project

	DB_CONNECTION=mysql
	DB_HOST=feitcher_db    <- container name in docker compose
	DB_PORT=3306
	DB_DATABASE=docker
	DB_USERNAME=docker
	DB_PASSWORD=secret

run docker compose from project directory

	docker compose up --build

## Docker build

Composer packages will be installed when docker builds the `feitcher_php` container however the following commands needs to be run to setup the the project itself

	docker exec -it feitcher_php php /var/www/html/artisan key:generate --force
	docker exec -it feitcher_php php /var/www/html/artisan migrate --force
	docker exec -it feitcher_php php /var/www/html/artisan passport:install --force
	
when you ran the last command make sure you grab the password credentials 

	Password grant client created successfully.
	Client ID: 2
	Client secret: xxxxxxx

And add these to the `.env`

	CLIENT_ID=2
	CLIENT_SECRET=xxxxxx

once it is done you are good to go