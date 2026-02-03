#!/bin/bash

# Railway Deployment Script - Run this after setting environment variables on Railway

echo "🚀 Starting Shipment Tracker deployment..."

# Run migrations
echo "📦 Running database migrations..."
php artisan migrate --force

# Seed database with demo data
echo "🌱 Seeding database with demo data..."
php artisan db:seed

# Cache configuration
echo "⚙️ Caching configuration..."
php artisan config:cache

# Cache views
echo "🎨 Caching views..."
php artisan view:cache

echo "✅ Deployment complete!"
echo ""
echo "Your app is ready at: https://shipment-tracker-production-ccdb.up.railway.app"
echo ""
echo "Default Admin Credentials:"
echo "Email: admin@example.com"
echo "Password: password123"
