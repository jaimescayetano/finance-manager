# Finance Manager - Deployment Guide

This guide will walk you through the steps to deploy the Finance Manager application locally.

Clone the repository to your local machine:

```bash
git clone git@github.com:jaimescayetano/finance-manager.git
```

Navigate into the project directory and install the required dependencies:
```bash
cd finance-manager
composer install
```

Copy the example environment file to create your local .env file:
```bash
cp .env.example .env
```

To secure user sessions, generate the application key:
```bash
php artisan key:generate
```

Execute the migrations to set up the database schema, and seed it with initial data:
```bash
php artisan migrate --seed
```

You can now run the application locally:
```bash
php artisan serve
```

The application will be available at http://127.0.0.1:8000/admin.

You can log in with the following test credentials:

    Email: admin@gmail.com
    Password: password
