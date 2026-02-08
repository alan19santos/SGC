<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TypeOccurrence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserAdmSeeder::class,
            ProfileSeeder::class,
            UserProfileSeeder::class,
            TypeServiceseeder::class,
            TypeOccurrenceSeeeder::class,
            TypeEmployeeSeeder::class,
            StatusOccurrenceSeeder::class,
            StatusSeeder::class,
            StatusReservedSeeder::class,
            StatusPrioritySeeder::class,
            FinancialCategorySeeder::class,
            FinancialTypeSeeder::class,
            FinancialStatusSeeder::class,
            FineReasonSeeder::class,
            ReservedSeeder::class,
        ]);
    }
}
