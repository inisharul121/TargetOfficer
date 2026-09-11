<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TaxonomySeeder::class,
            BadgesSeeder::class,
            Bcs10thSeeder::class,
            Bcs11thSeeder::class,
            Bcs12thSeeder::class,
            Bcs13thSeeder::class,
            Bcs14thSeeder::class,
            Bcs15thSeeder::class,
            Bcs16thSeeder::class,
            Bcs17thSeeder::class,
            Bcs23rdSeeder::class,
            QuestionExplanationSeeder::class,
            LiveExamSeeder::class,
            StudyRoutineSeeder::class,
            FlashcardSeeder::class,
            CurrentAffairsSeeder::class,
            DigitalBookSeeder::class,
        ]);
    }
}
