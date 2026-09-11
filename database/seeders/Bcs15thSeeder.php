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

class Bcs15thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '15th')->first() ?? ExamYear::firstOrCreate(['year' => '15th'], [
            'name_en' => '15th BCS Exam',
            'name_bn' => '১৫তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 15th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '15th-bcs-preliminary'],
            [
                'title_bn' => '১৫তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '15th BCS Preliminary Question Solution',
                'description_bn' => '১৫তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 15th BCS Preliminary Examination.',
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

        // Subject mappings
        $subjects = [
            'bangla' => Subject::where('slug', 'bangla')->first()?->id,
            'english' => Subject::where('slug', 'english')->first()?->id,
            'bangladesh' => Subject::where('slug', 'bangladesh-affairs')->first()?->id,
            'international' => Subject::where('slug', 'international-affairs')->first()?->id,
            'science' => Subject::where('slug', 'science-technology')->first()?->id,
            'math' => Subject::where('slug', 'math-mental-ability')->first()?->id,
        ];

        $questionsData = [
            [
                'stem' => '‘সুন্দর হে, দাও দাও সুন্দর জীবন। হউক দূর অকল্যাণ সকল অশোভন।’- চরণ দুটি কার লেখা?',
                'subject' => 'bangla',
                'explanation' => '<strong>কাজী নজরুল ইসলাম</strong>: জাতীয় কবি কাজী নজরুল ইসলামের ‘সুন্দর হে’ শীর্ষক প্রার্থনামূলক বিখ্যাত কবিতার অমর বাণী এটি।',
                'options' => [
                    ['A', 'কাজী নজরুল ইসলাম', true],
                    ['B', 'রবীন্দ্রনাথ ঠাকুর', false],
                    ['C', 'গোলাম মোস্তফা', false],
                    ['D', 'শেখ ফজলুল করিম', false],
                ],
            ],
            [
                'stem' => 'আকাবা কোন দেশের সমুদ্র বন্দর?',
                'subject' => 'international',
                'explanation' => '<strong>জর্ডান</strong>: লোহিত সাগরের আকাবা উপসাগরের তীরে অবস্থিত আকাবা (Aqaba) হলো মধ্যপ্রাচ্যের দেশ জর্ডানের একমাত্র উপকূলীয় সমুদ্র বন্দর।',
                'options' => [
                    ['A', 'মিয়ানমার', false],
                    ['B', 'জর্ডান', true],
                    ['C', 'ইরাক', false],
                    ['D', 'ইসরাইল', false],
                ],
            ],
            [
                'stem' => '‘ক্রুজিরো’ কোন দেশের মুদ্রার নাম?',
                'subject' => 'international',
                'explanation' => '<strong>ব্রাজিল</strong>: ব্রাজিলের ঐতিহাসিক মুদ্রার নাম ছিল ক্রুজিরো (Cruzeiro)। ১৯৯৪ সালে ব্রাজিলের বর্তমান আধুনিক মুদ্রা হিসেবে ‘রিয়াল’ (Real) প্রবর্তিত হয়।',
                'options' => [
                    ['A', 'লুক্সেমবার্গ', false],
                    ['B', 'ব্রাজিল', true],
                    ['C', 'কম্বোডিয়া', false],
                    ['D', 'মঙ্গোলিয়া', false],
                ],
            ],
            [
                'stem' => '‘The World Economic Forum’ কর্তৃক নির্ধারিত International Competitiveness Ranking-এ ১৯৯৩ সালে কোন দেশ সর্বোচ্চ স্থান অধিকার করেছে?',
                'subject' => 'international',
                'explanation' => '<strong>দক্ষিণ কোরিয়া</strong>: ওয়ার্ল্ড ইকোনমিক ফোরামের (WEF) ১৯৯৩ সালের আন্তর্জাতিক প্রতিযোগিতামূলক সূচকে উদীয়মান অর্থনীতিগুলোর মধ্যে দক্ষিণ কোরিয়া শীর্ষস্থান অর্জন করেছিল।',
                'options' => [
                    ['A', 'যুক্তরাষ্ট্র', false],
                    ['B', 'জাপান', false],
                    ['C', 'জার্মানি', false],
                    ['D', 'দক্ষিণ কোরিয়া', true],
                ],
            ],
            [
                'stem' => 'পৃথিবীর বিভিন্ন দেশের মধ্যে জনসংখ্যার দিক থেকে বাংলাদেশের স্থান কততম?',
                'subject' => 'international',
                'explanation' => '<strong>অষ্টম</strong>: জনসংখ্যায় বিশ্বে বাংলাদেশের বর্তমান অবস্থান অষ্টম (শীর্ষে রয়েছে ভারত ও চীন)। তৎকালীন সময়েও বাংলাদেশ শীর্ষ ৮ দেশের তালিকায় অবস্থান করছিল।',
                'options' => [
                    ['A', 'অষ্টম', true],
                    ['B', 'নবম', false],
                    ['C', 'দ্বাদশ', false],
                    ['D', 'চতুর্দশ', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের ভূ-উপগ্রহ কেন্দ্রের সংখ্যা কয়টি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>চার</strong>: বাংলাদেশে মোট ৪টি ভূ-উপগ্রহ কেন্দ্র রয়েছে: রাঙ্গামাটির বেতবুনিয়া (প্রথম, ১৯৭৫), গাজীপুরের তালিবাবাদ, ঢাকার মহাখালী এবং সিলেট ভূ-উপগ্রহ কেন্দ্র।',
                'options' => [
                    ['A', 'এক', false],
                    ['B', 'দুই', false],
                    ['C', 'তিন', false],
                    ['D', 'চার', true],
                ],
            ],
            [
                'stem' => 'গঙ্গা-ব্রহ্মপুত্র-মেঘনায় সম্মিলিত নদী অববাহিকার কত শতাংশ বাংলাদেশের অন্তর্ভুক্ত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৭</strong>: গঙ্গা-ব্রহ্মপুত্র-মেঘনা (GBM) সম্মিলিত বিশাল নদী অববাহিকার প্রায় ১৭.৫ লক্ষ বর্গকিলোমিটার এলাকার মধ্যে মাত্র প্রায় ৭ থেকে ৮ শতাংশ ভূখণ্ড বাংলাদেশের সীমানায় অবস্থিত।',
                'options' => [
                    ['A', '৪', false],
                    ['B', '১৪', false],
                    ['C', '৭', true],
                    ['D', '৩৩', false],
                ],
            ],
            [
                'stem' => 'গ্রিনিচ মান সময় অপেক্ষা বাংলাদেশ সময় কত ঘণ্টা আগে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৬ ঘণ্টা</strong>: বাংলাদেশ ৯০ ডিগ্রি পূর্ব দ্রাঘিমাংশে অবস্থিত হওয়ায় গ্রিনিচ মান সময় (GMT) অপেক্ষা বাংলাদেশের প্রমাণ সময় ঠিক ৬ ঘণ্টা এগিয়ে (+6 GMT)।',
                'options' => [
                    ['A', '৬ ঘণ্টা', true],
                    ['B', 'সাড়ে ৫ ঘণ্টা', false],
                    ['C', 'সাড়ে ৬ ঘণ্টা', false],
                    ['D', '৫ ঘণ্টা', false],
                ],
            ],
            [
                'stem' => 'The speaker failed to make the audience –– to him patiently.',
                'subject' => 'english',
                'explanation' => '<strong>listen</strong>: Causative verb \'make\' এর পর ব্যক্তিবাচক Object থাকলে পরবর্তী Verb-টির Bare Infinitive (base form) বসে, অর্থাৎ \'listen\'।',
                'options' => [
                    ['A', 'to listen', false],
                    ['B', 'listening', false],
                    ['C', 'listened', false],
                    ['D', 'listen', true],
                ],
            ],
            [
                'stem' => 'Which of the following ages in literary history is the latest?',
                'subject' => 'english',
                'explanation' => '<strong>The Georgian Age</strong>: ইংরেজি সাহিত্যের সময়ানুক্রমে: Restoration (1660–1700), Augustan (1700–1745), Victorian (1832–1901) এবং The Georgian Age (1910–1936), যা প্রদত্ত অপশনগুলোর মধ্যে সর্বশেষ।',
                'options' => [
                    ['A', 'The Augustan Age', false],
                    ['B', 'The Victorian Age', false],
                    ['C', 'The Georgian Age', true],
                    ['D', 'The Restoration Age', false],
                ],
            ],
            [
                'stem' => 'Wisdom শব্দের বাংলা অর্থ-',
                'subject' => 'bangla',
                'explanation' => '<strong>প্রজ্ঞা</strong>: ইংরেজি \'Wisdom\' শব্দের যথার্থ ও প্রাতিষ্ঠানিক পারিভাষিক বাংলা রূপ হলো ‘প্রজ্ঞা’ (গভীর জ্ঞান ও বিচক্ষণতা)। Knowledge হলো জ্ঞান, Intellect হলো মেধা।',
                'options' => [
                    ['A', 'জ্ঞান', false],
                    ['B', 'বুদ্ধি', false],
                    ['C', 'মেধা', false],
                    ['D', 'প্রজ্ঞা', true],
                ],
            ],
            [
                'stem' => 'The first English dictionary was compiled by–',
                'subject' => 'english',
                'explanation' => '<strong>Samuel Johnson</strong>: ১৭৫৫ সালে প্রকাশিত ইংরেজি ভাষার প্রথম প্রামাণ্য ও পূর্ণাঙ্গ আধুনিক অভিধান \'A Dictionary of the English Language\' সংকলন করেন ড. স্যামুয়েল জনসন।',
                'options' => [
                    ['A', 'Iazak Walton', false],
                    ['B', 'Samuel Johnson', true],
                    ['C', 'Samual Butler', false],
                    ['D', 'Sir Thomas Browne', false],
                ],
            ],
            [
                'stem' => 'স্বাধীনতা যুদ্ধকালে বাংলাদেশকে কয়টি সেক্টরে ভাগ করা হয়েছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১১ টি</strong>: ১৯৭১ সালের মহান মুক্তিযুদ্ধে সুষ্ঠু পরিচালনার সুবিধার্থে সমগ্র বাংলাদেশকে ১১টি সামরিক সেক্টরে এবং ৬৪টি সাব-সেক্টরে বিভক্ত করা হয়েছিল।',
                'options' => [
                    ['A', '৯ টি', false],
                    ['B', '১০ টি', false],
                    ['C', '১১ টি', true],
                    ['D', '১২ টি', false],
                ],
            ],
            [
                'stem' => 'নিম্নের কোন আন্তর্জাতিক সংস্থার সদর দপ্তর বাংলাদেশে অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>IJO</strong>: আন্তর্জাতিক পাট সংস্থা International Jute Organization (IJO, বর্তমানে IJSG)-এর বৈশ্বিক সদর দপ্তর বাংলাদেশের রাজধানী ঢাকার ফার্মগেটে অবস্থিত।',
                'options' => [
                    ['A', 'IJO', true],
                    ['B', 'APEC', false],
                    ['C', 'SAARC', false],
                    ['D', 'ADB', false],
                ],
            ],
            [
                'stem' => 'ওয়াল স্ট্রিট কোথায় অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>নিউইয়র্ক</strong>: মার্কিন যুক্তরাষ্ট্রের নিউইয়র্ক শহরের ম্যানহাটনে অবস্থিত ‘ওয়াল স্ট্রিট’ (Wall Street) বিশ্বের সর্ববৃহৎ অর্থনৈতিক ও শেয়ার লেনদেন কেন্দ্র।',
                'options' => [
                    ['A', 'ডালাস', false],
                    ['B', 'লন্ডন', false],
                    ['C', 'নিউইয়র্ক', true],
                    ['D', 'হংকং', false],
                ],
            ],
            [
                'stem' => 'আকাশ নীল দেখায় কেন?',
                'subject' => 'science',
                'explanation' => '<strong>নীল আলোর বিক্ষেপণ অপেক্ষাকৃত বেশি বলে</strong>: র্যালের বিক্ষেপণ সূত্রানুযায়ী কম তরঙ্গদৈর্ঘ্যের আলো বেশি বিক্ষিপ্ত হয়। দৃশ্যমান আলোর মধ্যে নীল রঙের তরঙ্গদৈর্ঘ্য কম হওয়ায় বায়ুমণ্ডলের ধূলিকণা দ্বারা সর্বাধিক বিক্ষিপ্ত হয়ে আকাশকে নীল দেখায়।',
                'options' => [
                    ['A', 'নীল আলোর তরঙ্গ দৈর্ঘ্য বেশি বলে', false],
                    ['B', 'নীল সমুদ্রের প্রতিফলনের ফলে', false],
                    ['C', 'নীল আলোর বিক্ষেপণ অপেক্ষাকৃত বেশি বলে', true],
                    ['D', 'নীল আলোর প্রতিফলন বেশি বলে', false],
                ],
            ],
            [
                'stem' => '১ বর্গইঞ্চি কত বর্গ সেন্টিমিটারের সমান?',
                'subject' => 'science',
                'explanation' => '<strong>৬.৪৫</strong>: ১ ইঞ্চি = ২.৫৪ সেন্টিমিটার। সুতরাং ১ বর্গইঞ্চি = $(২.৫৪ \times ২.৫৪) = ৬.৪৫১৬$ বর্গ সেন্টিমিটার।',
                'options' => [
                    ['A', '০.০৯২৯', false],
                    ['B', '৭.৩২', false],
                    ['C', '৬.৪৫', true],
                    ['D', '৬৪.৫০', false],
                ],
            ],
            [
                'stem' => 'যে ভূমিতে ফসল জন্মায় না-',
                'subject' => 'bangla',
                'explanation' => '<strong>ঊষর</strong>: বাক্য সংকোচনে: যে ভূমিতে কোনো ফসল জন্মায় না তাকে ‘ঊষর’ বলে। যে জমি চাষ করা হয় না তা ‘পতিত’ এবং যা সন্তান প্রসব করে না তা ‘বন্ধ্যা’।',
                'options' => [
                    ['A', 'পতিত', false],
                    ['B', 'অনুর্বর', false],
                    ['C', 'ঊষর', true],
                    ['D', 'বন্ধ্যা', false],
                ],
            ],
            [
                'stem' => '‘অপমান’ শব্দের ‘অপ’ উপসর্গটি কোন অর্থে ব্যবহৃত?',
                'subject' => 'bangla',
                'explanation' => '<strong>বিপরীত</strong>: ‘মান’ শব্দের অর্থ সম্মান বা সমাদর। তার বিপরীত অর্থ প্রকাশ করতে তৎসম উপসর্গ ‘অপ’ যুক্ত হয়ে ‘অপমান’ শব্দটি গঠিত হয়েছে।',
                'options' => [
                    ['A', 'বিপরীত', true],
                    ['B', 'নিকৃষ্ট', false],
                    ['C', 'বিকৃত', false],
                    ['D', 'অভাব', false],
                ],
            ],
            [
                'stem' => '‘সোনালী কাবিন’ এর রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>আল-মাহমুদ</strong>: আধুনিক বাংলা সাহিত্যের অন্যতম শ্রেষ্ঠ আধুনিক কবি আল মাহমুদের বিখ্যাত ও কালজয়ী চতুর্দশপদী সনেট কাব্যগ্রন্থ হলো ‘সোনালী কাবিন’ (১৯৭৩)।',
                'options' => [
                    ['A', 'হাসান হাফিজুর রহমান', false],
                    ['B', 'আল-মাহমুদ', true],
                    ['C', 'হুমায়ুন আজাদ', false],
                    ['D', 'শক্তি চট্টোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => 'My uncle has three sons, –– work in the same office.',
                'subject' => 'english',
                'explanation' => '<strong>All of whom</strong>: ব্যক্তির ক্ষেত্রে Preposition-এর পরে Relative Pronoun হিসেবে Objective রূপ \'whom\' ব্যবহৃত হয়। তাই ক্লজটিকে যুক্ত করতে \'all of whom\' সঠিক।',
                'options' => [
                    ['A', 'All of them', false],
                    ['B', 'Who all', false],
                    ['C', 'They all', false],
                    ['D', 'All of whom', true],
                ],
            ],
            [
                'stem' => 'People always remember patriots. Which of the following is the best passive form?',
                'subject' => 'english',
                'explanation' => '<strong>The patriots are always remembered</strong>: সাধারণ সত্য বা সর্বজনীন কথায় \'by people\' সাধারণত উহ্য রাখা হয়। Present Indefinite-এর প্যাসিভ কাঠামো: \'The patriots are always remembered\'।',
                'options' => [
                    ['A', 'The patriots will always be remembered by people', false],
                    ['B', 'The patriots are always being remembered', false],
                    ['C', 'People are always remembered by the patriots', false],
                    ['D', 'The patriots are always remembered', true],
                ],
            ],
            [
                'stem' => 'রবীন্দ্রনাথ ঠাকুর তাঁর রচিত কোন নাটকটি কাজী নজরুল ইসলামকে উৎসর্গ করেছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>বসন্ত</strong>: কাজী নজরুল ইসলাম যখন আলিপুর জেলে বন্দি ছিলেন, তখন ১৯২৩ সালে রবীন্দ্রনাথ ঠাকুর তাঁর রচিত বিখ্যাত গীতিনাট্য ‘বসন্ত’ তাঁকে উৎসর্গ করেন।',
                'options' => [
                    ['A', 'বিসর্জন', false],
                    ['B', 'ডাকঘর', false],
                    ['C', 'বসন্ত', true],
                    ['D', 'অচলায়তন', false],
                ],
            ],
            [
                'stem' => 'বাংলা একাডেমি থেকে প্রকাশিত ত্রৈমাসিক সাহিত্য পত্রিকার নাম-',
                'subject' => 'bangla',
                'explanation' => '<strong>উত্তরাধিকার</strong>: বাংলা একাডেমি থেকে প্রকাশিত নিয়মিত মর্যাদাপূর্ণ সাহিত্য পত্রিকার নাম হলো ‘উত্তরাধিকার’ (সূচনাকালে মাসিক, বর্তমানে ত্রৈমাসিক হিসেবেও সুপরিচিত)।',
                'options' => [
                    ['A', 'সুন্দরম', false],
                    ['B', 'লোকায়ত', false],
                    ['C', 'উত্তরাধিকার', true],
                    ['D', 'কিছুধ্বনি', false],
                ],
            ],
            [
                'stem' => '‘ঢাকা মুসলিম সাহিত্য সমাজ’ এর প্রধান লেখক ছিলেন-',
                'subject' => 'bangla',
                'explanation' => '<strong>কাজী আবদুল ওদুদ, আবুল হুসেন প্রমুখ</strong>: ১৯২৬ সালে ঢাকা বিশ্ববিদ্যালয়ে প্রতিষ্ঠিত ‘মুসলিম সাহিত্য সমাজ’ বা ‘বুদ্ধির মুক্তি আন্দোলন’-এর প্রধান সংগঠক ও লেখক ছিলেন কাজী আবদুল ওদুদ, আবুল হুসেন ও কাজী মোতাহার হোসেন।',
                'options' => [
                    ['A', 'কাজী আবদুল ওদুদ, আবুল হুসেন প্রমুখ', true],
                    ['B', 'মোহাম্মদ বরকত উল্লাহ, আবুল কালাম শামসুদ্দীন প্রমুখ', false],
                    ['C', 'মোহাম্মদ আকরম খাঁ, মুহম্মদ শহীদুল্লাহ প্রমুখ', false],
                    ['D', 'কাজী ইমদাদুল হক, মোহাম্মদ ওয়াজেদ আলী প্রমুখ', false],
                ],
            ],
            [
                'stem' => 'পরস্পরকে স্পর্শ করে আছে এমন তিনটি বৃত্তের কেন্দ্র P, Q, R এবং PQ = a, QR = b, RP = c হলে P কেন্দ্রিক বৃত্তের ব্যাস হবে-',
                'subject' => 'math',
                'explanation' => '<strong>c + a – b</strong>: ধরি তিনটি বৃত্তের ব্যাসার্ধ $r_1, r_2, r_3$। $PQ = r_1 + r_2 = a$, $QR = r_2 + r_3 = b$, $RP = r_3 + r_1 = c$। যোগ করে পাই $২(r_1 + r_2 + r_3) = a + b + c$। অতএব $r_1 = \frac{c + a - b}{২}$। সুতরাং P কেন্দ্রিক বৃত্তের ব্যাস $২r_1 = c + a - b$।',
                'options' => [
                    ['A', 'a + b + c', false],
                    ['B', 'b + c – a', false],
                    ['C', 'c + a – b', true],
                    ['D', 'a – b + c', false],
                ],
            ],
            [
                'stem' => 'x + y – 1 = 0, x – y + 1= 0 এবং y + 3 = 0 সরল রেখা তিনটি দ্বারা গঠিত ত্রিভুজটি-',
                'subject' => 'math',
                'explanation' => '<strong>সমদ্বিবাহু</strong>: প্রথম দুটি রেখার ঢাল যথাক্রমে $-১$ ও $+১$, অর্থাৎ তারা পরস্পরের সাথে লম্ব এবং y-অক্ষের সাপেক্ষে প্রতিসম। $y = -৩$ অনুভূমিক রেখার সাথে ছেদ করে সমান দুটি বাহু উৎপন্ন করে, ফলে এটি সমদ্বিবাহু ত্রিভুজ।',
                'options' => [
                    ['A', 'সমবাহু', false],
                    ['B', 'বিষমবাহু', false],
                    ['C', 'সমকোণী', false],
                    ['D', 'সমদ্বিবাহু', true],
                ],
            ],
            [
                'stem' => '১ থেকে ৯৯ পর্যন্ত সংখ্যার যোগফল-',
                'subject' => 'math',
                'explanation' => '<strong>৪৯৫০</strong>: ধারাটির পদসংখ্যা $n = ৯৯$। প্রথম $n$ সংখ্যক স্বাভাবিক সংখ্যার যোগফল = $\frac{n(n + ১)}{২} = \frac{৯৯ \times ১০০}{২} = ৯৯ \times ৫০ = ৪৯৫০$।',
                'options' => [
                    ['A', '৪৮৫০', false],
                    ['B', '৪৯৫০', true],
                    ['C', '৫৭৫০', false],
                    ['D', '৫৯৫০', false],
                ],
            ],
            [
                'stem' => 'a = 1, b = – 1, c = 2, d = – 2 হলে, a – (– b) – (– c) – (– d) এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>0</strong>: রাশিটি সমাধান: $a + b + c + d = ১ + (-১) + ২ + (-২) = ১ - ১ + ২ - ২ = ০$।',
                'options' => [
                    ['A', '0', true],
                    ['B', '1', false],
                    ['C', '2', false],
                    ['D', '3', false],
                ],
            ],
            [
                'stem' => 'ইসলামিক উন্নয়ন ব্যাংককে (IDB) দেয়া বাংলাদেশের চাঁদার হার কত?',
                'subject' => 'international',
                'explanation' => '<strong>১০.০ মিলিয়ন ইসলামিক দিনার</strong>: ১৯৭৪ সালে জেদ্দায় প্রতিষ্ঠিত ইসলামী উন্নয়ন ব্যাংকে (IDB) সদস্য রাষ্ট্র হিসেবে বাংলাদেশের প্রাথমিক চাঁদার পরিমাণ ছিল ১০ মিলিয়ন ইসলামিক দিনার।',
                'options' => [
                    ['A', '২৫.০ মিলিয়ন ইসলামিক দিনার', false],
                    ['B', '১৫.৫ মিলিয়ন ইসলামিক দিনার', false],
                    ['C', '১০.০ মিলিয়ন ইসলামিক দিনার', true],
                    ['D', 'কোনো চাঁদা দিতে হয় না', false],
                ],
            ],
            [
                'stem' => '‘ঠক চাচা’ চরিত্রটি কোন উপন্যাসে পাওয়া যায়?',
                'subject' => 'bangla',
                'explanation' => '<strong>আলালের ঘরের দুলাল</strong>: প্যারীচাঁদ মিত্র (টেকচাঁদ ঠাকুর) রচিত বাংলা সাহিত্যের প্রথম আধুনিক উপন্যাস ‘আলালের ঘরের দুলাল’ (১৮৫৮)-এর বিখ্যাত ধূর্ত ও স্বার্থান্বেষী খলচরিত্র হলো ‘ঠক চাচা’।',
                'options' => [
                    ['A', 'আলালের ঘরের দুলাল', true],
                    ['B', 'জোহরা', false],
                    ['C', 'মৃত্যুক্ষুধা', false],
                    ['D', 'হাজার বছর ধরে', false],
                ],
            ],
            [
                'stem' => '‘বঙ্গদর্শন’ পত্রিকা কোন সালে প্রথম প্রকাশিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৮৭২</strong>: সাহিত্যসম্রাট বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের সম্পাদনায় ১৮৭২ সালের বৈশাখ মাসে কলকাতা থেকে বাংলা সাহিত্যের দিকপাল মাসিক সাময়িকপত্র ‘বঙ্গদর্শন’ প্রথম প্রকাশিত হয়।',
                'options' => [
                    ['A', '১৮৬৫', false],
                    ['B', '১৮৭২', true],
                    ['C', '১৮৭৫', false],
                    ['D', '১৮৮১', false],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘intrepid’?',
                'subject' => 'english',
                'explanation' => '<strong>fearless</strong>: \'Intrepid\' অর্থ নির্ভীক, সাহসী বা ভয়হীন (fearless / dauntless)।',
                'options' => [
                    ['A', 'arrogant', false],
                    ['B', 'belligerent', false],
                    ['C', 'questioning', false],
                    ['D', 'fearless', true],
                ],
            ],
            [
                'stem' => 'What is the meaning of the expression ‘bottom line’?',
                'subject' => 'english',
                'explanation' => '<strong>The essential point</strong>: ব্যবসায় ও কথ্য ইংরেজিতে \'Bottom line\' দ্বারা চূড়ান্ত ফলাফল বা সবচেয়ে গুরুত্বপূর্ণ মূল বিষয়টিকে বোঝায় (the essential or ultimate point)。',
                'options' => [
                    ['A', 'The final step', false],
                    ['B', 'The end of a road', false],
                    ['C', 'The last line of a book', false],
                    ['D', 'The essential point', true],
                ],
            ],
            [
                'stem' => 'The word ‘plurality’ means––',
                'subject' => 'english',
                'explanation' => '<strong>The holding of more than office at a time</strong>: আভিধানিক ও রাজনৈতিক পরিভাষায় \'Plurality\' দ্বারা একই সময়ে একাধিক পদ ধরে রাখা (holding of more than one office) অথবা নির্বাচনে প্রতিদ্বন্দ্বীদের তুলনায় সর্বোচ্চ ভোট প্রাপ্তিকে বোঝায়।',
                'options' => [
                    ['A', 'The letter ‘S’', false],
                    ['B', 'Men and Women', false],
                    ['C', 'Chaos and Confusion', false],
                    ['D', 'The holding of more than office at a time', true],
                ],
            ],
            [
                'stem' => '‘Pediatric’ relates to the treatment of–',
                'subject' => 'english',
                'explanation' => '<strong>Children</strong>: চিকিৎসাবিজ্ঞানে \'Pediatrics\' হলো শিশুদের রোগ নির্ণয়, লালন-পালন ও স্বাস্থ্যসেবা সংক্রান্ত বিশেষায়িত শাখা।',
                'options' => [
                    ['A', 'Adults', false],
                    ['B', 'Children', true],
                    ['C', 'Old people', false],
                    ['D', 'Women', false],
                ],
            ],
            [
                'stem' => '‘Boot leg’ means to–',
                'subject' => 'english',
                'explanation' => '<strong>smuggle</strong>: \'Bootleg\' অর্থ চোরাচালান করা বা বেআইনিভাবে কোনো পণ্য (বিশেষ করে মাদকদ্রব্য বা নিষিদ্ধ মালামাল) তৈরি ও পাচার করা (to smuggle or traffic illicitly)。',
                'options' => [
                    ['A', 'distribute', false],
                    ['B', 'export', false],
                    ['C', 'import', false],
                    ['D', 'smuggle', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে সারা বছর নাব্য নদীপথের দৈর্ঘ্য কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৫,৪০০ কি.মি.</strong>: বর্ষাকালে নৌপথের দৈর্ঘ্য প্রায় ৮,৪০০ কিমি হলেও শুকনো মৌসুমে সারা বছর নাব্য নৌপথের দৈর্ঘ্য কমে প্রায় ৫,৪০০ কিলোমিটার বা তার নিচে দাঁড়ায়।',
                'options' => [
                    ['A', '৮,০০০ কি.মি.', false],
                    ['B', '৫,৪০০ কি.মি.', true],
                    ['C', '১১,০০০ কি.মি.', false],
                    ['D', '৮,৫০০ কি.মি.', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের GDP- তে কৃষিখাতের অবদান কত শতাংশ?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১১.০২%</strong>: অর্থনৈতিক সমীক্ষা অনুযায়ী বাংলাদেশের জিডিপিতে কৃষিখাতের অবদান ক্রমান্বয়ে কমে বর্তমানে প্রায় ১১.০২% এ দাঁড়িয়েছে (তৎকালীন ১৯৯৩-৯৪ সালে ছিল প্রায় ৩০% এর কাছাকাছি)।',
                'options' => [
                    ['A', '১৭.২৩%', false],
                    ['B', '১৮.০২%', false],
                    ['C', '১১.২০%', false],
                    ['D', '১১.০২%', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ ও মায়ানমার কোন নদী দ্বারা বিভক্ত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নাফ</strong>: কক্সবাজার জেলার টেকনাফে অবস্থিত নাফ নদী (দৈর্ঘ্য প্রায় ৫৬ কিমি) বাংলাদেশ ও প্রতিবেশী মিয়ানমারের মধ্যবর্তী প্রাকৃতিক আন্তর্জাতিক সীমানা নির্দেশ করে।',
                'options' => [
                    ['A', 'নাফ', true],
                    ['B', 'কর্ণফুলী', false],
                    ['C', 'নবগঙ্গা', false],
                    ['D', 'ভাগীরথী', false],
                ],
            ],
            [
                'stem' => 'বিশ্বব্যাংক-এর কোন অঙ্গসংগঠনটি ‘Soft Loan Window’ নামে পরিচিত?',
                'subject' => 'international',
                'explanation' => '<strong>IDA</strong>: উন্নয়নশীল ও দরিদ্র দেশগুলোকে দীর্ঘমেয়াদে নামমাত্র বা বিনা সুদে ঋণ প্রদান করায় ইন্টারন্যাশনাল ডেভেলপমেন্ট অ্যাসোসিয়েশন (IDA)-কে বিশ্বব্যাংকের ‘নরম ঋণ প্রদানকারী জানালা’ (Soft Loan Window) বলা হয়।',
                'options' => [
                    ['A', 'IBRD', false],
                    ['B', 'IDA', true],
                    ['C', 'IFC', false],
                    ['D', 'EDI', false],
                ],
            ],
            [
                'stem' => 'আফ্রিকা মহাদেশের মানচিত্রে Horns of Africa- তে কোন দেশটি অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>ইথিওপিয়া</strong>: আফ্রিকার উত্তর-পূর্বাঞ্চলীয় শিং-সদৃশ অঞ্চল ‘হর্ন অব আফ্রিকা’ (Horn of Africa)-তে অবস্থিত দেশগুলো হলো: সোমালিয়া, ইথিওপিয়া, ইরিত্রিয়া ও জিবুতি।',
                'options' => [
                    ['A', 'ইথিওপিয়া', true],
                    ['B', 'নাইজেরিয়া', false],
                    ['C', 'কেনিয়া', false],
                    ['D', 'সুদান', false],
                ],
            ],
            [
                'stem' => '১৯৯৬ সালের অলিম্পিক গেমস কোথায় অনুষ্ঠিত হয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>আটলান্টা</strong>: আধুনিক অলিম্পিকের শতবর্ষপূর্তি উপলক্ষে ১৯৯৬ সালের ২৬তম গ্রীষ্মকালীন অলিম্পিক গেমস মার্কিন যুক্তরাষ্ট্রের জর্জিয়া অঙ্গরাজ্যের আটলান্টা (Atlanta) শহরে অনুষ্ঠিত হয়।',
                'options' => [
                    ['A', 'লসএঞ্জেলস', false],
                    ['B', 'আটলান্টা', true],
                    ['C', 'টোকিও', false],
                    ['D', 'নয়াদিল্লি', false],
                ],
            ],
            [
                'stem' => '১৯৯২ সালের Wimbledon টেনিস প্রতিযোগিতায় men’s singles--এ কে চ্যাম্পিয়ন হন?',
                'subject' => 'international',
                'explanation' => '<strong>Andre Agassi</strong>: ১৯৯২ সালের উইম্বলডন পুরুষ একক ফাইনালে ক্রোয়েশিয়ার গোরান ইভানিচেভিচকে পরাজিত করে মার্কিন টেনিস তারকা আন্দ্রে আগাসি তাঁর প্রথম গ্র্যান্ড স্ল্যাম খেতাব জয় করেন।',
                'options' => [
                    ['A', 'Boris Becker', false],
                    ['B', 'Mechael Stich', false],
                    ['C', 'Andre Agassi', true],
                    ['D', 'Stefan Edberg', false],
                ],
            ],
            [
                'stem' => 'কোন নেতা ফরায়েজী আন্দোলনের নেতৃত্ব দেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>হাজী শরীয়তউল্লাহ</strong>: উনিশ শতকের শুরুতে বাংলায় ব্রিটিশ বিরোধী ও ইসলাম ধর্মের ফরজ বিধান পালনের লক্ষ্যে ‘ফরায়েজী আন্দোলন’ প্রতিষ্ঠা ও নেতৃত্ব দেন ফরিদপুরের বিখ্যাত সমাজসংস্কারক হাজী শরীয়তউল্লাহ।',
                'options' => [
                    ['A', 'তিতুমীর', false],
                    ['B', 'সৈয়দ আহমদ বেরেলভি', false],
                    ['C', 'দুদু মিয়া', false],
                    ['D', 'হাজী শরীয়তউল্লাহ', true],
                ],
            ],
            [
                'stem' => 'তেঁতুলিয়া কোন জেলায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>পঞ্চগড়</strong>: তেঁতুলিয়া হলো বাংলাদেশের সর্বউত্তরের উপজেলা, যা হিমালয় কন্যা নামে খ্যাত পঞ্চগড় জেলায় অবস্থিত।',
                'options' => [
                    ['A', 'দিনাজপুর', false],
                    ['B', 'পঞ্চগড়', true],
                    ['C', 'জয়পুরহাট', false],
                    ['D', 'লালমনিরহাট', false],
                ],
            ],
            [
                'stem' => 'কে বাংলার রাজধানী ঢাকা থেকে মুর্শিদাবাদে স্থানান্তরিত করেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নবাব মুর্শিদকুলি খাঁ</strong>: ১৭১৭ সালে সুবেদার ও প্রথম নবাব মুর্শিদকুলি খাঁ রাজস্ব আদায়ের সুবিধা ও রাজনৈতিক কারণে বাংলার রাজধানী ঢাকা থেকে মুর্শিদাবাদে (মকসুদাবাদ) স্থানান্তর করেন।',
                'options' => [
                    ['A', 'নবাব সিরাজউদ্দৌলা', false],
                    ['B', 'নবাব মুর্শিদকুলি খাঁ', true],
                    ['C', 'সুবাদার ইসলাম খান', false],
                    ['D', 'নবাব শায়েস্তা খান', false],
                ],
            ],
            [
                'stem' => '১৯০৫ সালে নবগঠিত প্রদেশের প্রথম লেফটেন্যান্ট গভর্নর ছিলেন-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ব্যামফিল্ড ফুলার</strong>: ১৯০৫ সালে লর্ড কার্জন কর্তৃক বঙ্গভঙ্গের পর গঠিত ‘পূর্ববঙ্গ ও আসাম’ প্রদেশের প্রথম লেফটেন্যান্ট গভর্নর নিযুক্ত হন স্যার জোসেফ ব্যামফিল্ড ফুলার।',
                'options' => [
                    ['A', 'ব্যামফিল্ড ফুলার', true],
                    ['B', 'লর্ড মিন্টো', false],
                    ['C', 'লর্ড কার্জন', false],
                    ['D', 'ওয়ারেন হেস্টিংস', false],
                ],
            ],
            [
                'stem' => 'হিমছড়ি কোন শহরের নিকট অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>কক্সবাজার</strong>: কক্সবাজার সমুদ্র সৈকত থেকে মাত্র ১২ কিলোমিটার দক্ষিণে মেরিন ড্রাইভ সড়কের পাশে অবস্থিত প্রাকৃতিক ঝরনা ও পাহাড়ের মিলনস্থল হলো পর্যটন কেন্দ্র ‘হিমছড়ি’।',
                'options' => [
                    ['A', 'চট্টগ্রাম', false],
                    ['B', 'খুলনা', false],
                    ['C', 'কক্সবাজার', true],
                    ['D', 'রাজশাহী', false],
                ],
            ],
            [
                'stem' => 'Are you doing anything special –– the weekend? Fill in the gap with appropriate preposition.',
                'subject' => 'english',
                'explanation' => '<strong>at</strong>: ব্রিটিশ ইংরেজিতে সপ্তাহান্তে বা ছুটির দিন বোঝাতে \'at the weekend\' প্রচলিত ও আদর্শ এপ্রোপ্রিয়েট প্রেপজিশন হিসেবে ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'in', false],
                    ['B', 'for', false],
                    ['C', 'on', false],
                    ['D', 'at', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের কোন অঞ্চলকে ‘৩৬০ আউলিয়ার দেশ’ বলা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সিলেট</strong>: চতুর্দশ শতাব্দীতে হজরত শাহজালাল (র.) ও তাঁর ৩৬০ জন সফরসঙ্গী আউলিয়া ও সুফি সাধকদের আগমন ও ইসলাম প্রচারের স্মৃতিবিজড়িত সিলেটকে ‘৩৬০ আউলিয়ার দেশ’ বলা হয়।',
                'options' => [
                    ['A', 'চট্টগ্রাম', false],
                    ['B', 'সিলেট', true],
                    ['C', 'ঢাকা', false],
                    ['D', 'রাজশাহী', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের পানি সম্পদের চাহিদা সবচেয়ে বেশি কোন খাতে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>কৃষি</strong>: বাংলাদেশে তোলপাড় করা সেচ কার্যক্রম ও বোরো ধান চাষের প্রয়োজনে মোট ব্যবহৃত ভূগর্ভস্থ ও ভূ-উপরিভাগের প্রায় ৮৫–৮৮ ভাগ পানি সরাসরি কৃষিখাতে ব্যয় হয়।',
                'options' => [
                    ['A', 'আবাসিক', false],
                    ['B', 'কৃষি', true],
                    ['C', 'পরিবহন', false],
                    ['D', 'শিল্প', false],
                ],
            ],
            [
                'stem' => 'নিচের কোন তারিখে পিএলও-ইসরাইল পারস্পরিক স্বীকৃতি দলিলে স্বাক্ষর করে?',
                'subject' => 'international',
                'explanation' => '<strong>১৩ সেপ্টেম্বর, ১৯৯৩</strong>: অসলো চুক্তির (Oslo Accords) ঐতিহাসিক সমাপ্তি হিসেবে ১৯৯৩ সালের ১৩ সেপ্টেম্বর ওয়াশিংটনে হোয়াইট হাউসে ইয়াসির আরাফাত ও ইসহাক রবিন ঐতিহাসিক পারস্পরিক স্বীকৃতি দলিলে স্বাক্ষর করেন।',
                'options' => [
                    ['A', '১০ সেপ্টেম্বর, ১৯৯৩', false],
                    ['B', '১১ সেপ্টেম্বর, ১৯৯৩', false],
                    ['C', '১৩ সেপ্টেম্বর, ১৯৯৩', true],
                    ['D', '২০ সেপ্টেম্বর, ১৯৯৩', false],
                ],
            ],
            [
                'stem' => 'রিওডি জেনিরিওতে অনুষ্ঠিত ‘ধরিত্রী সম্মেলন’-এ কত দেশের প্রতিনিধি অংশগ্রহণ করেছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১৭৯</strong>: ১৯৯২ সালের জুনে ব্রাজিলের রিও ডি জেনিরোতে অনুষ্ঠিত ঐতিহাসিক জাতিসংঘ পরিবেশ ও উন্নয়ন শীর্ষ সম্মেলনে (Earth Summit) ১৭৯টি দেশের শীর্ষ প্রতিনিধি ও রাষ্ট্রপ্রধানগণ অংশগ্রহণ করেন।',
                'options' => [
                    ['A', '১৫০', false],
                    ['B', '১৫৬', false],
                    ['C', '১৭৮', false],
                    ['D', '১৭৯', true],
                ],
            ],
            [
                'stem' => '‘Club of Vienna’ কি?',
                'subject' => 'international',
                'explanation' => '<strong>পশ্চিম ইউরোপের চিত্রশিল্পীদের একটি সংগঠন</strong>: আন্তর্জাতিক সংস্কৃতি ও দৃশ্যকলার পরিমণ্ডলে প্রতিষ্ঠিত ঐতিহ্যবাহী চিত্রশিল্পীদের সংগঠন হলো ‘Club of Vienna’।',
                'options' => [
                    ['A', 'অস্ট্রিয়ার একটি বিখ্যাত পান্থশালা', false],
                    ['B', 'পশ্চিম ইউরোপের প্রধান বাণিজ্যিক ব্যাংকগুলোর বাৎসরিক সভা', false],
                    ['C', 'একটি বিশ্ব উন্নয়ন সংক্রান্ত গবেষণা প্রতিষ্ঠান', false],
                    ['D', 'পশ্চিম ইউরোপের চিত্রশিল্পীদের একটি সংগঠন', true],
                ],
            ],
            [
                'stem' => 'জাতিসংঘ ‘আদিবাসী বর্ষ’ হিসেবে কোন সালকে ঘোষণা করেছে?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৯৩ সাল</strong>: জাতিসংঘ সাধারণ পরিষদ বিশ্বজুড়ে ক্ষুদ্র নৃগোষ্ঠী ও আদিবাসীদের অধিকার রক্ষার লক্ষ্যে ১৯৯৩ সালকে ‘আন্তর্জাতিক আদিবাসী বর্ষ’ হিসেবে ঘোষণা করেছিল।',
                'options' => [
                    ['A', '১৯৯১ সাল', false],
                    ['B', '১৯৯২ সাল', false],
                    ['C', '১৯৯৩ সাল', true],
                    ['D', '১৯৯৪ সাল', false],
                ],
            ],
            [
                'stem' => '১৯৯৩ সালে জাতিসংঘের তত্ত্বাবধানে কম্বোডিয়ায় অনুষ্ঠিত নির্বাচনে কোন দল বিজয়ী হয়েছে?',
                'subject' => 'international',
                'explanation' => '<strong>ফুনসিনপেক</strong>: প্রিন্স নরোদম রানারিদ্ধের নেতৃত্বাধীন রাজতন্ত্রী রাজনৈতিক দল ফুনসিনপেক (FUNCINPEC) জাতিসংঘের ইউএনটিএসি (UNTAC) পরিচালিত ঐতিহাসিক ১৯৯৩ সালের নির্বাচনে সংখ্যাগরিষ্ঠতা অর্জন করে।',
                'options' => [
                    ['A', 'ফুনসিনপেক', true],
                    ['B', 'সিপিপি', false],
                    ['C', 'খেমাররুজ', false],
                    ['D', 'কেপিএলএনএফ', false],
                ],
            ],
            [
                'stem' => '‘স্ট্রোক’ আকস্মিক অজ্ঞান বা মৃত্যুর কারণ হতে পারে- এটি কী?',
                'subject' => 'science',
                'explanation' => '<strong>মস্তিষ্কে রক্তক্ষরণ এবং রক্ত প্রবাহে বাধা</strong>: মস্তিষ্কের ধমনিতে রক্ত জমাট বাঁধার কারণে রক্ত চলাচলে বাধা সৃষ্টি হলে (Ischemic) অথবা রক্তনালী ছিঁড়ে রক্তক্ষরণ ঘটলে (Hemorrhagic) মস্তিষ্কের কোষ বিনষ্ট হয়ে স্ট্রোক সংঘটিত হয়।',
                'options' => [
                    ['A', 'হৃৎপিণ্ডের সজোরে সংকোচন বা বন্ধ হয়ে যাওয়া', false],
                    ['B', 'মস্তিষ্কে রক্তক্ষরণ এবং রক্ত প্রবাহে বাধা', true],
                    ['C', 'হৃৎপিণ্ডের অংশবিশেষের অসাড়তা', false],
                    ['D', 'ফুসফুস হঠাৎ বিকল হয়ে যাওয়া', false],
                ],
            ],
            [
                'stem' => 'কোনটি রক্তের কাজ নয়?',
                'subject' => 'science',
                'explanation' => '<strong>জারক রস (enzyme) বিতরণ করা</strong>: রক্ত হরমোন, অক্সিজেন, পুষ্টি উপাদান এবং বর্জ্য পদার্থ পরিবহন করে। কিন্তু পরিপাকনালীর জারক রস বা এনজাইম নালীযুক্ত গ্রন্থি (Exocrine gland) থেকে ক্ষরিত হয়, রক্ত দ্বারা পরিবাহিত হয় না।',
                'options' => [
                    ['A', 'কলা (Tissue) হতে ফুসফুসে বর্জ্য পদার্থ বহন করা', false],
                    ['B', 'ক্ষুদ্রান্ত্র হতে কলাতে খাদ্যের সারবস্তু বহন করা', false],
                    ['C', 'হরমোন বিতরণ করা', false],
                    ['D', 'জারক রস (enzyme) বিতরণ করা', true],
                ],
            ],
            [
                'stem' => 'ডিজিটাল ঘড়ি বা ক্যালকুলেটরে কালচে অনুজ্জ্বল যে লেখা ফুটে ওঠে তা কিসের ভিত্তিতে তৈরি?',
                'subject' => 'science',
                'explanation' => '<strong>এলসিডি</strong>: ডিজিটাল ক্যালকুলেটর ও হাতঘড়িতে শক্তি সাশ্রয়ী লিকুইড ক্রিস্টাল ডিসপ্লে বা এলসিডি (LCD - Liquid Crystal Display) প্রযুক্তি ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'এলইডি', false],
                    ['B', 'সিলিকন চিপ', false],
                    ['C', 'এলসিডি', true],
                    ['D', 'আইসি', false],
                ],
            ],
            [
                'stem' => 'Which of the following is a correct sentence?',
                'subject' => 'english',
                'explanation' => '<strong>He was too clever to miss the point.</strong>: \'Too ... to\' নেতিবাচক অর্থ প্রকাশ করে। এর অর্থ সে এতটাই চালাক ছিল যে বিষয়টি তার চোখ এড়ায়নি (He was so clever that he did not miss the point)।',
                'options' => [
                    ['A', 'He was too clever not to miss the point', false],
                    ['B', 'He was so clever to miss the point', false],
                    ['C', 'He was too clever to miss the point.', true],
                    ['D', 'He was too clever to grasp the point', false],
                ],
            ],
            [
                'stem' => 'The ‘Poet Laureate’ is–',
                'subject' => 'english',
                'explanation' => '<strong>the court poet England</strong>: ব্রিটেনের রাজপরিবার বা সরকার কর্তৃক আনুষ্ঠানিকভাবে নিযুক্ত জাতীয় বা রাজকবিকে \'Poet Laureate\' বলা হয় (যেমন জন ড্রাইডেন, উইলিয়াম ওয়ার্ডসওয়ার্থ, আলফ্রেড টেনিসন প্রমূখ)।',
                'options' => [
                    ['A', 'the best poet of the country', false],
                    ['B', 'a winner of the Noble Prize in poetry', false],
                    ['C', 'the court poet England', true],
                    ['D', 'a classical poet', false],
                ],
            ],
            [
                'stem' => 'Which of the following school of literary writings is connected with a medical theory?',
                'subject' => 'english',
                'explanation' => '<strong>Comedy of Humours</strong>: প্রাচীন গ্রিক চিকিৎসাবিজ্ঞানের ‘চার শারীরিক রস’ (রক্ত, কফ, পিত্ত ও কৃষ্ণপিত্ত)-এর ভারসাম্যের তত্ত্বের ওপর ভিত্তি করে রেনেসাঁস যুগের নাট্যকার বেন জনসন \'Comedy of Humours\' নাট্যরীতি প্রতিষ্ঠা করেন।',
                'options' => [
                    ['A', 'Comedy of Manners', false],
                    ['B', 'Theater of the Absurd', false],
                    ['C', 'Heroic Tragedy', false],
                    ['D', 'Comedy of Humours', true],
                ],
            ],
            [
                'stem' => 'Who of the following was both a poet and painter?',
                'subject' => 'english',
                'explanation' => '<strong>Blake</strong>: ইংরেজ রোমান্টিক কবি উইলিয়াম ব্লেক (William Blake) একাধারে কালজয়ী রহস্যবাদী কবি এবং দক্ষ চিত্রশিল্পী ও খোদাইকার ছিলেন।',
                'options' => [
                    ['A', 'Keats', false],
                    ['B', 'Donne', false],
                    ['C', 'Blake', true],
                    ['D', 'Spenser', false],
                ],
            ],
            [
                'stem' => 'ট্র্যাজেডি, কমেডি ও ফার্সের মূল পার্থক্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>জীবনানুভূতির গভীরতায়</strong>: ট্র্যাজেডিতে মানবজীবনের গভীর যন্ত্রণা ও দার্শনিক উপলব্ধি থাকে, কমেডিতে জীবনের সঙ্গতিপূর্ণ আনন্দ ও মনস্তত্ত্ব থাকে, আর ফার্সে হালকা লঘু হাস্যরস প্রধান হয়।',
                'options' => [
                    ['A', 'জীবনানুভূতির গভীরতায়', true],
                    ['B', 'দৃষ্টিভঙ্গির সূক্ষ্মতায়', false],
                    ['C', 'কাহিনীর সরলতা ও জটিলতায়', false],
                    ['D', 'ভাষার প্রকারভেদে', false],
                ],
            ],
            [
                'stem' => 'সাধু ভাষা ও চলিত ভাষার পার্থক্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>ক্রিয়াপদ ও সর্বনাম পদের রূপে</strong>: সাধু ও চলিত ভাষার প্রধান ব্যাকরণিক পার্থক্য হলো ক্রিয়াপদ ও সর্বনাম পদের রূপগত ভিন্নতা (যেমন: সাধুতে ‘তাহারা করিতেছে’, চলিতে ‘তারা করছে’)।',
                'options' => [
                    ['A', 'তৎসম ও অতৎসম শব্দের ব্যবহারে', false],
                    ['B', 'ক্রিয়াপদ ও সর্বনাম পদের রূপে', true],
                    ['C', 'শব্দের কথা ও লেখ্য রূপে', false],
                    ['D', 'বাক্যের সরলতা ও জটিলতায়', false],
                ],
            ],
            [
                'stem' => '‘সমকাল’ পত্রিকার সম্পাদক ছিলেন--।',
                'subject' => 'bangla',
                'explanation' => '<strong>সিকান্দার আবু জাফর</strong>: ১৯৫৭ সালে ঢাকা থেকে প্রকাশিত আধুনিক মননশীল ও প্রগতিশীল মাসিক সাহিত্য পত্রিকা ‘সমকাল’-এর প্রতিষ্ঠাতা সম্পাদক ছিলেন কবি সিকান্দার আবু জাফর।',
                'options' => [
                    ['A', 'বিনয় ঘোষ', false],
                    ['B', 'সিকান্দার আবু জাফর', true],
                    ['C', 'মোহাম্মদ আকরম খাঁ', false],
                    ['D', 'তফাজ্জল হোসেন', false],
                ],
            ],
            [
                'stem' => '‘प्रभात চিন্তা’, ‘নিভৃত চিন্তা’, ‘নিশীথ চিন্তা’ প্রভৃতি গ্রন্থের রচয়িতা-',
                'subject' => 'bangla',
                'explanation' => '<strong>কালীপ্রসন্ন ঘোষ</strong>: উনিশ শতকের বিশিষ্ট প্রাবন্ধিক কালীপ্রসন্ন ঘোষের বিখ্যাত মননশীল ও নীতিশিক্ষামূলক প্রবন্ধগ্রন্থ হলো প্রভাত চিন্তা, নিভৃত চিন্তা ও নিশীথ চিন্তা।',
                'options' => [
                    ['A', 'কালীপ্রসন্ন সিংহ', false],
                    ['B', 'কালীপ্রসন্ন ঘোষ', true],
                    ['C', 'কৃষ্ণচন্দ্র মজুমদার', false],
                    ['D', 'এস ওয়াজেদ আলী', false],
                ],
            ],
            [
                'stem' => '‘সুশিক্ষিত লোক মাত্রই স্বশিক্ষিত’ এই উক্তিটি কার?',
                'subject' => 'bangla',
                'explanation' => '<strong>প্রমথ চৌধুরী</strong>: বিশিষ্ট প্রাবন্ধিক প্রমথ চৌধুরীর বিখ্যাত মননশীল প্রবন্ধ ‘বই পড়া’-র কালজয়ী ও বহুল উদ্ধৃত বাক্য এটি।',
                'options' => [
                    ['A', 'রবীন্দ্রনাথ ঠাকুর', false],
                    ['B', 'কাজী আবদুল ওদুদ', false],
                    ['C', 'মোহাম্মদ লুৎফর রহমান', false],
                    ['D', 'প্রমথ চৌধুরী', true],
                ],
            ],
            [
                'stem' => 'বাতাসের নাইট্রোজেন কিভাবে মাটির উর্বরতা বৃদ্ধি করে?',
                'subject' => 'science',
                'explanation' => '<strong>পানিতে মিশে মাটিতে শোষিত হওয়ার ফলে</strong>: বৃষ্টির সময় বজ্রপাতে নাইট্রোজেন অক্সিজেনের সাথে যুক্ত হয়ে নাইট্রেট অ্যাসিড তৈরি করে যা বৃষ্টির পানিতে মিশে মাটিতে শোষিত হয়ে প্রাকৃতিকভাবে মাটির উর্বরতা বৃদ্ধি করে।',
                'options' => [
                    ['A', 'সরাসরি মাটিতে মিশ্রিত হয়ে জৈব বস্তু প্রস্তুত করে', false],
                    ['B', 'ব্যাকটেরিয়ার সাহায্যে উদ্ভিদের গ্রহণ ও উপযোগী বস্তু প্রস্তুত করে', false],
                    ['C', 'পানিতে মিশে মাটিতে শোষিত হওয়ার ফলে', true],
                    ['D', 'মাটির অজৈব লবণকে পরিবর্তিত করে', false],
                ],
            ],
            [
                'stem' => '‘গ্রিনহাউজ ইফেক্টের’ পরিণতিতে বাংলাদেশের সবচেয়ে গুরুতর প্রত্যক্ষ ক্ষতি কী হবে?',
                'subject' => 'science',
                'explanation' => '<strong>নিম্নভূমি নিমজ্জিত হবে</strong>: বৈশ্বিক উষ্ণায়নের ফলে মেরু অঞ্চলের বরফ গলে সমুদ্রপৃষ্ঠের উচ্চতা বৃদ্ধি পাওয়ায় নদীমাতৃক বাংলাদেশের উপকূলীয় নিম্নভূমির প্রায় ১৭ শতাংশ এলাকা সাগরে নিমজ্জিত হওয়ার আশঙ্কা সবচেয়ে গুরুতর।',
                'options' => [
                    ['A', 'উত্তাপ অনেক বেড়ে যাবে', false],
                    ['B', 'নিম্নভূমি নিমজ্জিত হবে', true],
                    ['C', 'সাইক্লোনের প্রবণতা বাড়বে', false],
                    ['D', 'বৃষ্টিপাত কমে যাবে', false],
                ],
            ],
            [
                'stem' => 'নিত্য ব্যবহার্য বহু ‘এরোসোলের’ কৌটায় এখন লেখা থাকে ‘সিএফসি’ বিহীন। সিএফসি গ্যাস কেন ক্ষতিকারক?',
                'subject' => 'science',
                'explanation' => '<strong>ওজোনস্তরে ফুটো সৃষ্টি করে</strong>: ক্লোরোফ্লুরোকার্বন (CFC) বায়ুমণ্ডলের স্ট্র্যাটোস্ফিয়ারে পৌঁছে অতিবেগুনি রশ্মির প্রভাবে ক্লোরিন পরমাণু মুক্ত করে ওজোন ($O_3$) অণুকে ভেঙে ওজোনস্তরে ক্ষয় ও গহ্বর সৃষ্টি করে।',
                'options' => [
                    ['A', 'ফুসফুসে রোগ সৃষ্টি করে', false],
                    ['B', 'গ্রিন হাউজ ইফেক্টে অবদান রাখে', false],
                    ['C', 'ওজোনস্তরে ফুটো সৃষ্টি করে', true],
                    ['D', 'দাহ্য বলে অগ্নিকাণ্ডের সম্ভাবনা ঘটায়', false],
                ],
            ],
            [
                'stem' => '৬৪ কিলোগ্রাম বালি ও পাথরের টুকরোর মিশ্রণে বালির পরিমাণ ২৫%। কত কিলোগ্রাম বালি মিশালে নতুন মিশ্রণে পাথর টুকরোর পরিমাণ ৪০% হবে?',
                'subject' => 'math',
                'explanation' => '<strong>৫৬.০</strong>: মিশ্রণে বালি = $৬৪ \times ২৫\% = ১৬$ কেজি, পাথর = $৬৪ - ১৬ = ৪৮$ কেজি। নতুন মিশ্রণে পাথর থাকবে ৪০%। অর্থাৎ ৪০% = ৪৮ কেজি $\implies$ ১০০% = ১২০ কেজি। অতএব বালি মেশাতে হবে = $১২০ - ৬৪ = ৫৬$ কেজি।',
                'options' => [
                    ['A', '৯.৬', false],
                    ['B', '১১.০', false],
                    ['C', '৪৮.০', false],
                    ['D', '৫৬.০', true],
                ],
            ],
            [
                'stem' => 'কোন সংখ্যার ২/৭ অংশ ৬৪-এর সমান?',
                'subject' => 'math',
                'explanation' => '<strong>২২৪</strong>: সংখ্যাটি $x$ হলে: $\frac{২}{৭} x = ৬৪ \implies x = \frac{৬৪ \times ৭}{২} = ৩২ \times ৭ = ২২৪$।',
                'options' => [
                    ['A', '১৮ ২/৭', false],
                    ['B', '২৪৮', false],
                    ['C', '২১৭', false],
                    ['D', '২২৪', true],
                ],
            ],
            [
                'stem' => 'একটি ৫০ মিটার লম্বা মই একটি খাড়া দেওয়ালের সাথে হেলান দিয়ে রাখা হয়েছে। মইয়ের এক প্রান্ত মাটি হতে ৪০ মিটার উচ্চে দেয়ালকে স্পর্শ করে। মই-এর অপর প্রান্ত হতে দেওয়ালের দূরত্ব (মিটারে)-',
                'subject' => 'math',
                'explanation' => '<strong>৩০</strong>: পিথাগোরাসের সূত্রানুযায়ী দেওয়াল হতে দূরত্ব = $\sqrt{৫০^২ - ৪০^২} = \sqrt{২৫০০ - ১৬০০} = \sqrt{৯০০} = ৩০$ মিটার।',
                'options' => [
                    ['A', '১০', false],
                    ['B', '৩০', true],
                    ['C', '২০', false],
                    ['D', '২৫', false],
                ],
            ],
            [
                'stem' => '(2 + x) + 3 = 3(x + 2) হলে x এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>– 1/2</strong>: $x + ৫ = ৩x + ৬ \implies ৩x - x = ৫ - ৬ \implies ২x = -১ \implies x = -১/২$।',
                'options' => [
                    ['A', '– 1/2', true],
                    ['B', '1/2', false],
                    ['C', '1/3', false],
                    ['D', '2/3', false],
                ],
            ],
            [
                'stem' => 'কোন সংখ্যাটি বৃহত্তম?',
                'subject' => 'math',
                'explanation' => '<strong>√0.3</strong>: এখানে $০.৩ = ০.৩০০$, কিন্তু $\sqrt{০.৩} \approx ০.৫৪৭৭$। সুতরাং ভগ্নাংশের বর্গমূল করলে মান বৃদ্ধি পায়, ফলে $\sqrt{০.৩}$ বৃহত্তম।',
                'options' => [
                    ['A', '0.3', false],
                    ['B', '√0.3', true],
                    ['C', '25', false],
                    ['D', '13', false],
                ],
            ],
            [
                'stem' => 'শুদ্ধ বানানটি নির্দেশ করুন-',
                'subject' => 'bangla',
                'explanation' => '<strong>মুহুর্মুহু</strong>: সংস্কৃত ব্যাকরণ অনুযায়ী সঠিক বানানটি হলো ‘মুহুর্মুহু’ (উভয় অংশে হ্রস্ব-উ কার এবং রেফ)। এর অর্থ বারবার বা পুনঃপুন।',
                'options' => [
                    ['A', 'মুহুর্মুহু', true],
                    ['B', 'মূহুর্মুহু', false],
                    ['C', 'মুহূর্মূহু', false],
                    ['D', 'মুহূর্মুহু', false],
                ],
            ],
            [
                'stem' => '‘দ্যুলোক’ শব্দের যথার্থ সন্ধি-বিচ্ছেদ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>দিব্ + লোক</strong>: এটি নিপাতনে সিদ্ধ সন্ধি: দিব্ (যার অর্থ আকাশ বা স্বর্গ) + লোক = দ্যুলোক।',
                'options' => [
                    ['A', 'দুঃ + লোক', false],
                    ['B', 'দিব্ + লোক', true],
                    ['C', 'দ্বি + লোক', false],
                    ['D', 'দ্বিঃ + লোক', false],
                ],
            ],
            [
                'stem' => '‘তাপ’ শব্দের বিপরীতার্থক শব্দ-',
                'subject' => 'bangla',
                'explanation' => '<strong>শৈত্য</strong>: ‘তাপ’ শব্দের যথার্থ আভিধানিক বিপরীত শব্দ হলো ‘শৈত্য’ (শীতল অবস্থা বা ঠান্ডাভাব)।',
                'options' => [
                    ['A', 'শৈত্য', true],
                    ['B', 'শীতল', false],
                    ['C', 'উত্তাপ', false],
                    ['D', 'হিম', false],
                ],
            ],
            [
                'stem' => 'আল্ট্রাসনোগ্রাফি কী?',
                'subject' => 'science',
                'explanation' => '<strong>ছোট তরঙ্গদৈর্ঘ্যের শব্দের দ্বারা ইমেজিং</strong>: মানবদেহের অভ্যন্তরীণ অঙ্গ-প্রত্যঙ্গের চিত্র ধারণের জন্য উচ্চ কম্পাঙ্ক ও ক্ষুদ্র তরঙ্গদৈর্ঘ্য বিশিষ্ট পরাশ্রাব্য শব্দতরঙ্গ (Ultrasound) ব্যবহার করে প্রতিচ্ছবি তৈরি করার চিকিৎসাপদ্ধতিকে আল্ট্রাসনোগ্রাফি বলে।',
                'options' => [
                    ['A', 'নতুন ধরনের এক্সরে', false],
                    ['B', 'ছোট তরঙ্গদৈর্ঘ্যের শব্দের দ্বারা ইমেজিং', true],
                    ['C', 'শরীরের অভ্যন্তরের শব্দ বিশ্লেষণ', false],
                    ['D', 'শক্তিশালী শব্দ দিয়ে পিত্তপাথর বিচূর্ণীকরণ', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে তড়িৎ-এর কম্পাঙ্ক (frequency) প্রতি সেকেন্ডে ৫০ সাইকেল-এর তাৎপর্য কী?',
                'subject' => 'science',
                'explanation' => '<strong>প্রতি সেকেন্ডে বিদ্যুৎ প্রবাহ ৫০ বার দিক বদলায়</strong>: ৫০ হার্টজ পরিবর্তী প্রবাহের (AC) অর্থ হলো বিদ্যুৎ প্রবাহ প্রতি সেকেন্ডে ৫০টি পূর্ণ চক্র সম্পন্ন করে এবং এর দিক প্রতি অর্ধচক্রে রূপান্তরিত হয়।',
                'options' => [
                    ['A', 'প্রতি সেকেন্ড বিদ্যুৎ প্রবাহ ৫০ বার বন্ধ হয়', false],
                    ['B', 'প্রতি সেকেন্ডে বিদ্যুৎ প্রবাহ ৫০ একক দৈর্ঘ্য অতিক্রম করে', false],
                    ['C', 'প্রতি সেকেন্ডে বিদ্যুৎ প্রবাহ ৫০ বার দিক বদলায়', true],
                    ['D', 'প্রতি সেকেন্ডে বিদ্যুৎ প্রবাহ ৫০ বার উঠানামা করে', false],
                ],
            ],
            [
                'stem' => 'নদীর একপাশ থেকে গুন টেনে নৌকাকে মাঝ নদীতে রেখেই সামনের দিকে নেয়া সম্ভব হয় কীভাবে?',
                'subject' => 'science',
                'explanation' => '<strong>যথাযথভাবে হাল ঘুরিয়ে</strong>: গুন টানার সময় বলের আড়াআড়ি উপাংশ নৌকাকে তীরের দিকে টানে। নৌকার হাল উপযুক্ত কোণে ঘুরিয়ে বিপরীতমুখী বল তৈরি করে নৌকাকে তীরের দিকে ভিড়তে না দিয়ে মাঝ নদীতে রেখে এগিয়ে নেওয়া হয়।',
                'options' => [
                    ['A', 'যথাযথভাবে হাল ঘুরিয়ে', true],
                    ['B', 'নদী স্রোতের সুকৌশল ব্যবহার', false],
                    ['C', 'গুন টানার সময় টানটি সামনের দিকে রেখে', false],
                    ['D', 'পাল ব্যবহার করে', false],
                ],
            ],
            [
                'stem' => 'নিচের কোন দেশটি Group of seven (G-7) এর সদস্য নয়?',
                'subject' => 'international',
                'explanation' => '<strong>সুইডেন</strong>: বিশ্বের শিল্পোন্নত শীর্ষ ৭টি দেশের জোট জি-৭ এর সদস্যরা হলো: যুক্তরাষ্ট্র, যুক্তরাজ্য, কানাডা, ফ্রান্স, জার্মানি, ইতালি ও জাপান। সুইডেন জি-৭ এর সদস্য নয়।',
                'options' => [
                    ['A', 'কানাডা', false],
                    ['B', 'ইতালি', false],
                    ['C', 'সুইডেন', true],
                    ['D', 'জাপান', false],
                ],
            ],
            [
                'stem' => 'বিশ্বের কোন শহর ‘নিষিদ্ধ শহর’ নামে পরিচিত?',
                'subject' => 'international',
                'explanation' => '<strong>লাসা</strong>: তিব্বতের রাজধানী লাসা দুর্গম হিমালয় পরিবেষ্টিত হওয়ায় এবং বহিরাগতদের প্রবেশে প্রাচীন কঠোর ধর্মীয় নিষেধাজ্ঞার কারণে ‘নিষিদ্ধ শহর’ (Forbidden City) নামে সুপরিচিত।',
                'options' => [
                    ['A', 'লাসা', true],
                    ['B', 'উলানবাটোর', false],
                    ['C', 'পিয়ংইয়ং', false],
                    ['D', 'কাবুল', false],
                ],
            ],
            [
                'stem' => '‘League of Arab States’- এর বর্তমান সদর দপ্তর কোথায় অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>কায়রো</strong>: ১৯৪৫ সালে গঠিত ২২টি সদস্য দেশের আঞ্চলিক সংস্থা আরব লীগের (Arab League) স্থায়ী সদর দপ্তর মিসরের রাজধানী কায়রোতে অবস্থিত।',
                'options' => [
                    ['A', 'তিউনিসিয়া', false],
                    ['B', 'কায়রো', true],
                    ['C', 'রাবাত', false],
                    ['D', 'জেদ্দা', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ নিচে উল্লিখিত কোন সময়ের জন্য জাতিসংঘ নিরাপত্তা পরিষদে অস্থায়ী সদস্য নির্বাচিত হয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৭৯-৮০</strong>: বাংলাদেশ এযাবৎ দুইবার জাতিসংঘ নিরাপত্তা পরিষদের অস্থায়ী সদস্য হিসেবে দায়িত্ব পালন করেছে: প্রথমবার ১৯৭৯–১৯৮০ মেয়াদে এবং দ্বিতীয়বার ২০০০–২০০১ মেয়াদে।',
                'options' => [
                    ['A', '১৯৭৮-৭৯', false],
                    ['B', '১৯৭৯-৮০', true],
                    ['C', '১৯৮০-৮১', false],
                    ['D', '১৯৮২-৮৩', false],
                ],
            ],
            [
                'stem' => 'The United Nations University কোন শহরে অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>টোকিও</strong>: জাতিসংঘের আন্তর্জাতিক গবেষণা ও উচ্চশিক্ষা প্রতিষ্ঠান ‘ইউনাইটেড নেশনস ইউনিভার্সিটি’ (UNU)-র মূল সদর দপ্তর জাপানের রাজধানী টোকিওতে অবস্থিত।',
                'options' => [
                    ['A', 'লন্ডন', false],
                    ['B', 'ব্রাসেলস', false],
                    ['C', 'নিউইয়র্ক', false],
                    ['D', 'টোকিও', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের মোট রপ্তানি আয়ে রেডিমেড গার্মেন্টস-এর অংশ কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৬০%</strong>: তৎকালীন ১৯৯৩-৯৪ সালে তৈরি পোশাক খাতের অংশ ছিল প্রায় ৬০% (বর্তমানে এটি বৃদ্ধি পেয়ে মোট জাতীয় রপ্তানি আয়ের প্রায় ৮৪–৮৫ শতাংশে পৌঁছেছে)।',
                'options' => [
                    ['A', '৭৫%', false],
                    ['B', '৫৬%', false],
                    ['C', '৩৫%', false],
                    ['D', '৬০%', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ জাতীয় সংসদের নির্ধারিত আসনে মহিলা সদস্যের সংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৫০</strong>: সংবিধানের পঞ্চদশ সংশোধনীর মাধ্যমে জাতীয় সংসদে নারীদের জন্য সংরক্ষিত নারী আসনের সংখ্যা ৪৫ থেকে বৃদ্ধি করে ৫০টিতে উন্নীত করা হয়েছে (পঞ্চম সংসদে এটি ৩০টি ছিল)।',
                'options' => [
                    ['A', '৩০', false],
                    ['B', '৩২', false],
                    ['C', '৩৫', false],
                    ['D', '৫০', true],
                ],
            ],
            [
                'stem' => '‘ইচ্ছা’ বিশেষ্যের বিশেষণ নির্দেশ করুন।',
                'subject' => 'bangla',
                'explanation' => '<strong>ইচ্ছুক</strong>: ‘ইচ্ছা’ বিশেষ্য পদের বিশেষণ রূপ হলো ‘ইচ্ছুক’ অথবা ‘ঐচ্ছিক’। অপশনে ‘ইচ্ছুক’ বিদ্যমান।',
                'options' => [
                    ['A', 'ইচ্ছাময়', false],
                    ['B', 'ঐচ্ছিক', false],
                    ['C', 'ইচ্ছুক', true],
                    ['D', 'অনিচ্ছা', false],
                ],
            ],
            [
                'stem' => 'কোন বাক্যটিতে সমধাতুজ কর্ম আছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>সে যে চাল চেলেছে তাতে তাকে ষড়যন্ত্রকারী ছাড়া আর কিছু বলা যায় না</strong>: ক্রিয়াপদ এবং কর্মপদ একই ধাতু থেকে উৎপন্ন হলে তাকে সমধাতুজ কর্ম বলে। এখানে ‘চাল’ (কর্ম) এবং ‘চেলেছে’ (ক্রিয়া) একই ধাতু নিষ্পন্ন।',
                'options' => [
                    ['A', 'সে বই পড়ছে', false],
                    ['B', 'সে গভীর চিন্তায় মগ্ন', false],
                    ['C', 'সে ঘুমিয়ে আছে', false],
                    ['D', 'সে যে চাল চেলেছে তাতে তাকে ষড়যন্ত্রকারী ছাড়া আর কিছু বলা যায় না', true],
                ],
            ],
            [
                'stem' => 'What is the synonym of ‘incredible’?',
                'subject' => 'english',
                'explanation' => '<strong>Unbelievable</strong>: \'Incredible\' অর্থ অবিশ্বাস্য বা অভাবনীয়। এর যথার্থ সমার্থক (Synonym) শব্দ হলো \'Unbelievable\'।',
                'options' => [
                    ['A', 'Unbelievable', true],
                    ['B', 'Unthinkable', false],
                    ['C', 'Unlikely', false],
                    ['D', 'Unthinking', false],
                ],
            ],
            [
                'stem' => 'What is the antonym of ‘famous’?',
                'subject' => 'english',
                'explanation' => '<strong>Obscure</strong>: \'Famous\' অর্থ বিখ্যাত বা সুবিদিত। এর বিপরীতার্থক (Antonym) শব্দ হলো অপ্রসিদ্ধ, অখ্যাত বা অস্পষ্ট অর্থে \'Obscure\'।',
                'options' => [
                    ['A', 'Opaque', false],
                    ['B', 'Illiterate', false],
                    ['C', 'Obscure', true],
                    ['D', 'Immature', false],
                ],
            ],
            [
                'stem' => '‘Plebiscite’ is a term related to ––?',
                'subject' => 'english',
                'explanation' => '<strong>Politics</strong>: \'Plebiscite\' শব্দের অর্থ গণভোট (direct vote by the people on an important political question), যা রাষ্ট্রবিজ্ঞান ও রাজনীতির (Politics) সাথে সম্পর্কিত।',
                'options' => [
                    ['A', 'Medicine', false],
                    ['B', 'Technology', false],
                    ['C', 'Law', false],
                    ['D', 'Politics', true],
                ],
            ],
            [
                'stem' => 'Who wrote ‘beauty is truth, truth is beauty’?',
                'subject' => 'english',
                'explanation' => '<strong>Keats</strong>: জন কিটস (John Keats)-এর অমর কবিতা \'Ode on a Grecian Urn\' (১৮১৯)-এর সমাপ্তি চরণে এ কালজয়ী দার্শনিক উক্তিটি রয়েছে।',
                'options' => [
                    ['A', 'Shakespeare', false],
                    ['B', 'Wordsworth', false],
                    ['C', 'Keats', true],
                    ['D', 'Eliot', false],
                ],
            ],
            [
                'stem' => 'Many islands make up –––.',
                'subject' => 'english',
                'explanation' => '<strong>an archipelago</strong>: একাধিক দ্বীপের সমষ্টি বা দ্বীপপুঞ্জকে ইংরেজিতে \'an archipelago\' বলা হয় (যেমন ইন্দোনেশিয়া, জাপান ইত্যাদি)।',
                'options' => [
                    ['A', 'an isles', false],
                    ['B', 'an archipelago', true],
                    ['C', 'a peninsula', false],
                    ['D', 'a continent', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে সরকারি মেডিকেল কলেজের সংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৩৭</strong>: স্বাস্থ্য অধিদপ্তরের সর্বশেষ অনুমোদিত পরিসংখ্যান অনুযায়ী বাংলাদেশে বর্তমানে মোট ৩৭টি সরকারি মেডিকেল কলেজ শিক্ষা কার্যক্রম পরিচালনা করছে।',
                'options' => [
                    ['A', '৩৭', true],
                    ['B', '৪০', false],
                    ['C', '৩৬', false],
                    ['D', '৪১', false],
                ],
            ],
            [
                'stem' => 'সেন্টমার্টিন দ্বীপ-এর অপর নাম কী?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নারিকেল জিঞ্জিরা</strong>: বঙ্গোপসাগরে অবস্থিত বাংলাদেশের একমাত্র প্রবাল দ্বীপ সেন্টমার্টিনের প্রাচীন ও স্থানীয় অপর নাম হলো ‘নারিকেল জিঞ্জিরা’।',
                'options' => [
                    ['A', 'নারিকেল জিঞ্জিরা', true],
                    ['B', 'সোনাদিয়া', false],
                    ['C', 'কুতুবদিয়া', false],
                    ['D', 'নিঝুম দ্বীপ', false],
                ],
            ],
            [
                'stem' => 'ষষ্ঠ জনশুমারি ও গৃহগণনা ২০২২- অনুসারে, বাংলাদেশের বর্তমান জনসংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৬ কোটি ৫১ লাখ</strong>: বাংলাদেশ পরিসংখ্যান ব্যুরোর (BBS) ষষ্ঠ জনশুমারি ও গৃহগণনা ২০২২-এর চূড়ান্ত ফলাফল অনুযায়ী দেশের সমন্বয়কৃত মোট জনসংখ্যা প্রায় ১৬ কোটি ৯৮ লাখ (প্রাথমিক গণনা ছিল ১৬ কোটি ৫১ লাখ ৫৮ হাজার ৬১৬ জন)।',
                'options' => [
                    ['A', '১৬ কোটি ৫১ লাখ', true],
                    ['B', '১৬ কোটি ৫৪ লাখ', false],
                    ['C', '১৬ কোটি ৫৯ লাখ', false],
                    ['D', '১৬ কোটি ৫২ লাখ', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, options, tags and link to the 15th BCS exam
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
                'explanation_bn' => $q['explanation'] ?? null,
                'status' => 'published',
                'created_by' => $admin?->id,
                'reference_source' => '১৫তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '15th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1993',
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
