# Google Workspace Reseller Platform

A complete Laravel application for managing Google Workspace reselling business in Bangladesh. This platform provides a comprehensive solution for selling, managing, and billing Google Workspace subscriptions with local payment gateway integration.

## Features

### Customer Features
- **Professional Landing Page**: Modern, responsive homepage showcasing services
- **Dynamic Pricing Page**: Displays all available plans with features and pricing
- **Multi-step Checkout**: Complete registration and payment process
- **Customer Dashboard**: View subscription status, billing history, and manage account
- **Billing Management**: Download invoices, view payment history
- **Support System**: Create and track support tickets
- **Subscription Management**: Upgrade, downgrade, or cancel subscriptions

### Admin Features
- **Admin Dashboard**: Key metrics and business overview
- **Customer Management**: View and manage all customers
- **Provisioning Queue**: Manage Google Workspace account provisioning
- **Plan Management**: Create, edit, and manage service plans
- **Support Ticket Management**: Handle customer support requests
- **Billing Automation**: Automated recurring billing system

### Technical Features
- **Payment Gateway Integration**: SSLCOMMERZ integration for local payments
- **Role-based Access Control**: Admin and customer roles with permissions
- **Automated Billing**: Scheduled commands for recurring payments
- **PDF Invoice Generation**: Professional invoice downloads
- **Modern UI**: Built with Tailwind CSS and Alpine.js
- **Responsive Design**: Works on all devices
- **SEO Optimized**: Dynamic meta tags, sitemap generation, structured data
- **Content Marketing**: Built-in blog system for SEO content
- **Analytics Integration**: Google Tag Manager with conversion tracking

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Payment Gateway**: SSLCOMMERZ (Bangladesh)
- **PDF Generation**: DomPDF
- **Authentication**: Laravel's built-in auth with role management
- **Scheduling**: Laravel Task Scheduling
- **SEO**: Spatie Laravel Sitemap, dynamic meta tags
- **Analytics**: Google Tag Manager integration

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd google-reseller-platform
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=google_reseller
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Configure web server**
   Point your web server to the `public` directory.

### Default Admin Account
- **Email**: admin@google-reseller.com
- **Password**: password

## Configuration

### Payment Gateway Setup
1. Sign up for SSLCOMMERZ account
2. Update `.env` file with your SSLCOMMERZ credentials:
   ```
   SSLCOMMERZ_STORE_ID=your_store_id
   SSLCOMMERZ_STORE_PASSWORD=your_store_password
   SSLCOMMERZ_SANDBOX=true
   ```

### Email Configuration
Update `.env` file with your email settings:
```
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Scheduled Tasks
Set up a cron job to run Laravel's scheduler:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Usage

### For Customers
1. Visit the homepage
2. Browse plans on the pricing page
3. Select a plan and complete checkout
4. Access customer dashboard after registration
5. Manage subscription and billing

### For Admins
1. Login with admin credentials
2. Access admin dashboard
3. Manage customers, plans, and provisioning
4. Handle support tickets
5. Monitor business metrics

## Database Schema

### Core Tables
- `users` - User accounts with roles
- `companies` - Customer companies
- `plans` - Service plans and pricing
- `subscriptions` - Customer subscriptions
- `invoices` - Billing records
- `google_workspace_instances` - Google account provisioning
- `support_tickets` - Customer support system
- `categories` - Blog categories for content marketing
- `posts` - Blog posts for SEO content

## API Endpoints

### Public Routes
- `GET /` - Homepage
- `GET /pricing` - Pricing page
- `GET /checkout/{plan}` - Checkout form
- `POST /checkout` - Process checkout
- `POST /webhooks/sslcommerz` - Payment callback
- `GET /blog` - Blog index
- `GET /blog/{post:slug}` - Blog post
- `GET /blog/category/{category:slug}` - Blog category

### Customer Routes (Authenticated)
- `GET /customer/dashboard` - Customer dashboard
- `GET /customer/billing` - Billing history
- `GET /customer/subscription` - Subscription management
- `GET /support` - Support tickets

### Admin Routes (Authenticated)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/customers` - Customer management
- `GET /admin/provisioning` - Provisioning queue
- `GET /admin/plans` - Plan management
- `GET /admin/blog` - Blog management
- `GET /admin/blog/categories` - Category management

## Security Features

- **CSRF Protection**: All forms protected
- **Role-based Access**: Admin and customer roles
- **Input Validation**: Comprehensive form validation
- **SQL Injection Protection**: Eloquent ORM
- **XSS Protection**: Blade template escaping

## Deployment

### Production Checklist
1. Set `APP_ENV=production` in `.env`
2. Configure production database
3. Set up SSL certificate
4. Configure web server (Apache/Nginx)
5. Set up cron jobs for scheduled tasks
6. Configure backup system
7. Set up monitoring and logging

### Server Requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 15+
- Web server (Apache/Nginx)
- SSL certificate
- Cron job support

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support, please contact:
- Email: support@yourdomain.com
- Documentation: [Link to documentation]

## Changelog

### Version 1.0.0
- Initial release
- Complete customer and admin functionality
- Payment gateway integration
- Automated billing system
- Support ticket system
