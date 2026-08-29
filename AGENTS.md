# AGENTS.md

## Stack
- **Framework**: Laravel 10.10 (PHP 8.1+)
- **Build/Assets**: Vite
- **Database**: MySQL
- **Testing**: PHPUnit
- **Admin UI**: Bootstrap 5.3.3 + custom CSS

## Project Structure
- `app/Http/Controllers/` – User controllers (Home, Menu, Cart, Checkout) and Admin controllers
- `app/Http/Controllers/Admin/` – Admin CRUD: MenuController, OrderController
- `app/Models/` – Eloquent models: User, Menu, Category, Order, OrderItem
- `resources/views/admin/` – Admin dashboard and CRUD templates
- `public/css/style.css` – Custom styling (Poppins font, brown/beige theme)
- `database/migrations/` – Schema for categories, menus, orders, order_items

## Key Routes
- `/admin` – Dashboard (AdminController@index)
- `/admin/menus` – Menu CRUD (Admin\MenuController)
- `/admin/orders` – Order management (Admin\OrderController, index/show/update only)
- User routes: `/menu`, `/cart`, `/checkout`

## Database Setup
Run migrations to set up tables:
```
php artisan migrate
```

Optional: Seed sample data:
```
php artisan db:seed
```

## Development Commands
- `php artisan serve` – Start dev server
- `npm run dev` – Watch Vite assets (if using JS/CSS bundling)
- `php artisan tinker` – Interactive shell
- `./vendor/bin/phpunit` – Run tests

## Code Style & Linting
- **Pint** is configured (`laravel/pint`); run: `./vendor/bin/pint`
- No explicit linter configured in package.json; use Pint for PHP formatting

## Testing
- Test suites: `tests/Unit` and `tests/Feature`
- Config: `phpunit.xml` (uses array session driver, array cache for testing)
- Run all tests: `./vendor/bin/phpunit`

## Admin Dashboard Features
- **AdminController@index** passes:
  - `$totalMenu` – Menu count
  - `$totalOrder` – Order count
  - `$totalRevenue` – Sum of 'Selesai' status orders
  - `$pendingOrder` – Count of 'Menunggu' status orders
- View: `resources/views/admin/index.blade.php` (basic card layout)

## Order Status Values
Used in Order model and filtering:
- `'Menunggu'` (Pending)
- `'Diproses'` (Processing)
- `'Selesai'` (Completed)
- `'Dibatalkan'` (Cancelled)

## Environment
- Database credentials: `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE` in `.env`
- Running locally via Laragon (Windows dev environment)

## Important Notes
- Debug route `/cek-db` exists in `routes/web.php` – remove before production
- No git repo or pre-commit hooks configured
