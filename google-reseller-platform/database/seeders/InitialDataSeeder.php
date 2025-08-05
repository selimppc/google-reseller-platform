<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage_plans',
            'manage_subscriptions',
            'manage_customers',
            'manage_support',
            'view_dashboard',
            'manage_billing',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to admin role
        $adminRole->givePermissionTo($permissions);

        // Assign permissions to customer role
        $customerRole->givePermissionTo(['view_dashboard']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@google-reseller.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $admin->assignRole('admin');

        // Create sample plans
        $plans = [
            [
                'name' => 'Business Starter',
                'slug' => 'business-starter',
                'price_monthly' => 1500.00,
                'price_annually' => 15000.00,
                'google_workspace_sku' => 'Google-Apps-For-Business',
                'features' => [
                    '30 GB Storage per user',
                    'Custom business email',
                    'Video and voice conferencing',
                    'Security and admin controls',
                    '24/7 phone and email support',
                    'Bangla Support'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Business Standard',
                'slug' => 'business-standard',
                'price_monthly' => 2500.00,
                'price_annually' => 25000.00,
                'google_workspace_sku' => 'Google-Apps-For-Business',
                'features' => [
                    '2 TB Storage per user',
                    'Custom business email',
                    'Video and voice conferencing',
                    'Security and admin controls',
                    '24/7 phone and email support',
                    'Bangla Support',
                    'Advanced security features'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Business Plus',
                'slug' => 'business-plus',
                'price_monthly' => 3500.00,
                'price_annually' => 35000.00,
                'google_workspace_sku' => 'Google-Apps-For-Business',
                'features' => [
                    '5 TB Storage per user',
                    'Custom business email',
                    'Video and voice conferencing',
                    'Security and admin controls',
                    '24/7 phone and email support',
                    'Bangla Support',
                    'Advanced security features',
                    'Enhanced support'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(['slug' => $planData['slug']], $planData);
        }

        // Create blog categories
        $categories = [
            [
                'name' => 'Google Workspace Tips',
                'slug' => 'google-workspace-tips',
                'description' => 'Tips and tricks for using Google Workspace effectively',
            ],
            [
                'name' => 'Business Email',
                'slug' => 'business-email',
                'description' => 'Articles about professional email setup and management',
            ],
            [
                'name' => 'Productivity',
                'slug' => 'productivity',
                'description' => 'Productivity tips and tools for businesses',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Create sample blog posts
        $posts = [
            [
                'title' => 'How to Set Up Professional Email for Your Business in Bangladesh',
                'slug' => 'how-to-setup-professional-email-business-bangladesh',
                'body' => '<p>Setting up a professional email for your business is crucial for building trust and credibility. In Bangladesh, many businesses still use free email services, but this can hurt your professional image.</p><p>With Google Workspace, you can get custom email addresses like info@yourcompany.com that look professional and trustworthy.</p><p>Here are the steps to set up professional email:</p><ol><li>Choose a domain name for your business</li><li>Sign up for Google Workspace</li><li>Configure your domain with Google</li><li>Set up email accounts for your team</li><li>Configure email clients and mobile apps</li></ol><p>Contact us to get started with professional email for your business!</p>',
                'category_id' => 2,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Benefits of Google Drive for Small and Medium Enterprises',
                'slug' => 'benefits-google-drive-sme-bangladesh',
                'body' => '<p>Google Drive offers numerous benefits for small and medium enterprises in Bangladesh. With cloud storage, you can access your files from anywhere, collaborate with team members in real-time, and never worry about losing important documents.</p><p>Key benefits include:</p><ul><li>Secure cloud storage with automatic backup</li><li>Real-time collaboration on documents</li><li>Version control and file history</li><li>Easy sharing and permissions management</li><li>Mobile access from anywhere</li></ul><p>Learn how Google Workspace can transform your business operations.</p>',
                'category_id' => 3,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'cPanel Email vs Google Workspace: Which is Better for Your Business?',
                'slug' => 'cpanel-email-vs-google-workspace-comparison',
                'body' => '<p>Many businesses in Bangladesh use cPanel email hosting, but Google Workspace offers superior features and reliability. Let\'s compare the two options:</p><h3>cPanel Email Limitations:</h3><ul><li>Limited storage space</li><li>No real-time collaboration</li><li>Basic spam protection</li><li>No mobile sync</li><li>Difficult to manage</li></ul><h3>Google Workspace Advantages:</h3><ul><li>Unlimited storage with Google Drive</li><li>Real-time collaboration tools</li><li>Advanced spam and security protection</li><li>Seamless mobile integration</li><li>Professional admin controls</li></ul><p>Make the switch to Google Workspace for better productivity and collaboration.</p>',
                'category_id' => 1,
                'status' => 'published',
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $postData) {
            Post::firstOrCreate(['slug' => $postData['slug']], array_merge($postData, ['author_id' => $admin->id]));
        }

        $this->command->info('Initial data seeded successfully!');
        $this->command->info('Admin user created: admin@google-reseller.com / password');
        $this->command->info('Sample blog posts created for SEO content marketing');
    }
}
