Laravel + soketi = <3
=====================

This project demonstrates the power of soketi's WebSocket functionality in Laravel.

## Installing the project

The server requires:

- Composer
- Node.js + NPM (for soketi)
- PHP 7.3+

```bash
git clone git@github.com:soketi/laravel-chat-app.git
```

```bash
cd laravel-chat-app
```

## Installing the chat room app

Run the following chain commands to install the project:

```bash
composer install --ignore-platform-reqs && \
cp .env.example .env && \
touch database/database.sqlite && \
php artisan key:generate && \
php artisan migrate:fresh --seed && \
php artisan storage:link
```

Build the frontend assets:

```bash
npm install && npm run dev
```

Run the internal server to make the HTTP server accessible on `http://127.0.0.1:8000`:

```bash
php artisan serve
```

## Installing soketi

You can find multiple [installation methods](https://rennokki.gitbook.io/soketi-docs/getting-started/installation) for soketi, but for this project we assume you already have NPM installed:

```bash
npm install -g @soketi/soketi@latest
```

To launch the server, open a new terminal window and let it run in the background:

```bash
soketi start
```

## Authentication

The seeders created three accounts. All accounts can be accessed with the password `secret`:

- `test@test.com`
- `test2@test.com`
- `test3@test.com`

## Linting the code

You can lint the code for Vue:

```bash
npm run lint
```

For PHP, use the CSFixer command:

```bash
vendor/bin/php-cs-fixer fix
```
