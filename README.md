
# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone git@github.com:marianabassily2/transactions.git

Switch to the repo folder

    cd transactions

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations 

    php artisan migrate

Seed th roles,permissions and users

    php artisan db:seed
    
Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
