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

class Bcs27thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '27th')->first() ?? ExamYear::firstOrCreate(['year' => '27th'], [
            'name_en' => '27th BCS Exam',
            'name_bn' => '২৭তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 27th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '27th-bcs-preliminary'],
            [
                'title_bn' => '২৭তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '27th BCS Preliminary Question Solution',
                'description_bn' => '২৭তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 27th BCS Preliminary Examination.',
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
                'stem' => 'কোনটি উপন্যাস?',
                'subject' => 'bangla',
                'explanation' => '<strong>কন্যাকুমারী</strong>: কথাসাহিত্যিক তারাশঙ্কর বন্দ্যোপাধ্যায় রচিত সুন্দরবন অঞ্চলের আদিবাসীদের জীবনের পটভূমিতে লেখা উপন্যাস হলো ‘কন্যাকুমারী’ (১৯৩৯)। \'নতুন চাঁদ\' নজরুলের কাব্যগ্রন্থ, \'গড্ডলিকা\' পরশুরামের গল্পগ্রন্থ, \'নেমেসিস\' নূরুল মোমেনের নাটক।',
                'options' => [
                    ['A', 'নতুন চাঁদ', false],
                    ['B', 'কন্যাকুমারী', true],
                    ['C', 'গড্ডলিকা', false],
                    ['D', 'নেমেসিস', false],
                ],
            ],
            [
                'stem' => 'লৌকিক কাহিনীর প্রথম রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>দৌলত কাজী</strong>: সপ্তদশ শতকে আরাকান রাজসভার পৃষ্ঠপোষকতায় মধ্যযুগের প্রথম মানবপ্রেমমূলক লৌকিক প্রণয়কাব্য ‘সতীময়না ও লোরচন্দ্রানী’ রচনা করেন দৌলত কাজী।',
                'options' => [
                    ['A', 'আলাওল', false],
                    ['B', 'কোরেশী মগন', false],
                    ['C', 'দৌলত কাজী', true],
                    ['D', 'সৈয়দ সুলতান', false],
                ],
            ],
            [
                'stem' => 'সাপ্তাহিক ‘সুধাকর’-এর সম্পাদক কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>শেখ আবদুর রহিম</strong>: ১৮৮৯ সালে কলকাতা থেকে প্রকাশিত মুসলিম রেনেসাঁর ঐতিহাসিক সাপ্তাহিক পত্রিকা ‘সুধাকর’-এর প্রতিষ্ঠাতা সম্পাদক ছিলেন শেখ আবদুর রহিম।',
                'options' => [
                    ['A', 'মুন্সি মোহাম্মদ রিয়াজউদ্দিন আহমদ', false],
                    ['B', 'মুন্সি মোহাম্মদ মেহের উল্লাহ', false],
                    ['C', 'শেখ আবদুর রহিম', true],
                    ['D', 'ইসমাইল হোসেন সিরাজী', false],
                ],
            ],
            [
                'stem' => 'মাসিক ‘মোহাম্মদী’ কোন সালে প্রকাশিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৯২৭</strong>: মাওলানা মোহাম্মদ আকরম খাঁ কর্তৃক ১৯২৭ সালে কলকাতা থেকে বিখ্যাত মাসিক সাহিত্য পত্রিকা ‘মোহাম্মদী’ প্রকাশিত হয় (পরে ঢাকায় স্থানান্তরিত হয়)।',
                'options' => [
                    ['A', '১৯২৬', false],
                    ['B', '১৯২৭', true],
                    ['C', '১৯২৮', false],
                    ['D', '১৯২৯', false],
                ],
            ],
            [
                'stem' => 'কোন পত্রিকাটি ১৯২৩ সালে প্রকাশিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>কল্লোল</strong>: বাংলা সাহিত্যে আধুনিকতাবাদী তরুণ লেখকদের আন্দোলনমুখর বিখ্যাত মুখপত্র ‘কল্লোল’ ১৯২৩ সালে দীনেশরঞ্জন দাশ ও গোকুলচন্দ্র নাগের সম্পাদনায় প্রকাশিত হয়।',
                'options' => [
                    ['A', 'কালিকলম', false],
                    ['B', 'প্রগতি', false],
                    ['C', 'কল্লোল', true],
                    ['D', 'সবুজপত্র', false],
                ],
            ],
            [
                'stem' => 'ঢাকা থেকে প্রকাশিত হয় কোন পত্রিকাটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>ক্রান্তি</strong>: পঞ্চাশের দশকে ঢাকা থেকে প্রকাশিত প্রগতিশীল সাহিত্য পত্রিকাগুলোর মধ্যে অন্যতম ছিল ‘ক্রান্তি’।',
                'options' => [
                    ['A', 'অরণি', false],
                    ['B', 'পরিচয়', false],
                    ['C', 'নবশক্তি', false],
                    ['D', 'ক্রান্তি', true],
                ],
            ],
            [
                'stem' => 'গ্রিক শব্দ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>দাম</strong>: গ্রিক ভাষার \'Drachma\' শব্দ থেকে বাংলায় প্রচলিত ঋণশব্দ হলো ‘দাম’ (মূল্য)। এ ছাড়া সুরঙ্গও গ্রিক শব্দ। তুফান আরবি, লুঙ্গি বর্মি, কুশন ইংরেজি।',
                'options' => [
                    ['A', 'তুফান', false],
                    ['B', 'লুঙ্গী', false],
                    ['C', 'কুশন', false],
                    ['D', 'দাম', true],
                ],
            ],
            [
                'stem' => 'বাংলা ভাষায় কয়টি খাঁটি বাংলা উপসর্গ আছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>একুশ</strong>: বাংলা ব্যাকরণ মতে খাঁটি বাংলা উপসর্গ মোট ২১টি (অ, অঘা, অজ, অনা, আ, আড়, আন, আব, ইতি, ঊন, কদ, কু, নি, পাতি, বি, ভর, রাম, স, সা, সু, হা)। তৎসম উপসর্গ ২০টি।',
                'options' => [
                    ['A', 'উনিশ', false],
                    ['B', 'কুড়ি', false],
                    ['C', 'একুশ', true],
                    ['D', 'বাইশ', false],
                ],
            ],
            [
                'stem' => '‘শিশুরাজেয এই মেয়েটি একটি ছোটখাট বর্গির উপদ্রব বলিলেই হয়।’ রবীন্দ্রনাথ ঠাকুরের কোন গল্পের সংলাপ?',
                'subject' => 'bangla',
                'explanation' => '<strong>সমাপ্তি</strong>: রবীন্দ্রনাথ ঠাকুরের ছোটগল্প ‘সমাপ্তি’-তে চঞ্চলা ও স্বাধীনচেতা কিশোরী নায়িকা মৃন্ময়ীর দুরন্তপনা প্রসঙ্গে এই বিখ্যাত সংলাপটি বর্ণিত হয়েছে।',
                'options' => [
                    ['A', 'একরাত্রি', false],
                    ['B', 'শুভা', false],
                    ['C', 'সমাপ্তি', true],
                    ['D', 'পোস্টমাস্টার', false],
                ],
            ],
            [
                'stem' => 'বাংলা সাহিত্যের প্রথম ইতিহাস গ্রন্থ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>বঙ্গভাষা ও সাহিত্য</strong>: ১৮৯৬ সালে ড. দীনেশচন্দ্র সেন রচিত ‘বঙ্গভাষা ও সাহিত্য’ বাংলা সাহিত্যের প্রথম প্রণালীবদ্ধ ও নির্ভরযোগ্য ইতিহাস গ্রন্থ।',
                'options' => [
                    ['A', 'বাঙ্গালা সাহিত্যের ইতিহাস', false],
                    ['B', 'বঙ্গভাষা ও সাহিত্য', true],
                    ['C', 'বাংলা সাহিত্যের কথা', false],
                    ['D', 'বাংলা সাহিত্যের রূপরেখা', false],
                ],
            ],
            [
                'stem' => 'কত খ্রিস্টাব্দে শরৎচন্দ্র চট্টোপাধ্যায় কলকাতা বিশ্ববিদ্যালয়ের ‘জগত্তারিণী’ পদক লাভ করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৯২৩</strong>: কথাসাহিত্যিক শরৎচন্দ্র চট্টোপাধ্যায় বাংলা সাহিত্যে অনন্য অবদানের স্বীকৃতিস্বরূপ ১৯২৩ সালে কলকাতা বিশ্ববিদ্যালয় থেকে মর্যাদাপূর্ণ ‘জগত্তারিণী স্বর্ণপদক’ লাভ করেন।',
                'options' => [
                    ['A', '১৯১৬', false],
                    ['B', '১৯২৩', true],
                    ['C', '১৯৩৩', false],
                    ['D', '১৯০৩', false],
                ],
            ],
            [
                'stem' => 'রাজা রামমোহন রচিত বাংলা ব্যাকরণের নাম কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>গৌড়ীয় ব্যাকরণ</strong>: বাঙালি কর্তৃক রচিত প্রথম বাংলা ব্যাকরণ হলো রাজা রামমোহন রায় রচিত ‘গৌড়ীয় ব্যাকরণ’ (১৮৩৩ সালে স্কুল বুক সোসাইটি থেকে প্রকাশিত)।',
                'options' => [
                    ['A', 'মাগধীয় ব্যাকরণ', false],
                    ['B', 'গৌড়ীয় ব্যাকরণ', true],
                    ['C', 'মাতৃভাষা ব্যাকরণ', false],
                    ['D', 'ভাষা ও ব্যাকরণ', false],
                ],
            ],
            [
                'stem' => '‘মেছো’ শব্দের প্রকৃতি-প্রত্যয় কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>মাছ + উয়া > ও</strong>: বিশেষ্য \'মাছ\'-এর সাথে তদ্ধিত প্রত্যয় \'উয়া\' যুক্ত হয়ে আদি স্বরের পরিবর্তন (অভিশ্রুতি) ঘটিয়ে \'মেছো\' গঠিত হয়: মাছ + উয়া > মেছো।',
                'options' => [
                    ['A', 'মাছ + ও', false],
                    ['B', 'মেছ + ও', false],
                    ['C', 'মাছি + উয়া > ও', false],
                    ['D', 'মাছ + উয়া > ও', true],
                ],
            ],
            [
                'stem' => 'কোন সন্ধিটি নিপাতনে সিদ্ধ?',
                'subject' => 'bangla',
                'explanation' => '<strong>পর + পর = পরস্পর</strong>: যে সন্ধি ব্যাকরণের সাধারণ কোনো নিয়ম না মেনে সিদ্ধ হয় তাকে নিপাতনে সিদ্ধ সন্ধি বলে। পর + পর = পরস্পর (বিসর্গ ছাড়া \'স\'-এর আগমন)।',
                'options' => [
                    ['A', 'বাক্ + দান = বাগদান', false],
                    ['B', 'উৎ + ছেদ = উচ্ছেদ', false],
                    ['C', 'পর + পর = পরস্পর', true],
                    ['D', 'সম্ + সার = সংসার', false],
                ],
            ],
            [
                'stem' => 'বাংলা মৌলিক নাটকের যাত্রা শুরু হয় কোন নাট্যকারের হাতে?',
                'subject' => 'bangla',
                'explanation' => '<strong>রামনারায়ণ তর্করত্ন</strong>: ১৮৫৪ সালে রামনারায়ণ তর্করত্ন রচিত কৌলীন্য প্রথা বিরোধী সামাজিক নাটক ‘কুলীনকুলসর্বস্ব’ হলো বাংলা ভাষায় রচিত প্রথম মৌলিক সার্থক নাটক।',
                'options' => [
                    ['A', 'মধুসূদন দত্ত', false],
                    ['B', 'দীনবন্ধু মিত্র', false],
                    ['C', 'জ্যোতিরিন্দ্রনাথ ঠাকুর', false],
                    ['D', 'রামনারায়ণ তর্করত্ন', true],
                ],
            ],
            [
                'stem' => 'প্রত্যক্ষ কোনো বস্তুর সাথে পরোক্ষ কোনো বস্তুর তুলনা করলে প্রত্যক্ষ বস্তুটিকে বলা হয় –।',
                'subject' => 'bangla',
                'explanation' => '<strong>উপমেয়</strong>: যাকে কোনো কিছুর সাথে তুলনা করা হয় (প্রত্যক্ষ বস্তু) তাকে উপমেয় বলে; আর যার সাথে তুলনা করা হয় (পরোক্ষ বস্তু) তাকে উপমান বলে।',
                'options' => [
                    ['A', 'উপমিত', false],
                    ['B', 'উপমান', false],
                    ['C', 'উপমেয়', true],
                    ['D', 'রূপক', false],
                ],
            ],
            [
                'stem' => '‘পাখি সব করে রব রাতি পোহাইল’ পঙ্‌ক্তিটির রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>মদনমোহন তর্কালংকার</strong>: শিশুশিক্ষার পথপ্রদর্শক কবি মদনমোহন তর্কালংকারের ‘প্রভাত’ কবিতার প্রথম চরণ হলো ‘পাখি সব করে রব রাতি পোহাইল’।',
                'options' => [
                    ['A', 'রামনারায়ণ তর্করত্ন', false],
                    ['B', 'বিহারী লাল', false],
                    ['C', 'কৃষ্ণচন্দ্র মজুমদার', false],
                    ['D', 'মদনমোহন তর্কালংকার', true],
                ],
            ],
            [
                'stem' => '‘আমি কিংবদন্তীর কথা বলছি’-এর রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>আবু জাফর ওবায়দুল্লাহ</strong>: ঐতিহ্য ও মুক্তিচেতনার কবি আবু জাফর ওবায়দুল্লাহ রচিত বিখ্যাত দীর্ঘ ইতিহাসভিত্তিক কাব্যগ্রন্থ ‘আমি কিংবদন্তীর কথা বলছি’ (১৯৮১)।',
                'options' => [
                    ['A', 'সিকান্দার আবু জাফর', false],
                    ['B', 'আবু জাফর ওবায়দুল্লাহ', true],
                    ['C', 'ফররুখ আহমদ', false],
                    ['D', 'আহসান হাবীব', false],
                ],
            ],
            [
                'stem' => '‘জীবনে জ্যাঠামি ও সাহিত্যে ন্যাকামি’ সহ্য করতে পারতেন না-',
                'subject' => 'bangla',
                'explanation' => '<strong>প্রমথ চৌধুরী</strong>: শাণিত মননশীল প্রাবন্ধিক ও বীরবল ছদ্মনামের সাহিত্যিক প্রমথ চৌধুরী কৃত্রিমতা ও অলংকারবহুল ভারিক্কিপনা ঘৃণা করতেন।',
                'options' => [
                    ['A', 'বঙ্কিমচন্দ্র', false],
                    ['B', 'সৈয়দ মুজতবা আলী', false],
                    ['C', 'প্রমথ চৌধুরী', true],
                    ['D', 'প্রমথনাথ বিশী', false],
                ],
            ],
            [
                'stem' => '‘এ মাটি সোনার বাড়া’-এ উদ্ধৃতিতে ‘সোনা’ কোন অর্থে ব্যবহার করা হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>বিশেষণের অতিশায়ন</strong>: এখানে মাটির অপরিসীম উর্বরতা ও অমূল্য মাহাত্ম্যকে সোনার চেয়েও উৎকৃষ্ট বা শ্রেষ্ঠত্ব নির্দেশ করতে বিশেষণের অতিশায়ন হিসেবে ব্যবহার করা হয়েছে।',
                'options' => [
                    ['A', 'বিশেষণের অতিশায়ন', true],
                    ['B', 'রূপবাচক বিশেষণ', false],
                    ['C', 'উপাদান বাচক বিশেষণ', false],
                    ['D', 'বিধেয় বিশেষণ', false],
                ],
            ],
            [
                'stem' => 'What would have happened if –––?',
                'subject' => 'english',
                'explanation' => '<strong>The bridge had broken</strong>: 3rd conditional বাক্যে প্রধান ক্লজে \'would have + V3\' থাকলে if-ক্লজটিতে Past Perfect Tense (\'had + V3\' অর্থাৎ \'had broken\') বসে।',
                'options' => [
                    ['A', 'The bridge is broken', false],
                    ['B', 'The bridge would break', false],
                    ['C', 'The bridge had broken', true],
                    ['D', 'The bridge had been broke', false],
                ],
            ],
            [
                'stem' => 'Explain the meaning of ‘Bring to pass’.',
                'subject' => 'english',
                'explanation' => '<strong>Cause to happen</strong>: \'Bring to pass\' একটি ঐতিহ্যবাহী ইংরেজি ইডিয়ম যার অর্থ কোনো কিছু ঘটানো বা সংঘটিত করা (to cause something to happen)।',
                'options' => [
                    ['A', 'Cause to destroy', false],
                    ['B', 'Cause to happen', true],
                    ['C', 'Cause to carry out', false],
                    ['D', 'Cause to convince', false],
                ],
            ],
            [
                'stem' => 'Which of the following sentences is the correct one?',
                'subject' => 'english',
                'explanation' => '<strong>Paper is made from wood</strong>: কাঁচামাল পরিবর্তিত হয়ে নতুন পদার্থ সৃষ্টি হলে এবং মূল কাঁচামাল দৃশ্যমান না থাকলে \'made from\' বসে (যেমন: Paper is made from wood)। কাঁচামাল অপরিবর্তিত থাকলে \'made of\' বসে (যেমন: Chair is made of wood)।',
                'options' => [
                    ['A', 'Paper is made of wood', false],
                    ['B', 'Paper is made from wood', true],
                    ['C', 'Paper is made by wood', false],
                    ['D', 'Paper is made on wood', false],
                ],
            ],
            [
                'stem' => 'The word bounty is closest in meaning to',
                'subject' => 'english',
                'explanation' => '<strong>generosity</strong>: \'Bounty\' শব্দের অর্থ উদারতা, বদান্যতা বা প্রাচুর্যপূর্ণ উপহার। এর সমার্থক হলো \'generosity\' বা \'liberality\'।',
                'options' => [
                    ['A', 'generosity', true],
                    ['B', 'familiar', false],
                    ['C', 'dividing line', false],
                    ['D', 'sympathy', false],
                ],
            ],
            [
                'stem' => 'Give the correct passive form of ‘My teacher embodies all the good qualities’.',
                'subject' => 'english',
                'explanation' => '<strong>All the good qualities are embodied in my teacher.</strong>: \'Embody\' ক্রিয়ার পর passive voice-এ agent preposition হিসেবে \'by\'-এর পরিবর্তে \'in\' বসে।',
                'options' => [
                    ['A', 'All the good qualities are embodied by my teacher.', false],
                    ['B', 'All the good qualities are embodied in my teacher.', true],
                    ['C', 'All the good qualities are embodied to my teacher.', false],
                    ['D', 'All the good qualities are embodied on my teacher.', false],
                ],
            ],
            [
                'stem' => 'Choose the correct indirect speech- She asked me, ‘Are you happy in your new job?’',
                'subject' => 'english',
                'explanation' => '<strong>She asked me if I was happy in my new job</strong>: Direct speech-এর Interrogative Yes/No প্রশ্নের indirect রূপে linking word হিসেবে \'if\' এবং Present Indefinite পরিবর্তিত হয়ে Past Indefinite (\'I was happy\') হয়।',
                'options' => [
                    ['A', 'She asked me if I was happy in my new job', true],
                    ['B', 'She asked me if I have been happy in my new job', false],
                    ['C', 'She asked me whether I am happy in my new job', false],
                    ['D', 'She asked me if I had been happy in my new job', false],
                ],
            ],
            [
                'stem' => 'The meaning of the word ‘Obese’ is–',
                'subject' => 'english',
                'explanation' => '<strong>very fat</strong>: \'Obese\' শব্দের অর্থ অতিশয় স্থূলকায় বা মাত্রাতিরিক্ত মোটা (grossly fat or overweight)।',
                'options' => [
                    ['A', 'very fat', true],
                    ['B', 'ugly', false],
                    ['C', 'tardy', false],
                    ['D', 'obnoxious', false],
                ],
            ],
            [
                'stem' => 'A person who writes about his own life writes––',
                'subject' => 'english',
                'explanation' => '<strong>an autobiography</strong>: কোনো লেখক যখন নিজের জীবনের কাহিনী নিজেই লেখেন, তখন তাকে \'autobiography\' (আত্মজীবনী) বলা হয়।',
                'options' => [
                    ['A', 'a diary', false],
                    ['B', 'a biography', false],
                    ['C', 'an autobiography', true],
                    ['D', 'a chronicle', false],
                ],
            ],
            [
                'stem' => 'Which of the following sentences is correct?',
                'subject' => 'english',
                'explanation' => '<strong>Why have you done this?</strong>: Wh-interrogative বাক্যের গঠন: Wh-word (\'Why\') + auxiliary (\'have\') + subject (\'you\') + V3 (\'done\') + object (\'this\')?',
                'options' => [
                    ['A', 'Why have you done this?', true],
                    ['B', 'Why you had done this?', false],
                    ['C', 'Why you have done this?', false],
                    ['D', 'Why did you done this?', false],
                ],
            ],
            [
                'stem' => 'What will be the correct preposition to complete the sentence? ‘I am not good ___ translation’',
                'subject' => 'english',
                'explanation' => '<strong>at</strong>: কোনো বিষয়ে দক্ষতা বা পারদর্শিতা বোঝাতে appropriate adjective phrase হিসেবে \'good at\' বসে (নাবোধক হলেও \'not good at\')।',
                'options' => [
                    ['A', 'in', false],
                    ['B', 'about', false],
                    ['C', 'with', false],
                    ['D', 'at', true],
                ],
            ],
            [
                'stem' => 'Which is the noun of the word ‘beautiful’.',
                'subject' => 'english',
                'explanation' => '<strong>Beauty</strong>: \'Beautiful\' একটি বিশেষণ (adjective)। এর বিশেষ্য (noun) রূপ হলো \'Beauty\' (সৌন্দর্য), আর ক্রিয়ারূপ হলো \'Beautify\' (সৌন্দর্যমণ্ডিত করা)।',
                'options' => [
                    ['A', 'Beauty', true],
                    ['B', 'Beautify', false],
                    ['C', 'Beauteous', false],
                    ['D', 'Beautifully', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank with appropriate preposition. ‘Hurry up! we have to go ––– five minutes?’',
                'subject' => 'english',
                'explanation' => '<strong>in / by</strong>: নির্দিষ্ট সময়সীমার মধ্যে বা পূর্বে যাত্রা করার ক্ষেত্রে \'in five minutes\' (পাঁচ মিনিটের মধ্যে) বা \'by five minutes\' ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'in', false],
                    ['B', 'on', false],
                    ['C', 'by', true],
                    ['D', 'for', false],
                ],
            ],
            [
                'stem' => 'Identify the imperative sentence.',
                'subject' => 'english',
                'explanation' => '<strong>Stand up</strong>: আদেশ, নির্দেশ বা অনুরোধসূচক বাক্য যেখানে subject (You) উহ্য থাকে এবং verb দ্বারা বাক্য শুরু হয়, তাকে Imperative sentence বলে।',
                'options' => [
                    ['A', 'I shall go to college', false],
                    ['B', 'Matin is singing a song', false],
                    ['C', 'Stand up', true],
                    ['D', 'It has been raining since morning', false],
                ],
            ],
            [
                'stem' => 'Fill in the gap with the suitable word. To stay healthy, we must plan to have a balanced –––.',
                'subject' => 'english',
                'explanation' => '<strong>diet</strong>: সুষম পুষ্টিকর খাদ্যাভ্যাস বোঝাতে সুনির্দিষ্ট ইংরেজি শব্দগুচ্ছ হলো \'balanced diet\' (সুষম খাদ্য)।',
                'options' => [
                    ['A', 'diet', true],
                    ['B', 'food', false],
                    ['C', 'drink', false],
                    ['D', 'environment', false],
                ],
            ],
            [
                'stem' => 'The rich should not look down ––– the poor.',
                'subject' => 'english',
                'explanation' => '<strong>upon</strong>: কাউকে ঘৃণা বা অবজ্ঞার চোখে দেখা বোঝাতে উপযুক্ত Prepositional idiom হলো \'look down upon\' (to despise or treat with contempt)।',
                'options' => [
                    ['A', 'at', false],
                    ['B', 'for', false],
                    ['C', 'towards', false],
                    ['D', 'upon', true],
                ],
            ],
            [
                'stem' => 'I took a map with me, as I didn’t want to ––– my way on the journey.',
                'subject' => 'english',
                'explanation' => '<strong>lose</strong>: পথ হারিয়ে ফেলা বোঝাতে সঠিক ক্রিয়াপদ হলো \'lose one\'s way\' (L-o-s-e)। \'Loose\' হলো শিথিল বা আলগা (adjective)।',
                'options' => [
                    ['A', 'loose', false],
                    ['B', 'lose', true],
                    ['C', 'lost', false],
                    ['D', 'loss', false],
                ],
            ],
            [
                'stem' => 'Every driver must be held ––– his own actions.',
                'subject' => 'english',
                'explanation' => '<strong>responsible for</strong>: কোনো ব্যক্তি তার কর্ম বা আচরণের জন্য দায়ী থাকার ক্ষেত্রে উপযুক্ত phrase হলো \'held responsible for\' (দায়বদ্ধ থাকা)।',
                'options' => [
                    ['A', 'responsible for', true],
                    ['B', 'responsible to', false],
                    ['C', 'liable to', false],
                    ['D', 'blamed for', false],
                ],
            ],
            [
                'stem' => '‘Through thick and thin’ means––',
                'subject' => 'english',
                'explanation' => '<strong>under all conditions</strong>: ইংরেজি ইডিয়ম \'through thick and thin\' বলতে বোঝায় সুখে-দুঃখে বা যেকোনো পরিস্থিতিতে অবিচল থাকা (under all conditions, good or bad)।',
                'options' => [
                    ['A', 'under all conditions', true],
                    ['B', 'to make thick and thin', false],
                    ['C', 'not clear in understanding', false],
                    ['D', 'of great density', false],
                ],
            ],
            [
                'stem' => '‘Prior to’ means–',
                'subject' => 'english',
                'explanation' => '<strong>before</strong>: \'Prior to\' শব্দগুচ্ছের অর্থ কোনো কিছুর পূর্বে বা আগে (before or earlier than something)।',
                'options' => [
                    ['A', 'after', false],
                    ['B', 'before', true],
                    ['C', 'immediately', false],
                    ['D', 'during the period of', false],
                ],
            ],
            [
                'stem' => 'Nobody knocked him down; it was an–',
                'subject' => 'english',
                'explanation' => '<strong>accident</strong>: কোনো পূর্বপরিকল্পনা ছাড়া অনাকাঙ্ক্ষিত আকস্মিক দুর্ঘটনা বোঝাতে \'accident\' যথাযথ শব্দ।',
                'options' => [
                    ['A', 'incident', false],
                    ['B', 'occurrence', false],
                    ['C', 'accident', true],
                    ['D', 'event', false],
                ],
            ],
            [
                'stem' => '১² + ২² + ৩² + ............ + ৫০² = কত?',
                'subject' => 'math',
                'explanation' => '<strong>৪২৯২৫</strong>: প্রথম n সংখ্যক স্বাভাবিক সংখ্যার বর্গের সমষ্টি S = [n(n + 1)(2n + 1)] / 6। এখানে n = 50। অতএব S = [50 × 51 × 101] / 6 = [2550 × 101] / 6 = 257550 / 6 = ৪২৯২৫।',
                'options' => [
                    ['A', '৩৫৭২৫', false],
                    ['B', '৪২৯২৫', true],
                    ['C', '৪৫৫০০', false],
                    ['D', '৪৭২২৫', false],
                ],
            ],
            [
                'stem' => '৪ টাকায় ৫টি করে কিনে ৫ টাকায় ৪টি করে বিক্রয় করলে শতকরা কত লাভ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>৫৬.২৫%</strong>: ১টির ক্রয়মূল্য = ৪/৫ = ০.৮০ টাকা। ১টির বিক্রয়মূল্য = ৫/৪ = ১.২৫ টাকা। লাভ = ১.২৫ - ০.৮০ = ০.৪৫ টাকা। শতকরা লাভ = (০.৪৫ / ০.৮০) × ১০০% = ৫৬.২৫%।',
                'options' => [
                    ['A', '৪৫%', false],
                    ['B', '৪৮.৫০%', false],
                    ['C', '৫২.৭৫%', false],
                    ['D', '৫৬.২৫%', true],
                ],
            ],
            [
                'stem' => 'এক ব্যবসায়ী একটি পণ্যের মূল্য ২৫% বাড়ালো, অতঃপর বর্ধিত মূল্য থেকে ২৫% কমালো। সর্বশেষ মূল্য সর্বপ্রথম মূল্যের তুলনায়-',
                'subject' => 'math',
                'explanation' => '<strong>৬.২৫% কমানো হয়েছে</strong>: নিট পরিবর্তন সূত্র: a + b + ab/100 = 25 - 25 - (25 × 25)/100 = - 625/100 = - 6.25%। অর্থাৎ ৬.২৫% কমেছে।',
                'options' => [
                    ['A', '৪৫% কমানো হয়েছে', false],
                    ['B', '৬.২৫% কমানো হয়েছে', true],
                    ['C', '৬.২৫% বাড়ানো হয়েছে', false],
                    ['D', '৫% বাড়ানো হয়েছে', false],
                ],
            ],
            [
                'stem' => 'যদি একটি কাজ ৯ জন লোক ১২ দিনে করতে পারে, অতিরিক্ত ৩ জন লোক নিয়োগ করলে কাজটি কতদিনে শেষ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>৯ দিনে</strong>: মোট শ্রম = ৯ × ১২ = ১০৮ জন-দিন। অতিরিক্ত ৩ জন সহ মোট লোক = ৯ + ৩ = ১২ জন। সময় লাগবে = ১০৮ / ১২ = ৯ দিন।',
                'options' => [
                    ['A', '৭', false],
                    ['B', '৯', true],
                    ['C', '১০', false],
                    ['D', '১২', false],
                ],
            ],
            [
                'stem' => 'শিক্ষা সফরে যাওয়ার জন্য ২৪০০ টাকা বাস ভাড়া করা হলো এবং প্রত্যেক ছাত্র/ছাত্রী সমান ভাড়া বহন করবে ঠিক হলো। অতিরিক্ত ১০ জন ছাত্র/ছাত্রী যাওয়ায় প্রতি জনের ভাড়া ৮ টাকা কমে গেল। বাসে কতজন ছাত্র/ছাত্রী গিয়েছিল?',
                'subject' => 'math',
                'explanation' => '<strong>৬০</strong>: ধরি বাসে যাওয়া মোট শিক্ষার্থীর সংখ্যা x। পরিকল্পনা ছিল (x - 10) জনের। প্রশ্নমতে, ২৪০০/(x - 10) - ২৪০০/x = ৮ => ২৪০/x(x-10) = ১/১০ => x(x - 10) = ৩০০০ => x² - 10x - 3000 = 0 => (x - 60)(x + 50) = 0 => x = ৬০ জন।',
                'options' => [
                    ['A', '৪০', false],
                    ['B', '৪৮', false],
                    ['C', '৫০', false],
                    ['D', '৬০', true],
                ],
            ],
            [
                'stem' => 'পিতা, মাতা ও পুত্রের বয়সের গড় ৩৭ বছর। আবার পিতা ও পুত্রের বয়সের গড় ৩৫ বছর। মাতার বয়স কত?',
                'subject' => 'math',
                'explanation' => '<strong>৪১ বছর</strong>: পিতা, মাতা ও পুত্রের মোট বয়স = ৩৭ × ৩ = ১১১ বছর। পিতা ও পুত্রের মোট বয়স = ৩৫ × ২ = ৭০ বছর। অতএব মাতার বয়স = ১১১ - ৭০ = ৪১ বছর।',
                'options' => [
                    ['A', '৩৮ বছর', false],
                    ['B', '৪১ বছর', true],
                    ['C', '৪৫ বছর', false],
                    ['D', '৪৮ বছর', false],
                ],
            ],
            [
                'stem' => 'যদি (x-y)² = 14 এবং xy = 2 হয় তবে, x² + y² = কত?',
                'subject' => 'math',
                'explanation' => '<strong>১৮</strong>: আমরা জানি, x² + y² = (x - y)² + 2xy = 14 + 2(2) = 14 + 4 = 18।',
                'options' => [
                    ['A', '১২', false],
                    ['B', '১৪', false],
                    ['C', '১৬', false],
                    ['D', '১৮', true],
                ],
            ],
            [
                'stem' => 'বৃত্তের ব্যাস তিনগুণ বৃদ্ধি করলে ক্ষেত্রফল কতগুণ বৃদ্ধি পাবে?',
                'subject' => 'math',
                'explanation' => '<strong>৯</strong>: বৃত্তের ক্ষেত্রফল ব্যাসের বর্গের সমানুপাতিক (A ∝ d²)। ব্যাস ৩ গুণ হলে ক্ষেত্রফল ৩² = ৯ গুণ হবে।',
                'options' => [
                    ['A', '৪', false],
                    ['B', '৯', true],
                    ['C', '১২', false],
                    ['D', '১৬', false],
                ],
            ],
            [
                'stem' => 'একটি সমদ্বিবাহু সমকোণী ত্রিভুজের অতিভুজের দৈর্ঘ্য ১২ সেমি হলে ত্রিভুজটির ক্ষেত্রফল কত বর্গ সে.মি.?',
                'subject' => 'math',
                'explanation' => '<strong>৩৬</strong>: সমদ্বিবাহু সমকোণী ত্রিভুজের ক্ষেত্রফল = (অতিভুজ)² / ৪ = ১২² / ৪ = ১৪৪ / ৪ = ৩৬ বর্গ সেমি।',
                'options' => [
                    ['A', '৩৬', true],
                    ['B', '৪৮', false],
                    ['C', '৫৬', false],
                    ['D', '৭২', false],
                ],
            ],
            [
                'stem' => '৬০ থেকে ৮০ এর মধ্যবর্তী বৃহত্তম ও ক্ষুদ্রতম মৌলিক সংখ্যার অন্তর হবে-',
                'subject' => 'math',
                'explanation' => '<strong>১৮</strong>: ৬০ থেকে ৮০ এর মধ্যে ক্ষুদ্রতম মৌলিক সংখ্যাটি হলো ৬১ এবং বৃহত্তম মৌলিক সংখ্যাটি হলো ৭৯। এদের অন্তর = ৭৯ - ৬১ = ১৮।',
                'options' => [
                    ['A', '৮', false],
                    ['B', '১২', false],
                    ['C', '১৮', true],
                    ['D', '১৪০', false],
                ],
            ],
            [
                'stem' => 'NIPORT কি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>জনসংখ্যা বিষয়ক গবেষণা প্রতিষ্ঠান</strong>: NIPORT-এর পূর্ণরূপ হলো National Institute of Population Research and Training (জাতীয় জনসংখ্যা গবেষণা ও প্রশিক্ষণ ইনস্টিটিউট)।',
                'options' => [
                    ['A', 'জনসংখ্যা বিষয়ক গবেষণা প্রতিষ্ঠান', true],
                    ['B', 'পোলট্রি ফার্ম বিষয়ক গবেষণা প্রতিষ্ঠান', false],
                    ['C', 'নদীবন্দর বিষয়ক গবেষণা প্রতিষ্ঠান', false],
                    ['D', 'বন্দর বিষয়ক গবেষণা প্রতিষ্ঠান', false],
                ],
            ],
            [
                'stem' => 'সংবিধানের কোন অনুচ্ছেদে ‘রাষ্ট্র ও গণজীবনের সর্বস্তরে নারী পুরুষের সমান অধিকার লাভ করিবেন’ বলা আছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২৮(২) নং অনুচ্ছেদে</strong>: বাংলাদেশ সংবিধানের মৌলিক অধিকার অংশের ২৮(২) অনুচ্ছেদে স্পষ্টভাবে বর্ণিত— \'রাষ্ট্র ও গণজীবনের সর্বস্তরে নারী পুরুষের সমান অধিকার লাভ করিবেন।\'।',
                'options' => [
                    ['A', '১০নং অনুচ্ছেদে', false],
                    ['B', '২১(২) নং অনুচ্ছেদে', false],
                    ['C', '২৭ নং অনুচ্ছেদে', false],
                    ['D', '২৮(২) নং অনুচ্ছেদে', true],
                ],
            ],
            [
                'stem' => 'UNDP রিপোর্ট সেপ্টেম্বর ২০০৫ মোতাবেক বাংলাদেশের মাথাপিছু আয় কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪৪৪ ডলার (তৎকালীন)</strong>: ২০০৫ সালের ইউএনডিপি মানব উন্নয়ন প্রতিবেদনে বাংলাদেশের তৎকালীন বার্ষিক মাথাপিছু আয় ৪৪৪ মার্কিন ডলার হিসেবে প্রকাশিত হয়েছিল (সাম্প্রতিক অর্থবছরে তা প্রায় ২৮০০ ডলারে উন্নীত হয়েছে)।',
                'options' => [
                    ['A', '৪৪৪ ডলার', true],
                    ['B', '৭৭০ ডলার', false],
                    ['C', '১০৭০ ডলার', false],
                    ['D', '১৭৭০ ডলার', false],
                ],
            ],
            [
                'stem' => 'স্বাধীনতা যুদ্ধে অবদানের জন্য ‘বীরপ্রতীক’ উপাধি লাভ করে কতজন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪২৬ জন</strong>: ১৯৭১ সালের মহান মুক্তিযুদ্ধে সাহসিকতার জন্য ১৯৭৩ সালের সরকারি গেজেট অনুযায়ী ৪২৬ জন বীর মুক্তিযোদ্ধাকে \'বীর প্রতীক\' খেতাব প্রদান করা হয়।',
                'options' => [
                    ['A', '৭ জন', false],
                    ['B', '৬৮ জন', false],
                    ['C', '১৭৫ জন', false],
                    ['D', '৪২৬ জন', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের ইক্ষু গবেষণা ইনস্টিটিউট কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ঈশ্বরদী</strong>: পাবনা জেলার ঈশ্বরদীতে অবস্থিত বাংলাদেশ সুগারক্রপ গবেষণা ইনস্টিটিউট (BSRI) দেশের প্রধান ইক্ষু ও মিষ্টি জাতীয় ফসল গবেষণা কেন্দ্র।',
                'options' => [
                    ['A', 'দিনাজপুর', false],
                    ['B', 'গোপালপুর', false],
                    ['C', 'পাকশী', false],
                    ['D', 'ঈশ্বরদী', true],
                ],
            ],
            [
                'stem' => 'মিলেনিয়াম ডেভেলপমেন্ট গোল অর্জন করার কথা কোন সময়ে?',
                'subject' => 'international',
                'explanation' => '<strong>২০১৫ সালে</strong>: ২০০০ সালে জাতিসংঘের সহস্রাব্দ সম্মেলনে গৃহীত ৮টি মিলেনিয়াম ডেভেলপমেন্ট গোল (MDG) অর্জনের নির্ধারিত সময়সীমা ছিল ২০১৫ সাল।',
                'options' => [
                    ['A', '২০১০ সালে', false],
                    ['B', '২০১৫ সালে', true],
                    ['C', '২০২০ সালে', false],
                    ['D', '২০২৫ সালে', false],
                ],
            ],
            [
                'stem' => 'রাজারবাগ পুলিশ লাইনে ‘দুর্জয়’ ভাস্কর্যটির শিল্পী কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মৃণাল হক</strong>: ১৯৭১ সালের ২৫ মার্চ কালরাতে রাজারবাগে পুলিশ বাহিনীর বীরত্বপূর্ণ প্রথম সশস্ত্র প্রতিরোধ স্মরণে নির্মিত ভাস্কর্য ‘দুর্জয়’-এর ভাস্কর হলেন মৃণাল হক।',
                'options' => [
                    ['A', 'হামিদুর রহমান', false],
                    ['B', 'মৃণাল হক', true],
                    ['C', 'শামীম শিকদার', false],
                    ['D', 'নভেরা আহমেদ', false],
                ],
            ],
            [
                'stem' => 'চট্টগ্রাম-কক্সবাজার সাবমেরিন কেবলস অপটিক্যাল ফাইবার স্থাপন করার জন্য বাংলাদেশ সরকারকে কত দূরত্বের ব্যয় বহন করতে হবে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৭০ কি.মি.</strong>: SEA-ME-WE-4 সাবমেরিন ক্যাবলের মূল শাখা ল্যান্ডিং স্টেশন কক্সবাজারের সাথে চট্টগ্রাম পর্যন্ত অভ্যন্তরীণ ব্যাকবোন সংযোগে ১৭০ কিমি অপটিক্যাল ফাইবার নেটওয়ার্ক স্থাপন ব্যয় বহন করা হয়।',
                'options' => [
                    ['A', '৭০০ কি.মি.', false],
                    ['B', '৫৭০ কি.মি.', false],
                    ['C', '৩০০ কি.মি.', false],
                    ['D', '১৭০ কি.মি.', true],
                ],
            ],
            [
                'stem' => 'রাজেন্দ্রপুর সেনানিবাসে অবস্থিত মুক্তিযুদ্ধের স্মৃতিস্তম্ভের নাম কী?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>রক্ত সোপান</strong>: গাজীপুরের রাজেন্দ্রপুর সেনানিবাসে মহান মুক্তিযুদ্ধের শহীদদের স্মরণে নির্মিত স্মৃতিস্তম্ভটির নাম ‘রক্ত সোপান’।',
                'options' => [
                    ['A', 'বিজয়স্তম্ভ', false],
                    ['B', 'বিজয়কেতন', false],
                    ['C', 'স্বাধীনতা সোপান', false],
                    ['D', 'রক্ত সোপান', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের পোস্টাল একাডেমি কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>রাজশাহী</strong>: বাংলাদেশ ডাক বিভাগের কর্মকর্তাদের উচ্চতর পেশাগত প্রশিক্ষণ প্রদানের শীর্ষ জাতীয় প্রতিষ্ঠান \'বাংলাদেশ পোস্টাল একাডেমি\' রাজশাহী শহরে অবস্থিত।',
                'options' => [
                    ['A', 'রাজশাহী', true],
                    ['B', 'ঢাকা', false],
                    ['C', 'চট্টগ্রাম', false],
                    ['D', 'খুলনা', false],
                ],
            ],
            [
                'stem' => 'প্রস্তাবিত পদ্মা সেতুর দৈর্ঘ্য কত কি.মি.?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৬.১৫ কিমি</strong>: ২০২২ সালের ২৫ জুন উদ্বোধনকৃত দেশের দীর্ঘতম দোতলা বিশিষ্ট পদ্মা বহুমুখী সেতুর মূল দৈর্ঘ্য ৬.১৫ কিলোমিটার (প্রস্থ ১৮.১০ মিটার)।',
                'options' => [
                    ['A', '৫.০৩', false],
                    ['B', '৬.০৩', false],
                    ['C', '৪.৮', false],
                    ['D', '৬.৮', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে সর্বপ্রথম কোন মহিলা টেস্টটিউব শিশুর মা হন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ফিরোজা বেগম</strong>: ২০০১ সালের ৩০ মে বাংলাদেশে প্রথম সফল আইভিএফ টেস্টটিউব ত্রয়ী সন্তান জন্ম দিয়ে ফিরোজা বেগম দেশের প্রথম টেস্টটিউব শিশুর মা হওয়ার গৌরব অর্জন করেন।',
                'options' => [
                    ['A', 'পারভীন ফাতেমা', false],
                    ['B', 'ফিরোজা বেগম', true],
                    ['C', 'রওশন জাহান', false],
                    ['D', 'কানিজ ফাতেমা', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ জাতিসংঘের কততম সদস্য?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৩৬ তম</strong>: ১৯৭৪ সালের ১৭ সেপ্টেম্বর জাতিসংঘের ২৯তম সাধারণ অধিবেশনে সর্বসম্মতভাবে বাংলাদেশ সংস্থাটির ১৩৬তম সদস্য রাষ্ট্র হিসেবে অন্তর্ভুক্ত হয়।',
                'options' => [
                    ['A', '১৩৬ তম', true],
                    ['B', '১৩৭ তম', false],
                    ['C', '১৩৮ তম', false],
                    ['D', '১৩৯ তম', false],
                ],
            ],
            [
                'stem' => 'কেন্দ্রীয় শহীদ মিনারের স্থপতি কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>হামিদুর রহমান</strong>: মহান ভাষা আন্দোলনের স্মৃতিবিজড়িত জাতীয় কেন্দ্রীয় শহীদ মিনারের মূল নকশা ও স্থাপত্য পরিকল্পনা প্রণয়ন করেন শিল্পী হামিদুর রহমান (সহযোগী ভাস্কর নভেরা আহমেদ)।',
                'options' => [
                    ['A', 'তানভীর কবীর', false],
                    ['B', 'হামিদুর রহমান', true],
                    ['C', 'হামিদুজ্জামান', false],
                    ['D', 'অস্কার বাদল', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘ সাধারণ পরিষদের প্রথম বাংলাদেশী সভাপতি কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>হুমায়ুন রশীদ চৌধুরী</strong>: ১৯৮৬ সালে জাতিসংঘের ৪১তম সাধারণ অধিবেশনে বাংলাদেশের তৎকালীন পররাষ্ট্রমন্ত্রী হুমায়ুন রশীদ চৌধুরী প্রথম বাঙালি ও বাংলাদেশী হিসেবে সভাপতি নির্বাচিত হন।',
                'options' => [
                    ['A', 'বি এ সিদ্দিকী', false],
                    ['B', 'খাজা ওয়াসিউদ্দিন', false],
                    ['C', 'হুমায়ুন রশীদ চৌধুরী', true],
                    ['D', 'শমসের মবিন চৌধুরী', false],
                ],
            ],
            [
                'stem' => 'স্বাধীনতা যুদ্ধে অবদান রাখার জন্য কতজন মহিলাকে বীরপ্রতীক উপাধিতে ভূষিত করা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২ জন</strong>: মুক্তিযুদ্ধে প্রত্যক্ষ সাহসিকতাপূর্ণ অবদানের জন্য ক্যাপ্টেন ডা. সেতারা বেগম এবং তারামন বিবি— এই দুজন মহীয়সী নারীকে \'বীর প্রতীক\' খেতাবে ভূষিত করা হয়।',
                'options' => [
                    ['A', '৫ জন', false],
                    ['B', '৭ জন', false],
                    ['C', '২ জন', true],
                    ['D', '৬ জন', false],
                ],
            ],
            [
                'stem' => 'কর্মসংস্থান ব্যাংক প্রতিষ্ঠিত হয় কোন সনে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৯৮</strong>: দেশের বেকার যুবকদের কর্মসংস্থান সৃষ্টি ও ক্ষুদ্র ব্যবসা পরিচালনায় সহজ শর্তে ঋণ সহায়তা দিতে ১৯৯৮ সালে বিশেষায়িত আর্থিক প্রতিষ্ঠান \'কর্মসংস্থান ব্যাংক\' প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৯৫', false],
                    ['B', '১৯৯৬', false],
                    ['C', '১৯৯৮', true],
                    ['D', '২০০১', false],
                ],
            ],
            [
                'stem' => 'লোকসংখ্যার দিক থেকে বাংলাদেশ বিশ্বের কততম স্থানে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৮ম</strong>: জাতিসংঘের জনসংখ্যা তহবিল (UNFPA) ও বিবিএস-এর সর্বশেষ বৈশ্বিক পরিসংখ্যান অনুযায়ী জনসংখ্যার দিক থেকে বিশ্বে বাংলাদেশের বর্তমান অবস্থান ৮ম।',
                'options' => [
                    ['A', '৫ম', false],
                    ['B', '৭ম', false],
                    ['C', '৮ম', true],
                    ['D', '১০ম', false],
                ],
            ],
            [
                'stem' => 'সেন্ট মার্টিন দ্বীপের আয়তন কত বর্গ কিলোমিটার?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৮</strong>: বঙ্গোপসাগরের উত্তর-পূর্বাংশে অবস্থিত বাংলাদেশের একমাত্র প্রবাল দ্বীপ সেন্টমার্টিনের (নারিকেল জিঞ্জিরা) ভৌগোলিক আয়তন প্রায় ৮ বর্গ কিলোমিটার (জোয়ার-ভাটার তারতম্যে প্রায় ৩.৫ বর্গ মাইল)।',
                'options' => [
                    ['A', '৮', true],
                    ['B', '১০', false],
                    ['C', '১২', false],
                    ['D', '১৪', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে পরমাণু শক্তি কমিশন গঠিত হয় কোন সনে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৭৩</strong>: পরমাণু শক্তির শান্তিপূর্ণ ব্যবহারের লক্ষ্যে রাষ্ট্রপতি বঙ্গবন্ধু শেখ মুজিবুর রহমানের জারি করা পিও নং ১৫ অনুযায়ী ১৯৭৩ সালের ২৭ ফেব্রুয়ারি বাংলাদেশ পরমাণু শক্তি কমিশন (BAEC) গঠিত হয়।',
                'options' => [
                    ['A', '১৯৭২', false],
                    ['B', '১৯৭৩', true],
                    ['C', '১৯৭৫', false],
                    ['D', '১৯৯৭', false],
                ],
            ],
            [
                'stem' => 'কোন ইঞ্জিনে কার্বুরেটর থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>পেট্রোল ইঞ্জিনে</strong>: পেট্রোল বা গ্যাসোলিন ইঞ্জিনে বাতাস ও জ্বালানির সঠিক অনুপাতের দাহ্য মিশ্রণ তৈরির জন্য কার্বুরেটর (Carburetor) ব্যবহৃত হয়। ডিজেল ইঞ্জিনে ফুয়েল ইনজেক্টর থাকে।',
                'options' => [
                    ['A', 'পেট্রোল ইঞ্জিনে', true],
                    ['B', 'ডিজেল ইঞ্জিনে', false],
                    ['C', 'রকেট ইঞ্জিনে', false],
                    ['D', 'বিমান ইঞ্জিন', false],
                ],
            ],
            [
                'stem' => 'সর্বাপেক্ষা ছোট তরঙ্গ দৈর্ঘ্যের বিকিরণ হচ্ছে-',
                'subject' => 'science',
                'explanation' => '<strong>গামা রশ্মি</strong>: তড়িৎচৌম্বক বর্ণালীর মধ্যে গামা রশ্মির (Gamma Ray) তরঙ্গদৈর্ঘ্য সবচেয়ে ক্ষুদ্রতম (১০⁻¹২ মিটারের চেয়ে কম) এবং এর কম্পাঙ্ক ও ভেদ ক্ষমতা সর্বাধিক।',
                'options' => [
                    ['A', 'আলফা রশ্মি', false],
                    ['B', 'বিটা রশ্মি', false],
                    ['C', 'গামা রশ্মি', true],
                    ['D', 'রঞ্জন রশ্মি', false],
                ],
            ],
            [
                'stem' => 'মানুষের হৃৎপিণ্ডে কতটি প্রকোষ্ঠ থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>চারটি</strong>: স্তন্যপায়ী হিসেবে মানুষের হৃৎপিণ্ড চার প্রকোষ্ঠবিশিষ্ট: দুটি অলিন্দ (ডান ও বাম অলিন্দ) এবং দুটি নিলয় (ডান ও বাম নিলয়)।',
                'options' => [
                    ['A', 'দুটি', false],
                    ['B', 'চারটি', true],
                    ['C', 'ছয়টি', false],
                    ['D', 'আটটি', false],
                ],
            ],
            [
                'stem' => 'প্রেসার কুকারে রান্না তাড়াতাড়ি হয়, কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>উচ্চচাপে তরলের স্ফুটনাংক বৃদ্ধি পায়</strong>: আবদ্ধ পাত্রে অতিরিক্ত বাষ্পীয় চাপের ফলে পানির স্বাভাবিক স্ফুটনাঙ্ক ১০০°C থেকে বেড়ে ১২০°C-১২৫°C হয়, ফলে উচ্চ তাপমাত্রায় দ্রুত খাদ্য সিদ্ধ হয়।',
                'options' => [
                    ['A', 'রান্নার জন্য শুধু তাপ নয় চাপও কাজে লাগে', false],
                    ['B', 'বদ্ধ পাত্রে তাপ সংরক্ষিত হয়', false],
                    ['C', 'উচ্চচাপে তরলের স্ফুটনাংক বৃদ্ধি পায়', true],
                    ['D', 'সঞ্চিত বাষ্পের তাপ রান্না সহায়ক', false],
                ],
            ],
            [
                'stem' => 'বিলিরুবিন তৈরি হয়-',
                'subject' => 'science',
                'explanation' => '<strong>প্লীহায় / যকৃতে</strong>: লোহিত রক্তকণিকার (RBC) স্বাভাবিক ভাঙ্গন প্লীহায় (Spleen) ঘটে হিমোগ্লোবিন বিনষ্ট হয়ে বিলিরুবিন ও বিলিভার্ডিন তৈরি হয় এবং পরবর্তীতে তা যকৃতে এসে পিত্তরসের সাথে পরিবাহিত হয়।',
                'options' => [
                    ['A', 'পিত্তথলিতে', false],
                    ['B', 'কিডনীতে', false],
                    ['C', 'প্লীহায়', true],
                    ['D', 'যকৃতে', false],
                ],
            ],
            [
                'stem' => 'মানুষের গায়ের রং কোন উপাদানের উপর নির্ভর করে?',
                'subject' => 'science',
                'explanation' => '<strong>মেলানিন</strong>: মানব ত্বকের এপিডার্মিসের মেলানোসাইট কোষ থেকে ক্ষরিত জৈব রঞ্জক \'মেলানিন\' (Melanin)-এর পরিমাণের ওপর নির্ভর করে ত্বকের বর্ণ ফর্সা বা শ্যামলা/কালো হয়।',
                'options' => [
                    ['A', 'মেলানিন', true],
                    ['B', 'থায়ামিন', false],
                    ['C', 'ক্যারোটিন', false],
                    ['D', 'হিমোগ্লোবিন', false],
                ],
            ],
            [
                'stem' => 'বাদুড় অন্ধকারে চলাফেরা করে কীভাবে?',
                'subject' => 'science',
                'explanation' => '<strong>সৃষ্ট শব্দের প্রতিধ্বনি শুনে</strong>: বাদুড় মুখ দিয়ে উচ্চ কম্পাঙ্কের শব্দোত্তর তরঙ্গ (Ultrasound) তৈরি করে এবং প্রতিবন্ধকে বাধা পেয়ে ফিরে আসা প্রতিধ্বনি (Echolocation) শুনে অন্ধকারে পথ ও শিকার চিহ্নিত করে।',
                'options' => [
                    ['A', 'তীক্ষ্ম দৃষ্টিসম্পন্ন চোখের সাহায্যে', false],
                    ['B', 'ক্রমাগত শব্দ উৎপন্নের মাধ্যমে অবস্থান নির্ণয় করে', false],
                    ['C', 'সৃষ্ট শব্দের প্রতিধ্বনি শুনে', true],
                    ['D', 'অলৌকিকভাবে', false],
                ],
            ],
            [
                'stem' => 'গাছের খাদ্য তালিকায় আছে-',
                'subject' => 'science',
                'explanation' => '<strong>N, P, K, S ও Zn</strong>: উদ্ভিদের স্বাভাবিক বৃদ্ধি ও পুষ্টির জন্য প্রধান পুষ্টি উপাদান হলো নাইট্রোজেন (N), ফসফরাস (P), পটাশিয়াম (K), সালফার (S) এবং জিংক (Zn)।',
                'options' => [
                    ['A', 'N, P, K, S ও Zn', true],
                    ['B', 'Na, P, K, S ও Zn', false],
                    ['C', 'N, B, K, S ও Al', false],
                    ['D', 'N, P, K, S ও Al', false],
                ],
            ],
            [
                'stem' => 'নিচের কোনটি DNA এর নাইট্রোজেন বেস?',
                'subject' => 'science',
                'explanation' => '<strong>গোয়ানিন</strong>: ডিএনএ-র (DNA) চারটি নাইট্রোজেনাস ক্ষারক হলো অ্যাডিনিন (A), গুয়ানিন (G), সাইটোসিন (C) এবং থাইমিন (T)। ইউরাসিল থাকে কেবল আরএনএ-তে।',
                'options' => [
                    ['A', 'ইউরাসিল', false],
                    ['B', 'গোয়ানিন', true],
                    ['C', 'পিরিডক্সিন', false],
                    ['D', 'অ্যাসপারাজিন', false],
                ],
            ],
            [
                'stem' => 'নিচের কোনটি পরমাণুর নিউক্লিয়াসে থাকে না?',
                'subject' => 'science',
                'explanation' => '<strong>electron</strong>: পরমাণুর কেন্দ্রস্থল নিউক্লিয়াসে প্রোটন ও নিউট্রন (নিউক্লিয়ন) দৃঢ়ভাবে আবদ্ধ থাকে, আর ঋণাত্মক চার্জযুক্ত ইলেকট্রন নিউক্লিয়াসের বাইরে বিভিন্ন কক্ষপথে আবর্তন করে।',
                'options' => [
                    ['A', 'meson', false],
                    ['B', 'neutron', false],
                    ['C', 'proton', false],
                    ['D', 'electron', true],
                ],
            ],
            [
                'stem' => '২০০৫ সালে যুক্তরাষ্ট্রের দক্ষিণ বা দক্ষিণ-পশ্চিম অঞ্চলে সর্বপ্রথম কোন হারিকেনটি আঘাত হানে?',
                'subject' => 'science',
                'explanation' => '<strong>আইভান / ডেনিস</strong>: বিধ্বংসী আটলান্টিক হারিকেনগুলোর মধ্যে হারিকেন ডেনিস ও হারিকেন ক্যাটরিনা ২০০৫ সালে মেক্সিকো উপসাগরীয় উপকূল ও দক্ষিণ যুক্তরাষ্ট্রে আঘাত হেনেছিল।',
                'options' => [
                    ['A', 'ডেনিস', false],
                    ['B', 'ক্যাটারিনা', false],
                    ['C', 'আইভান', true],
                    ['D', 'রিটা', false],
                ],
            ],
            [
                'stem' => 'কোন দেশটি স্ক্যান্ডিনেভিয়ার অন্তর্ভুক্ত নয়?',
                'subject' => 'international',
                'explanation' => '<strong>নেদারল্যান্ডস ও যুক্তরাষ্ট্র</strong>: স্ক্যান্ডিনেভিয়ান অঞ্চলের দেশগুলো হলো ডেনমার্ক, নরওয়ে ও সুইডেন (বিস্তৃত অর্থে ফিনল্যান্ড ও আইসল্যান্ড)। নেদারল্যান্ডস ও যুক্তরাষ্ট্র স্ক্যান্ডিনেভিয়ার অংশ নয়।',
                'options' => [
                    ['A', 'ডেনমার্ক', false],
                    ['B', 'ফিনল্যান্ড', false],
                    ['C', 'নেদারল্যান্ডস', false],
                    ['D', 'যুক্তরাষ্ট্র', true],
                ],
            ],
            [
                'stem' => 'মুসলমান প্রধান না হয়েও কোন দেশটি ইসলামী সহযোগিতা সংস্থার সদস্য?',
                'subject' => 'international',
                'explanation' => '<strong>উগান্ডা</strong>: ওআইসি (OIC)-র সদস্য দেশগুলোর মধ্যে মধ্য আফ্রিকার দেশ উগান্ডা ও গায়ানা মুসলিম সংখ্যাগরিষ্ঠ দেশ না হওয়া সত্ত্বেও ওআইসির পূর্ণ সদস্য।',
                'options' => [
                    ['A', 'নাইজেরিয়া', false],
                    ['B', 'লেবানন', false],
                    ['C', 'নাইজার', false],
                    ['D', 'উগান্ডা', true],
                ],
            ],
            [
                'stem' => 'কিউবায় ক্ষেপণাস্ত্র সংকটের সময় যুক্তরাষ্ট্রের প্রেসিডেন্ট কে ছিলেন?',
                'subject' => 'international',
                'explanation' => '<strong>জন এফ কেনেডি</strong>: ১৯৬২ সালের অক্টোবর মাসে স্নায়ুযুদ্ধের চরম উত্তেজনাকর ১৩ দিনের কিউবান মিসাইল সংকটের সময় যুক্তরাষ্ট্রের ৩৫তম প্রেসিডেন্ট ছিলেন জন এফ. কেনেডি।',
                'options' => [
                    ['A', 'রিচার্ড এম নিক্সন', false],
                    ['B', 'জন এফ কেনেডি', true],
                    ['C', 'লিন্ডন বেইনস জনসন', false],
                    ['D', 'হ্যারি এস ট্রুম্যান', false],
                ],
            ],
            [
                'stem' => 'মার্কিন যুক্তরাষ্ট্রের কোন প্রেসিডেন্ট ১২ বছর ক্ষমতায় অধিষ্ঠিত ছিলেন?',
                'subject' => 'international',
                'explanation' => '<strong>ফ্রাঙ্কলিন রুজভেল্ট</strong>: একমাত্র মার্কিন প্রেসিডেন্ট হিসেবে ফ্রাঙ্কলিন ডি. রুজভেল্ট ১৯৩৩ থেকে ১৯৪৫ সাল পর্যন্ত একটানা ১২ বছর মার্কিন রাষ্ট্রপতির দায়িত্বে অধিষ্ঠিত ছিলেন।',
                'options' => [
                    ['A', 'হ্যারি এস ট্রুম্যান', false],
                    ['B', 'ফ্রাঙ্কলিন রুজভেল্ট', true],
                    ['C', 'জেমস মনরো', false],
                    ['D', 'তথ্যটি সঠিক নয়', false],
                ],
            ],
            [
                'stem' => 'ভারতীয় লোকসভার নির্বাচিত সদস্য সংখ্যা কত?',
                'subject' => 'international',
                'explanation' => '<strong>৫৪৩</strong>: ভারতীয় লোকসভার মোট ৫৪৩টি সংসদীয় আসনে প্রত্যক্ষ জনগণের ভোটে সাংসদরা নির্বাচিত হন।',
                'options' => [
                    ['A', '৫৪৩', true],
                    ['B', '৫৪৫', false],
                    ['C', '৪১৪', false],
                    ['D', '৫৪০', false],
                ],
            ],
            [
                'stem' => 'কোন দেশের মহিলারা সর্বপ্রথম ভোটাধিকার লাভ করে?',
                'subject' => 'international',
                'explanation' => '<strong>নিউজিল্যান্ড</strong>: বিশ্বের প্রথম স্বাধীন ও স্বশাসিত দেশ হিসেবে ১৮৯৩ সালে ওশেনিয়ার দেশ নিউজিল্যান্ডে মহিলাদের জাতীয় নির্বাচনে পূর্ণ ভোটাধিকার প্রদান করা হয়।',
                'options' => [
                    ['A', 'মার্কিন যুক্তরাষ্ট্র', false],
                    ['B', 'নিউজিল্যান্ড', true],
                    ['C', 'বাহামা', false],
                    ['D', 'সুইজারল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'রাসায়নিক অস্ত্র চুক্তি নুমো (Chemical Weapons Convention) কোন সালে স্বাক্ষরিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৯৩</strong>: প্যারিসে ১৯৯৩ সালের ১৩ জানুয়ারি আন্তর্জাতিক রাসায়নিক অস্ত্র নিষিদ্ধকরণ সংক্রান্ত সার্বজনীন কনভেনশন (CWC) স্বাক্ষরিত হয় (কার্যকর হয় ২৯ এপ্রিল ১৯৯৭)।',
                'options' => [
                    ['A', '১৯৯০', false],
                    ['B', '১৯৯৩', true],
                    ['C', '১৯৯৬', false],
                    ['D', '১৯৯৯', false],
                ],
            ],
            [
                'stem' => 'কোন পরিষদের সুপারিশক্রমে জাতিসংঘে নতুন সদস্য গ্রহণ করা হয়?',
                'subject' => 'international',
                'explanation' => '<strong>নিরাপত্তা পরিষদ</strong>: জাতিসংঘের সনদের ৪(২) অনুচ্ছেদ অনুযায়ী ১৫ সদস্যের নিরাপত্তা পরিষদের ইতিবাচক সুপারিশের ভিত্তিতে সাধারণ পরিষদের দুই-তৃতীয়াংশ সংখ্যাগরিষ্ঠ ভোটে নতুন সদস্য রাষ্ট্র গৃহীত হয়।',
                'options' => [
                    ['A', 'অছি পরিষদ', false],
                    ['B', 'অর্থনৈতিক ও সামাজিক পরিষদ', false],
                    ['C', 'নিরাপত্তা পরিষদ', true],
                    ['D', 'সাধারণ পরিষদ', false],
                ],
            ],
            [
                'stem' => 'কোন মুসলিম মনীষী সর্বপ্রথম নোবেল পুরস্কার পান?',
                'subject' => 'international',
                'explanation' => '<strong>আনোয়ার সাদাত</strong>: ১৯৭৮ সালে ক্যাম্প ডেভিড শান্তি চুক্তির ঐতিহাসিক অবদানের জন্য মিশরের তৎকালীন প্রেসিডেন্ট আনোয়ার সাদাত প্রথম মুসলিম হিসেবে শান্তিতে নোবেল পুরস্কার লাভ করেন।',
                'options' => [
                    ['A', 'ইয়াসির আরাফাত', false],
                    ['B', 'নাগীব মাহফুজ', false],
                    ['C', 'আনোয়ার সাদাত', true],
                    ['D', 'প্রফেসর আব্দুস সালাম', false],
                ],
            ],
            [
                'stem' => 'বাদশা ফাহাদের পর সৌদি বাদশা কে হন?',
                'subject' => 'international',
                'explanation' => '<strong>আব্দুল্লাহ</strong>: ২০০৫ সালের ১ আগস্ট সৌদি আরবের দীর্ঘকালীন শাসক বাদশাহ ফাহাদ বিন আব্দুল আজিজের মৃত্যুর পর তাঁর সৎ ভাই বাদশাহ আব্দুল্লাহ বিন আব্দুল আজিজ নতুন বাদশাহ হিসেবে সিংহাসনে আরোহণ করেন।',
                'options' => [
                    ['A', 'খালেদ', false],
                    ['B', 'ফয়সাল', false],
                    ['C', 'আব্দুল আজিজ', false],
                    ['D', 'আবদুল্লাহ', true],
                ],
            ],
            [
                'stem' => 'অক্সফাম (Oxfam) এর সদর দপ্তর কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>লন্ডন</strong>: আন্তর্জাতিক দারিদ্র্য বিমোচন ও মানবিক দাতব্য সংস্থা অক্সফাম ১৯৪২ সালে যুক্তরাজ্যে প্রতিষ্ঠিত হয় এবং এর আন্তর্জাতিক প্রধান কার্যালয় যুক্তরাজ্যে অবস্থিত।',
                'options' => [
                    ['A', 'নিউইয়র্ক', false],
                    ['B', 'ক্যামেনিক্স', false],
                    ['C', 'লন্ডন', true],
                    ['D', 'হেগ', false],
                ],
            ],
            [
                'stem' => 'কোনটি বিংশ শতাব্দীর শেষ ভাগে উপনিবেশবাদের নিগড় থেকে মুক্ত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>ম্যাকাউ</strong>: পর্তুগালের অধীনে থাকা সাড়ে চার শতাব্দীর উপনিবেশ ম্যাকাউ ১৯৯৯ সালের ২০ ডিসেম্বর আনুষ্ঠানিকভাবে চীনের সার্বভৌমত্বে হস্তান্তর হয়। হংকং মুক্ত হয় ১৯৯৭ সালে।',
                'options' => [
                    ['A', 'হংকং', false],
                    ['B', 'শ্রীলংকা', false],
                    ['C', 'ম্যাকাউ', true],
                    ['D', 'বাংলাদেশ', false],
                ],
            ],
            [
                'stem' => 'নিচের কোন চুক্তিটি যুক্তরাষ্ট্রের সিনেটে অনুমোদিত হয়নি?',
                'subject' => 'international',
                'explanation' => '<strong>সল্ট-২ চুক্তি (SALT-2)</strong>: ১৯৭৯ সালে কার্টার ও ব্রেজনেভের স্বাক্ষরিত কৌশলগত অস্ত্র সীমিতকরণ চুক্তি \'SALT-II\' সোভিয়েত ইউনিয়নের আফগানিস্তান আক্রমণের কারণে মার্কিন সিনেটে কখনো অনুমোদিত ও অনুসমর্থিত হয়নি।',
                'options' => [
                    ['A', 'এবিএম চুক্তি (ABM)', false],
                    ['B', 'সল্ট-১ চুক্তি (SALT-1)', false],
                    ['C', 'সল্ট-২ চুক্তি (SALT-2)', true],
                    ['D', 'স্টার্ট-২ চুক্তি (START-2)', false],
                ],
            ],
            [
                'stem' => 'Amnesty International কত সালে নোবেল শান্তি পুরস্কার পেয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৭৭</strong>: বিশ্বজুড়ে মানবাধিকার রক্ষা ও বিবেকের বন্দিদের মুক্তিতে অসামান্য অবদানের জন্য আন্তর্জাতিক মানবাধিকার সংস্থা অ্যামনেস্টি ইন্টারন্যাশনাল ১৯৭৭ সালে শান্তিতে নোবেল পুরস্কার লাভ করে।',
                'options' => [
                    ['A', '১৯৭৭', true],
                    ['B', '১৯৭৮', false],
                    ['C', '১৯৭৯', false],
                    ['D', '১৯৮১', false],
                ],
            ],
            [
                'stem' => 'START-2 কী?',
                'subject' => 'international',
                'explanation' => '<strong>কৌশলগত অস্ত্র হ্রাস সংক্রান্ত চুক্তি</strong>: ১৯৯৩ সালে মস্কোয় বুশ ও ইয়েলৎসিনের মধ্যে স্বাক্ষরিত মার্কিন-রুশ দ্বিপাক্ষিক পারমাণবিক মিসাইল ও ওয়ারহেড হ্রাস চুক্তি হলো Strategic Arms Reduction Treaty-II (START-II)।',
                'options' => [
                    ['A', 'টিভিতে সম্প্রচারিত একটি সিরিয়াল', false],
                    ['B', 'বাণিজ্য সংক্রান্ত একটি চুক্তি', false],
                    ['C', 'কৌশলগত অস্ত্র হ্রাস সংক্রান্ত চুক্তি', true],
                    ['D', 'এর কোনোটিই নয়', false],
                ],
            ],
            [
                'stem' => 'আসিয়ান রিজিওনাল ফোরাম (ARF)এর সদস্য সংখ্যা কত?',
                'subject' => 'international',
                'explanation' => '<strong>২৭</strong>: এশিয়া-প্রশান্ত মহাসাগরীয় অঞ্চলের নিরাপত্তা আলোচনা বিষয়ক আঞ্চলিক জোট আসিয়ান রিজিওনাল ফোরাম (ARF)-এর বর্তমান সদস্য দেশ সংখ্যা ২৭টি (বাংলাদেশ ২০০৬ সালে যোগ দেয়)।',
                'options' => [
                    ['A', '২১', false],
                    ['B', '২২', false],
                    ['C', '২৩', false],
                    ['D', '২৬', true],
                ],
            ],
            [
                'stem' => 'মালয়েশিয়ার সাবেক প্রধানমন্ত্রী ড. মাহাথির মোহাম্মদ কত বছর ক্ষমতায় ছিলেন?',
                'subject' => 'international',
                'explanation' => '<strong>২২ বছর</strong>: মালয়েশিয়ার আধুনিকায়নের রূপকার ড. মাহাথির মোহাম্মদ ১৯৮১ থেকে ২০০৩ সাল পর্যন্ত প্রথম দফায় একটানা দীর্ঘ ২২ বছর দেশটির প্রধানমন্ত্রী হিসেবে দায়িত্ব পালন করেন।',
                'options' => [
                    ['A', '২১ বছর', false],
                    ['B', '২২ বছর', true],
                    ['C', '২৪ বছর', false],
                    ['D', '২৫ বছর', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ কত সালে ইসলামী সম্মেলন সংস্থার সদস্যপদ লাভ করে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৭৪ সালে</strong>: ১৯৭৪ সালের ফেব্রুয়ারিতে লাহোরে অনুষ্ঠিত দ্বিতীয় ওআইসি সম্মেলনে বঙ্গবন্ধু শেখ মুজিবুর রহমানের অংশগ্রহণের মাধ্যমে বাংলাদেশ আনুষ্ঠানিকভাবে ওআইসির সদস্যপদ লাভ করে।',
                'options' => [
                    ['A', '১৯৭২ সালে', false],
                    ['B', '১৯৭৩ সালে', false],
                    ['C', '১৯৭৪ সালে', true],
                    ['D', '১৯৭৫ সালে', false],
                ],
            ],
            [
                'stem' => 'ইরাকের সাবেক প্রেসিডেন্ট জালাল তালাবানি কোন সম্প্রদায়ের?',
                'subject' => 'international',
                'explanation' => '<strong>কুর্দি</strong>: সাদ্দাম হোসেন পরবর্তী নয়া গণতান্ত্রিক ইরাকে ২০০৫ সালে নির্বাচিত প্রথম অ-আরব প্রেসিডেন্ট জালাল তালাবানি প্যাট্রিয়টিক ইউনিয়ন অব কুর্দিস্তানের (PUK) প্রভাবশালী কুর্দি নেতা ছিলেন।',
                'options' => [
                    ['A', 'সুন্নি', false],
                    ['B', 'শিয়া', false],
                    ['C', 'কুর্দি', true],
                    ['D', 'খ্রিস্টান', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, options, tags and link to the 27th BCS exam
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
                'reference_source' => '২৭তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '27th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '2007',
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
