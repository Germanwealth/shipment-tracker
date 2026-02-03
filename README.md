# Shipment Tracker

A production-ready shipment tracking web application built with Laravel, PostgreSQL, and Tailwind CSS.

## Features

✨ **Admin Dashboard** - Manage shipments with full CRUD operations
🔐 **Secure Authentication** - Admin-only access with hashed passwords  
📦 **Auto-Generated Tracking Codes** - Unique, non-guessable codes for each shipment
🌐 **Public Tracking** - Anyone can track shipments using a tracking code (no auth required)
📍 **Tracking Timeline** - Visual timeline of shipment updates with status, location, and notes
🎨 **Modern UI** - Clean, responsive design with Tailwind CSS
🗄️ **PostgreSQL Database** - Reliable data storage with proper relationships
🚀 **Railway Ready** - Easy deployment to Railway platform

## Tech Stack

- **Backend**: Laravel 11 (latest stable)
- **Database**: PostgreSQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel built-in auth system
- **Deployment**: Railway

## Quick Start

### Prerequisites

- PHP 8.2+
- Composer
- PostgreSQL 12+
- Node.js & npm (for Tailwind)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd tracker
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment variables**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure PostgreSQL**
   Edit `.env` with your PostgreSQL credentials:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=shipment_tracker
   DB_USERNAME=postgres
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed demo data (optional)**
   ```bash
   php artisan db:seed
   ```

7. **Start the application**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Public tracking: http://localhost:8000
   - Admin login: http://localhost:8000/admin/login
   - Demo credentials: admin@example.com / password123

## Project Structure

```
tracker/
├── app/
│   ├── Models/                  # Eloquent models (Admin, Shipment, TrackingUpdate)
│   ├── Http/
│   │   ├── Controllers/         # Request handlers
│   │   └── Middleware/          # Custom middleware
│   └── Kernel.php              # HTTP kernel
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/                # Demo data
├── resources/
│   └── views/                  # Blade templates
│       ├── layouts/            # Layout templates
│       ├── admin/              # Admin dashboard views
│       ├── auth/               # Authentication views
│       └── tracking/           # Public tracking views
├── routes/
│   └── web.php                 # Web routes
├── config/
│   ├── auth.php               # Authentication config
│   └── database.php           # Database config
├── .env.example               # Environment template
└── composer.json              # PHP dependencies
```

## Database Schema

### admins
- `id` - Primary key
- `name` - Admin name
- `email` - Unique email
- `password` - Hashed password
- `timestamps` - Created/updated at

### shipments
- `id` - Primary key
- `tracking_code` - Unique, auto-generated (TRK-XXXXXXXX)
- `sender_name` - Sender name
- `receiver_name` - Receiver name
- `item_description` - What's being shipped
- `origin` - Starting location
- `destination` - End location
- `current_status` - Current shipment status
- `expected_delivery_date` - Estimated delivery
- `timestamps` - Created/updated at
- `index on tracking_code` - For fast lookups

### tracking_updates
- `id` - Primary key
- `shipment_id` - Foreign key to shipments
- `status_title` - Status update title (e.g., "Arrived at Lagos Hub")
- `location` - Current location
- `note` - Optional notes
- `created_at` - Timestamp (displays in reverse chronological order)

## Core Features

### 1. Admin Dashboard
- View all shipments in a paginated table
- Create new shipments (tracking code auto-generated)
- Edit shipment details
- Delete shipments
- Manage tracking updates with timeline view

### 2. Shipment Creation
Admin can set:
- Sender name
- Receiver name
- Item description
- Origin & destination
- Initial status
- Expected delivery date

### 3. Tracking Updates
Admin can add multiple updates per shipment with:
- Status title
- Location
- Optional notes
- Auto-generated timestamp

### 4. Public Tracking
- Search by tracking code (no auth required)
- View shipment details
- See complete tracking timeline in chronological order
- Mobile-friendly interface

### 5. Authentication
- Admin login only
- Session-based authentication
- CSRF protection on all forms
- Secure password hashing

## API Routes

### Public Routes
- `GET /` - Public tracking page
- `GET /track/{trackingCode}` - Search and view shipment

### Admin Routes (Protected)
- `GET /admin/login` - Login form
- `POST /admin/login` - Handle login
- `POST /admin/logout` - Handle logout
- `GET /admin/shipments` - List all shipments
- `GET /admin/shipments/create` - Create shipment form
- `POST /admin/shipments` - Store shipment
- `GET /admin/shipments/{id}/edit` - Edit shipment form
- `PUT /admin/shipments/{id}` - Update shipment
- `DELETE /admin/shipments/{id}` - Delete shipment
- `GET /admin/shipments/{id}/updates` - View tracking updates
- `POST /admin/shipments/{id}/updates` - Add tracking update

## Deployment to Railway

1. **Push to GitHub** (if using version control)
   ```bash
   git add .
   git commit -m "Initial commit"
   git push origin main
   ```

2. **Connect to Railway**
   - Visit [railway.app](https://railway.app)
   - Create new project
   - Select GitHub repository
   - Configure environment variables in Railway dashboard

3. **Environment Variables on Railway**
   ```
   APP_KEY=your_app_key
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=pgsql
   DB_HOST=your_railway_db_host
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run migrations on Railway**
   ```bash
   railway run php artisan migrate --force
   ```

## Security Features

✓ CSRF protection on all forms
✓ Hashed password storage (bcrypt)
✓ Session-based authentication
✓ Input validation on all endpoints
✓ SQL injection prevention (Eloquent ORM)
✓ XSS protection via Blade templating
✓ Unique tracking codes (non-sequential)

## Validation Rules

**Shipment Creation/Update:**
- Sender name: Required, string, max 255
- Receiver name: Required, string, max 255
- Item description: Required, string, max 1000
- Origin: Required, string, max 255
- Destination: Required, string, max 255
- Current status: Required, string, max 255
- Expected delivery date: Required, date, after today

**Tracking Updates:**
- Status title: Required, string, max 255
- Location: Required, string, max 255
- Note: Optional, string, max 1000

## Troubleshooting

### Database Connection Error
- Ensure PostgreSQL is running
- Check `.env` database credentials
- Verify database exists: `createdb shipment_tracker`

### Migration Errors
- Run `php artisan migrate:fresh` to reset (warning: deletes data)
- Check migrations are in correct order

### Authentication Issues
- Clear session cache: `php artisan cache:clear`
- Ensure admin guard is configured in `config/auth.php`

## Testing

Create a test shipment:
1. Log in with admin@example.com / password123
2. Click "Create New Shipment"
3. Fill in all fields
4. Copy the generated tracking code
5. Log out and go to homepage
6. Search with the tracking code

## Support & Contributing

For issues or suggestions, please open an issue in the repository.

## License

This project is open source and available under the MIT License.

---

**Built with ❤️ for production-ready shipment tracking**
# Last updated: Tue Feb  3 04:00:06 PM WAT 2026
