<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index(['status', 'next_payment_date'], 'idx_subscriptions_status_next_payment');
            $table->index(['company_id', 'status'], 'idx_subscriptions_company_status');
        });

        // Add indexes for invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->index(['status', 'due_date'], 'idx_invoices_status_due_date');
            $table->index(['company_id', 'status'], 'idx_invoices_company_status');
            $table->index('invoice_number', 'idx_invoices_number');
        });

        // Add indexes for google_workspace_instances table
        Schema::table('google_workspace_instances', function (Blueprint $table) {
            $table->index('status', 'idx_instances_status');
            $table->index(['company_id', 'status'], 'idx_instances_company_status');
        });

        // Add indexes for support_tickets table
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'idx_tickets_status_created');
            $table->index(['user_id', 'status'], 'idx_tickets_user_status');
        });

        // Add indexes for posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'idx_posts_status_published');
            $table->index('slug', 'idx_posts_slug');
        });

        // Add indexes for plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->index(['is_active', 'price_monthly'], 'idx_plans_active_price');
            $table->index('slug', 'idx_plans_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from subscriptions table
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex('idx_subscriptions_status_next_payment');
            $table->dropIndex('idx_subscriptions_company_status');
        });

        // Remove indexes from invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('idx_invoices_status_due_date');
            $table->dropIndex('idx_invoices_company_status');
            $table->dropIndex('idx_invoices_number');
        });

        // Remove indexes from google_workspace_instances table
        Schema::table('google_workspace_instances', function (Blueprint $table) {
            $table->dropIndex('idx_instances_status');
            $table->dropIndex('idx_instances_company_status');
        });

        // Remove indexes from support_tickets table
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropIndex('idx_tickets_status_created');
            $table->dropIndex('idx_tickets_user_status');
        });

        // Remove indexes from posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_status_published');
            $table->dropIndex('idx_posts_slug');
        });

        // Remove indexes from plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->dropIndex('idx_plans_active_price');
            $table->dropIndex('idx_plans_slug');
        });
    }
}; 