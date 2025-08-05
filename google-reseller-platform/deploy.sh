#!/bin/bash

# Digital Ascent BD - Production Deployment Script
# This script automates the deployment process for the Google Workspace Reseller Platform

set -e  # Exit on any error

echo "🚀 Starting Digital Ascent BD Production Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel project root directory"
    exit 1
fi

print_status "Step 1: Installing/Updating Composer Dependencies..."
composer install --no-dev --optimize-autoloader

print_status "Step 2: Installing/Updating NPM Dependencies..."
npm install
npm run build

print_status "Step 3: Clearing Application Caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

print_status "Step 4: Running Database Migrations..."
php artisan migrate --force

print_status "Step 5: Optimizing Application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

print_status "Step 6: Setting Proper Permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

print_status "Step 7: Creating Storage Symlink..."
php artisan storage:link

print_status "Step 8: Restarting Queue Workers..."
php artisan queue:restart

print_status "Step 9: Testing Application Health..."
if curl -f http://localhost/health > /dev/null 2>&1; then
    print_status "Health check passed!"
else
    print_warning "Health check failed - please verify manually"
fi

print_status "Step 10: Deployment Complete! 🎉"

echo ""
echo "📋 Post-Deployment Checklist:"
echo "  ✅ Verify SSLCOMMERZ credentials are configured"
echo "  ✅ Verify GTM container ID is set"
echo "  ✅ Verify email settings are configured"
echo "  ✅ Test payment flow end-to-end"
echo "  ✅ Verify recurring billing works"
echo "  ✅ Check all admin functions"
echo "  ✅ Test customer portal"
echo "  ✅ Verify SEO meta tags"
echo "  ✅ Test GTM conversion tracking"
echo ""

print_status "Digital Ascent BD is now live! 🚀" 