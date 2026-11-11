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
        // 1. Seed Roles and Permissions
        $this->call(RoleAndPermissionSeeder::class);

        // 2. Create Default Super Admin
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
        $superAdmin->syncRoles(['super-admin']);

        // 3. Create Default Member
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
    }
}
