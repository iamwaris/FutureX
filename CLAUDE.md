# CreatorOS

Premium Creator Operating System — a Laravel + Filament platform that serves as a streamer/creator's central hub (not a portfolio, not a Linktree, not a gaming template). Full product spec: [docs/DESIGN_BRIEF.md](docs/DESIGN_BRIEF.md). Build order: [docs/MILESTONES.md](docs/MILESTONES.md).

## Stack

- **Backend/Admin:** Laravel 12, Filament 3 (admin panel at `/admin`)
- **Database:** MariaDB (standalone instance, NOT XAMPP's bundled MySQL — see Environment below)
- **Frontend:** Blade + Tailwind CSS v4 + Alpine.js + GSAP (motion), Vite build
- **Why Laravel + Filament over a JS-native stack:** chosen to stay in the existing PHP/XAMPP environment. Filament's resource/panel system covers the Theme Builder, Page Builder, and Content Manager requirements without hand-building an admin panel from scratch.

## Environment quirks (read before debugging "it doesn't work")

- PHP is XAMPP's bundled `C:\xampp\php\php.exe` — not on PATH in the bash tool, must be invoked by full path (or via PowerShell where it may resolve differently).
- The `intl` and `zip` PHP extensions were disabled by default in `C:\xampp\php\php.ini` and were enabled to install Filament. This is a machine-wide XAMPP config change, not project-local.
- **Composer is not installed globally.** `composer.phar` lives in the project root (gitignored) — run it as `php composer.phar <command>`.
- **Database is a standalone MariaDB instance at `127.0.0.1:3306`, database `dbfuturex`** — this is a pre-existing server with other unrelated databases on it, not XAMPP's bundled MySQL (which has its own root password and was not used). Credentials are in `.env` only.
- **Node.js is v18.13.0**, but Vite 7 and `@tailwindcss/oxide` require Node ^20.19 or >=22.12. `npm install` works with engine warnings; `npm run dev`/`build` should be considered unverified until Node is upgraded. Do this before starting M2 frontend work.
- The project lives directly in `htdocs/FutureX`, so **do not rely on XAMPP's Apache** hitting it directly — Laravel needs the webserver docroot at `public/`, not the project root. Use `php artisan serve` for local dev (matches `APP_URL=http://localhost:8000` in `.env`), or configure an Apache VirtualHost pointing at `FutureX/public` if XAMPP Apache is preferred later.

## Conventions

- Every visual property (color, font, radius, shadow, spacing, animation intensity) must come from the design token system (M1), never hardcoded in a Blade/CSS file. This is the whole point of the Theme Engine — a single codebase must support radically different creator brands via admin-panel edits only.
- Admin-editable content (sections, videos, gallery, events, sponsors, shop) goes through Filament resources — no seeding permanent content directly in migrations/seeders beyond dev fixtures.
- Third-party integrations (Twitch, Kick, YouTube, Discord, shop providers, etc.) should be built behind a small service/interface per provider so the active provider is admin-switchable, per the brief's "no fixed templates" requirement.

## Setup

```
php composer.phar install
npm install
cp .env.example .env   # then fill in DB credentials
php artisan key:generate
php artisan migrate
php artisan serve
```

Admin panel: `http://localhost:8000/admin`
