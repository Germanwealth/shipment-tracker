# 🚀 Complete Railway Deployment Checklist

Follow these steps to fix the 500 error and get your app running on Railway.

## ✅ Step 1: Update Railway Environment Variables

**Go to your Railway project dashboard and add these variables:**

### Essential Variables
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://shipment-tracker-production-ccdb.up.railway.app
LOG_LEVEL=error
```

Replace the URL with your actual Railway domain if different.

### Database Variables (Should be auto-set by PostgreSQL service)
These should already exist from your PostgreSQL service:
- `DATABASE_HOST`
- `DATABASE_PORT`
- `DATABASE_NAME`
- `DATABASE_USERNAME`
- `DATABASE_PASSWORD`

**If these don't exist, add them manually with your PostgreSQL connection details.**

---

## ✅ Step 2: Check PostgreSQL Service

1. In Railway Dashboard, go to your project
2. Verify PostgreSQL service is running (status should be "Active")
3. If not running, click "Deploy" to start it

---

## ✅ Step 3: Trigger Redeploy

After setting environment variables:
1. Go to "Deployments" section
2. Click "Redeploy" on the latest deployment
3. Or make a new commit and push to GitHub to trigger auto-deploy

---

## ✅ Step 4: Monitor Logs

1. Click on the latest deployment
2. View logs in real-time
3. Look for these messages:
   ```
   Starting Shipment Tracker...
   Configuration cached successfully
   Blade templates cached successfully
   Starting PHP-FPM...
   Starting Nginx...
   ```

---

## ✅ Step 5: Database Migrations

The Procfile automatically runs migrations on deployment:
```
release: php artisan migrate --force
```

This will run automatically during the release phase.

---

## ✅ Step 6: Test the Application

Once deployment completes:

1. **Visit Home Page:**
   ```
   https://shipment-tracker-production-ccdb.up.railway.app/
   ```
   Should show the tracking form (not 500 error)

2. **Visit Admin Login:**
   ```
   https://shipment-tracker-production-ccdb.up.railway.app/admin/login
   ```
   Should show login page

3. **Default Admin Credentials:**
   - Email: `admin@example.com`
   - Password: `password123`

---

## 🔧 Troubleshooting

### Still Getting 500 Error?

**Check these things in order:**

1. **Environment Variables**
   - Open Railway Dashboard → Variables
   - Verify all variables are set (APP_ENV, APP_DEBUG, APP_URL, LOG_LEVEL)
   - Check that DATABASE_* variables exist

2. **PostgreSQL Service**
   - Go to Services tab
   - Verify PostgreSQL is running and healthy
   - Click on PostgreSQL service and check its logs

3. **Recent Deployment Logs**
   - Click on latest deployment
   - Scroll through logs for errors
   - Look for "ERROR" or "Exception"

4. **Manually Run Migrations**
   - If logs show database errors, migrations may not have run
   - SSH into Railway shell and run: `php artisan migrate --force`

### How to SSH into Railway Container

1. Click your app service
2. Look for terminal/shell icon
3. Run: `php artisan migrate --force`
4. Run: `php artisan db:seed` (to add test data)

---

## 📝 What We've Done

✅ Updated `.env.example` for Railway production
✅ Updated `Dockerfile` to properly handle environment setup
✅ Added `Procfile` with release phase for migrations
✅ Pushed all changes to GitHub
✅ Created this deployment guide

---

## 🎯 Quick Reference

| Action | Command |
|--------|---------|
| View logs | Railway Dashboard → Deployments → Click deployment |
| SSH to container | Railway Dashboard → App → Terminal |
| Run migrations | `php artisan migrate --force` |
| Seed database | `php artisan db:seed` |
| Check config | `php artisan config:show` |

---

## 📞 Still Need Help?

1. Check `RAILWAY_SETUP.md` for detailed setup info
2. Review Railway logs for specific error messages
3. Verify all environment variables are set correctly
4. Ensure PostgreSQL service is healthy

---

**Your deployment is now configured and should work! 🎉**
