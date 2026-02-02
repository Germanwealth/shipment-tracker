# Shipment Tracker - Development Instructions

This is a production-ready Laravel shipment tracking application with PostgreSQL backend and Blade + Tailwind CSS frontend.

## Project Overview

- **Type**: Laravel 11 Web Application
- **Database**: PostgreSQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Auth**: Laravel built-in auth system
- **Deployment Target**: Railway

## Key Files & Structure

### Models (app/Models/)
- `Admin.php` - Admin user model
- `Shipment.php` - Shipment with auto-generated tracking codes
- `TrackingUpdate.php` - Timeline updates for shipments

### Controllers (app/Http/Controllers/)
- `AdminShipmentController.php` - CRUD operations for shipments
- `PublicTrackingController.php` - Public tracking search
- `Auth/AdminAuthController.php` - Admin login/logout

### Database
- Migrations in `database/migrations/`
- Seeders in `database/seeders/` (includes demo data)

### Views (resources/views/)
- Layouts: `layouts/app.blade.php`, `layouts/admin.blade.php`
- Admin: Dashboard, create/edit shipments, tracking updates
- Public: Tracking search, results, not-found page
- Auth: Admin login page

### Routes (routes/web.php)
- Public: `/` (tracking page), `/track/{code}` (search)
- Admin: `/admin/login`, `/admin/shipments/*`

## Quick Setup

1. Copy `.env.example` to `.env`
2. Update PostgreSQL credentials in `.env`
3. Run `composer install`
4. Run `php artisan migrate`
5. Run `php artisan db:seed` (optional, adds demo data)
6. Run `php artisan serve`

## Default Admin Credentials (After Seeding)
- Email: admin@example.com
- Password: password123

## Important Features

✓ Unique, auto-generated tracking codes (TRK-XXXXXXXX format)
✓ Admin-only authentication with session management
✓ Public tracking without authentication
✓ Full CRUD operations for shipments
✓ Tracking timeline with multiple updates per shipment
✓ PostgreSQL with proper relationships and indexes
✓ Responsive Tailwind CSS UI
✓ CSRF protection on all forms
✓ Input validation on all endpoints

## When Making Changes

- Keep models in `app/Models/`
- Add new controllers to `app/Http/Controllers/`
- Create migrations with proper relationships
- Use Blade views with Tailwind CSS classes
- Always validate user input
- Maintain RESTful route structure
- Test admin flows and public tracking

## Deployment Notes

This app is Railway-ready. For Railway deployment:
1. Set environment variables in Railway dashboard
2. Run migrations: `railway run php artisan migrate --force`
3. Ensure PostgreSQL service is attached
4. Set proper error handling for production

## Database Relationships

- Shipment hasMany TrackingUpdates
- TrackingUpdate belongsTo Shipment
- Relationships properly defined in models

Enjoy building! 🚀
