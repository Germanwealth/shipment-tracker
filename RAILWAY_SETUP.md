# Railway Deployment Setup

This guide explains how to properly deploy the Shipment Tracker on Railway.

## Prerequisites
- Railway account
- PostgreSQL database service added to your Railway project
- Docker/Container deployment enabled

## Step-by-Step Setup

### 1. Create Database Service (if not already created)
In Railway Dashboard:
1. Click "New" → "Database" → "PostgreSQL"
2. This will automatically create the database and set environment variables

### 2. Set Environment Variables in Railway
Go to your project settings and add these variables:

| Variable | Value | Note |
|----------|-------|------|
| `APP_ENV` | `production` | Production mode |
| `APP_DEBUG` | `false` | Disable debug mode |
| `APP_URL` | `https://shipment-tracker-production-ccdb.up.railway.app` | Your Railway domain |
| `LOG_LEVEL` | `error` | Production logging |

### 3. Database Variables (automatically set by Railway)
These are automatically provided by the PostgreSQL service:
- `DATABASE_HOST`
- `DATABASE_PORT`
- `DATABASE_NAME`
- `DATABASE_USERNAME`
- `DATABASE_PASSWORD`

### 4. Deploy and Run Migrations
After pushing to GitHub:
1. Railway will automatically deploy from your GitHub repo
2. The release phase in `Procfile` will run migrations automatically:
   ```
   release: php artisan migrate --force
   ```

### 5. Verify Deployment
Once deployed, test these URLs:
- Home page: `https://shipment-tracker-production-ccdb.up.railway.app/`
- Admin login: `https://shipment-tracker-production-ccdb.up.railway.app/admin/login`

### 6. Default Admin Credentials (after seeding)
- Email: `admin@example.com`
- Password: `password123`

## Troubleshooting

### 500 Error on First Deploy
This usually means:
1. Database migrations haven't run yet
2. Environment variables aren't set
3. APP_KEY is missing

**Solution:** The Procfile's release phase will handle migrations automatically on first deploy.

### Database Connection Failed
Check that:
1. PostgreSQL service is running in Railway
2. Database environment variables are properly set
3. The app can reach the database host

### View Logs
In Railway Dashboard:
1. Go to your project
2. Click "Deployments"
3. Select the latest deployment
4. View logs in real-time

## Local Development

For local development, use Docker:
```bash
docker-compose up -d
docker-compose exec -T app php artisan migrate
docker-compose exec -T app php artisan db:seed
```

Then visit `http://localhost:8000`

## File Structure Reference

- `.env` - Local development environment
- `.env.example` - Railway production template
- `Dockerfile` - Container configuration
- `Procfile` - Railway release and process definitions
- `docker-compose.yml` - Local Docker setup

## Important Notes

- Never commit `.env` with sensitive credentials to GitHub
- `.env.example` is a template for Railway
- Railway automatically provides database credentials as environment variables
- The app runs on port 8080 internally, exposed as 80 to the web
