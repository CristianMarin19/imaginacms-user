# imaginacms-iuser


## SEED MODULE (User and Roles by default)

```php
php artisan module:seed Iuser
```

## Configuration PASSPORT

### Create Personal Client

1. Run the following command:

```php
    php artisan passport:client --personal
```
2. Type ENTER (users default)

3. Type ENTER (laravel default)

### Create Password Client

1. Run the following command:

```php
    php artisan passport:client --password
```
2. Type ENTER (users default)

3. Type "laravel-password"

4. Copy the keys it generates to the .env file


### APP URL

Change app url variable in the .env

```php
APP_URL=http://host.docker.internal:8081/
```

### Create Super Admin User

Use the following Artisan command to create a super admin user. Replace the placeholders with the desired user details:

```bash
php artisan iuser:create-super-admin demo@example.com FirstName LastName
```
