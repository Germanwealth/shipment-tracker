# ✅ Railway Deployment - Final Setup Guide

Your DATABASE_URL is configured. Follow these exact steps:

## Step 1: Set Environment Variables on Railway

Go to your Railway project dashboard and add these variables:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://shipment-tracker-production-ccdb.up.railway.app
LOG_LEVEL=error
DATABASE_URL=postgresql://postgres:fCSilQKKhYSUPobAWMffNXJGwygLfhwp@gondola.proxy.rlwy.net:42360/railway
```

**Important:** Replace the `APP_URL` and `DATABASE_URL` with your actual Railway values.

## Step 2: Deploy

Either:
- **Auto-deploy:** Push code to GitHub (Railway auto-deploys)
- **Manual:** Click "Deploy" in Railway dashboard

Wait for deployment to complete (you'll see "✓ Deployment successful").

## Step 3: Run Migrations (if not auto-run)

Railway should auto-run migrations via Procfile. But if needed:

1. Go to Railway dashboard
2. Click your app service
3. Click the terminal icon (shell/SSH)
4. Run: 
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

## Step 4: Test the App

Visit:
- **Home Page:** https://shipment-tracker-production-ccdb.up.railway.app/
- **Admin Login:** https://shipment-tracker-production-ccdb.up.railway.app/admin/login

**Default Credentials:**
- Email: `admin@example.com`
- Password: `password123`

## Step 5: View Logs (if 500 error still appears)

1. Click on your app in Railway
2. Go to "Deployments" tab
3. Click latest deployment
4. Scroll down to see logs
5. Look for errors or "ERROR" messages

---

## Common Issues & Solutions

### Still Getting 500 Error?

**Check these in order:**

1. **Verify DATABASE_URL is set**
   - Go to Variables tab
   - Look for `DATABASE_URL`
   - Confirm it's the full URL you provided

2. **Check PostgreSQL Service**
   - Click on PostgreSQL service
   - Verify status is "Active"

3. **Check Logs for Specific Error**
   - Look for error messages in deployment logs
   - Common issues:
     - "could not connect to server" → Database URL wrong
     - "SQLSTATE" → Database error
     - "No such file" → Missing file

4. **Force Redeploy**
   - Go to Deployments
   - Click "Redeploy" on latest
   - Wait for new deployment

### Database Connection Failed?

The connection string should parse correctly. Verify:
- Host: `gondola.proxy.rlwy.net`
- Port: `42360`
- Username: `postgres`
- Password: (hidden for security)
- Database: `railway`

### Migrations Not Running?

SSH into the container and run manually:
```bash
php artisan migrate --force --seed
```

---

## What's Configured

✅ **DATABASE_URL** parsing in `config/database.php`
✅ **Procfile** with automatic migrations
✅ **Dockerfile** with proper environment setup
✅ **GitHub** with all production configs

---

## Next Steps

1. Verify all variables are set in Railway
2. Deploy the app
3. Check logs for errors
4. Access the app at your Railway URL

**You're all set! The app should now work on Railway. 🚀**
