# Metrics App Backend

[Here](https://metrics-app-be.herokuapp.com/) is the server base url

 [![GitHub license](https://img.shields.io/github/license/gothinkster/laravel-realworld-example-app.svg)](http://opensource.org/licenses/mit-license.php)

> ### Laravel backend codebase for a metrics app that accepts users metric values and dates that eventually plots a graph with the input values.


----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

This is the easiest way to get PHP and all it's dependencies on your system
- Download WAMP or XAMPP to manage APACHE, MYSQL and PhpMyAdmin. This also installs PHP by default. You can follow [this ](https://youtu.be/h6DEDm7C37A)tutorial

- Download and install [composer ](https://getcomposer.org/)globally on your system


Clone the repository

    git clone https://github.com/tosinibrahim96/metrics-app-be.git

Switch to the repo folder

    cd metrics-app-be

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/tosinibrahim96/metrics-app-be.git
    cd metrics-app-be
    composer install
    cp .env.example .env
    php artisan key:generate

## Environment variables

- `.env` - Environment variables can be set in this file

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve OR php artisan serve --port={PORT_NUMBER} (setting a PORT manually)

## Database seeding

**Populate the database with seed data. This will help ensure the frontend can start using the API with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    

----------

## API Documentation

This application has a full documentation on it's available endpoints and how to communicate with them.

> [Full API Spec](https://documenter.getpostman.com/view/9516308/2s93eSZaiL)


----------

# Testing API

Run the laravel development server

    php artisan serve
    php artisan serve --port={PORT_NUMBER} (setting a PORT manually)

The api can now be accessed at

    http://localhost:{PORT_NUMBER}

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
|  	|     	|   	|


# License
- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2023 © <a href="https://www.linkedin.com/in/ibrahim-alausa/" target="_blank">Ibrahim Alausa</a>.
