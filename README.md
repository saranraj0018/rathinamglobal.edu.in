# rathinamglobal.edu.in

Public website of Rathinam Global University, built on Laravel 13. It replaces the
earlier core-PHP site (`rgu_test`). Every legacy URL works at the same address.

## Requirements

- PHP 8.3+ with `curl`, `mbstring`, `openssl`, `fileinfo`
- Composer 2
- No database. Sessions and cache use the filesystem.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan serve
```

Then fill in the Apps Script URLs in `.env`. Without them the forms answer
"could not reach the service":

| Key | Used by |
| --- | --- |
| `BUS_REGISTRATION_APPS_SCRIPT_URL` | `/acbus` registration form |
| `BROCHURE_LEADS_APPS_SCRIPT_URL` | `/esg` and `/esia` enquiry forms |
| `TURNSTILE_SECRET_KEY` | optional server-side CAPTCHA check for `/acbus` |

Run the tests with `php artisan test`.

## Where things live

| What | Where |
| --- | --- |
| Routes (every public URL, named) | `routes/web.php` |
| Controllers | `app/Http/Controllers` |
| Layouts | `resources/views/layouts` (`base`, `app` = main nav + footer, `research`) |
| Shared partials | `resources/views/partials` (nav, footer, analytics), `components/courses-nav` |
| Page views | `resources/views/{home,schools,programmes,research,events,faq,...}` |
| Page content (tables, lists, FAQs, programme data) | `resources/data/**/*.php`, read through `App\Support\ContentRepository` |
| Images, CSS, JS, PDFs, video | `storage/app/public/` (served at `/storage/...` via the symlink), referenced with `storage_asset('path')` |
| Gated brochures, JD export | `storage/app/private/` |
| Site settings (canonical host, analytics, form endpoints) | `config/rgu.php` |

Most content edits are data-file edits. For example, a new patent row goes in
`resources/data/research/patents.php`, a new event in `resources/data/events.php`
plus `resources/data/events/{slug}.php`, and a new programme page in
`resources/data/programmes/{school}/{slug}.php`.

`storage_asset()` adds a `?v=<mtime>` stamp to CSS and JS. The server caches those
files for a year, so updated files reach browsers without renaming them.

### Homepage CSS

The homepage loads `assets/css/home.bundle.css` asynchronously and inlines
`assets/css/critical.css`. After editing `tailwind.css`, `style.css` or
`extracted.css`, rebuild both:

```bash
php artisan rgu:build-css
```

## Legacy URLs

`App\Http\Controllers\LegacyUrlController` (the route fallback) handles old addresses:

- `/research/patents.php`, `/law/index.html`, ... get a 301 to the clean URL
- `/assets/...`, `/esg/images/...` (old file paths) get a 301 to `/storage/...`
- `/research/startup` and `/research/books-book-chapters` get a 301 to their canonical pages

## Deployment

1. Point the document root at `public/`, not the project root.
2. In `.env`, set `APP_ENV=production`, `APP_DEBUG=false` and the real `APP_URL`.
3. Run:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan storage:link
   php artisan optimize
   ```
4. Make `storage/` and `bootstrap/cache/` writable by the web server.

`public/.htaccess` forces HTTPS (it is aware of the nginx/Cloudflare proxy) and
sets compression, caching and security headers.

Some paths on the live server are not part of this codebase: `/global-affairs`,
`/careers`, `/blog/`, `/news/`, `/fab/` and `/gc`. Either keep them as folders inside
`public/` or serve them separately. Otherwise they return 404 after cut-over.

## Migration notes

These items were not carried over from `rgu_test` on purpose:

- `acbus/submit/.cache.php` is a password-protected web shell that downloads and
  `eval`s remote code.
- `events/home.php`, `research/leads.php` and `faq/index.php` are injected
  gambling-spam pages. The cloaking in `events/index.php` and `research/index.php`
  served them to Googlebot only. The genuine pages were rebuilt from
  `events/readme.txt`, `research/readme.txt` and `faq/data/faqs.php`, and the
  spam sub-sitemaps were dropped.
- `*.zip` archives, `*.bak` files and `tools/` were dropped. `tools/` is replaced
  by `php artisan rgu:build-css`.
