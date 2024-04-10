<img alt="img" src="./public/img/readme/logo.svg" style="display: block; margin: 0 auto; padding-top: 20px"/>
<img width="200" alt="img" src="./public/img/readme/girl-training.svg" style="display: block; right: 0; top: 0; position: absolute";/>

<h1 align="center" style="color: dodgerblue">E-commerce Fitness Shop Laravel</h1>

## 🔵 About project

Ecommerce Shop with Laravel/Inertia/VueJs 3/Filament and API's.

Will use some features, such as:

- Authentication with Laravel Breeze for site
- Separate admin panel auth /admin/login using Laravel Filament.
- Spatie permissions. Only user with role Admin has access to admin panel. See UserSeeder generate a few test users with role Admin

## 🔵 Installation
- Install Redis for horizon
- Install DB (mysql/postgres)
- Copy from .env.example and create a new .env file. In it we register a connection to the database
- Run the commands:
### Backend
```
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan db:seed
npm install
php artisan serve
php artisan horizon
vite
```
### Frontend
By default, you don't need npm install. Because project has built front files
```
npm install
npm run build
//or
npm run dev
```

## 🔵 Dev tips

### Permissions
Without going into bash, just in the project folder for the first time give the perms
```
sudo chmod -R 777  ./
```

### Docker
```
docker-compose build --no-cache
docker-compose up --build --force-recreate --no-deps
docker-compose down
docker-compose up -d
docker exec -it project_name_app bash
systemctl restart docker
```

### Aliases Mac OS
For those new to creating bash aliases, the process is pretty simple.
First, open up the ~/.zshrc file in a text editor that is found in your home directory.
Uncomment or add the following lines:
```
cd ~ 
open .zshrc
```
Paste text alias `.zshrc` and save file:
```
alias a="php artisan"
```
Reopen terminal
