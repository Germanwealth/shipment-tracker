# 🔧 Production 500 Error - Complete Debugging Guide

## The Issue
The app works locally but returns 500 errors in production on Railway.

## Root Cause
Without seeing the actual error, the most common causes are:
1. **Database connection failed** - DATABASE_URL not set or wrong
2. **Storage permissions** - Can't write to `/storage` or `/bootstrap/cache`
3. **Laravel bootstrap error** - Config cache or view cache failed
4. **Missing environment variables** - APP_KEY, APP_DEBUG, etc.

## Solution - Follow These Steps Exactly

### Step 1: Add All Required Environment Variables on Railway

Go to Railway Dashboard → Your App → Variables tab and add **all** of these:

```
APP_NAME=Shipment Tracker
APP_ENV=production
APP_KEY=base64:n8qjOmaLS4SyxbLSbhGeBlKy92fJiJ2rB6oeHOtLTUU=
APP_DEBUG=true
APP_URL=https://shipment-tracker-production-ccdb.up.railway.app
LOG_CHANNEL=stack
LOG_LEVEL=debug
DATABASE_URL=postgresql://postgres:fCSilQKKhYSUPobAWMffNXJGwygLfhwp@gondola.proxy.rlwy.net:42360/railway
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

**Note:** `APP_DEBUG=true` is temporary - it shows actual errors. We'll set it to `false` after debugging.

### Step 2: Redeploy

1. Go to **Deployments** tab
2. Click the three dots on latest deployment
3. Click **Redeploy**
4. Wait for it to finish

### Step 3: Check the Debug Endpoint

Visit: `https://shipment-tracker-production-ccdb.up.railway.app/debug.php`

This will show you:
- ✓/✗ Environment variables
- ✓/✗ Storage directory permissions
- ✓/✗ Database connection test
- ✓/✗ Laravel bootstrap status

**Report what you see at the debug endpoint!**

### Step 4: Check Railway Logs

1. Click on your app in Railway
2. Go to **Deployments** tab
3. Click on latest deployment
4. **Scroll down and copy the full logs**

Look for lines that say:
- `ERROR`
- `Exception`
- `SQLSTATE`
- `Connection refused`

### Step 5: Check Docker Logs (Advanced)

If you have Railway CLI installed:
```bash
railway logs
```

---

## What Changed in the Latest Update

✅ **Better error handling** - Now shows actual PHP errors
✅ **Debug mode enabled** - Set `APP_DEBUG=true` so you can see the error
✅ **Storage permissions fixed** - Made storage writable
✅ **Debug endpoint added** - `/debug.php` shows everything
✅ **Database test added** - Checks connection on startup

---

## Immediate Action Items

1. **Add all environment variables** (see Step 1 above)
2. **Set `APP_DEBUG=true`** (shows real errors)
3. **Redeploy** 
4. **Visit `/debug.php`** endpoint
5. **Report what you see**

---

## If Still Failing

After doing these steps, run `/debug.php` and tell me:

1. Does the debug page load?
2. What does it say about database connection?
3. What are the storage directory permissions?
4. What error appears in the logs?

Then I can fix the specific issue!

---

## After It Works

Once it's working, change:
```
APP_DEBUG=false
LOG_LEVEL=error
```

To hide errors from the public (security best practice).

---

**Push code, redeploy, check `/debug.php`, then report what you see!** 🚀
