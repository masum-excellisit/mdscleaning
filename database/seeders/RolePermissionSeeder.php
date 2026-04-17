<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Catalogue
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'categories.manage',
            'collections.manage',
            'attributes.manage',
            'inventory.manage',

            // Sales
            'orders.view', 'orders.update', 'orders.delete',
            'customers.view', 'customers.update',

            // Content
            'banners.manage',
            'homepage.manage',
            'blogs.manage',
            'pages.manage',
            'faqs.manage',

            // Marketing
            'coupons.manage',
            'newsletter.manage',

            // Media & Support
            'media.manage',
            'contacts.view', 'contacts.delete',

            // Configuration
            'settings.manage',
            'roles.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ROLE: super-admin (everything)
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // ROLE: admin (everything except settings + roles)
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(
            Permission::whereNotIn('name', ['settings.manage', 'roles.manage'])->get()
        );

        // ROLE: manager (catalogue + orders + customers + inventory)
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions([
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'categories.manage', 'collections.manage', 'attributes.manage', 'inventory.manage',
            'orders.view', 'orders.update',
            'customers.view', 'customers.update',
        ]);

        // ROLE: content-editor (banners, blogs, pages, faqs, homepage)
        $editor = Role::firstOrCreate(['name' => 'content-editor', 'guard_name' => 'web']);
        $editor->syncPermissions([
            'banners.manage', 'homepage.manage',
            'blogs.manage', 'pages.manage', 'faqs.manage',
            'media.manage',
        ]);

        // ROLE: order-manager (orders only)
        $orderMgr = Role::firstOrCreate(['name' => 'order-manager', 'guard_name' => 'web']);
        $orderMgr->syncPermissions(['orders.view', 'orders.update']);

        // ROLE: customer (frontend, no admin perms)
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Default super-admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@mdscleaning.com'],
            [
                'name'              => 'MDS Admin',
                'password'          => Hash::make('Admin@123'),
                'phone'             => '8179890656',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->hasRole('super-admin')) {
            $admin->assignRole('super-admin');
        }

        $this->command->info('Roles, permissions, and super-admin user created.');
        $this->command->info('Admin login: admin@mdscleaning.com / Admin@123');
    }
}
