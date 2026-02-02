# Shipment Tracker - API & Routes Reference

## Public Routes (No Authentication Required)

### Homepage / Tracking Search
```
GET /
```
- **Description**: Display the public tracking search page
- **View**: `resources/views/tracking/index.blade.php`
- **Features**:
  - Large search bar for tracking codes
  - Information about how to track
  - Admin login link

### Search Shipment
```
GET /track/{trackingCode}
Route Name: tracking.search
```
- **Description**: Search for a shipment by tracking code
- **Parameters**: `trackingCode` (string, e.g., "TRK-8F3A9C2D")
- **Response**:
  - If found: Shows shipment details + tracking timeline
  - If not found: Shows "Not Found" page
- **View**: 
  - Success: `resources/views/tracking/result.blade.php`
  - Not Found: `resources/views/tracking/not-found.blade.php`

---

## Admin Routes (Authentication Required)

### Login

#### Show Login Form
```
GET /admin/login
Route Name: admin.login
```
- **Description**: Display admin login page
- **View**: `resources/views/auth/login.blade.php`
- **Demo Credentials**: 
  - Email: admin@example.com
  - Password: password123

#### Handle Login
```
POST /admin/login
Route Name: admin.login.post
```
- **Description**: Process admin login
- **Request Body**:
  ```json
  {
    "email": "admin@example.com",
    "password": "password123",
    "remember": true (optional)
  }
  ```
- **Response**: Redirect to shipments dashboard or back with errors
- **Validation**: Email (required, valid email), Password (required, min 8 chars)

#### Handle Logout
```
POST /admin/logout
Route Name: admin.logout
Middleware: auth:admin
```
- **Description**: Logout admin user
- **Response**: Redirect to public tracking page
- **Note**: Uses POST with CSRF token (form submission)

---

## Shipment Management Routes

All shipment routes require `auth:admin` middleware

### List All Shipments
```
GET /admin/shipments
Route Name: admin.shipments.index
Middleware: auth:admin
```
- **Description**: Display all shipments in a paginated table
- **View**: `resources/views/admin/dashboard.blade.php`
- **Features**:
  - 10 shipments per page
  - Sort by latest created
  - Edit, Update, Delete actions
  - Status badges with colors
- **Response**: Blade template with paginated shipments

### Create Shipment Form
```
GET /admin/shipments/create
Route Name: admin.shipments.create
Middleware: auth:admin
```
- **Description**: Display form to create new shipment
- **View**: `resources/views/admin/shipments/create.blade.php`
- **Form Fields**:
  - Sender name (required, string, max 255)
  - Receiver name (required, string, max 255)
  - Item description (required, string, max 1000)
  - Origin (required, string, max 255)
  - Destination (required, string, max 255)
  - Current status (required, string, options: Pending, Processing, In Transit, Out for Delivery, Delivered)
  - Expected delivery date (required, date, must be after today)

### Store Shipment
```
POST /admin/shipments
Route Name: admin.shipments.store
Middleware: auth:admin
```
- **Description**: Create and store new shipment
- **Request Body**:
  ```json
  {
    "sender_name": "Tech Store Lagos",
    "receiver_name": "John Doe",
    "item_description": "Samsung Galaxy A50 Smartphone",
    "origin": "Lagos Warehouse",
    "destination": "Abuja",
    "current_status": "Processing",
    "expected_delivery_date": "2024-02-15"
  }
  ```
- **Auto-Generated**: 
  - `tracking_code` (format: TRK-XXXXXXXX, unique)
  - `created_at`, `updated_at` timestamps
- **Validation**: As per create form
- **Response**: Redirect to shipments list with success message
- **Success Message**: "Shipment created successfully!"

### Edit Shipment Form
```
GET /admin/shipments/{id}/edit
Route Name: admin.shipments.edit
Middleware: auth:admin
```
- **Description**: Display form to edit shipment
- **Parameters**: `id` (shipment ID)
- **View**: `resources/views/admin/shipments/edit.blade.php`
- **Features**:
  - Pre-filled with current shipment data
  - Cannot edit tracking code (read-only)
  - Shows creation timestamp
- **Response**: Blade template with edit form

### Update Shipment
```
PUT /admin/shipments/{id}
Route Name: admin.shipments.update
Middleware: auth:admin
```
- **Description**: Update existing shipment
- **Parameters**: `id` (shipment ID)
- **Request Body**: Same as create (excluding tracking_code)
- **Validation**: Same as create
- **Response**: Redirect to shipments list with success message
- **Success Message**: "Shipment updated successfully!"

### Delete Shipment
```
DELETE /admin/shipments/{id}
Route Name: admin.shipments.destroy
Middleware: auth:admin
```
- **Description**: Delete shipment and all its tracking updates
- **Parameters**: `id` (shipment ID)
- **Cascade**: Automatically deletes related `tracking_updates`
- **Response**: Redirect to shipments list with success message
- **Success Message**: "Shipment deleted successfully!"
- **Confirmation**: Browser confirm dialog before deletion

---

## Tracking Updates Routes

All update routes require `auth:admin` middleware

### View Tracking Updates
```
GET /admin/shipments/{id}/updates
Route Name: admin.shipments.updates
Middleware: auth:admin
```
- **Description**: Display tracking updates for a shipment
- **Parameters**: `id` (shipment ID)
- **View**: `resources/views/admin/shipments/updates.blade.php`
- **Features**:
  - Form to add new update
  - Timeline display of all updates
  - Ordered by created_at (descending)
  - Edit/delete actions (admin can manage)
  - Shipment details card
  - Quick action links

### Store Tracking Update
```
POST /admin/shipments/{id}/updates
Route Name: admin.shipments.updates.store
Middleware: auth:admin
```
- **Description**: Add tracking update to shipment
- **Parameters**: `id` (shipment ID)
- **Request Body**:
  ```json
  {
    "status_title": "Arrived at Lagos Hub",
    "location": "Lagos Distribution Center",
    "note": "Package received and scanned. Ready for next leg of journey."
  }
  ```
- **Validation**:
  - `status_title`: Required, string, max 255
  - `location`: Required, string, max 255
  - `note`: Optional, string, max 1000
- **Auto-Generated**: 
  - `created_at` timestamp
  - `shipment_id` (from route parameter)
- **Response**: Redirect to updates page with success message
- **Success Message**: "Tracking update added successfully!"

---

## Model Relationships

### Shipment Model
```php
// One shipment has many tracking updates
public function trackingUpdates(): HasMany
{
    return $this->hasMany(TrackingUpdate::class)->orderBy('created_at', 'desc');
}

// Generate unique tracking code
public static function generateTrackingCode(): string
```

### TrackingUpdate Model
```php
// Many tracking updates belong to one shipment
public function shipment(): BelongsTo
{
    return $this->belongsTo(Shipment::class);
}
```

### Admin Model
```php
// Extends Authenticatable for session-based auth
class Admin extends Authenticatable
```

---

## Request/Response Examples

### Example 1: Create Shipment

**Request:**
```bash
POST /admin/shipments
Content-Type: application/x-www-form-urlencoded
CSRF-Token: [token]

sender_name=Fashion+Hub+Nigeria&
receiver_name=Jane+Smith&
item_description=Cotton+Dresses&
origin=Lagos&
destination=Port+Harcourt&
current_status=Processing&
expected_delivery_date=2024-02-20
```

**Response:** Redirect to `/admin/shipments` with success flash

### Example 2: Public Tracking

**Request:**
```bash
GET /track/TRK-8F3A9C2D
```

**Response:** HTML page with shipment details and timeline

### Example 3: Add Tracking Update

**Request:**
```bash
POST /admin/shipments/1/updates
Content-Type: application/x-www-form-urlencoded
CSRF-Token: [token]

status_title=In+Transit&
location=Lagos-Ibadan+Route&
note=On+the+way+to+destination
```

**Response:** Redirect to `/admin/shipments/1/updates` with success flash

---

## Error Responses

### 404 Not Found
- Shipment not found in `/track/{trackingCode}`
- Shows "Tracking Code Not Found" page

### 422 Validation Error
- Invalid form data
- Redirects back with validation errors
- Form values are remembered (`old()`)

### 401 Unauthorized
- Trying to access admin routes without login
- Redirects to `/admin/login`

### 403 Forbidden
- CSRF token mismatch
- Returns 419 error

---

## HTTP Methods Used

- **GET**: Display forms and data
- **POST**: Submit forms (login, create, add updates)
- **PUT**: Update existing resources
- **DELETE**: Remove resources

---

## CSRF Protection

All POST, PUT, DELETE requests require CSRF token:
```html
<form method="POST" action="/admin/shipments">
    @csrf
    <!-- form fields -->
</form>
```

Or for DELETE via form method spoofing:
```html
<form method="POST" action="/admin/shipments/1">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
```

---

## Pagination

Shipments are paginated with 10 per page:
```
GET /admin/shipments?page=2
```

Links displayed at bottom of table automatically.

---

## Summary Table

| HTTP | Route | Name | Auth | Purpose |
|------|-------|------|------|---------|
| GET | / | tracking.index | No | Public search page |
| GET | /track/{code} | tracking.search | No | Search shipment |
| GET | /admin/login | admin.login | No | Login form |
| POST | /admin/login | admin.login.post | No | Handle login |
| POST | /admin/logout | admin.logout | Yes | Logout |
| GET | /admin/shipments | admin.shipments.index | Yes | List shipments |
| GET | /admin/shipments/create | admin.shipments.create | Yes | Create form |
| POST | /admin/shipments | admin.shipments.store | Yes | Store shipment |
| GET | /admin/shipments/{id}/edit | admin.shipments.edit | Yes | Edit form |
| PUT | /admin/shipments/{id} | admin.shipments.update | Yes | Update shipment |
| DELETE | /admin/shipments/{id} | admin.shipments.destroy | Yes | Delete shipment |
| GET | /admin/shipments/{id}/updates | admin.shipments.updates | Yes | View updates |
| POST | /admin/shipments/{id}/updates | admin.shipments.updates.store | Yes | Add update |

---

**Note**: All admin routes (Yes in Auth column) require `auth:admin` middleware.
