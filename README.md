# ToGo

A simple ToGo list to make a list of places you'd like to go to in the future. (a ToDo list variant)

## Install

Make your `.env` file and all dependencies:


```bash
cp ./.env.example ./.env
composer install
npm ci
php artisan key:generate
```

Add `OPENROUTE_APIKEY` to your `.env` file

## Start application

```bash
./vendor/bin/sail up
```

access application on [localhost:80](http://localhost:80).

## Testing

    php artisan test

## Features

- Add places with autocomplete (with openroute)
- Delete places
- Visit places

## Future features

- More checks
- Auth with user


