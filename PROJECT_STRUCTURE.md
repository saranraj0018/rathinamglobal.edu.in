# Rathinam Global University project structure

- `app/` — Laravel application code: controllers, models, services, middleware, observers, providers, support helpers, and console commands.
- `bootstrap/` — Laravel application bootstrap and cache directory.
- `config/` — framework and application configuration, including the assistant settings.
- `database/` — migrations, factories, and seeders. Migrations are part of the data contract and must be retained.
- `public/` — web entry point and browser assets. The Priya widget uses `js/voice-assistant.js`, `js/gemini-live-native.js`, and `css/voice-assistant.css`.
- `resources/` — Blade templates, reusable page components, university content data, and Vite source CSS/JavaScript.
- `routes/` — web routes, admin routes, and console routes.
- `storage/app/` — public university media, private files, and the approved hostel/transport context. Preserve uploaded and knowledge content.
- `storage/framework/` — Laravel-generated caches and compiled views.
- `storage/logs/` — application logs.
- `tests/` — Laravel unit/feature tests and native Live JavaScript mock tests.
- `vendor/` — Composer-managed PHP dependencies. Manage these only through Composer.
- `node_modules/` — npm-managed frontend dependencies. Manage these only through npm.
- `work/` — local checkpoints and rollback artifacts; preserve these.

Root files such as `artisan`, `composer.json`, `package.json`, `vite.config.js`, and `phpunit.xml` provide command-line entry points, dependency/build configuration, and test configuration. `.env` contains local settings and credentials and must not be committed or edited during cleanup without explicit authorization.
