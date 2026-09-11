<?php

namespace Database\Seeders;

use App\Models\CurrentAffair;
use Illuminate\Database\Seeder;

class CurrentAffairsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title_bn' => 'বাংলাদেশের জাতীয় অর্থনৈতিক প্রবৃদ্ধি ও চলতি অর্থবছরের বাজেট হাইলাইটস',
                'title_en' => 'National Economic Growth & Budget Highlights',
                'category' => 'economy',
                'category_bn' => 'অর্থনীতি ও বাজেট',
                'month_key' => '2026-09',
                'published_date' => '2026-09-08',
                'is_featured' => true,
                'summary_bn' => 'চলতি অর্থবছরে মূল্যস্ফীতি নিয়ন্ত্রণ, রপ্তানি বহুমুখীকরণ এবং বৈদেশিক মুদ্রার রিজার্ভ সুরক্ষায় কেন্দ্রীয় ব্যাংকের নতুন মুদ্রানীতি ও নীতিগত সংস্কার গৃহীত হয়েছে।',
                'details_bn' => 'বাংলাদেশ ব্যাংক ও অর্থ মন্ত্রণালয়ের যৌথ পর্যালোচনায় রাজস্ব ঘাটতি হ্রাস ও সিঙ্গেল ডিজিট মূল্যস্ফীতি নিশ্চিতকরণে সমন্বিত কার্যক্রম শুরু হয়েছে। এছাড়া রেমিট্যান্স প্রবাহ বাড়াতে প্রণোদনা ব্যবস্থার আধুনিকায়ন করা হয়েছে।',
                'mini_quiz' => [
                    [
                        'question' => 'চলতি অর্থবছরে সর্বোচ্চ বরাদ্দ কোন খাতে দেওয়া হয়েছে?',
                        'options' => ['শিক্ষা ও প্রযুক্তি', 'পরিবহন ও যোগাযোগ', 'স্বাস্থ্যসেবা', 'কৃষি ও পল্লি উন্নয়ন'],
                        'correct_answer' => 'শিক্ষা ও প্রযুক্তি',
                    ],
                    [
                        'question' => 'বৈদেশিক মুদ্রার রিজার্ভ গণনা পদ্ধতিকে কী বলা হয়?',
                        'options' => ['BPM6', 'GDP Deflator', 'NDP Matrix', 'SWIFT Core'],
                        'correct_answer' => 'BPM6',
                    ],
                ],
            ],
            [
                'title_bn' => 'জাতিসংঘ সাধারণ পরিষদের ৮১তম অধিবেশন ও বৈশ্বিক জলবায়ু রূপরেখা',
                'title_en' => '81st UN General Assembly & Global Climate Framework',
                'category' => 'international',
                'category_bn' => 'আন্তর্জাতিক বিষয়াবলী',
                'month_key' => '2026-09',
                'published_date' => '2026-09-05',
                'is_featured' => false,
                'summary_bn' => 'নিউইয়র্কে জাতিসংঘের সাধারণ পরিষদের অধিবেশনে উন্নয়নশীল দেশগুলোর জন্য জলবায়ু অভিযোজন তহবিল (Loss and Damage Fund) কার্যকরভাবে বাস্তবায়নের ওপর জোর দেওয়া হয়।',
                'details_bn' => 'বিশ্ব নেতাদের উপস্থিতিতে নবায়নযোগ্য শক্তির ব্যবহার দ্বিগুণ করা এবং ২০৩০ সালের মধ্যে কার্বন নির্গমন উল্লেখযোগ্য পরিমাণে কমানোর নতুন রোডম্যাপে ঐক্যমত্য প্রতিষ্ঠিত হয়েছে।',
                'mini_quiz' => [
                    [
                        'question' => 'জাতিসংঘের সদর দপ্তর কোথায় অবস্থিত?',
                        'options' => ['নিউইয়র্ক, যুক্তরাষ্ট্র', 'জেনেভা, সুইজারল্যান্ড', 'প্যারিস, ফ্রান্স', 'লন্ডন, যুক্তরাজ্য'],
                        'correct_answer' => 'নিউইয়র্ক, যুক্তরাষ্ট্র',
                    ],
                ],
            ],
            [
                'title_bn' => 'বঙ্গবন্ধু টানেল ও রূপপুর পারমাণবিক বিদ্যুৎ কেন্দ্রের বাণিজ্যিক কার্যক্রম',
                'title_en' => 'Bangabandhu Tunnel & Rooppur Nuclear Power Commercial Status',
                'category' => 'bangladesh',
                'category_bn' => 'বাংলাদেশ বিষয়াবলী',
                'month_key' => '2026-09',
                'published_date' => '2026-09-02',
                'is_featured' => false,
                'summary_bn' => 'দক্ষিণ এশিয়ায় নদীর তলদেশে নির্মিত প্রথম টানেল "বঙ্গবন্ধু শেখ মুজিবুর রহমান টানেল" কর্ণফুলী নদীর তলদেশে ৩.৩২ কিলোমিটার দীর্ঘ ও জাতীয় অর্থনীতির প্রবৃদ্ধিতে মাইলফলক।',
                'details_bn' => 'রূপপুর পারমাণবিক বিদ্যুৎ কেন্দ্র জাতীয় গ্রিডে বিদ্যুৎ সরবরাহের মাধ্যমে ক্লিন এনার্জি খাতে বাংলাদেশের নতুন অধ্যায় সূচনা করেছে। রাশিয়ার সহযোগিতায় ভিভিইআর-১২০০ রিঅ্যাক্টর প্রযুক্তি ব্যবহৃত হয়েছে।',
                'mini_quiz' => [
                    [
                        'question' => 'কর্ণফুলী টানেলের দৈর্ঘ্য কত কিলোমিটার?',
                        'options' => ['৩.৩২ কিমি', '৪.১৫ কিমি', '২.৮০ কিমি', '৩.৭৫ কিমি'],
                        'correct_answer' => '৩.৩২ কিমি',
                    ],
                ],
            ],
            [
                'title_bn' => 'কৃত্রিম বুদ্ধিমত্তা (AI) নিয়ন্ত্রণ ও আন্তর্জাতিক সাইবার সুরক্ষা চুক্তি ২০২৬',
                'title_en' => 'Global AI Safety & Cyber Security Treaty 2026',
                'category' => 'science',
                'category_bn' => 'বিজ্ঞান ও প্রযুক্তি',
                'month_key' => '2026-09',
                'published_date' => '2026-09-01',
                'is_featured' => false,
                'summary_bn' => 'বিশ্বের ৬০টি দেশের সম্মতিক্রমে জেনারেটিভ এআই এবং ডিপফেক প্রতিরোধে প্রথম বহুপাক্ষিক আন্তর্জাতিক ডিজিটাল সুরক্ষা চুক্তি স্বাক্ষরিত হয়েছে।',
                'details_bn' => 'এই চুক্তির আওতায় এআই মডেলের ট্রেনিং ডাটা নিরীক্ষা, অ্যালগরিদমিক স্বচ্ছতা এবং নাগরিক গোপনীয়তা সুরক্ষায় সার্বজনীন মানদণ্ড নির্ধারণ করা হয়েছে।',
                'mini_quiz' => [
                    [
                        'question' => 'কম্পিউটার নিরাপত্তায় ব্যবহৃত SSL এর পূর্ণরূপ কী?',
                        'options' => ['Secure Sockets Layer', 'System Security Link', 'Server Socket Level', 'Shared Security Layer'],
                        'correct_answer' => 'Secure Sockets Layer',
                    ],
                ],
            ],
        ];

        foreach ($articles as $article) {
            CurrentAffair::updateOrCreate(
                [
                    'title_bn' => $article['title_bn'],
                    'month_key' => $article['month_key'],
                ],
                $article
            );
        }
    }
}
