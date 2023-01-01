# Cranberry Punch

Cranberry Punch is an Employee Attendance Management System that allows you to easily track and manage employee attendance. With Cranberry Punch, you can quickly and easily see who is present and who is absent, as well as record and track attendance data for future reference.

## Installation

To install Cranberry Punch, follow these steps:

1. Navigate to the directory where you want to install Cranberry Punch:

    ```
    cd /path/to/cranberry-punch
    ```

2. Run the following command to install the required packages:

    ```
    npm clean-install
    composer install
    ```

## First Time Installation Only

If you are installing Cranberry Punch for the first time, you will need to run the following additional steps:

1. Copy the example environment file and create a new `.env` file:

    ```
    cp .env.example .env
    ```

2. Generate an application key:

    ```
    php artisan key:generate
    ```

3. Run the database migrations and seed the database with initial data:

    ```
    php artisan migrate:fresh --seed
    ```

    **NOTE:** The `migrate:fresh` command destroys all data in the database. Do not run this command in a production environment.

## For Production

If you are installing Cranberry Punch in a production environment, you should use the following commands instead:

```
php artisan migrate
php artisan db:seed --class=InitialSetupSeeder
```

## Export Translations

To export translations for the `en` locale, run the following command:

```
php artisan translatable:export en
```

## Run Development Environment

To start the development server, run the following command:

```
php artisan serve
```

Then, run the following command to compile the front-end assets:

```
npm run dev
```

## Upgrade Filament

To upgrade Filament, run the following commands:

```
php artisan config:clear
php artisan livewire:discover
php artisan route:clear
php artisan view:clear
```

```
composer update
php artisan filament:upgrade
```

## Run Cypress Test

To run the Cypress test suite, run the following command:

```
npx cypress open
```
