<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            ['name_bn' => 'প্রথম পরীক্ষা সম্পন্ন', 'name_en' => 'First Step Officer', 'code' => 'FIRST_EXAM', 'icon' => 'award', 'description_bn' => 'টার্গেট অফিসারে আপনার প্রথম মডেল টেস্ট সফলভাবে সম্পন্ন করার জন্য অর্জিত।', 'reward_coins' => 50],
            ['name_bn' => '৭ দিনের স্টাডি স্ট্রাইক', 'name_en' => '7-Day Study Warrior', 'code' => 'STREAK_7_DAYS', 'icon' => 'flame', 'description_bn' => 'টানা ৭ দিন প্ল্যাটফর্মে নিয়মিত পরীক্ষা দেওয়ার স্বীকৃতি।', 'reward_coins' => 100],
            ['name_bn' => 'নির্ভুল স্নাইপার (Accuracy 90%+)', 'name_en' => 'Accuracy Sniper', 'code' => 'ACCURACY_SNIPER', 'icon' => 'target', 'description_bn' => 'কোনো মডেল টেস্টে ৯০%+ নির্ভুলতার জন্য।', 'reward_coins' => 150],
            ['name_bn' => 'বুয়েট প্যাটার্ন মাস্টার', 'name_en' => 'BUET Pattern Master', 'code' => 'BUET_MASTER', 'icon' => 'shield-check', 'description_bn' => 'বুয়েট প্যাটার্ন পরীক্ষায় শীর্ষ স্কোর অর্জনকারী।', 'reward_coins' => 200],
            ['name_bn' => '৩০ দিনের মেগা স্ট্রাইক', 'name_en' => '30-Day Mega Streak', 'code' => 'STREAK_30_DAYS', 'icon' => 'fire', 'description_bn' => 'টানা ৩০ দিন অনুশীলন করার অসাধারণ অর্জন।', 'reward_coins' => 500],
            ['name_bn' => 'প্রশ্ন পথপ্রদর্শক (১০০+ প্রশ্ন সমাধান)', 'name_en' => '100 Questions Solved', 'code' => 'SOLVED_100', 'icon' => 'check-circle', 'description_bn' => 'মোট ১০০টির বেশি প্রশ্ন সমাধান করার জন্য।', 'reward_coins' => 120],
        ];

        foreach ($badges as $bData) {
            Badge::firstOrCreate(['code' => $bData['code']], $bData);
        }
    }
}
