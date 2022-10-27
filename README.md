## About Open Attendance
Open Attendance is an Employee Attendance System.

## Installation

```
cd /path/to/open-attendance
npm clean-install
composer install
```

**First Time Installation Only**
```
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed # This step destroys all data in the database. NOT TO BE RUN IN PRODUCTION
```

**For Production**
```
php artisan migrate
php artisan db:seed --class=InitialSetupSeeder
```

**Export Translations**
```
php artisan translatable:export en
```

**Run Development Environment**
```
php artisan serve
```
```
npm run watch --stats-children
```
**Upgrade Filament**
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

**Run Cypress Test**
```
npx cypress open
```
