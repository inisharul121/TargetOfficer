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

class Bcs28thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '28th')->first() ?? ExamYear::firstOrCreate(['year' => '28th'], [
            'name_en' => '28th BCS Exam',
            'name_bn' => '২৮তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 28th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '28th-bcs-preliminary'],
            [
                'title_bn' => '২৮তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '28th BCS Preliminary Question Solution',
                'description_bn' => '২৮তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 28th BCS Preliminary Examination.',
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
                'stem' => 'চর্যাপদ আবিষ্কৃত হয় কোথা থেকে?',
                'subject' => 'bangla',
                'explanation' => '<strong>নেপালের রাজগ্রন্থশালা থেকে</strong>: মহামহোপাধ্যায় হরপ্রসাদ শাস্ত্রী ১৯০৭ সালে নেপালের রাজদরবারের রয়েল লাইব্রেরি (রয়েল আর্কাইভ) থেকে চর্যাপদের মূল পুথিটি উদ্ধার করেন।',
                'options' => [
                    ['A', 'বাঁকুড়ার এক গৃহস্থের গোয়াল ঘর থেকে', false],
                    ['B', 'আরাকান রাজগ্রন্থাগার থেকে', false],
                    ['C', 'নেপালের রাজগ্রন্থশালা থেকে', true],
                    ['D', 'সুদূর চীন দেশ থেকে', false],
                ],
            ],
            [
                'stem' => 'মঙ্গলযুগের সর্বশেষ কবির নাম কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>ভারতচন্দ্র রায়গুণাকর</strong>: অষ্টাদশ শতকের মধ্যভাগে অন্নদামঙ্গল কাব্যের স্রষ্টা রায়গুণাকর ভারতচন্দ্র (মৃত্যু ১৭৬০) হলেন বাংলা মধ্যযুগের ও মঙ্গলকাব্য ধারার সর্বশেষ শ্রেষ্ঠ কবি।',
                'options' => [
                    ['A', 'বিজয়গুপ্ত', false],
                    ['B', 'ভারতচন্দ্র রায়গুণাকর', true],
                    ['C', 'মুকুন্দরাম চক্রবর্তী', false],
                    ['D', 'কানাহরি দত্ত', false],
                ],
            ],
            [
                'stem' => 'বিদ্যাপতি কোথাকার কবি ছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>মিথিলার</strong>: বৈষ্ণব পদাবলীর অন্যতম প্রধান পদকর্তা মৈথিল কোকিল কবি বিদ্যাপতি প্রাচীন ভারতের মিথিলা রাজ্যের (বর্তমান বিহারের দ্বারভাঙা) বিশপী গ্রামের অধিবাসী ও রাজকবি ছিলেন।',
                'options' => [
                    ['A', 'নবদ্বীপের', false],
                    ['B', 'মিথিলার', true],
                    ['C', 'বৃন্দাবনের', false],
                    ['D', 'বর্ধমানেন', false],
                ],
            ],
            [
                'stem' => 'শ্রীকৃষ্ণকীর্তন কাব্যের বড়াই কী ধরনের চরিত্র?',
                'subject' => 'bangla',
                'explanation' => '<strong>রাধাকৃষ্ণের প্রেমের দূতী</strong>: বড়ু চণ্ডীদাস রচিত ‘শ্রীকৃষ্ণকীর্তন’ কাব্যের বৃদ্ধা মধ্যস্থতাকারী চরিত্র বড়াই রাধা ও কৃষ্ণের প্রেমের যোগাযোগকারী বা ঘটক/দূতী হিসেবে মুখ্য ভূমিকা পালন করেছে।',
                'options' => [
                    ['A', 'শ্রী রাধার ননদিনী', false],
                    ['B', 'শ্রী রাধার শাশুড়ি', false],
                    ['C', 'রাধাকৃষ্ণের প্রেমের দূতী', true],
                    ['D', 'জনৈক গোপবালা', false],
                ],
            ],
            [
                'stem' => 'লোকসাহিত্য কাকে বলে?',
                'subject' => 'bangla',
                'explanation' => '<strong>লোকের মুখে মুখে প্রচলিত কাহিনি, গান ছড়া ইত্যাদিকে</strong>: সাধারণ মানুষের মুখে মুখে ঐতিহ্যগতভাবে বংশপরম্পরায় রচিত ও প্রচলিত রূপকথা, উপকথা, ছড়া, প্রবাদ, গীতিকা ও লোকগীতিকে লোকসাহিত্য বলা হয়।',
                'options' => [
                    ['A', 'গ্রামীণ নরনারীর প্রণয় সংবলিত উপাখ্যানকে', false],
                    ['B', 'লোক সাধারণের কল্যাণে দেবতার স্তুতিমূলক রচনাকে', false],
                    ['C', 'লোকের মুখে মুখে প্রচলিত কাহিনি, গান ছড়া ইত্যাদিকে', true],
                    ['D', 'গ্রামীণ অশিক্ষিত ও অখ্যাত লোকের সৃষ্ট রচনাকে', false],
                ],
            ],
            [
                'stem' => 'বাংলা সাহিত্যে কখন গদ্যের সূচনা হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>উনিশ শতকে</strong>: উনিশ শতকের শুরুতে ১৮০১ সালে ফোর্ট উইলিয়াম কলেজ প্রতিষ্ঠা এবং উইলিয়াম কেরি, রামরাম বসু ও মৃত্যুঞ্জয় বিদ্যালঙ্কারের রচনার মাধ্যমে বাংলা গদ্য সাহিত্যের আনুষ্ঠানিক সূচনা ঘটে।',
                'options' => [
                    ['A', 'নবম শতকে', false],
                    ['B', 'ত্রয়োদশ শতকে', false],
                    ['C', 'ষোড়শ শতকে', false],
                    ['D', 'উনিশ শতকে', true],
                ],
            ],
            [
                'stem' => 'বাংলা ভাষায় প্রথম সাময়িকপত্র কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>দিগদর্শন</strong>: শ্রীরামপুর মিশন থেকে ১৮১৮ সালের এপ্রিলে জন ক্লার্ক মার্শম্যানের সম্পাদনায় বাংলা ভাষার প্রথম মাসিক সাময়িকপত্র ‘দিগদর্শন’ প্রকাশিত হয়।',
                'options' => [
                    ['A', 'দিগদর্শন', true],
                    ['B', 'সংবাদ প্রভাকর', false],
                    ['C', 'তত্ত্ববোধিনী', false],
                    ['D', 'বঙ্গদর্শন', false],
                ],
            ],
            [
                'stem' => 'ইয়ং বেঙ্গল কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>ইংরেজি ভাবধারাপুষ্ট বাঙালি যুবক</strong>: হিন্দু কলেজের তরুণ অধ্যাপক হেনরি লুই ভিভিয়ান ডিরোজিওর মুক্তবুদ্ধি ও পাশ্চাত্য শিক্ষায় উদ্বুদ্ধ যুক্তিবাদী প্রগতিশীল বাঙালি তরুণ শিষ্যদের \'ইয়ং বেঙ্গল\' (Young Bengal) বলা হতো।',
                'options' => [
                    ['A', 'বাংলাভাষা শিক্ষার্থী ইংরেজ', false],
                    ['B', 'ইংরেজি ভাবধারাপুষ্ট বাঙালি যুবক', true],
                    ['C', 'একটি সাহিত্যিক গোষ্ঠীর নাম', false],
                    ['D', 'একটি সাময়িক পত্রের নাম', false],
                ],
            ],
            [
                'stem' => 'দীনবন্ধু মিত্রের প্রহসন কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>বিয়ে পাগলা বুড়ো</strong>: সমাজের অন্ধ বৃদ্ধদের বিবাহ লালসাকে ব্যঙ্গ করে দীনবন্ধু মিত্রের রচিত জনপ্রিয় সামাজিক প্রহসন হলো ‘বিয়ে পাগলা বুড়ো’ (১৮৬৬)।',
                'options' => [
                    ['A', 'বিয়ে পাগলা বুড়ো', true],
                    ['B', 'বুড়ো শালিকের ঘাড়ে রোঁ', false],
                    ['C', 'কিঞ্চিৎ জলযোগ', false],
                    ['D', 'কল্কি অবতার', false],
                ],
            ],
            [
                'stem' => 'মীর মশাররফ হোসেনের নাটক কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>বেহুলা গীতিনাভিনয়</strong>: মনসামঙ্গল কাব্যের লৌকিক কাহিনীর আশ্রয়ে মীর মশাররফ হোসেন রচিত পৌরাণিক গীতিনাট্য হলো ‘বেহুলা গীতিনাভিনয়’ (১৮৮৯)।',
                'options' => [
                    ['A', 'নটির পূজা', false],
                    ['B', 'বেহুলা গীতিনাভিনয়', true],
                    ['C', 'নবীন তপস্বিনী', false],
                    ['D', 'কৃষ্ণকুমারী', false],
                ],
            ],
            [
                'stem' => 'কলকাতায় প্রথম রঙ্গমঞ্চ তৈরি হয় কত সালে?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৭৫৩ সালে</strong>: লালবাজার প্রাঙ্গণে ইংরেজদের নাট্যাভিনয়ের সুবিধার্থে ১৭৫৩ সালে কলকাতায় প্রথম আধুনিক থিয়েটার বা প্লে-হাউস নাট্যমঞ্চ নির্মিত হয়েছিল।',
                'options' => [
                    ['A', '১৮১৭ সালে', false],
                    ['B', '১৮৩২ সালে', false],
                    ['C', '১৮৫২ সালে', false],
                    ['D', '১৭৫৩ সালে', true],
                ],
            ],
            [
                'stem' => 'রবীন্দ্রনাথ ঠাকুরের অতিপ্রাকৃত গল্প কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>ক্ষুধিত পাষাণ</strong>: মোগল প্রাসাদের অতৃপ্ত প্রেতাত্মা ও অলৌকিক রোমান্সের মায়াবী আবহ নিয়ে রচিত রবীন্দ্রনাথের শ্রেষ্ঠ অতিপ্রাকৃত মনস্তাত্ত্বিক গল্প হলো ‘ক্ষুধিত পাষাণ’।',
                'options' => [
                    ['A', 'একরাত্রি', false],
                    ['B', 'নষ্টনীড়', false],
                    ['C', 'ক্ষুধিত পাষাণ', true],
                    ['D', 'মধ্যবর্তিনী', false],
                ],
            ],
            [
                'stem' => 'বাংলা সাহিত্যের প্রথম মুসলিম ঔপন্যাসিকের নাম কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>মীর মশাররফ হোসেন</strong>: ১৮৭৩ সালে ‘রত্নাবতী’ উপন্যাস রচনার মধ্য দিয়ে মীর মশাররফ হোসেন বাংলা সাহিত্যের প্রথম মুসলিম ঔপন্যাসিক হিসেবে আত্মপ্রকাশ করেন।',
                'options' => [
                    ['A', 'মোজাম্মেল হোসেন', false],
                    ['B', 'ইসমাইল হোসেন সিরাজী', false],
                    ['C', 'মীর মশাররফ হোসেন', true],
                    ['D', 'ফররুখ আহমদ', false],
                ],
            ],
            [
                'stem' => 'নজরুল ইসলামের সম্পাদিত পত্রিকা কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>ধূমকেতু</strong>: ১৯২২ সালের ১১ আগস্ট কাজী নজরুল ইসলামের সম্পাদনায় অর্ধ-সাপ্তাহিক পত্রিকা ‘ধূমকেতু’ প্রথম প্রকাশিত হয়, যা ভারতীয় স্বাধীনতা সংগ্রামে তুমুল আলোড়ন সৃষ্টি করেছিল।',
                'options' => [
                    ['A', 'মাহে নও', false],
                    ['B', 'সওগাত', false],
                    ['C', 'ধূমকেতু', true],
                    ['D', 'কালিকলম', false],
                ],
            ],
            [
                'stem' => 'জীবনানন্দ দাশের প্রবন্ধগ্রন্থ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>কবিতার কথা</strong>: রূপসী বাংলার কবি জীবনানন্দ দাশের সুগভীর নন্দনতত্ত্ব ও কাব্যতত্ত্বমূলক বিখ্যাত প্রবন্ধ সংকলন হলো ‘কবিতার কথা’ (১৯৫৫)।',
                'options' => [
                    ['A', 'ধূসর পাণ্ডুলিপি', false],
                    ['B', 'কবিতার কথা', true],
                    ['C', 'ঝরা পালকের কবি', false],
                    ['D', 'দুর্দিনের যাত্রী', false],
                ],
            ],
            [
                'stem' => '‘সাত সাগরের মাঝি’ কাব্যগ্রন্থের রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ফররুখ আহমদ</strong>: মুসলিম জাগরণ ও রেনেসাঁর কবি ফররুখ আহমদের প্রথম ও শ্রেষ্ঠ কালজয়ী কাব্যগ্রন্থ হলো ‘সাত সাগরের মাঝি’ (১৯৪৪)।',
                'options' => [
                    ['A', 'কাজী নজরুল ইসলাম', false],
                    ['B', 'ফররুখ আহমদ', true],
                    ['C', 'আব্দুল কাদির', false],
                    ['D', 'বন্দে আলী মিয়া', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের ভাষা আন্দোলনভিত্তিক উপন্যাস কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>আরেক ফাল্গুন</strong>: ভাষা আন্দোলনের প্রত্যক্ষ পটভূমিতে কথাশিল্পী জহির রায়হান রচিত প্রথম ও অমর উপন্যাস হলো ‘আরেক ফাল্গুন’ (১৯৬৯)।',
                'options' => [
                    ['A', 'অগ্নিসাক্ষী', false],
                    ['B', 'চিলেকোঠার সেপাই', false],
                    ['C', 'আরেক ফাল্গুন', true],
                    ['D', 'অনেক সূর্যের আশা', false],
                ],
            ],
            [
                'stem' => 'মুক্তিযুদ্ধভিত্তিক উপন্যাস কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>জাহান্নাম হইতে বিদায়</strong>: কথাসাহিত্যিক শওকত ওসমান রচিত ১৯৭১ সালের মুক্তিযুদ্ধ ও পাকিস্তানি হানাদার বাহিনীর গণহত্যার নির্মম বাস্তবতার উপন্যাস ‘জাহান্নাম হইতে বিদায়’।',
                'options' => [
                    ['A', 'শঙ্খনীল কারাগার', false],
                    ['B', 'কাঁটাতারের প্রজাপতি', false],
                    ['C', 'জাহান্নাম হইতে বিদায়', true],
                    ['D', 'আর্তনাদ', false],
                ],
            ],
            [
                'stem' => 'শওকত ওসমান কোন উপন্যাসের জন্য আদমজী পুরস্কার লাভ করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>ক্রীতদাসের হাসি</strong>: আইয়ুব খানের সামরিক স্বৈরশাসনের বিরুদ্ধে রূপক ও প্রতীকাশ্রয়ী রাজনৈতিক উপন্যাস ‘ক্রীতদাসের হাসি’ (১৯৬২)-র জন্য শওকত ওসমান মর্যাদাপূর্ণ আদমজী সাহিত্য পুরস্কার লাভ করেন।',
                'options' => [
                    ['A', 'বনী আদম', false],
                    ['B', 'জননী', false],
                    ['C', 'চৌরসন্ধি', false],
                    ['D', 'ক্রীতদাসের হাসি', true],
                ],
            ],
            [
                'stem' => '‘উপরোধ’ শব্দের অর্থ কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>অনুরোধ</strong>: বাংলা শব্দ ‘উপরোধ’-এর আভিধানিক অর্থ সুপারিশ, অনুরোধ বা সাধ্যসাধনা।',
                'options' => [
                    ['A', 'প্রতিরোধ', false],
                    ['B', 'উপস্থাপন', false],
                    ['C', 'অনুরোধ', true],
                    ['D', 'উপযোগী', false],
                ],
            ],
            [
                'stem' => 'Dhaka is becoming one of the ––– cities in Asia.',
                'subject' => 'english',
                'explanation' => '<strong>busiest</strong>: \'One of the\' এর পরে superlative degree (\'busiest\') এবং plural noun (\'cities\') বসে।',
                'options' => [
                    ['A', 'more busy', false],
                    ['B', 'busy', false],
                    ['C', 'busiest', true],
                    ['D', 'most busiest', false],
                ],
            ],
            [
                'stem' => 'He had written the book before he––',
                'subject' => 'english',
                'explanation' => '<strong>retired</strong>: \'Before\'-এর পূর্বের ক্লজটি Past Perfect (\'had written\') হলে পরের ক্লজটি Past Indefinite (\'retired\') হয়।',
                'options' => [
                    ['A', 'retired', true],
                    ['B', 'had retired', false],
                    ['C', 'has retired', false],
                    ['D', 'will be retired', false],
                ],
            ],
            [
                'stem' => 'Rizvi requested Rini ––– telephone to attend the meeting.',
                'subject' => 'english',
                'explanation' => '<strong>by</strong>: টেলিফোন বা মাধ্যমের সাহায্যে যোগাযোগের ক্ষেত্রে \'by telephone\' বা \'over the telephone\' ব্যবহৃত হয়। এখানে \'by\' সঠিক।',
                'options' => [
                    ['A', 'over', false],
                    ['B', 'through', false],
                    ['C', 'with', false],
                    ['D', 'by', true],
                ],
            ],
            [
                'stem' => 'The word ‘precedence’ means––',
                'subject' => 'english',
                'explanation' => '<strong>priority</strong>: \'Precedence\' শব্দের অর্থ অগ্রাধিকার বা গুরুত্বের ক্রমানুসারে অগ্রে থাকা। এর হুবহু প্রতিশব্দ হলো \'priority\'।',
                'options' => [
                    ['A', 'example', false],
                    ['B', 'priority', true],
                    ['C', 'elderly', false],
                    ['D', 'Case', false],
                ],
            ],
            [
                'stem' => 'The prices of rice are--',
                'subject' => 'english',
                'explanation' => '<strong>rising</strong>: চালের মূল্য বৃদ্ধি পাচ্ছে বা চড়ছে অর্থে intransitive verb হিসেবে \'rising\' বসে। \'Raising\' হলো transitive verb যার object প্রয়োজন।',
                'options' => [
                    ['A', 'raising', false],
                    ['B', 'risen', false],
                    ['C', 'rising', true],
                    ['D', 'Raised', false],
                ],
            ],
            [
                'stem' => '‘To get along with’ means–',
                'subject' => 'english',
                'explanation' => '<strong>to adjust</strong>: Phrasal verb \'to get along with\'-এর অর্থ কারও সাথে মানিয়ে চলা বা বন্ধুত্বপূর্ণ সুসম্পর্ক বজায় রাখা (to harmonize or adjust)।',
                'options' => [
                    ['A', 'to adjust', true],
                    ['B', 'to accompany', false],
                    ['C', 'to interest', false],
                    ['D', 'to walk', false],
                ],
            ],
            [
                'stem' => '‘If winter comes, can spring be far behind?’ These lines were written by––',
                'subject' => 'english',
                'explanation' => '<strong>Shelley</strong>: রোমান্টিক কবি পার্সি বিশি শেলি (P.B. Shelley)-র অমর আশাবাদী কবিতা \'Ode to the West Wind\'-এর শেষ চরণ এটি।',
                'options' => [
                    ['A', 'Keats', false],
                    ['B', 'Frost', false],
                    ['C', 'Eliot', false],
                    ['D', 'Shelley', true],
                ],
            ],
            [
                'stem' => 'The verb of the word ‘short’ is––',
                'subject' => 'english',
                'explanation' => '<strong>shorten</strong>: \'Short\' (হ্রস্ব/সংক্ষিপ্ত) বিশেষণের সঠিক ক্রিয়ারূপ হলো \'shorten\' (ছোট বা সংক্ষিপ্ত করা)।',
                'options' => [
                    ['A', 'enshort', false],
                    ['B', 'shorten', true],
                    ['C', 'shorted', false],
                    ['D', 'Shorting', false],
                ],
            ],
            [
                'stem' => '‘Light’ is to ‘dark’ as ‘cold’ is to––',
                'subject' => 'english',
                'explanation' => '<strong>hot</strong>: এটি একটি বিপরীতার্থক সাদৃশ্য (Analogy): Light (আলো)-এর বিপরীত Dark (অন্ধকার), তেমনি Cold (ঠাণ্ডা)-এর বিপরীত Hot (গরম)।',
                'options' => [
                    ['A', 'hot', true],
                    ['B', 'heat', false],
                    ['C', 'cool', false],
                    ['D', 'Winter', false],
                ],
            ],
            [
                'stem' => 'Many prefer donating money ––– distributing clothes.',
                'subject' => 'english',
                'explanation' => '<strong>to</strong>: দুটি কাজের মধ্যে অধিকতর পছন্দ নির্দেশ করতে \'prefer\'-এর পর সর্বদা preposition \'to\' বসে: \'prefer donating money to distributing clothes\'।',
                'options' => [
                    ['A', 'than', false],
                    ['B', 'but', false],
                    ['C', 'to', true],
                    ['D', 'Without', false],
                ],
            ],
            [
                'stem' => 'Julia has been ill ––– three months.',
                'subject' => 'english',
                'explanation' => '<strong>for</strong>: কোনো নির্দিষ্ট সময়কালের বিস্তার বা ব্যাপ্তি (Period of time, যেমন \'three months\') বোঝাতে \'for\' বসে।',
                'options' => [
                    ['A', 'since', false],
                    ['B', 'about', false],
                    ['C', 'in', false],
                    ['D', 'for', true],
                ],
            ],
            [
                'stem' => 'We were waiting for the bus. The underlined part is––',
                'subject' => 'english',
                'explanation' => '<strong>a prepositional phrase</strong>: \'for the bus\' অংশটি preposition \'for\' দিয়ে শুরু হয়ে noun phrase \'the bus\'-কে যুক্ত করেছে, তাই এটি একটি Prepositional Phrase।',
                'options' => [
                    ['A', 'a noun phrase', false],
                    ['B', 'an infinitive phrase', false],
                    ['C', 'a prepositional phrase', true],
                    ['D', 'a verb phrase', false],
                ],
            ],
            [
                'stem' => 'The word ‘disinterested’ means–',
                'subject' => 'english',
                'explanation' => '<strong>neutral</strong>: \'Disinterested\' শব্দের অর্থ নিরপেক্ষ বা স্বার্থহীন (impartial, unbiased, or neutral)। অনেকে একে \'uninterested\' (অনগ্রহী)-এর সাথে ভুল করেন।',
                'options' => [
                    ['A', 'lack of interest', false],
                    ['B', 'indifferent', false],
                    ['C', 'callous', false],
                    ['D', 'Neutral', true],
                ],
            ],
            [
                'stem' => 'Who did write first English dictionary?',
                'subject' => 'english',
                'explanation' => '<strong>Samuel Johnson</strong>: ড. স্যামুয়েল জনসন ১৭৫৫ সালে নয় বছরের কঠোর পরিশ্রমে ইংরেজি ভাষার প্রথম প্রামাণ্য ও পূর্ণাঙ্গ অভিধান \'A Dictionary of the English Language\' সংকলন করেন।',
                'options' => [
                    ['A', 'Boswell', false],
                    ['B', 'Ben Jonson', false],
                    ['C', 'Samuel Johnson', true],
                    ['D', 'Milton', false],
                ],
            ],
            [
                'stem' => 'New programs will be ––– next week in Bangladesh Television.',
                'subject' => 'english',
                'explanation' => '<strong>telecast</strong>: \'Telecast\' বা \'Broadcast\' ক্রিয়ার Past ও Past Participle রূপও অপরিবর্তিত থেকে \'telecast\' ও \'broadcast\'-ই থাকে (\'telecasted\' ব্যাকরণগতভাবে ভুল)।',
                'options' => [
                    ['A', 'telecast', true],
                    ['B', 'published', false],
                    ['C', 'telecasted', false],
                    ['D', 'Broadcasted', false],
                ],
            ],
            [
                'stem' => 'The word ‘electorate’ means−',
                'subject' => 'english',
                'explanation' => '<strong>a body of voters</strong>: \'Electorate\' বলতে কোনো দেশ বা নির্বাচনী এলাকার সকল নিবন্ধিত ভোটারের সমষ্টিকে (a body of all qualified voters) বোঝায়।',
                'options' => [
                    ['A', 'election office', false],
                    ['B', 'a body of voters', true],
                    ['C', 'many elections', false],
                    ['D', 'candidates', false],
                ],
            ],
            [
                'stem' => '‘Animal Farm’ was written by–',
                'subject' => 'english',
                'explanation' => '<strong>George Orwell</strong>: সোভিয়েত সর্বগ্রাসী একনায়কতন্ত্রের ব্যঙ্গাত্মক রূপক উপন্যাস ‘অ্যানিমেল ফার্ম’ (Animal Farm, ১৯৪৫)-এর রচয়িতা জর্জ অরওয়েল।',
                'options' => [
                    ['A', 'George Orwell', true],
                    ['B', 'Stevenson', false],
                    ['C', 'Swift', false],
                    ['D', 'Mark Twain', false],
                ],
            ],
            [
                'stem' => 'There is no alternative ––– training.',
                'subject' => 'english',
                'explanation' => '<strong>to</strong>: কোনো কিছুর বিকল্প বোঝাতে \'alternative\'-এর পর appropriate preposition হিসেবে \'to\' বসে: \'alternative to training\'।',
                'options' => [
                    ['A', 'to', true],
                    ['B', 'for', false],
                    ['C', 'than', false],
                    ['D', 'of', false],
                ],
            ],
            [
                'stem' => 'Which sentence is correct?',
                'subject' => 'english',
                'explanation' => '<strong>This is a unique case</strong>: \'Unique\' শব্দের উচ্চারণ ব্যঞ্জনধ্বনি \'ইউ\' (ju:)-এর মতো হওয়ায় এর পূর্বে article \'a\' বসে এবং এটি absolute adjective হওয়ায় এর সাথে \'very\' বা \'most\' বসে না।',
                'options' => [
                    ['A', 'This is an unique case', false],
                    ['B', 'This is a unique case', true],
                    ['C', 'This is a very unique case', false],
                    ['D', 'This is the most unique case', false],
                ],
            ],
            [
                'stem' => 'I cannot ––– to pay such high prices.',
                'subject' => 'english',
                'explanation' => '<strong>afford</strong>: কোনো কিছু ক্রয় বা পরিশোধের আর্থিক সামর্থ্য বোঝাতে modal \'cannot\'-এর পর \'afford\' বসে: \'cannot afford to pay\'।',
                'options' => [
                    ['A', 'able', false],
                    ['B', 'but', false],
                    ['C', 'try', false],
                    ['D', 'afford', true],
                ],
            ],
            [
                'stem' => 'কোন গোষ্ঠী থেকে বাঙালি জাতির প্রধান অংশ গড়ে উঠেছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>অস্ট্রিক</strong>: নৃবিজ্ঞানীদের মতে প্রাচীনকালে আগত প্রাক-দ্রাবিড় বা অস্ট্রিক (অস্ট্রোলয়েড) নরগোষ্ঠী থেকেই মূলত বাঙালি জাতির প্রধান অংশ বা মৌলিক ভিত্তি গড়ে উঠেছে।',
                'options' => [
                    ['A', 'নেগ্রিটো', false],
                    ['B', 'ভোটচীন', false],
                    ['C', 'দ্রাবিড়', false],
                    ['D', 'অস্ট্রিক', true],
                ],
            ],
            [
                'stem' => 'ঢাকায় সর্বপ্রথম কবে বাংলার রাজধানী স্থাপিত হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৬১০ খ্রিস্টাব্দে</strong>: মুঘল সুবাদার ইসলাম খান চিশতি ১৬১০ খ্রিস্টাব্দে রাজমহল থেকে রাজধানী ঢাকায় স্থানান্তর করেন এবং শহরটির নাম রাখেন জাহাঙ্গীরনগর।',
                'options' => [
                    ['A', '১২০৬ খ্রিস্টাব্দে', false],
                    ['B', '১৩১০ খ্রিস্টাব্দে', false],
                    ['C', '১৬১০ খ্রিস্টাব্দে', true],
                    ['D', '১৫২৬ খ্রিস্টাব্দে', false],
                ],
            ],
            [
                'stem' => 'ঐতিহাসিক ২১-দফা দাবীর প্রথম দাবীটি কী ছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বাংলাকে অন্যতম রাষ্ট্রভাষা</strong>: ১৯৫৪ সালের যুক্তফ্রন্টের ঐতিহাসিক ২১ দফার প্রথম ও প্রধান দাবি ছিল— \'বাংলাকে পাকিস্তানের অন্যতম রাষ্ট্রভাষা করা\'।',
                'options' => [
                    ['A', 'বাংলাকে অন্যতম রাষ্ট্রভাষা', true],
                    ['B', 'প্রাদেশিক স্বায়ত্তশাসন', false],
                    ['C', 'পূর্ববাংলার অর্থনৈতিক বৈষম্য দূরীকরণ', false],
                    ['D', 'বিনা ক্ষতিপূরণে জমিদারী উচ্ছেদ', false],
                ],
            ],
            [
                'stem' => 'অপরাজেয় বাংলা কবে উদ্বোধন করা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৬ ডিসেম্বর, ১৯৭৯</strong>: ঢাকা বিশ্ববিদ্যালয় কলা ভবন প্রাঙ্গণে সৈয়দ আব্দুল্লাহ খালিদ নির্মিত অমর মুক্তিযুদ্ধের ভাস্কর্য ‘অপরাজেয় বাংলা’ ১৯৭৯ সালের বিজয় দিবসে (১৬ ডিসেম্বর) আনুষ্ঠানিকভাবে উদ্বোধন করা হয়।',
                'options' => [
                    ['A', '১৬ ডিসেম্বর, ১৯৭৯', true],
                    ['B', '২৬ ডিসেম্বর, ১৯৭৯', false],
                    ['C', '১ জানুয়ারি, ১৯৮০', false],
                    ['D', '২১ ফেব্রুয়ারি, ১৯৮০', false],
                ],
            ],
            [
                'stem' => 'জাতীয় স্মৃতিসৌধের উচ্চতা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪৬.৫ মি.</strong>: সাভারে অবস্থিত জাতীয় স্মৃতিসৌধের মূল কাঠামোর ভূমি হতে শীর্ষদেশ পর্যন্ত উচ্চতা হলো ১৫০ ফুট বা ৪৬.৫ মিটার।',
                'options' => [
                    ['A', '৪৬.৫ মি.', true],
                    ['B', '৪৬ মি.', false],
                    ['C', '৪৫.৫ মি.', false],
                    ['D', '৪৫ মি.', false],
                ],
            ],
            [
                'stem' => 'হাজংদের অধিবাস কোথায়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ময়মনসিংহ ও নেত্রকোনা</strong>: বাংলাদেশের উত্তরাঞ্চলের ময়মনসিংহ, নেত্রকোনা ও শেরপুরের গারো পাহাড়ের পাদদেশে প্রধানত হাজং ক্ষুদ্র নৃগোষ্ঠীর বসবাস।',
                'options' => [
                    ['A', 'ময়মনসিংহ ও নেত্রকোনা', true],
                    ['B', 'কক্সবাজার ও রামু', false],
                    ['C', 'রংপুর ও দিনাজপুর', false],
                    ['D', 'সিলেট ও মণিপুর', false],
                ],
            ],
            [
                'stem' => 'নিঝুম দ্বীপের আয়তন কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৮০ বা ৯২ বর্গ কিমি</strong>: নোয়াখালী জেলার হাতিয়া উপজেলার দক্ষিণে মেঘনার মোহনায় অবস্থিত বাল্লার চর বা নিঝুম দ্বীপের বর্তমান আনুমানিক ভৌগোলিক আয়তন প্রায় ৯২ বর্গকিলোমিটার (তৎকালীন অপশনে ৮০ বর্গমাইল হিসেবে উল্লেখিত)।',
                'options' => [
                    ['A', '৮০ ব.মা.', true],
                    ['B', '৮২ ব.মা.', false],
                    ['C', '৮৫ ব.মা.', false],
                    ['D', '৯০ ব.মা.', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে গ্রামের সংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৮৭১৯১ টি</strong>: ঐতিহ্যগতভাবে সরকারি আদমশুমারি ও পরিসংখ্যান প্রতিবেদনে বাংলাদেশে মোট গ্রামের সংখ্যা ৮৭,১৯১টি হিসেবে প্রচলিত।',
                'options' => [
                    ['A', '৮৭১৯১ টি', true],
                    ['B', '৮৪৫০০ টি', false],
                    ['C', '৮৫৫০০ টি', false],
                    ['D', '৮৩৯০০ টি', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের প্রথম জাতীয় সংসদ নির্বাচন কবে হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৭ মার্চ, ১৯৭৩</strong>: স্বাধীন বাংলাদেশের প্রথম জাতীয় সংসদ নির্বাচন অনুষ্ঠিত হয় ১৯৭৩ সালের ৭ মার্চ, যেখানে ৩০০ আসনের মধ্যে আওয়ামী লীগ ২৯৩ আসনে বিপুল জয়লাভ করে।',
                'options' => [
                    ['A', '৭ মার্চ, ১৯৭৩', true],
                    ['B', '৫ মার্চ, ১৯৭৩', false],
                    ['C', '৬ এপ্রিল, ১৯৭৩', false],
                    ['D', '১১ এপ্রিল, ১৯৭৩', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের সবচেয়ে ছোট ইউনিয়ন কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সেন্টমার্টিন</strong>: কক্সবাজারের টেকনাফ উপজেলার প্রবালদ্বীপ সেন্টমার্টিন ইউনিয়ন আয়তন ও জনসংখ্যার দিক দিয়ে বাংলাদেশের সবচেয়ে ক্ষুদ্র ইউনিয়ন পরিষদ।',
                'options' => [
                    ['A', 'সেন্টমার্টিন', true],
                    ['B', 'লালপুর', false],
                    ['C', 'হিলি', false],
                    ['D', 'লালমোহন', false],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্রের সিনেটের মোট আসন সংখ্যা কতটি?',
                'subject' => 'international',
                'explanation' => '<strong>১০০</strong>: মার্কিন আইনসভা কংগ্রেসের উচ্চকক্ষ সিনেটে ৫০টি অঙ্গরাজ্যের প্রতিটির সমান প্রতিনিধিত্ব নিশ্চিত করতে ২ জন করে মোট ১০০ জন সিনেটর থাকেন।',
                'options' => [
                    ['A', '৯৯', false],
                    ['B', '১০০', true],
                    ['C', '১০১', false],
                    ['D', '১০২', false],
                ],
            ],
            [
                'stem' => 'ফেয়ার ফ্যাক্স কী?',
                'subject' => 'international',
                'explanation' => '<strong>গোয়েন্দা সংস্থা</strong>: ফেয়ারফ্যাক্স গ্রুপ (Fairfax Group) হলো মার্কিন যুক্তরাষ্ট্রে অবস্থিত একটি আন্তর্জাতিক খ্যাতিসম্পন্ন বেসরকারি নিরাপত্তা ও আর্থিক গোয়েন্দা তদন্ত সংস্থা।',
                'options' => [
                    ['A', 'সংবাদ সংস্থা', false],
                    ['B', 'পরিবেশ সংস্থা', false],
                    ['C', 'গোয়েন্দা সংস্থা', true],
                    ['D', 'মানবাধিকার সংস্থা', false],
                ],
            ],
            [
                'stem' => 'NASA -এর সদর দপ্তর কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>ওয়াশিংটন ডিসি</strong>: মার্কিন যুক্তরাষ্ট্রের মহাকাশ গবেষণা সংস্থা নাসা (NASA)-এর কেন্দ্রীয় সদর দপ্তর রাজধানী ওয়াশিংটন ডি.সি.-তে অবস্থিত।',
                'options' => [
                    ['A', 'ফ্লোরিডা', false],
                    ['B', 'ওয়াশিংটন ডিসি', true],
                    ['C', 'কেপ কেনেডি', false],
                    ['D', 'টেক্সাস', false],
                ],
            ],
            [
                'stem' => 'দক্ষিণ আফ্রিকা কত বছর শ্বেতাঙ্গ শাসনে ছিল?',
                'subject' => 'international',
                'explanation' => '<strong>৩৪২ বছর</strong>: ১৬৫২ সালে ওলন্দাজ জান ফন রিয়েবেকের আগমন থেকে শুরু করে ১৯৯৪ সালে নেলসন ম্যান্ডেলার গণতান্ত্রিক নির্বাচনের মাধ্যমে বর্ণবাদ অবসান পর্যন্ত দক্ষিণ আফ্রিকা দীর্ঘ ৩৪২ বছর শ্বেতাঙ্গ শাসনাধীনে ছিল।',
                'options' => [
                    ['A', '৩০০ বছর', false],
                    ['B', '৩৩৫ বছর', false],
                    ['C', '৩৪২ বছর', true],
                    ['D', '৫০০ বছর', false],
                ],
            ],
            [
                'stem' => 'বসনিয়ার যুদ্ধবিরতি স্বাক্ষরের মধ্যস্থতাকারী কে?',
                'subject' => 'international',
                'explanation' => '<strong>বিল ক্লিনটন</strong>: ১৯৯৫ সালে মার্কিন প্রেসিডেন্ট বিল ক্লিনটনের উদ্যোগে যুক্তরাষ্ট্রের ওহাইওর ডেটনে ঐতিহাসিক \'ডেটন শান্তি চুক্তি\' স্বাক্ষরের মাধ্যমে বসনীয় যুদ্ধের অবসান ঘটে।',
                'options' => [
                    ['A', 'বিল ক্লিনটন', true],
                    ['B', 'জিমি কার্টার', false],
                    ['C', 'নিক্সন', false],
                    ['D', 'রিগান', false],
                ],
            ],
            [
                'stem' => 'ফ্রান্সের বর্তমান প্রেসিডেন্টের নাম কী?',
                'subject' => 'international',
                'explanation' => '<strong>ইমানুয়েল ম্যাক্রোঁ</strong>: বর্তমান ফরাসি প্রজাতন্ত্রের প্রেসিডেন্ট হলেন ইমানুয়েল ম্যাক্রোঁ (তৎকালীন বিসিএস পরীক্ষার সময় প্রেসিডেন্ট ছিলেন জ্যাক শিরাক)।',
                'options' => [
                    ['A', 'ইমানুয়েল ম্যাক্রোঁ', true],
                    ['B', 'জ্যাক শিরাক', false],
                    ['C', 'ফ্রঁসোয়ে মিতেরাঁ', false],
                    ['D', 'জেনারেল দ্য গল', false],
                ],
            ],
            [
                'stem' => 'হোয়াংহো নদীর উৎপত্তিস্থল কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>কুয়েনলুন পর্বত</strong>: চীনের দ্বিতীয় দীর্ঘতম এবং \'চীনের দুঃখ\' হিসেবে পরিচিত ৫,৪৬৪ কিমি দীর্ঘ হোয়াংহো (হলুদ নদী) পশ্চিম চীনের কুয়েনলুন (বায়ান হার) পর্বতমালা থেকে উৎপত্তি লাভ করেছে।',
                'options' => [
                    ['A', 'হিমালয়', false],
                    ['B', 'কুয়েনলুন পর্বত', true],
                    ['C', 'ব্ল্যাক ফরেস্ট', false],
                    ['D', 'আল্পস', false],
                ],
            ],
            [
                'stem' => 'মেক্সিকো ও যুক্তরাষ্ট্র বিভক্তকারী সীমারেখা কোনটি?',
                'subject' => 'international',
                'explanation' => '<strong>সনোরা লাইন</strong>: মেক্সিকো ও যুক্তরাষ্ট্রের দক্ষিণ-পশ্চিম সীমানায় অবস্থিত সীমানা রেখাকে সনোরা লাইন (বা রিও গ্র্যান্ডে নদী সীমানা) বলা হয়।',
                'options' => [
                    ['A', 'সনোরা লাইন', true],
                    ['B', 'ম্যাকনামারা লাইন', false],
                    ['C', 'ডুরান্ড লাইন', false],
                    ['D', 'হিন্ডারবার্গ লাইন', false],
                ],
            ],
            [
                'stem' => 'ইউরোপের ককপিট বলা হয় কোন দেশকে?',
                'subject' => 'international',
                'explanation' => '<strong>বেলজিয়াম</strong>: ইউরোপের বহু ঐতিহাসিক যুদ্ধ (যেমন: ওয়াটারলুর যুদ্ধ) বেলজিয়ামের মাটিতে সংঘটিত হওয়ায় ভৌগোলিকভাবে দেশটিকে \'ইউরোপের ককপিট\' (Cockpit of Europe) বা রণক্ষেত্র বলা হয়।',
                'options' => [
                    ['A', 'বেলজিয়াম', true],
                    ['B', 'ফ্রান্স', false],
                    ['C', 'জার্মানি', false],
                    ['D', 'ফিনল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'বিশ্বের কোন দেশের স্বাক্ষরতার হার ১০০%?',
                'subject' => 'international',
                'explanation' => '<strong>ফিনল্যান্ড</strong>: উত্তর ইউরোপের নর্ডিক দেশ ফিনল্যান্ডের প্রাথমিক ও মাধ্যমিক শিক্ষা ব্যবস্থা অত্যন্ত সমৃদ্ধ হওয়ায় তাদের স্বাক্ষরতার হার শতভাগ (১০০%)।',
                'options' => [
                    ['A', 'পোল্যান্ড', false],
                    ['B', 'ফিনল্যান্ড', true],
                    ['C', 'কাজাখস্তান', false],
                    ['D', 'স্লোভাকিয়া', false],
                ],
            ],
            [
                'stem' => 'রেফ্রিজারেটরে কম্প্রেসরের কাজ কী?',
                'subject' => 'science',
                'explanation' => '<strong>ফ্রেয়নকে বাষ্পে পরিণত করা / সংকুচিত করা</strong>: রেফ্রিজারেটরের কম্প্রেসর বাষ্পীভূত কুলিং গ্যাস বা ফ্রেয়নকে উচ্চ চাপে সংকুচিত করে কন্ডেনসারে পাঠিয়ে তাপ মুক্ত করতে বাধ্য করে।',
                'options' => [
                    ['A', 'ফ্রেয়নকে ঘনীভূত করা', false],
                    ['B', 'ফ্রেয়নকে বাষ্পে পরিণত করা', true],
                    ['C', 'ফ্রেয়নকে সংকুচিত করে এর তাপ ও তাপমাত্রা বাড়ানো', false],
                    ['D', 'ফ্রেয়নকে ঠাণ্ডা করা', false],
                ],
            ],
            [
                'stem' => 'এক গ্রাম পানির তাপমাত্রা ২০° হতে ৩০° সেলসিয়াসে বৃদ্ধির জন্য কত তাপের প্রয়োজন?',
                'subject' => 'science',
                'explanation' => '<strong>১০ ক্যালরি</strong>: ১ গ্রাম বিশুদ্ধ পানির তাপমাত্রা ১° সেলসিয়াস বৃদ্ধি করতে ১ ক্যালরি তাপের প্রয়োজন। অতএব ২০° থেকে ৩০° (পার্থক্য ১০°C) বাড়াতে তাপ লাগবে ১ × ১০ = ১০ ক্যালরি।',
                'options' => [
                    ['A', '১০ ক্যালরি', true],
                    ['B', '২ ক্যালরি', false],
                    ['C', '৩ ক্যালরি', false],
                    ['D', '৪ ক্যালরি', false],
                ],
            ],
            [
                'stem' => 'কোন শব্দ শোনার পরে কত সেকেন্ড পর্যন্ত এর রেশ আমাদের মস্তিষ্কে থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>০.১ সেকেন্ড</strong>: কোনো শব্দ শোনার পর মানব মস্তিষ্কে তার প্রভাব বা অনুভূতি প্রায় ১/১০ সেকেন্ড বা ০.১ সেকেন্ড পর্যন্ত অক্ষুণ্ণ থাকে, একে শব্দের অনুভূতি স্থায়িত্বকাল (Persistance of hearing) বলে।',
                'options' => [
                    ['A', '১ সেকেন্ড', false],
                    ['B', '০.১ সেকেন্ড', true],
                    ['C', '০.০১ সেকেন্ড', false],
                    ['D', '০.০০১ সেকেন্ড', false],
                ],
            ],
            [
                'stem' => 'টেপ রেকর্ডার এবং কম্পিউটারের স্মৃতির ফিতায় কী ধরনের চুম্বক ব্যবহৃত হয়?',
                'subject' => 'science',
                'explanation' => '<strong>স্থায়ী চুম্বক</strong>: ম্যাগনেটিক টেপ ও রেকর্ডিং মাধ্যমে ফেরোম্যাগনেটিক উপাদান (যেমন আয়রন অক্সাইড বা ক্রোমিয়াম ডাই অক্সাইড)-এর স্থায়ী চুম্বকত্ব বৈশিষ্ট্যকে তথ্য সংরক্ষণে কাজে লাগানো হয়।',
                'options' => [
                    ['A', 'স্থায়ী চুম্বক', true],
                    ['B', 'অস্থায়ী চুম্বক', false],
                    ['C', 'সংকর চুম্বক', false],
                    ['D', 'প্রাকৃতিক চুম্বক', false],
                ],
            ],
            [
                'stem' => 'টেলিভিশনে রঙিন ছবি উৎপাদনের জন্য কয়টি মৌলিক রং-এর ছবি ব্যবহার করা হয়?',
                'subject' => 'science',
                'explanation' => '<strong>৩টি</strong>: কালার টেলিভিশনে তিনটি মৌলিক বর্ণ— লাল (Red), সবুজ (Green) এবং নীল (Blue) বা সংক্ষেপে RGB ব্যবহারের মাধ্যমে অন্যান্য সকল দৃশ্যমান বর্ণ তৈরি করা হয়।',
                'options' => [
                    ['A', '১টি', false],
                    ['B', '২টি', false],
                    ['C', '৩টি', true],
                    ['D', '৪টি', false],
                ],
            ],
            [
                'stem' => 'পৃথিবীতে কখন ল্যাপটপ কম্পিউটার প্রবর্তিত হয় এবং কোন কোম্পানি এটা তৈরি করে?',
                'subject' => 'science',
                'explanation' => '<strong>এপসন, ১৯৮১</strong>: ১৯৮১ সালে জাপানি প্রযুক্তি নির্মাতা প্রতিষ্ঠান এপসন (Epson) কর্তৃক উদ্ভাবিত ব্যাটারিচালিত \'Epson HX-20\' হলো বিশ্বের প্রথম বাণিজ্যিক পোর্টেবল হ্যান্ডহেল্ড ল্যাপটপ কম্পিউটার।',
                'options' => [
                    ['A', 'কমপ্যাক, ১৯৮৫', false],
                    ['B', 'এপসন, ১৯৮১', true],
                    ['C', 'আইবিএম, ১৯৮৩', false],
                    ['D', 'অ্যাপল, ১৯৭৭', false],
                ],
            ],
            [
                'stem' => 'যে যন্ত্রের সাহায্যে পরবর্তী উচ্চ বিভবকে নিম্ন বিভবে এবং নিম্ন বিভবকে উচ্চ বিভবে রূপান্তরিত করা হয় তার নাম কী?',
                'subject' => 'science',
                'explanation' => '<strong>ট্রান্সফরমার</strong>: তড়িৎচৌম্বকীয় আবেশ নীতির ওপর ভিত্তি করে পরিবর্তনশীল উচ্চ বিভবকে নিম্ন বিভবে (Step-down) কিংবা নিম্ন বিভবকে উচ্চ বিভবে (Step-up) রূপান্তরকারী স্থির যন্ত্র হলো ট্রান্সফরমার।',
                'options' => [
                    ['A', 'ট্রান্সফরমার', true],
                    ['B', 'মোটর', false],
                    ['C', 'জেনারেটর', false],
                    ['D', 'ডায়নামো', false],
                ],
            ],
            [
                'stem' => 'বিদ্যুৎ বিলের হিসাব কীভাবে করা হয়?',
                'subject' => 'science',
                'explanation' => '<strong>কিলোওয়াট ঘণ্টায়</strong>: গৃহস্থালি ও বাণিজ্যিক বিদ্যুৎ ব্যবহারের একক হিসেবে বোর্ড অব ট্রেড ইউনিট (BOT unit) বা কিলোওয়াট-ঘণ্টা (kWh) ব্যবহৃত হয় (১ ইউনিট = ১ কিলোওয়াট লোড ১ ঘণ্টা চালনা)।',
                'options' => [
                    ['A', 'ওয়াট আওয়ারে', false],
                    ['B', 'ওয়াটে', false],
                    ['C', 'ভোল্টে', false],
                    ['D', 'কিলোওয়াট ঘণ্টায়', true],
                ],
            ],
            [
                'stem' => 'কোনটি পানিতে দ্রবীভূত হয় না?',
                'subject' => 'science',
                'explanation' => '<strong>ক্যালসিয়াম কার্বনেট</strong>: ক্যালসিয়াম কার্বনেট (CaCO3) বা চক/চুনাপাথর পানিতে সম্পূর্ণ অদ্রবণীয়। লবণ (NaCl), ফিটকিরি ও গ্লিসারিন পানিতে সহজে দ্রবীভূত হয়।',
                'options' => [
                    ['A', 'গ্লিসারিন', false],
                    ['B', 'ফিটকিরি', false],
                    ['C', 'সোডিয়াম ক্লোরাইড', false],
                    ['D', 'ক্যালসিয়াম কার্বনেট', true],
                ],
            ],
            [
                'stem' => 'পারমাণবিক চুল্লিতে তাপ পরিবাহক হিসেবে কোন ধাতু ব্যবহৃত হয়?',
                'subject' => 'science',
                'explanation' => '<strong>সোডিয়াম</strong>: নিউক্লিয়ার রিঅ্যাক্টরে ফাস্ট ব্রিডার চুল্লিতে উচ্চ তাপ শোষণ ও পরিবহন নিশ্চিত করতে তরল সোডিয়াম (Liquid Sodium) কুল্যান্ট হিসেবে ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'সোডিয়াম', true],
                    ['B', 'পটাশিয়াম', false],
                    ['C', 'ম্যাগনেসিয়াম', false],
                    ['D', 'কোনোটিই নয়', false],
                ],
            ],
            [
                'stem' => 'চা পাতায় কোন ভিটামিন থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>ভিটামিন-বি কমপ্লেক্স</strong>: চা পাতায় উল্লেখযোগ্য পরিমাণে পানিতে দ্রবণীয় ভিটামিন-বি কমপ্লেক্স (থায়ামিন, রিবোফ্লাভিন, নিয়াসিন ইত্যাদি) এবং ফলিক এসিড বিদ্যমান।',
                'options' => [
                    ['A', 'ভিটামিন-ই', false],
                    ['B', 'ভিটামিন-কে', false],
                    ['C', 'ভিটামিন-বি কমপ্লেক্স', true],
                    ['D', 'ভিটামিন-এ', false],
                ],
            ],
            [
                'stem' => 'উদ্ভিদের পাতা হলদে হয়ে যায় কিসের অভাবে?',
                'subject' => 'science',
                'explanation' => '<strong>নাইট্রোজেনের</strong>: উদ্ভিদে ক্লোরোফিল অণুর অন্যতম প্রধান উপাদান হলো নাইট্রোজেন। এর অভাবে উদ্ভিদে ক্লোরোফিল তৈরি বিঘ্নিত হয়ে পাতা হলদে হয়ে যায়, যাকে \'ক্লোরোসিস\' (Chlorosis) বলে।',
                'options' => [
                    ['A', 'নাইট্রোজেনের', true],
                    ['B', 'ফসফরাসের', false],
                    ['C', 'ইউরিয়ার', false],
                    ['D', 'পটাশিয়ামের', false],
                ],
            ],
            [
                'stem' => 'মানুষের স্পাইনাল কর্ডের দৈর্ঘ্য কত?',
                'subject' => 'science',
                'explanation' => '<strong>১৮ ইঞ্চি (প্রায়)</strong>: মানবদেহের সুষুম্নাকাণ্ড বা স্পাইনাল কর্ডের (Spinal cord) গড় দৈর্ঘ্য প্রাপ্তবয়স্ক পুরুষে প্রায় ৪৫ সেন্টিমিটার বা প্রায় ১৮ ইঞ্চি।',
                'options' => [
                    ['A', '১৫ ইঞ্চি (প্রায়)', false],
                    ['B', '১৭ ইঞ্চি (প্রায়)', false],
                    ['C', '১৮ ইঞ্চি (প্রায়)', true],
                    ['D', '২০ ইঞ্চি (প্রায়)', false],
                ],
            ],
            [
                'stem' => 'ক্যান্সার রোগের কারণ কী?',
                'subject' => 'science',
                'explanation' => '<strong>কোষের অস্বাভাবিক বৃদ্ধি</strong>: ডিএনএ মিউটেশনের ফলে কোষ বিভাজনের স্বাভাবিক নিয়ন্ত্রণ ব্যবস্থা ভেঙে পড়ে দেহের কোনো অংশের কোষ যখন অস্বাভাবিক ও অনিয়ন্ত্রিতভাবে বৃদ্ধি পেতে থাকে, তখন ম্যালিগন্যান্ট টিউমার বা ক্যান্সার রোগ সৃষ্টি হয়।',
                'options' => [
                    ['A', 'কোষের অস্বাভাবিক মৃত্যু', false],
                    ['B', 'কোষের অস্বাভাবিক বৃদ্ধি', true],
                    ['C', 'কোষের অস্বাভাবিক জমাট বাঁধা', false],
                    ['D', 'উপরের সবগুলো', false],
                ],
            ],
            [
                'stem' => 'ইনসুলিন নিঃসৃত হয় কোথা থেকে?',
                'subject' => 'science',
                'explanation' => '<strong>অগ্ন্যাশয় হতে</strong>: অগ্ন্যাশয়ের (Pancreas) অন্তঃখরা গ্রন্থি আইলেটস অব ল্যাঙ্গারহ্যান্সের বিটা (β) কোষ থেকে ইনসুলিন হরমোন নিঃসৃত হয়, যা রক্তের গ্লুকোজের মাত্রা নিয়ন্ত্রণ করে।',
                'options' => [
                    ['A', 'অগ্ন্যাশয় হতে', true],
                    ['B', 'প্যানক্রিয়াস হতে', false],
                    ['C', 'লিভার হতে', false],
                    ['D', 'পিটুইটারী গ্ল্যান্ড হতে', false],
                ],
            ],
            [
                'stem' => 'সুষম খাদ্যের উপাদান কয়টি?',
                'subject' => 'science',
                'explanation' => '<strong>৬ টি</strong>: মানবদেহের স্বাস্থ্য সুরক্ষায় সুষম খাদ্যে ৬টি প্রধান উপাদান বিদ্যমান থাকে: শর্করা, আমিষ, স্নেহ বা ফ্যাট, ভিটামিন, খনিজ লবণ এবং পানি।',
                'options' => [
                    ['A', '৪ টি', false],
                    ['B', '৫ টি', false],
                    ['C', '৬ টি', true],
                    ['D', '৮ টি', false],
                ],
            ],
            [
                'stem' => 'জীবজগতের জন্য সবচেয়ে ক্ষতিকারক রশ্মি কোনটি?',
                'subject' => 'science',
                'explanation' => '<strong>গামা রশ্মি</strong>: অতি উচ্চ কম্পাঙ্ক ও তীব্র ভেদন ক্ষমতাসম্পন্ন তেজস্ক্রিয় গামা রশ্মি (Gamma Ray) সরাসরি জীবকোষের নিউক্লিয়াসে প্রবেশ করে ডিএনএ ধ্বংস ও মিউটেশন ঘটিয়ে মারাত্মক ক্ষতি সৃষ্টি করে।',
                'options' => [
                    ['A', 'আল্ট্রা-ভায়োলেট রশ্মি', false],
                    ['B', 'বিটা রশ্মি', false],
                    ['C', 'আলফা রশ্মি', false],
                    ['D', 'গামা রশ্মি', true],
                ],
            ],
            [
                'stem' => 'জনসংখ্যা বৃদ্ধির ফলে ব্যাপকভাবে ক্ষতিগ্রস্ত হচ্ছে কী?',
                'subject' => 'science',
                'explanation' => '<strong>প্রাকৃতিক পরিবেশ</strong>: অপরিকল্পিত জনসংখ্যা বৃদ্ধির ফলে বন উজাড়, জলাশয় ভরাট ও দূষণের কারণে সবচেয়ে বেশি বিপর্যস্ত ও ক্ষতিগ্রস্ত হচ্ছে আমাদের চারপাশের প্রাকৃতিক পরিবেশ ও বাস্তুতন্ত্র।',
                'options' => [
                    ['A', 'প্রাকৃতিক পরিবেশ', true],
                    ['B', 'সামাজিক পরিবেশ', false],
                    ['C', 'বায়বীয় পরিবেশ', false],
                    ['D', 'সাংস্কৃতিক পরিবেশ', false],
                ],
            ],
            [
                'stem' => 'কোথায় দিন রাত্রি সর্বত্র সমান?',
                'subject' => 'science',
                'explanation' => '<strong>নিরক্ষরেখায়</strong>: পৃথিবীর মেরুরেখার হেলে থাকার প্রভাব সত্ত্বেও নিরক্ষরেখায় (Equator / 0° অক্ষাংশ) সূর্য সারা বছর প্রায় লম্বভাবে আলো দেওয়ায় এখানে সর্বদা দিন ও রাত সমান (১২ ঘণ্টা করে) থাকে।',
                'options' => [
                    ['A', 'মেরু অঞ্চলে', false],
                    ['B', 'নিরক্ষরেখায়', true],
                    ['C', 'উত্তর গোলার্ধে', false],
                    ['D', 'দক্ষিণ গোলার্ধে', false],
                ],
            ],
            [
                'stem' => 'ছায়াপথ তার নিজ অক্ষকে কেন্দ্র করে ঘুরে আসতে যে সময় লাগে তাকে কী বলে?',
                'subject' => 'science',
                'explanation' => '<strong>কসমিক ইয়ার</strong>: সৌরজগৎসহ আমাদের ছায়াপথ আকাশগঙ্গার (Milky Way) কেন্দ্রের চারদিকে একবার ঘুরে আসতে প্রায় ২২ কোটি ৫০ লাখ থেকে ২৫ কোটি বছর সময় লাগে, এই সময়কালকে কসমিক বছর বা কসমিক ইয়ার (Cosmic Year) বলা হয়।',
                'options' => [
                    ['A', 'সৌর বছর', false],
                    ['B', 'কসমিক ইয়ার', true],
                    ['C', 'আলোক বর্ষ', false],
                    ['D', 'পলিসার', false],
                ],
            ],
            [
                'stem' => 'A rocket flying to the moon does not need wings because–',
                'subject' => 'science',
                'explanation' => '<strong>space is airless</strong>: বিমানের ডানার জন্য বায়ুমণ্ডলীয় উত্তোলক বল (Lift force) দরকার হয়, কিন্তু মহাকাশ বাতাসহীন ও শূন্য (airless) হওয়ায় রকেটের ডানার প্রয়োজন হয় না।',
                'options' => [
                    ['A', 'it has no engine', false],
                    ['B', 'space has too much dust', false],
                    ['C', 'it has no fuel', false],
                    ['D', 'space is airless', true],
                ],
            ],
            [
                'stem' => 'Rubber is notable for its–',
                'subject' => 'science',
                'explanation' => '<strong>elasticity</strong>: রাবার তার অনন্য স্থিতিস্থাপকতা (Elasticity / Flexibility)-র জন্য সুপরিচিত, যার কারণে টানলে এটি প্রসারিত হয় এবং বল অপসারণে পূর্বাবস্থায় ফিরে আসে।',
                'options' => [
                    ['A', 'lightness', false],
                    ['B', 'heaviness', false],
                    ['C', 'elasticity', true],
                    ['D', 'viscosity', false],
                ],
            ],
            [
                'stem' => 'Julius caesar was the ruler of Rome about–',
                'subject' => 'international',
                'explanation' => '<strong>2000 years ago</strong>: জুলিয়াস সিজার খ্রিস্টপূর্ব ১০০ অব্দে জন্মগ্রহণ করেন এবং খ্রিস্টপূর্ব ৪৪ অব্দে নিহত হন, অর্থাৎ তিনি প্রায় ২০০০ বছর পূর্বে রোমের একনায়ক শাসক ছিলেন।',
                'options' => [
                    ['A', '1000 years ago', false],
                    ['B', '1500 years ago', false],
                    ['C', '2000 years ago', true],
                    ['D', '3000 years ago', false],
                ],
            ],
            [
                'stem' => 'The South Pole is located in the––',
                'subject' => 'international',
                'explanation' => '<strong>Antarctic</strong>: পৃথিবীর দক্ষিণ মেরু (South Pole) অ্যান্টার্কটিকা (Antarctic) মহাদেশের বরফাচ্ছাদিত ভূখণ্ডে অবস্থিত। (উত্তর মেরু আর্কটিক মহাসাগরে অবস্থিত)।',
                'options' => [
                    ['A', 'Arctic', false],
                    ['B', 'Antarctic', true],
                    ['C', 'Antipodes', false],
                    ['D', 'Occident', false],
                ],
            ],
            [
                'stem' => 'Tiger : Zoology : Mars :?',
                'subject' => 'english',
                'explanation' => '<strong>Astronomy</strong>: বাঘ প্রাণিবিদ্যার (Zoology) আলোচনার বিষয়, তেমনি মঙ্গল গ্রহ (Mars) জ্যোতির্বিজ্ঞানের (Astronomy) আলোচনার বিষয়।',
                'options' => [
                    ['A', 'Astrology', false],
                    ['B', 'Cryptology', false],
                    ['C', 'Astronomy', true],
                    ['D', 'Telescopy', false],
                ],
            ],
            [
                'stem' => 'Break : Repair : : Wound :?',
                'subject' => 'english',
                'explanation' => '<strong>Heal</strong>: কোনো বস্তু ভেঙে গেলে তা মেরামত (Repair) করতে হয়, তেমনি কোনো ক্ষত (Wound) হলে তা নিরাময় বা সুস্থ (Heal) হতে হয়।',
                'options' => [
                    ['A', 'Heal', true],
                    ['B', 'Hurt', false],
                    ['C', 'Fix', false],
                    ['D', 'Plaster', false],
                ],
            ],
            [
                'stem' => 'Frightened : Scream : : Angry :?',
                'subject' => 'english',
                'explanation' => '<strong>Shout</strong>: মানুষ ভীত বা শঙ্কিত হলে আর্তনাদ (Scream) করে, আর রাগান্বিত হলে চিৎকার বা চেঁচামেচি (Shout) করে।',
                'options' => [
                    ['A', 'Cry', false],
                    ['B', 'Shiver', false],
                    ['C', 'Shout', true],
                    ['D', 'Sneer', false],
                ],
            ],
            [
                'stem' => 'He –––– consciousness as a result of his head hitting the car’s dashboard.',
                'subject' => 'english',
                'explanation' => '<strong>lost</strong>: মাথায় আঘাতের ফলে জ্ঞান বা চেতনা হারিয়ে ফেলার ক্ষেত্রে উপযুক্ত অভিব্যক্তি হলো \'lost consciousness\'।',
                'options' => [
                    ['A', 'failed', false],
                    ['B', 'broke', false],
                    ['C', 'lost', true],
                    ['D', 'passed', false],
                ],
            ],
            [
                'stem' => 'Only after I ––– home, did I remember my doctor\'s appointment.',
                'subject' => 'english',
                'explanation' => '<strong>went</strong>: \'Only after I went home\' ক্লজটিতে অতীত নির্দেশ করায় সাধারণ Past Indefinite Tense (\'went\') বসে।',
                'options' => [
                    ['A', 'going', false],
                    ['B', 'go', false],
                    ['C', 'went', true],
                    ['D', 'gone', false],
                ],
            ],
            [
                'stem' => 'When they had their first child, they put ––– a large sum for his education.',
                'subject' => 'english',
                'explanation' => '<strong>aside</strong>: ভবিষ্যতের কোনো সুনির্দিষ্ট উদ্দেশ্যে সঞ্চয় করে আলাদা রাখা বোঝাতে উপযুক্ত Phrasal Verb হলো \'put aside\' (to save money for a special purpose)।',
                'options' => [
                    ['A', 'aside', true],
                    ['B', 'beside', false],
                    ['C', 'outside', false],
                    ['D', 'under', false],
                ],
            ],
            [
                'stem' => 'If you count from 1 to 100, how many 5s will you pass on the way?',
                'subject' => 'math',
                'explanation' => '<strong>20</strong>: ১ থেকে ১০০ এর মধ্যে ৫ অঙ্কটি যেসব সংখ্যায় আসে: এককের ঘরে ৫, ১৫, ২৫, ৩৫, ৪৫, ৫৫, ৬৫, ৭৫, ৮৫, ৯৫ (১০টি); এবং দশকের ঘরে ৫০, ৫১, ৫২, ৫৩, ৫৪, ৫৫, ৫৬, ৫৭, ৫৮, ৫৯ (১০টি)। সর্বমোট ১০ + ১০ = ২০টি পাঁচ রয়েছে।',
                'options' => [
                    ['A', '20', true],
                    ['B', '11', false],
                    ['C', '18', false],
                    ['D', '19', false],
                ],
            ],
            [
                'stem' => 'A farmer had 17 hens. All but 9 died. How many live hens were left?',
                'subject' => 'math',
                'explanation' => '<strong>9</strong>: প্রশ্নে বলা হয়েছে \'All but 9 died\' অর্থাৎ ৯টি বাদে বাকি সব মারা গেল। অতএব জীবিত মুরগির সংখ্যা ৯টি।',
                'options' => [
                    ['A', '0', false],
                    ['B', '9', true],
                    ['C', '8', false],
                    ['D', '16', false],
                ],
            ],
            [
                'stem' => 'If two typist can type two pages in two minutes, how many typists will it take to type 18 pages in six minutes?',
                'subject' => 'math',
                'explanation' => '<strong>6</strong>: ২ জন টাইপিস্ট ২ মিনিটে টাইপ করে ২ পৃষ্ঠা => ১ জন টাইপিস্ট ২ মিনিটে টাইপ করে ১ পৃষ্ঠা => ১ জন টাইপিস্ট ৬ মিনিটে টাইপ করে ৩ পৃষ্ঠা। অতএব ৬ মিনিটে ১৮ পৃষ্ঠা টাইপ করতে টাইপিস্ট লাগবে ১৮ / ৩ = ৬ জন।',
                'options' => [
                    ['A', '3', false],
                    ['B', '6', true],
                    ['C', '9', false],
                    ['D', '18', false],
                ],
            ],
            [
                'stem' => 'The fifth consonant from the beginning of this sentence is the letter –––',
                'subject' => 'english',
                'explanation' => '<strong>t</strong>: \'The fifth consonant...\'-এর শুরু থেকে consonant গুলো গণনা করি: 1st=\'T\', 2nd=\'h\', 3rd=\'f\', 4th=\'f\', 5th=\'t\'। অতএব পঞ্চম ব্যঞ্জনবর্ণটি হলো \'t\'।',
                'options' => [
                    ['A', 'i', false],
                    ['B', 'e', false],
                    ['C', 'a', false],
                    ['D', 't', true],
                ],
            ],
            [
                'stem' => 'If the second day of the month is a Monday, the eighteenth day of the month is a––',
                'subject' => 'math',
                'explanation' => '<strong>Wednesday</strong>: মাসের ২ তারিখ সোমবার হলে পরবর্তী সোমবারগুলো হবে: ৯ তারিখ ও ১৬ তারিখ। ১৬ তারিখ সোমবার হলে ১৭ তারিখ মঙ্গলবার এবং ১৮ তারিখ বুধবার।',
                'options' => [
                    ['A', 'Sunday', false],
                    ['B', 'Tuesday', false],
                    ['C', 'Wednesday', true],
                    ['D', 'Monday', false],
                ],
            ],
            [
                'stem' => 'Two men, starting at the same point, walk in opposite directions for 4 meters, turn left and walk another 3 meters. What is the distance between them?',
                'subject' => 'math',
                'explanation' => '<strong>10 meters</strong>: বিপরীত দিকে ৪ মিটার গিয়ে বামে ৩ মিটার ঘুরলে তাদের অনুভূমিক ব্যবধান = ৪ + ৪ = ৮ মিটার এবং উল্লম্ব ব্যবধান = ৩ + ৩ = ৬ মিটার। পিথাগোরাসের উপপাদ্য অনুসারে তাদের সরাসরি দূরত্ব = √(৮² + ৬²) = √(৬৪ + ৩৬) = √১০০ = ১০ মিটার।',
                'options' => [
                    ['A', '7 meters', false],
                    ['B', '14 meters', false],
                    ['C', '10 meters', true],
                    ['D', '6 meters', false],
                ],
            ],
            [
                'stem' => '30% of 10 is 10% of which?',
                'subject' => 'math',
                'explanation' => '<strong>30</strong>: ১০ এর ৩০% = ১০ × ০.৩ = ৩। এখন, ধরি x এর ১০% = ৩ => ০.১x = ৩ => x = ৩০।',
                'options' => [
                    ['A', '30', true],
                    ['B', '60', false],
                    ['C', '40', false],
                    ['D', '600', false],
                ],
            ],
            [
                'stem' => 'Rahim is 12 years old. He is three times older than Karim. What will be the age of Rahim when he is two times older than Karim?',
                'subject' => 'math',
                'explanation' => '<strong>16 years</strong>: বর্তমানে রহিমের বয়স ১২ বছর এবং সে করিমের চেয়ে ৩ গুণ বয়সী, অর্থাৎ করিমের বয়স = ১২ / ৩ = ৪ বছর। তাদের বয়সের পার্থক্য = ১২ - ৪ = ৮ বছর। যখন রহিম করিমের দ্বিগুণ বয়সী হবে তখন করিমের বয়স হবে ৮ বছর এবং রহিমের বয়স হবে ৮ × ২ = ১৬ বছর।',
                'options' => [
                    ['A', '15 years', false],
                    ['B', '16 years', true],
                    ['C', '17 years', false],
                    ['D', '18 years', false],
                ],
            ],
            [
                'stem' => 'Divide 30 by half and add 10. What do you get?',
                'subject' => 'math',
                'explanation' => '<strong>70</strong>: ৩০ কে অর্ধেক (১/২) দ্বারা ভাগ করা অর্থ: ৩০ ÷ (১/২) = ৩০ × ২ = ৬০। এর সাথে ১০ যোগ করলে ৬০ + ১০ = ৭০ হয়।',
                'options' => [
                    ['A', '25', false],
                    ['B', '45', false],
                    ['C', '55', false],
                    ['D', '70', true],
                ],
            ],
            [
                'stem' => 'If a man swims 4 meters upstream at 1 mph and back downstream to the same point at 4 mph, what is his average speed?',
                'subject' => 'math',
                'explanation' => '<strong>1.6 mph</strong>: গড় গতিবেগ সূত্র = [২ × v₁ × v₂] / (v₁ + v₂) = (২ × ১ × ৪) / (১ + ৪) = ৮ / ৫ = ১.৬ মাইল/ঘণ্টা (1.6 mph)।',
                'options' => [
                    ['A', '0.8 mph', false],
                    ['B', '1.6 mph', true],
                    ['C', '2.4 mph', false],
                    ['D', '3.2 mph', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, options, tags and link to the 28th BCS exam
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
                'reference_source' => '২৮তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '28th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '2008',
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
