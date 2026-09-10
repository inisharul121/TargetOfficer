<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamType;
use App\Models\ExamYear;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionTag;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Bcs10thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '10th')->first();
        $admin = User::where('role', 'admin')->first();

        // 1. Create or Find Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '10th-bcs-preliminary'],
            [
                'title_bn' => '১০ম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '10th BCS Preliminary Question Solution',
                'description_bn' => '১০ম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন ও সঠিক উত্তর সমাধান।',
                'description_en' => 'Complete 100 questions and solutions of the 10th BCS Preliminary Examination.',
                'exam_mode' => 'previous_year',
                'organization_id' => $bpsc?->id,
                'exam_type_id' => $examType?->id,
                'exam_year_id' => $examYear?->id,
                'total_questions' => 100,
                'total_marks' => 100.00,
                'duration_minutes' => 60,
                'pass_percentage' => 50.00,
                'negative_mark_per_question' => 0.50,
                'is_published' => true,
                'is_premium' => false,
                'allow_pause' => true,
                'shuffle_questions' => false,
                'shuffle_options' => false,
                'show_instant_result' => true,
                'created_by' => $admin?->id,
            ]
        );

        // Subject caches
        $subjects = [
            'bangla' => Subject::where('slug', 'bangla')->first()?->id,
            'english' => Subject::where('slug', 'english')->first()?->id,
            'bangladesh' => Subject::where('slug', 'bangladesh-affairs')->first()?->id,
            'international' => Subject::where('slug', 'international-affairs')->first()?->id,
            'science' => Subject::where('slug', 'science-technology')->first()?->id,
            'math' => Subject::where('slug', 'math-mental-ability')->first()?->id,
        ];

        $questionsData = [
            // ==========================================
            // বাংলা ভাষা ও সাহিত্য (১ - ১৮)
            // ==========================================
            [
                'stem' => '‘আনারস’ এবং ‘চাবি’ শব্দ দুটি বাংলা ভাষা গ্রহণ করেছে-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'পর্তুগিজ ভাষা হতে', true],
                    ['B', 'আরবি ভাষা হতে', false],
                    ['C', 'দেশি ভাষা হতে', false],
                    ['D', 'ওলন্দাজ ভাষা হতে', false],
                ],
            ],
            [
                'stem' => 'শুদ্ধ বানান কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'মূমুষু', false],
                    ['B', 'মুমূর্ষু', true],
                    ['C', 'মূমর্ষু', false],
                    ['D', 'মুমূর্ষ', false],
                ],
            ],
            [
                'stem' => 'শুদ্ধ বাক্য কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'দুর্বলতাবশত অনাথিনী বসে পড়ল', false],
                    ['B', 'দুর্বলতাবশত অনাথিনী বসে পড়লো', false],
                    ['C', 'দুর্বলতাবশত অনাথা বসে পড়ল', true],
                    ['D', 'দুর্বলতাবশতঃ অনাথা বসে পড়ল', false],
                ],
            ],
            [
                'stem' => 'গুরুচণ্ডালী দোষমুক্ত কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'শবপোড়া', false],
                    ['B', 'মড়াদাহ', false],
                    ['C', 'শবদাহ', true],
                    ['D', 'শবমড়া', false],
                ],
            ],
            [
                'stem' => '‘কবর’ নাটকটির লেখক-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'জসীমউদ্‌দীন', false],
                    ['B', 'নজরুল ইসলাম', false],
                    ['C', 'মুনীর চৌধুরী', true],
                    ['D', 'দ্বিজেন্দ্রলাল রায়', false],
                ],
            ],
            [
                'stem' => 'বাংলায় কোরআন শরীফের প্রথম অনুবাদক কে?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'কেশবচন্দ্র সেন', false],
                    ['B', 'মওলানা মনিরুজ্জামান ইসলামাবাদী', false],
                    ['C', 'মওলানা আকরম খাঁ', false],
                    ['D', 'গিরিশচন্দ্র সেন', true],
                ],
            ],
            [
                'stem' => '‘রত্নাকর’ শব্দটির সন্ধি-বিচ্ছেদ-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'রত্ন + কর', false],
                    ['B', 'রত্না + কর', false],
                    ['C', 'রত্ন + আকর', true],
                    ['D', 'রত্না + আকর', false],
                ],
            ],
            [
                'stem' => 'ক্রিয়াপদের মূল অংশকে বলা হয়-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'বিভক্তি', false],
                    ['B', 'ধাতু', true],
                    ['C', 'প্রত্যয়', false],
                    ['D', 'কৃৎ', false],
                ],
            ],
            [
                'stem' => 'বাংলায় টি. এস. এলিয়টের কবিতার প্রথম অনুবাদক-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'রবীন্দ্রনাথ ঠাকুর', true],
                    ['B', 'বিষ্ণু দে', false],
                    ['C', 'সুধীন্দ্রনাথ দত্ত', false],
                    ['D', 'বুদ্ধদেব বসু', false],
                ],
            ],
            [
                'stem' => '‘অগ্নিবীণা’ কাব্যগ্রন্থের সংকলিত প্রথম কবিতা-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'অগ্রপথিক', false],
                    ['B', 'বিদ্রোহী', false],
                    ['C', 'প্রলয়োল্লাস', true],
                    ['D', 'ধূমকেতু', false],
                ],
            ],
            [
                'stem' => '‘শেষের কবিতা’ রবীন্দ্রনাথ রচিত-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'কবিতার নাম', false],
                    ['B', 'গল্প সংকলনের নাম', false],
                    ['C', 'উপন্যাসের নাম', true],
                    ['D', 'কাব্য সংকলনের নাম', false],
                ],
            ],
            [
                'stem' => '‘আমার ভাইয়ের রক্তে রাঙানো ২১ শে ফেব্রুয়ারি’র রচয়িতা কে?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'শামসুর রাহমান', false],
                    ['B', 'আলতাফ মাহমুদ', false],
                    ['C', 'হাসান হাফিজুর রহমান', false],
                    ['D', 'আবদুল গাফফার চৌধুরী', true],
                ],
            ],
            [
                'stem' => 'কোন দ্বিরুক্তি শব্দজুটি বহুবচন সংকেত করে?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'পাকা পাকা আম', true],
                    ['B', 'ছি ছি কি করছ', false],
                    ['C', 'নরম নরম হাত', false],
                    ['D', 'উড়ু উড়ু মন', false],
                ],
            ],
            [
                'stem' => 'কোন প্রবচন বাক্য ব্যবহারিক দিক হতে সঠিক?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'যত গর্জে তত বৃষ্টি হয় না', false],
                    ['B', 'অধিক সন্ন্যাসীতে গাজন নষ্ট', true],
                    ['C', 'নাচতে না জানলে উঠোন ভাঙ্গা', false],
                    ['D', 'যেখানে বাঘের ভয় সেখানে বিপদ হয়', false],
                ],
            ],
            [
                'stem' => 'কোন বাক্যে ‘মাথা’ শব্দটি বুদ্ধি অর্থে ব্যবহৃত?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'তিনিই সমাজের মাথা', false],
                    ['B', 'মাথা খাটিয়ে কাজ করবে', true],
                    ['C', 'লজ্জায় আমার মাথা কাটা গেল', false],
                    ['D', 'মাথা নেই তার মাথা ব্যথা', false],
                ],
            ],
            [
                'stem' => 'কোন শব্দে বিদেশি উপসর্গ ব্যবহৃত হয়েছে?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'নিখুঁত', false],
                    ['B', 'আনমনা', false],
                    ['C', 'অবহেলা', false],
                    ['D', 'নিমরাজি', true],
                ],
            ],
            [
                'stem' => 'কোনটি তদ্ভব শব্দ?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'চাঁদ', true],
                    ['B', 'সূর্য', false],
                    ['C', 'নক্ষত্র', false],
                    ['D', 'গগন', false],
                ],
            ],
            [
                'stem' => '‘উভয়কূল রক্ষা’ অর্থে ব্যবহৃত প্রবচন কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'কারো পৌষ মাস, কারও সর্বনাশ', false],
                    ['B', 'চাল না চুলো, ঢেঁকি না কুলো', false],
                    ['C', 'সাপও মরে, লাঠিও না ভাঙ্গে', true],
                    ['D', 'বোঝার উপর, শাকের আঁটি', false],
                ],
            ],

            // ==========================================
            // English Language & Literature (১৯ - ৩৪)
            // ==========================================
            [
                'stem' => 'Choose the correct alternative to complete the sentence: "He ____ to see us if he had been able to"',
                'subject' => 'english',
                'options' => [
                    ['A', 'would come', false],
                    ['B', 'would have come', true],
                    ['C', 'may have come', false],
                    ['D', 'may come', false],
                ],
            ],
            [
                'stem' => 'Choose the appropriate alternative to complete the sentence: "He had a .... of fever."',
                'subject' => 'english',
                'options' => [
                    ['A', 'strong attack', false],
                    ['B', 'severe attack', true],
                    ['C', 'serious kind', false],
                    ['D', 'bad attack', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence:',
                'subject' => 'english',
                'options' => [
                    ['A', 'I asked Javed had he passed', false],
                    ['B', 'I asked Javed if he had passed', true],
                    ['C', 'I asked Javed if you had passed', false],
                    ['D', 'I asked Javed that had he passed', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence:',
                'subject' => 'english',
                'options' => [
                    ['A', 'A few of the three boys got a prize', false],
                    ['B', 'Each of the three boys got a prize', true],
                    ['C', 'Every of the three boys got a prize', false],
                    ['D', 'All of the three boys got a prize', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence:',
                'subject' => 'english',
                'options' => [
                    ['A', 'The man said that was a fool', false],
                    ['B', 'The man who said that was a fool', true],
                    ['C', 'The man that said that was a fool', false],
                    ['D', 'The man which said that was a fool', false],
                ],
            ],
            [
                'stem' => 'Choose the correct answer: "How long did you wait?"',
                'subject' => 'english',
                'options' => [
                    ['A', 'Till lunch time', false],
                    ['B', 'Till he came', true],
                    ['C', 'Until six o’clock', false],
                    ['D', 'Since this morning', false],
                ],
            ],
            [
                'stem' => 'What will be the correct preposition to complete the sentence? "I am not bad ... tennis."',
                'subject' => 'english',
                'options' => [
                    ['A', 'in', false],
                    ['B', 'at', true],
                    ['C', 'about', false],
                    ['D', 'with', false],
                ],
            ],
            [
                'stem' => 'What is the antonym of ‘gentle’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Harsh', true],
                    ['B', 'modest', false],
                    ['C', 'clever', false],
                    ['D', 'rude', true],
                ],
            ],
            [
                'stem' => 'What is the synonym of ‘Jovial’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Jolly', true],
                    ['B', 'Gay', true],
                    ['C', 'Jealous', false],
                    ['D', 'Happy', false],
                ],
            ],
            [
                'stem' => 'What is the synonym of ‘Competent’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Circumstance', false],
                    ['B', 'Discrete', false],
                    ['C', 'Capable', true],
                    ['D', 'Prudent', false],
                ],
            ],
            [
                'stem' => 'Who is the author of ‘A Farewell to Arms’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'H. G. Wells', false],
                    ['B', 'George Orwell', false],
                    ['C', 'Thomas More', false],
                    ['D', 'Ernest Hemingway', true],
                ],
            ],
            [
                'stem' => 'Who is the author of ‘Animal Farm’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Thomas More', false],
                    ['B', 'George Orwell', true],
                    ['C', 'Boris Pasternak', false],
                    ['D', 'Charles Dickens', false],
                ],
            ],
            [
                'stem' => 'Who is the author of ‘India Wins Freedom’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Mahatma Gandhi', false],
                    ['B', 'J. L. Nehru', false],
                    ['C', 'Abul Kalam Azad', true],
                    ['D', 'Moulana Akram Khan', false],
                ],
            ],
            [
                'stem' => 'What kind of noun is ‘Cattle’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Proper', false],
                    ['B', 'Common', false],
                    ['C', 'Collective', true],
                    ['D', 'Material', false],
                ],
            ],
            [
                'stem' => 'What kind of noun is ‘Girl’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Proper', false],
                    ['B', 'Common', true],
                    ['C', 'Collective', false],
                    ['D', 'Material', false],
                ],
            ],
            [
                'stem' => 'What is the meaning of ‘White Elephant’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'An elephant of white colour', false],
                    ['B', 'A very costly or troublesome possession', true],
                    ['C', 'A black marketer', false],
                    ['D', 'A hoarder', false],
                ],
            ],

            // ==========================================
            // বাংলাদেশ বিষয়াবলী (৩৫ - ৫১)
            // ==========================================
            [
                'stem' => 'বাংলাদেশ গণপ্রজাতন্ত্রের ঘোষণা হয়েছিল-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '১৭ এপ্রিল, ১৯৭১', false],
                    ['B', '২৬ মার্চ, ১৯৭১', false],
                    ['C', '১১ এপ্রিল, ১৯৭১', false],
                    ['D', '১০ এপ্রিল, ১৯৭১', true],
                ],
            ],
            [
                'stem' => 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান প্রবর্তিত হয়-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '২৫ মার্চ, ১৯৭১', false],
                    ['B', '২৫ মার্চ, ১৯৭২', false],
                    ['C', '১৬ ডিসেম্বর, ১৯৭১', false],
                    ['D', '১৬ ডিসেম্বর, ১৯৭২', true],
                ],
            ],
            [
                'stem' => 'বিখ্যাত সাধক শাহ সুলতান বলখীর মাজার কোথায়?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'মহাস্থানগড়ে', true],
                    ['B', 'শাহজাদপুরে', false],
                    ['C', 'নেত্রকোনায়', false],
                    ['D', 'রামপালে', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের লোকশিল্প জাদুঘর কোথায়?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'চট্টগ্রাম', false],
                    ['B', 'বগুড়ায়', false],
                    ['C', 'সোনারগাঁওয়ে', true],
                    ['D', 'রামপালে', false],
                ],
            ],
            [
                'stem' => 'বাংলায় ইউরোপীয় বণিকদের মধ্যে বাণিজ্যের উদ্দেশ্যে প্রথম এসেছিলেন-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'ইংরেজরা', false],
                    ['B', 'ওলন্দাজরা', false],
                    ['C', 'ফরাসিরা', false],
                    ['D', 'পর্তুগিজরা', true],
                ],
            ],
            [
                'stem' => 'বাংলা নববর্ষ পহেলা বৈশাখ চালু করেছিলেন কে?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'সম্রাট আকবর', true],
                    ['B', 'শেরশাহ', false],
                    ['C', 'লক্ষণ সেন', false],
                    ['D', 'বাদশাহ শাজাহান', false],
                ],
            ],
            [
                'stem' => 'পাহাড়পুরের বৌদ্ধ বিহারটি কি নামে পরিচিত ছিল?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'সোমপুর বিহার', true],
                    ['B', 'ধর্মপাল বিহার', false],
                    ['C', 'জগদ্দল বিহার', false],
                    ['D', 'শ্রী বিহার', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে চীনামাটির সন্ধান পাওয়া গেছে-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'বিজয়পুরে', true],
                    ['B', 'রানীগঞ্জে', false],
                    ['C', 'টেকেনহাটে', false],
                    ['D', 'বিয়ানীবাজারে', false],
                ],
            ],
            [
                'stem' => 'ঢাকা বিশ্ববিদ্যালয় প্রতিষ্ঠিত হয় কোন সালে?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '১৯০৫', false],
                    ['B', '১৯১১', false],
                    ['C', '১৯৩৫', false],
                    ['D', '১৯২১', true],
                ],
            ],
            [
                'stem' => 'ঢাকার বিখ্যাত তারা মসজিদ তৈরি করেন?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'শায়েস্তা খান', false],
                    ['B', 'নওয়াব সলিমুল্লাহ', false],
                    ['C', 'মির্জা আহমেদ জান', true],
                    ['D', 'খান সাহেব আবুল হাসানাত', false],
                ],
            ],
            [
                'stem' => 'পাখি ছাড়া ‘বলাকা’ ও ‘দোয়েল’ কিসের নাম?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'দুটি কৃষি যন্ত্রপাতির নাম', false],
                    ['B', 'দুটি কৃষি সংস্থার নাম', false],
                    ['C', 'উন্নত জাতের গম শস্য', true],
                    ['D', 'কৃষি খামারের নাম', false],
                ],
            ],
            [
                'stem' => '‘অগ্নিশ্বর’, ‘কানাইবাঁশী’, ‘মোহনবাঁশী’ ও ‘বীটজবা’ কি জাতীয় ফলের নাম?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'পেয়ারা', false],
                    ['B', 'কলা', true],
                    ['C', 'পেঁপে', false],
                    ['D', 'জামরুল', false],
                ],
            ],
            [
                'stem' => 'বাংলায় চিরস্থায়ী বন্দোবস্ত প্রবর্তন করা হয় কোন সালে?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '১৭০০ সালে', false],
                    ['B', '১৭৬২ সালে', false],
                    ['C', '১৭৯৫ সালে', false],
                    ['D', '১৭৯৩ সালে', true],
                ],
            ],
            [
                'stem' => 'কোন মুঘল সম্রাট বাংলার নাম দেন ‘জান্নাতাবাদ’?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'বাবর', false],
                    ['B', 'হুমায়ুন', true],
                    ['C', 'আকবর', false],
                    ['D', 'জাহাঙ্গীর', false],
                ],
            ],
            [
                'stem' => 'উপমহাদেশের মধ্যে ঢাকা বিশ্ববিদ্যালয়ের প্রথম ভাইস চ্যান্সেলর-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'ড. রমেশচন্দ্র মজুমদার', false],
                    ['B', 'ড. সৈয়দ মোয়াজ্জেম হোসেন', false],
                    ['C', 'ড. মাহমুদ হাসান', false],
                    ['D', 'স্যার এ. এফ. রহমান', true],
                ],
            ],
            [
                'stem' => '১৯৮৮ সালের সিউল অলিম্পিকে বাংলাদেশের কোন ভাস্করের শিল্পকর্ম প্রদর্শনীতে স্থান পায়?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'শামীম শিকদার', false],
                    ['B', 'সৈয়দ আব্দুল্লাহ খালেদ', false],
                    ['C', 'হামিদুজ্জামান খান', true],
                    ['D', 'আবদুস সুলতান', false],
                ],
            ],
            [
                'stem' => 'ঢাকা কখন সর্বপ্রথম বাংলার রাজধানী হয়েছিল?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '১২৫৫', false],
                    ['B', '১৬১০', true],
                    ['C', '১৯০৫', false],
                    ['D', '১৯৪৭', false],
                ],
            ],

            // ==========================================
            // আন্তর্জাতিক বিষয়াবলী (৫২ - ৬৮)
            // ==========================================
            [
                'stem' => 'পূর্বাশা দ্বীপের অপর নাম -',
                'subject' => 'international',
                'options' => [
                    ['A', 'নিঝুম দ্বীপ', false],
                    ['B', 'সেন্ট মার্টিন', false],
                    ['C', 'দক্ষিণ তালপট্টি', true],
                    ['D', 'কুতুবদিয়া', false],
                ],
            ],
            [
                'stem' => '‘সার্ক’ এর প্রথম শীর্ষ বৈঠক অনুষ্ঠিত হয়-',
                'subject' => 'international',
                'options' => [
                    ['A', '১৯৮৪', false],
                    ['B', '১৯৮৭', false],
                    ['C', '১৯৮৫', true],
                    ['D', '১৯৮৬', false],
                ],
            ],
            [
                'stem' => 'আরব রাষ্ট্রগুলোর মধ্যে কোনটি বাংলাদেশকে প্রথম স্বীকৃতি দেয়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'ইরাক', true],
                    ['B', 'আলজেরিয়া', false],
                    ['C', 'সৌদি আরব', false],
                    ['D', 'জর্ডান', false],
                ],
            ],
            [
                'stem' => '‘পিএলও’ এর সদর দপ্তর-',
                'subject' => 'international',
                'options' => [
                    ['A', 'তিউনিস', false],
                    ['B', 'রামাল্লা', true],
                    ['C', 'বেনগাজি', false],
                    ['D', 'মরক্কো', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘের প্রথম মহাসচিব ছিলেন-',
                'subject' => 'international',
                'options' => [
                    ['A', 'উ থান্ট', false],
                    ['B', 'ট্রিগভেলি', true],
                    ['C', 'দাগ হ্যামারশোল্ড', false],
                    ['D', 'কুর্ট ওয়াল্ডহেইম', false],
                ],
            ],
            [
                'stem' => 'নিরাপত্তা পরিষদের এশীয় আসনে বাংলাদেশের প্রতিদ্বন্দ্বী ছিল-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ফিলিপাইন', false],
                    ['B', 'জাপান', true],
                    ['C', 'ইন্দোনেশিয়া', false],
                    ['D', 'থাইল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'সাধারণ পরিষদের নিয়মিত অধিবেশন শুরু হয়-',
                'subject' => 'international',
                'options' => [
                    ['A', 'সেপ্টেম্বর মাসের তৃতীয় মঙ্গলবার', true],
                    ['B', 'সেপ্টেম্বর মাসের প্রথম সোমবার', false],
                    ['C', 'সেপ্টেম্বর মাসের দ্বিতীয় মঙ্গলবার', false],
                    ['D', 'সেপ্টেম্বর মাসের চতুর্থ মঙ্গলবার', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘের বর্তমান সদস্য সংখ্যা কত?',
                'subject' => 'international',
                'options' => [
                    ['A', '১৫৬', false],
                    ['B', '১৫৭', false],
                    ['C', '১৫৮', false],
                    ['D', '১৯৩', true],
                ],
            ],
            [
                'stem' => 'ইসলামিক সম্মেলন সংস্থার সচিবালয় কোথায়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'তেহরান', false],
                    ['B', 'জেদ্দা', true],
                    ['C', 'কায়রো', false],
                    ['D', 'রিয়াদ', false],
                ],
            ],
            [
                'stem' => 'যে দেশ ‘এসডিআই’ প্রতিরক্ষা কর্মসূচি গ্রহণ করেছে-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ব্রিটেন', false],
                    ['B', 'ফ্রান্স', false],
                    ['C', 'যুক্তরাষ্ট্র', true],
                    ['D', 'রাশিয়া', false],
                ],
            ],
            [
                'stem' => 'ব্রিটেনের প্রশাসনিক সদর দপ্তরকে বলা হয়-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ওয়েস্টমিনিস্টার অ্যাবে', false],
                    ['B', 'হোয়াইট হল', true],
                    ['C', 'মার্বেল চার্চ', false],
                    ['D', 'বুশ হাউজ', false],
                ],
            ],
            [
                'stem' => 'দ্বিতীয় মহাযুদ্ধে জার্মানি আত্মসমর্পণ করে-',
                'subject' => 'international',
                'options' => [
                    ['A', '১৯৪২ সালের নভেম্বর মাসে', false],
                    ['B', '১৯৪৩ সালের ফেব্রুয়ারি', false],
                    ['C', '১৯৪৫ সালের মে মাসে', true],
                    ['D', '১৯৪৫ সালের সেপ্টেম্বর মাসে', false],
                ],
            ],
            [
                'stem' => 'কঙ্গোকে বিদেশি শাসন থেকে মুক্ত করার লড়াইয়ে চিরস্থায়ী নাম-',
                'subject' => 'international',
                'options' => [
                    ['A', 'কাশাভুবু', false],
                    ['B', 'প্যাট্রিক লুমুম্বা', true],
                    ['C', 'শোম্বে', false],
                    ['D', 'মবুতু', false],
                ],
            ],
            [
                'stem' => 'হিরোশিমায় এটম বোমা ফেলা হয়েছিল-',
                'subject' => 'international',
                'options' => [
                    ['A', '১৯৪৫ সালের আগস্ট মাসে', true],
                    ['B', '১৯৪৫ সালের মে মাসে', false],
                    ['C', '১৯৪৪ সালের সেপ্টেম্বর মাসে', false],
                    ['D', '১৯৪৪ সালের আগস্ট মাসে', false],
                ],
            ],
            [
                'stem' => '‘আইএমএফ’ এর সদর দপ্তর কোথায়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'ওয়াশিংটন', true],
                    ['B', 'মস্কো', false],
                    ['C', 'লন্ডন', false],
                    ['D', 'নিউইয়র্ক', false],
                ],
            ],
            [
                'stem' => 'নিকারাগুয়ার যে বিদ্রোহীরা যুক্তরাষ্ট্র সমর্থনপুষ্ট তার নাম-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ইউনিটা', false],
                    ['B', 'স্যান্ডিনিস্তা', false],
                    ['C', 'কন্ট্রা', true],
                    ['D', 'সোয়াপো', false],
                ],
            ],
            [
                'stem' => '‘ব্যাবিলনের ঝুলন্ত উদ্যান’ কোন দেশে অবস্থিত?',
                'subject' => 'international',
                'options' => [
                    ['A', 'ইরান', false],
                    ['B', 'ইরাক', true],
                    ['C', 'মিশর', false],
                    ['D', 'সিরিয়া', false],
                ],
            ],

            // ==========================================
            // সাধারণ বিজ্ঞান ও প্রযুক্তি (৬৯ - ৮৪)
            // ==========================================
            [
                'stem' => 'ইতিহাস বিখ্যাত ট্রয় নগরী কোথায়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'গ্রিসে', false],
                    ['B', 'ইতালিতে', false],
                    ['C', 'তুরস্কে', true],
                    ['D', 'স্পেনে', false],
                ],
            ],
            [
                'stem' => 'নবায়নযোগ্য শক্তি উৎসের একটি উদাহরণ হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'পারমাণবিক জ্বালানি', false],
                    ['B', 'পীট কয়লা', false],
                    ['C', 'ফুয়েল সেল', false],
                    ['D', 'সূর্য', true],
                ],
            ],
            [
                'stem' => 'প্রেসার কুকারে রান্না তাড়াতাড়ি হয়, কারণ-',
                'subject' => 'science',
                'options' => [
                    ['A', 'রান্নার জন্য শুধু তাপ নয় চাপও কাজে লাগে', false],
                    ['B', 'বদ্ধ পাত্রে তাপ সংরক্ষিত হয়', false],
                    ['C', 'উচ্চ চাপে তরলের স্ফুটনাংক বৃদ্ধি পায়', true],
                    ['D', 'সঞ্চিত বাষ্পের তাপ রান্নার সহায়ক', false],
                ],
            ],
            [
                'stem' => 'যে তিনটি মূখ্য বর্ণের সমন্বয়ে অন্যান্য বর্ণ সৃষ্টি করা যায়, সেগুলো হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'লাল, হলুদ, নীল', false],
                    ['B', 'লাল, কমলা, বেগুনী', false],
                    ['C', 'হলুদ, সবুজ, নীল', false],
                    ['D', 'লাল, নীল, সবুজ', true],
                ],
            ],
            [
                'stem' => 'ভৌগোলিকভাবে গুরুত্বপূর্ণ একটি কাল্পনিক রেখা বাংলাদেশের উপর দিয়ে গিয়েছে, সেটি হচ্ছে-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'মূল মধ্যরেখা', false],
                    ['B', 'কর্কটক্রান্তি রেখা', true],
                    ['C', 'মকরক্রান্তি রেখা', false],
                    ['D', 'আন্তর্জাতিক তারিখ রেখা', false],
                ],
            ],
            [
                'stem' => 'মাছ অক্সিজেন নেয়-',
                'subject' => 'science',
                'options' => [
                    ['A', 'মাঝে মাঝে পানির উপর নাক তুলে', false],
                    ['B', 'পানিতে অক্সিজেন ও হাইড্রোজেন বিশ্লিষ্ট করে', false],
                    ['C', 'পটকার মধ্যে জমানো বাতাস হতে', false],
                    ['D', 'পানির মধ্যে দ্রবীভূত বাতাস হতে', true],
                ],
            ],
            [
                'stem' => 'কচুশাক বিশেষভাবে মূল্যবান যে উপাদানের জন্য তা হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'ভিটামিন এ', false],
                    ['B', 'ভিটামিন সি', false],
                    ['C', 'লৌহ', true],
                    ['D', 'ক্যালসিয়াম', false],
                ],
            ],
            [
                'stem' => 'সাধারণ ড্রাইসেলে ইলেকট্রোড হিসেবে থাকে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'তামার দণ্ড ও দস্তার দণ্ড', false],
                    ['B', 'তামার পাত ও দস্তার পাত', false],
                    ['C', 'কার্বন দণ্ড ও দস্তার কৌটা', true],
                    ['D', 'তামার দণ্ড ও দস্তার কৌটা', false],
                ],
            ],
            [
                'stem' => 'দূরের বিদ্যুৎ উৎপাদন কেন্দ্র হতে বিদ্যুৎ নিয়ে আসতে হলে হাইভোল্টেজ ব্যবহার করার কারণ-',
                'subject' => 'science',
                'options' => [
                    ['A', 'এতে বিদ্যুৎ এর অপচয় কম হয়', true],
                    ['B', 'পথে কমে গিয়েও প্রয়োজনীয় ভোল্টেজ বজায় থাকে', false],
                    ['C', 'অধিক বিদ্যুৎ প্রবাহ পাওয়া যায়', false],
                    ['D', 'প্রয়োজনমত ভোল্টেজ কমিয়ে ব্যবহার করা যায়', false],
                ],
            ],
            [
                'stem' => 'সংকর ধাতু পিতলের উপাদান হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'তামা ও টিন', false],
                    ['B', 'তামা ও দস্তা', true],
                    ['C', 'তামা ও নিকেল', false],
                    ['D', 'তামা ও সীসা', false],
                ],
            ],
            [
                'stem' => 'আমাদের দেহকোষ রক্ত হতে গ্রহণ করে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'অক্সিজেন ও গ্লুকোজ', true],
                    ['B', 'অক্সিজেন ও রক্তের আমিষ', false],
                    ['C', 'ইউরিয়া ও গ্লুকোজ', false],
                    ['D', 'অ্যামাইনো এসিড ও কার্বন ডাই অক্সাইড', false],
                ],
            ],
            [
                'stem' => 'পৃথিবীর ঘূর্ণনের ফলে আমরা ছিটকে পড়ি না-',
                'subject' => 'science',
                'options' => [
                    ['A', 'মহাকর্ষ বলের জন্য', false],
                    ['B', 'মাধ্যাকর্ষণ বলের জন্য', true],
                    ['C', 'আমরা স্থির থাকার জন্য', false],
                    ['D', 'পৃথিবীর সঙ্গে আমাদের আবর্তনের জন্য', false],
                ],
            ],
            [
                'stem' => 'নিচের কোনটি জীবাশ্ম জ্বালানি নয়?',
                'subject' => 'science',
                'options' => [
                    ['A', 'পেট্রোলিয়াম', false],
                    ['B', 'কয়লা', false],
                    ['C', 'প্রাকৃতিক গ্যাস', false],
                    ['D', 'বায়োগ্যাস', true],
                ],
            ],
            [
                'stem' => 'বৈদ্যুতিক মোটর এমন একটি যন্ত্রকৌশল যা-',
                'subject' => 'science',
                'options' => [
                    ['A', 'তাপ শক্তিকে যান্ত্রিক শক্তিতে রূপান্তরিত করে', false],
                    ['B', 'তাপ শক্তিকে তড়িৎ শক্তিতে রূপান্তরিত করে', false],
                    ['C', 'যান্ত্রিক শক্তিকে তড়িৎ শক্তিতে রূপান্তরিত করে', false],
                    ['D', 'তড়িৎ শক্তিকে যান্ত্রিক শক্তিতে রূপান্তরিত করে', true],
                ],
            ],
            [
                'stem' => 'যে বায়ু সর্বদাই উচ্চচাপ অঞ্চল থেকে নিম্নচাপ অঞ্চলের দিকে প্রবাহিত হয় তাকে বলা হয়-',
                'subject' => 'science',
                'options' => [
                    ['A', 'অয়ন বায়ু', false],
                    ['B', 'প্রত্যয়ন বায়ু', false],
                    ['C', 'মৌসুমী বায়ু', false],
                    ['D', 'নিয়ত বায়ু', true],
                ],
            ],
            [
                'stem' => 'জলজ উদ্ভিদ সহজে ভাসতে পারে, কারণ-',
                'subject' => 'science',
                'options' => [
                    ['A', 'এরা অনেক ছোট হয়', false],
                    ['B', 'এদের কান্ডে অনেক বায়ু কুঠুরী থাকে', true],
                    ['C', 'এরা পানিতে জন্মে', false],
                    ['D', 'এদের পাতা অনেক কম থাকে', false],
                ],
            ],

            // ==========================================
            // গাণিতিক যুক্তি ও মানসিক দক্ষতা (৮৫ - ১০০)
            // ==========================================
            [
                'stem' => '১ থেকে ৩০ পর্যন্ত কয়টি মৌলিক সংখ্যা আছে?',
                'subject' => 'math',
                'options' => [
                    ['A', '১১টি', false],
                    ['B', '৮টি', false],
                    ['C', '১০টি', true],
                    ['D', '৯টি', false],
                ],
            ],
            [
                'stem' => 'নিচের কোন সংখ্যাটি মৌলিক সংখ্যা?',
                'subject' => 'math',
                'options' => [
                    ['A', '১৪৩', false],
                    ['B', '৯১', false],
                    ['C', '৪৭', true],
                    ['D', '৮৭', false],
                ],
            ],
            [
                'stem' => 'দুটি সংখ্যার গুণফল ১৫৩৬। সংখ্যা দুটির ল.সা.গু ৯৬ হলে, গ.সা.গু কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '১৬', true],
                    ['B', '২৪', false],
                    ['C', '৩২', false],
                    ['D', '১২', false],
                ],
            ],
            [
                'stem' => '(.১ × .০১ × .০০১) / (.২ × .০২ × .০০২) এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '1/80', false],
                    ['B', '1/800', false],
                    ['C', '1/8000', false],
                    ['D', '1/8', true],
                ],
            ],
            [
                'stem' => 'চিনির মূল্য ২৫% বৃদ্ধি পাওয়াতে একটি পরিবার চিনি খাওয়া এমনভাবে কমাল যে, চিনি বাবদ ব্যয় বৃদ্ধি পেল না। ঐ পরিবার চিনি খাওয়ার খরচ শতকরা কত কমিয়েছিল?',
                'subject' => 'math',
                'options' => [
                    ['A', '৩০%', false],
                    ['B', '২৫%', false],
                    ['C', '১৫%', false],
                    ['D', '২০%', true],
                ],
            ],
            [
                'stem' => 'টাকায় ৩টি করে আম কিনে টাকায় ২টি আম বিক্রয় করলে শতকরা কত লাভ হবে?',
                'subject' => 'math',
                'options' => [
                    ['A', '৫০%', true],
                    ['B', '৩০%', false],
                    ['C', '৩৩%', false],
                    ['D', '৩১%', false],
                ],
            ],
            [
                'stem' => 'সরল সুদের হার শতকরা কত টাকা হলে যে কোন মূলধন ৮ বছরের সুদে-আসলে তিনগুণ হবে?',
                'subject' => 'math',
                'options' => [
                    ['A', '১২.৫০ টাকা', false],
                    ['B', '২০ টাকা', false],
                    ['C', '২৫ টাকা', true],
                    ['D', '১৫ টাকা', false],
                ],
            ],
            [
                'stem' => '৬০ লিটার কেরোসিন ও পেট্রোলের মিশ্রণের অনুপাত ৭ : ৩। ঐ মিশ্রণে আর কত লিটার পেট্রোল মিশালে অনুপাত ৩ : ৭ হবে?',
                'subject' => 'math',
                'options' => [
                    ['A', '৭০', false],
                    ['B', '৮০', true],
                    ['C', '৯০', false],
                    ['D', '৯৮', false],
                ],
            ],
            [
                'stem' => '১ থেকে ৪৯ পর্যন্ত সংখ্যাগুলোর গড় কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '২৩', false],
                    ['B', '২৪.৫', false],
                    ['C', '২৫', true],
                    ['D', '২৫.৫', false],
                ],
            ],
            [
                'stem' => 'a + b = 5 এবং a – b = 3 হলে, ab এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '2', false],
                    ['B', '3', false],
                    ['C', '4', true],
                    ['D', '5', false],
                ],
            ],
            [
                'stem' => 'যদি (x - 5)(a + x) = x² - 25 হয় তবে, a এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '-5', false],
                    ['B', '5', true],
                    ['C', '25', false],
                    ['D', '-25', false],
                ],
            ],
            [
                'stem' => 'ত্রিভুজ ABC এর BE = EF = CF। ΔAEC এর ক্ষেত্রফল ৪৮ বর্গফুট হলে, ΔABC এর ক্ষেত্রফল কত বর্গফুট?',
                'subject' => 'math',
                'options' => [
                    ['A', '৭২', true],
                    ['B', '৬০', false],
                    ['C', '৪৮', false],
                    ['D', '৬৪', false],
                ],
            ],
            [
                'stem' => 'ত্রিভুজের একটি কোণ উহার অপর দুটি কোণের সমষ্টির সমান হলে ত্রিভুজটি-',
                'subject' => 'math',
                'options' => [
                    ['A', 'সমকোণী', true],
                    ['B', 'স্থূলকোণী', false],
                    ['C', 'সমবাহু', false],
                    ['D', 'সূক্ষ্মকোণী', false],
                ],
            ],
            [
                'stem' => 'সমবাহু ত্রিভুজের বাহুর দৈর্ঘ্য যদি a হয়, তবে ক্ষেত্রফল হবে-',
                'subject' => 'math',
                'options' => [
                    ['A', '(√3/4)a²', true],
                    ['B', '(√3/2)a²', false],
                    ['C', '(3/2)a²', false],
                    ['D', '(1/2)a²', false],
                ],
            ],
            [
                'stem' => 'কোনো একটি জিনিস নির্মাতা ২০% লাভে ও খুচরা বিক্রেতা ২০% লাভে বিক্রয় করে। যদি ঐ জিনিসের নির্মাণ খরচ ১০০ টাকা হয় তবে খুচরা মূল্য কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '১৪০ টাকা', false],
                    ['B', '১২০ টাকা', false],
                    ['C', '১৪৪ টাকা', true],
                    ['D', '১২৪ টাকা', false],
                ],
            ],
            [
                'stem' => 'a + b + c = 0 হলে, a³ + b³ + c³ এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', 'abc', false],
                    ['B', '3abc', true],
                    ['C', '6abc', false],
                    ['D', '9abc', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, their options, tags, and link to the exam
        foreach ($questionsData as $index => $q) {
            $orderNumber = $index + 1;
            $subjectId = $subjects[$q['subject']] ?? $subjects['bangla'];

            $question = Question::create([
                'subject_id' => $subjectId,
                'setter_organization_id' => $bpsc?->id,
                'stem_bn' => $q['stem'],
                'stem_en' => null,
                'question_type' => 'single_choice',
                'difficulty' => 'medium',
                'default_marks' => 1.00,
                'negative_marks' => 0.50,
                'status' => 'published',
                'created_by' => $admin?->id,
                'reference_source' => '১০ম বিসিএস প্রিলিমিনারি পরীক্ষা',
            ]);

            // Options
            foreach ($q['options'] as $optOrder => $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_letter' => $opt[0],
                    'option_text_bn' => $opt[1],
                    'is_correct' => $opt[2],
                    'order' => $optOrder + 1,
                ]);
            }

            // Tags
            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'exam',
                'tag_value' => '10th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1989',
            ]);

            // Link to Exam
            ExamQuestion::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'marks' => 1.00,
                'negative_marks' => 0.50,
                'order' => $orderNumber,
            ]);
        }
    }
}
