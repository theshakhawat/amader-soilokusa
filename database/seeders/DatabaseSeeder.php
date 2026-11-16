<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles & Permissions (First priority: foundational security layer)
        $this->call(RoleAndPermissionSeeder::class);

        // 2. Default Administrative and Standard Users
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@agamirshailkupa.org'],
            [
                'name' => 'সুপার অ্যাডমিন',
                'phone' => '01700123456',
                'password' => Hash::make('Admin@123456'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->syncRoles(['admin']);

        $member = User::firstOrCreate(
            ['email' => 'member@agamirshailkupa.org'],
            [
                'name' => 'সাধারণ সদস্য',
                'phone' => '01800123456',
                'password' => Hash::make('Member@123456'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $member->syncRoles(['member']);

        // 3. Site Settings, Navigation & Chrome Customizations
        $this->call([
            SiteCustomizationSeeder::class,
            TopbarSeeder::class,
            HeroBannerSeeder::class,
            NavItemSeeder::class,
        ]);

        // 4. Content & Dynamic Modules (with proper dependency order)
        $this->call([
            // Blog Categories and Posts (Categories are seeded first inside BlogSeeder)
            BlogSeeder::class,

            // Institutions (Categories seeded first, then institutions, images & members)
            InstitutionSeeder::class,

            // Committees & Executive Members
            CommitteeSeeder::class,

            // Upazila Unions & Parishads
            UnionSeeder::class,

            // Public & Govt Offices
            OfficeSeeder::class,

            // Events & Photos
            EventSeeder::class,

            // Notices & Attachments
            NoticeSeeder::class,

            // Development Projects & Photos
            ProjectSeeder::class,

            // Historic & Tourist Places
            PlaceSeeder::class,

            // Pride Personalities
            PrideSeeder::class,

            // Person Messages & Speeches
            PersonMessageSeeder::class,

            // Photo & Video Gallery Media
            GallerySeeder::class,

            // Dynamic Custom Pages
            PageSeeder::class,

            // Donations & Fund Management
            DonationSeeder::class,

            // Admin Global Quick Search Items Catalog
            AdminSearchItemSeeder::class,
        ]);
    }
}
