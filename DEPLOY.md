# Deploy — inspres.myappsonline.net

Target host: myappsonline.net (cPanel-style shared host)
Repo: https://github.com/shahrilunijaya-source/inspres
Branch: `main`

---

## One-time Setup

### 1. cPanel Git Version Control

1. cPanel → **Git Version Control** → **Create**
2. Clone URL: `https://github.com/shahrilunijaya-source/inspres.git`
3. Repository Path: `/home/<cpanel-user>/repositories/inspres`
4. Repository Name: `inspres`
5. If repo private: cPanel needs deploy key or PAT. Public repo = no auth needed.
6. Create. cPanel clones automatically.

### 2. Document Root

Set the addon/sub domain `inspres.myappsonline.net` document root to:

```
/home/<cpanel-user>/repositories/inspres/public
```

cPanel → **Domains** → edit `inspres.myappsonline.net` → Document Root.

Never point document root at the repo root. `public/` only. Otherwise `.env` and source code are web-exposed.

### 3. MySQL Database

1. cPanel → **MySQL Databases** → Create database `<prefix>_inspres`
2. Create user, strong password, grant **ALL PRIVILEGES** on that DB
3. Note: host=`localhost` or `127.0.0.1`, db, user, password

### 4. .env on Server

SSH or cPanel **Terminal**:

```bash
cd ~/repositories/inspres
cp .env.example .env
nano .env
```

Paste from local `.env.production` template, fill DB creds + mail. Save.

```bash
php artisan key:generate
```

### 5. Composer + Migrations

```bash
cd ~/repositories/inspres
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If `composer` not in PATH, use `php /opt/cpanel/composer/bin/composer` or check with host.

### 6. Permissions

```bash
chmod -R 775 storage bootstrap/cache
```

### 7. PHP Version

cPanel → **MultiPHP Manager** → set `inspres.myappsonline.net` to PHP 8.2+ (Laravel 13 requires).

### 8. Smoke test

Visit `https://inspres.myappsonline.net`. Expect Laravel welcome page.

If 500 error: check `storage/logs/laravel.log`.

---

## Recurring Deploys (after first setup)

Local:

```bash
cd inspres-app
git add .
git commit -m "<what changed>"
git push origin main
```

Server (cPanel — myappsonline likely no auto-webhook):

1. cPanel → Git Version Control → **Manage** → **Pull or Deploy** tab
2. Click **Update from Remote** → **Deploy HEAD Commit**

Or via Terminal:

```bash
cd ~/repositories/inspres
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Optional: .cpanel.yml auto-deploy

Add `.cpanel.yml` at repo root to chain `git pull` → composer + migrate automatically on deploy click. Skip for now until manual flow proven.

---

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| 500 error, blank page | Check `storage/logs/laravel.log`. Usually missing `APP_KEY` or DB creds wrong. |
| "No application encryption key" | Run `php artisan key:generate` on server. |
| Permission denied on storage | `chmod -R 775 storage bootstrap/cache`. |
| Vite/CSS missing | Run `npm install && npm run build` locally, commit `public/build`, push. Or build on server if Node available. |
| Migration fails | Verify DB user has ALL PRIVILEGES on the database. |
| 404 on all routes except `/` | mod_rewrite off. cPanel → enable, or check `public/.htaccess` exists. |

---

## Files

- `.env.production` — local template (gitignored). Copy to server `.env` and fill in.
- This file — commit to repo for future-you and team reference.
