

## This project is a starter project for a Laravel, Vue and Tailwind Application


- Uses npm for javascript package management
- Includes configured prettier and eslint for javascript
- Includes pint and larastan set up on backend
- Has one page that allows creation of projects and tasks with drag and drop implemented.


## Scripts set up in package.json
```
    "scripts": {
        "dev": "vite --port 4000",
        "build": "vite build",
        "larastan": "./vendor/bin/phpstan analyze",
        "pint": "./vendor/bin/pint",
        "prettier": "prettier --check '**/**/*.{js,jsx,ts,tsx,css,vue}'",
        "prettier:fix": "prettier --write '**/**/*.{js,jsx,ts,tsx,css}'",
        "runall" : "npm run pint & npm run larastan & npm run prettier:fix & npm run lint:fix",
        "lint": "eslint resources/js",
        "lint:fix": "eslint --fix resources/js"
    },
```

## To run Application

Create a valid .env file and then:

Run the migrations to create the database and create dummy data:
```
php artisan migrate:fresh --seed

npm run dev

php artisan serve
```

Application should be able to be accessed at:

http://127.0.0.1:8000/
