<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Dom\Attr;
use Illuminate\Container\Attributes\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


$this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            AttributeSeeder::class,
            CouponSeeder::class,
            CountrySeeder::class,
            GovernorateSeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            FaqSeeder::class,
    
        ]);
    }
}
