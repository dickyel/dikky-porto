# dikky-porto

Portfolio website Dikky — Laravel + MySQL CMS untuk profile, projects, services, testimonials, traffic analytics, sitemap, dan Google Analytics.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# sesuaikan DB di .env
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Admin default: `admin@dikky.dev` / `admin123`

Sitemap: `/sitemap.xml` · Robots: `/robots.txt`
