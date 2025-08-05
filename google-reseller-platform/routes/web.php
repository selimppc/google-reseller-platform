<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');

// Checkout routes
Route::get('/checkout/{plan}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Payment routes
Route::get('/payment/{invoice}', function ($invoice) {
    // Simulate payment gateway
    return view('payment.process', compact('invoice'));
})->name('payment.process');

Route::post('/checkout/callback', [CheckoutController::class, 'paymentCallback'])->name('checkout.callback');

// Webhook routes
Route::post('/webhooks/sslcommerz', [WebhookController::class, 'sslcommerzCallback'])->name('webhooks.sslcommerz');
Route::post('/webhooks/payment-ipn', [WebhookController::class, 'paymentIpn'])->name('webhooks.payment-ipn');

// Authentication routes
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Customer routes
    Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/billing', [CustomerController::class, 'billingHistory'])->name('billing');
        Route::get('/billing/{invoice}/download', [CustomerController::class, 'downloadInvoice'])->name('billing.download');
        Route::get('/subscription', [CustomerController::class, 'subscription'])->name('subscription');
        Route::post('/subscription/cancel', [CustomerController::class, 'cancelSubscription'])->name('subscription.cancel');
    });

    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{company}', [AdminController::class, 'customerDetails'])->name('customers.details');
        Route::get('/provisioning', [AdminController::class, 'provisioningQueue'])->name('provisioning');
        Route::post('/provisioning/{instance}', [AdminController::class, 'updateInstance'])->name('provisioning.update');
        Route::get('/plans', [AdminController::class, 'plans'])->name('plans');
        Route::post('/plans', [AdminController::class, 'storePlan'])->name('plans.store');
        Route::put('/plans/{plan}', [AdminController::class, 'updatePlan'])->name('plans.update');
        Route::post('/plans/{plan}/toggle', [AdminController::class, 'togglePlan'])->name('plans.toggle');
        
        // Blog management
        Route::get('/blog', [Admin\BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [Admin\BlogController::class, 'create'])->name('blog.create');
        Route::post('/blog', [Admin\BlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{post}/edit', [Admin\BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{post}', [Admin\BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{post}', [Admin\BlogController::class, 'destroy'])->name('blog.destroy');
        Route::get('/blog/categories', [Admin\BlogController::class, 'categories'])->name('blog.categories');
        Route::post('/blog/categories', [Admin\BlogController::class, 'storeCategory'])->name('blog.categories.store');
        Route::put('/blog/categories/{category}', [Admin\BlogController::class, 'updateCategory'])->name('blog.categories.update');
        Route::delete('/blog/categories/{category}', [Admin\BlogController::class, 'destroyCategory'])->name('blog.categories.destroy');
    });

    // Support routes
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::get('/create', [SupportController::class, 'create'])->name('create');
        Route::post('/', [SupportController::class, 'store'])->name('store');
        Route::get('/{ticket}', [SupportController::class, 'show'])->name('show');
        
        // Admin support routes
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [SupportController::class, 'adminIndex'])->name('index');
            Route::post('/{ticket}/status', [SupportController::class, 'updateStatus'])->name('status');
            Route::post('/{ticket}/reply', [SupportController::class, 'reply'])->name('reply');
        });
    });
});

require __DIR__.'/auth.php';
