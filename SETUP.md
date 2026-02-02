# Getting Started with Shipment Tracker

This guide will help you set up and run the Shipment Tracker application locally.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** - [Download](https://www.php.net/downloads)
- **Composer** - [Download](https://getcomposer.org/download/)
- **PostgreSQL 12+** - [Download](https://www.postgresql.org/download/)
- **Git** - [Download](https://git-scm.com/)
- **Node.js & npm** - [Download](https://nodejs.org/)

## Installation Steps

### Step 1: Clone or Extract the Project

```bash
cd /path/to/tracker
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Create Environment File

```bash
cp .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Configure Database

Edit `.env` file and update the PostgreSQL credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=shipment_tracker
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### Step 6: Create Database

```bash
# Using PostgreSQL command line
createdb shipment_tracker
```

Or if you're using pgAdmin:
1. Right-click on "Databases"
2. Select "Create" → "Database"
3. Name it "shipment_tracker"
4. Click "Save"

### Step 7: Run Migrations

```bash
php artisan migrate
```

This creates all necessary tables in your database.

### Step 8: Seed Demo Data (Optional)

```bash
php artisan db:seed
```

This creates:
- 1 admin user (admin@example.com / password123)
- 2 sample shipments with tracking updates

### Step 9: Install Frontend Dependencies

```bash
npm install
```

### Step 10: Start the Application

In one terminal, run:

```bash
php artisan serve
```

You should see:
```
Laravel development server started at [http://127.0.0.1:8000]
```

## Accessing the Application

### Public Tracking Page
- **URL**: http://localhost:8000
- **Purpose**: Users can search for shipments by tracking code
- **No authentication required**

### Admin Dashboard
- **URL**: http://localhost:8000/admin/login
- **Email**: admin@example.com (if seeded)
- **Password**: password123 (if seeded)
- **Purpose**: Create, edit, and manage shipments

## Testing the Application

### Test Creating a Shipment

1. Go to http://localhost:8000/admin/login
2. Log in with admin@example.com / password123
3. Click "Create New Shipment"
4. Fill in all fields:
   - Sender Name: Your Name
   - Receiver Name: John Doe
   - Item Description: Test Package
   - Origin: Lagos
   - Destination: Abuja
   - Status: Processing
   - Expected Delivery: Pick a future date
5. Click "Create Shipment"
6. Copy the generated tracking code

### Test Public Tracking

1. Log out or open a new incognito tab
2. Go to http://localhost:8000
3. Paste the tracking code in the search box
4. Click Search
5. You should see your shipment details and timeline

### Add Tracking Updates

1. Go back to admin dashboard
2. Find your shipment
3. Click "Updates" button
4. Add tracking updates with:
   - Status title (e.g., "Shipped from warehouse")
   - Location (e.g., "Lagos Hub")
   - Optional note
5. Check the public tracking page to see updates appear

## Common Issues & Solutions

### Error: "SQLSTATE[08006]"
- **Cause**: Cannot connect to PostgreSQL
- **Solution**: 
  - Ensure PostgreSQL is running
  - Check DB credentials in `.env`
  - Verify database exists: `psql -l`

### Error: "Class 'App\Models\Admin' not found"
- **Cause**: Migrations haven't run
- **Solution**: Run `php artisan migrate`

### Error: "No application encryption key"
- **Cause**: APP_KEY not generated
- **Solution**: Run `php artisan key:generate`

### Blank page / 500 error
- **Cause**: Usually permission or environment issues
- **Solution**: 
  - Check `storage/` and `bootstrap/cache` directories are writable
  - Run `php artisan config:cache` to clear cache
  - Check Laravel logs: `tail -f storage/logs/laravel.log`

## Database Structure

### admins table
Stores admin user credentials for authentication

### shipments table
Main table storing shipment information with auto-generated tracking codes

### tracking_updates table
Stores timeline updates for each shipment

See `README.md` for detailed schema information.

## Useful Artisan Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tinker shell (interactive database exploration)
php artisan tinker

# Reset database (WARNING: Deletes all data!)
php artisan migrate:fresh

# Run specific migration
php artisan migrate --path=database/migrations/2024_01_01_create_shipments.php

# Create new migration
php artisan make:migration create_table_name

# Seed database
php artisan db:seed
php artisan db:seed --class=ShipmentSeeder
```

## Next Steps

1. Customize the application for your needs
2. Modify shipment statuses in the create/edit forms
3. Update email/branding in views
4. Add more tracking update fields if needed
5. Deploy to Railway (see `README.md` for deployment instructions)

## Getting Help

- Check the `README.md` for comprehensive documentation
- Review `.github/copilot-instructions.md` for development guidelines
- Check `storage/logs/laravel.log` for error details
- Visit [Laravel Documentation](https://laravel.com/docs)

---

**Happy tracking! 🚀**
