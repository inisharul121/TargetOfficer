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

class Bcs13thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '13th')->first() ?? ExamYear::firstOrCreate(['year' => '13th'], [
            'name_en' => '13th BCS Exam',
            'name_bn' => '১৩তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 13th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '13th-bcs-preliminary'],
            [
                'title_bn' => '১৩তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '13th BCS Preliminary Question Solution',
                'description_bn' => '১৩তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 13th BCS Preliminary Examination.',
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
            // ==========================================
            // ১-২০: বাংলা ভাষা ও সাহিত্য (Bangla)
            // ==========================================
            [
                'stem' => '‘‘শৈবাল দিঘিরে কহে উচ্চ করি শির; লিখে রেখ, এক বিন্দু দিলেম শিশির।’’ এ অংশটুকুর প্রতিপাদ্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>অকৃতজ্ঞতা</strong>: কবিগুরু রবীন্দ্রনাথ ঠাকুরের ‘কণিকা’ কাব্যগ্রন্থের অন্তর্গত এ কবিতায় দীঘির অফুরন্ত জলে লালিত হয়েও শৈবাল এক ফোঁটা শিশিরবিন্দু ফেরত দিয়ে উপকারের যে অবমূল্যায়ন করে, তা মূলত মানবজীবনের ঘোর অকৃতজ্ঞতাকে প্রতীকায়িত করে।',
                'options' => [
                    ['A', 'প্রতিদান', false],
                    ['B', 'প্রত্যুপকার', false],
                    ['C', 'অকৃতজ্ঞতা', true],
                    ['D', 'অসহিষ্ণুতা', false],
                ],
            ],
            [
                'stem' => '‘মোসলেম ভারত’ নামক সাহিত্য পত্রিকার সম্পাদক ছিলেন-',
                'subject' => 'bangla',
                'explanation' => '<strong>মোজাম্মেল হক</strong>: ১৯২০ সালে কলকাতা থেকে প্রকাশিত প্রগতিশীল মাসিক সাহিত্য পত্রিকা ‘মোসলেম ভারত’-এর প্রতিষ্ঠাতা সম্পাদক ছিলেন কবি মোজাম্মেল হক। কাজী নজরুল ইসলামের কালজয়ী ‘বিদ্রোহী’ কবিতা প্রথম এ পত্রিকাতেই ছাপা হয়েছিল।',
                'options' => [
                    ['A', 'মীর মশাররফ হোসেন', false],
                    ['B', 'মুন্সী মোহাম্মদ রিয়াজউদ্দীন আহমদ', false],
                    ['C', 'মোজাম্মেল হক', true],
                    ['D', 'রিয়াজউদ্দীন আহমদ মাশহাদী', false],
                ],
            ],
            [
                'stem' => 'কোন দুটি অঘোষ ধ্বনি?',
                'subject' => 'bangla',
                'explanation' => '<strong>চ, ছ</strong>: বর্গের প্রথম ও দ্বিতীয় ধ্বনি উচ্চারণের সময় স্বরতন্ত্রী অনুরণিত হয় না বলে তাদের অঘোষ ধ্বনি বলে। চ-বর্গের প্রথম দুটি ব্যঞ্জনধ্বনি ‘চ’ ও ‘ছ’ হলো অঘোষ ধ্বনি।',
                'options' => [
                    ['A', 'চ, ছ', true],
                    ['B', 'ড, ঢ', false],
                    ['C', 'ব, ভ', false],
                    ['D', 'দ, ধ', false],
                ],
            ],
            [
                'stem' => '‘গোঁফ-খেজুরে’ এই বাগধারাটির অর্থ কী?',
                'subject' => 'bangla',
                'explanation' => '<strong>নিতান্ত অলস</strong>: ‘গোঁফ-খেজুরে’ বাগধারাটির প্রচলিত অর্থ চরম বা নিতান্ত অলস ব্যক্তি (যার মুখের গোঁফে খেজুর পড়লেও তুলে খাওয়ার শ্রম স্বীকার করে না)।',
                'options' => [
                    ['A', 'আরামপ্রিয়', false],
                    ['B', 'উদাসীন', false],
                    ['C', 'নিতান্ত অলস', true],
                    ['D', 'পরমুখাপেক্ষী', false],
                ],
            ],
            [
                'stem' => 'বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের ‘কৃষ্ণকান্তের উইল’ উপন্যাসের প্রধান দুটি চরিত্রের নাম-',
                'subject' => 'bangla',
                'explanation' => '<strong>গোবিন্দলাল ও রোহিণী</strong>: বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের অন্যতম শ্রেষ্ঠ সামাজিক-মনস্তাত্ত্বিক উপন্যাস ‘কৃষ্ণকান্তের উইল’ (১৮৭৮)-এর প্রধান দুই কেন্দ্রীয় ট্র্যাজিক চরিত্র হলো গোবিন্দলাল ও রোহিণী।',
                'options' => [
                    ['A', 'নগেন্দ্রনাথ ও কুন্দনন্দিনী', false],
                    ['B', 'মধুসূদন ও কুমুদিনী', false],
                    ['C', 'গোবিন্দলাল ও রোহিণী', true],
                    ['D', 'সুরেশ ও অচলা', false],
                ],
            ],
            [
                'stem' => '‘যা পূর্বে ছিল এখন নেই’-এক কথায় কি হবে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ভূতপূর্ব</strong>: বাক্য সংকোচনে: যা পূর্বে ছিল এখন নেই = ভূতপূর্ব। যা পূর্বে কখনো দেখা যায়নি = অদৃষ্টপূর্ব। যা পূর্বে কখনো ঘটেনি = অভূতপূর্ব।',
                'options' => [
                    ['A', 'অপূর্ব', false],
                    ['B', 'অদৃষ্টপূর্ব', false],
                    ['C', 'অভূতপূর্ব', false],
                    ['D', 'ভূতপূর্ব', true],
                ],
            ],
            [
                'stem' => 'কোন বাক্যে সমুচ্চয়ী অব্যয় ব্যবহৃত হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>লেখাপড়া কর, নতুবা ফেল করবে</strong>: যে অব্যয় পদ একাধিক বাক্য বা পদকে যুক্ত, বিযুক্ত বা সংকুচিত করে তাকে সমুচ্চয়ী অব্যয় বলে। এখানে ‘নতুবা’ একটি বিয়োজক সমুচ্চয়ী অব্যয় পদ।',
                'options' => [
                    ['A', 'ধন অপেক্ষা মান বড়', false],
                    ['B', 'তোমাকে দিয়ে কিছু হবে না', false],
                    ['C', 'লেখাপড়া কর, নতুবা ফেল করবে', true],
                    ['D', 'ঢং ঢং ঘণ্টা বাজে', false],
                ],
            ],
            [
                'stem' => 'কোন সালে রবীন্দ্রনাথ ঠাকুরের জন্ম-শতবার্ষিকী পালিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৯৬১</strong>: কবিগুরু রবীন্দ্রনাথ ঠাকুর ১৮৬১ সালের ৭ মে (২৫ বৈশাখ ১২৬৮ বঙ্গাব্দ) জোড়াসাঁকোর ঠাকুর পরিবারে জন্মগ্রহণ করেন। সেই অনুসারে ১৯৬১ সালে তাঁর জন্মশতবার্ষিকী সারা বিশ্বে মহাসমারোহে উদযাপিত হয়।',
                'options' => [
                    ['A', '১৯৫১', false],
                    ['B', '১৯৬১', true],
                    ['C', '১৯৭১', false],
                    ['D', '১৯৮১', false],
                ],
            ],
            [
                'stem' => 'বাংলা বানান রীতি অনুযায়ী একই শব্দের কোন দুটি বানানই শুদ্ধ?',
                'subject' => 'bangla',
                'explanation' => '<strong>নারি/নারী</strong>: বাংলা একাডেমির প্রমিত বানান বিধির পূর্বে সংস্কৃত ও তৎসম প্রয়োগের বিকল্প প্রশ্নে ‘নারি/নারী’ উভয় রূপই সমকালীনভাবে শুদ্ধ হিসেবে বিবেচিত হয়েছিল।',
                'options' => [
                    ['A', 'হাতি/হাতী', false],
                    ['B', 'নারি/নারী', true],
                    ['C', 'জাতি/জাতী', false],
                    ['D', 'দাদি/দাদী', false],
                ],
            ],
            [
                'stem' => '‘অনল প্রবাহ’ রচনা করেন কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>সৈয়দ ইসমাইল হোসেন সিরাজী</strong>: ব্রিটিশবিরোধী মুসলিম জাগরণের চারণকবি সৈয়দ ইসমাইল হোসেন সিরাজীর বিখ্যাত দেশাত্মবোধক কাব্যগ্রন্থ ‘অনল-প্রবাহ’ (১৯০০)। সরকার রাজদ্রোহের অভিযোগে এ গ্রন্থটি বাজেয়াপ্ত করে এবং কবিকে কারারুদ্ধ করে।',
                'options' => [
                    ['A', 'মোজাম্মেল হক', false],
                    ['B', 'সৈয়দ ইসমাইল হোসেন সিরাজী', true],
                    ['C', 'এয়াকুব আলী চৌধুরী', false],
                    ['D', 'মুনিরুজ্জামান ইসলামাবাদী', false],
                ],
            ],
            [
                'stem' => 'কোন বাক্যে সমাপিকা ক্রিয়া ব্যবহৃত হয়েছে-',
                'subject' => 'bangla',
                'explanation' => '<strong>আমি দুপুরে ভাত খাই</strong>: যে ক্রিয়া দ্বারা বাক্যের মনোভাব ও অর্থ সম্পূর্ণভাবে পরিসমাপ্ত হয় তাকে সমাপিকা ক্রিয়া বলে। ‘খাই’ ক্রিয়াটি বাক্যের বক্তব্য সমাপ্ত করেছে।',
                'options' => [
                    ['A', 'আমি ভাত খাচ্ছি', false],
                    ['B', 'আমি ভাত খেয়ে স্কুলে যাব', false],
                    ['C', 'আমি দুপুরে ভাত খাই', true],
                    ['D', 'তাড়াতাড়ি ভাত খেয়ে ওঠ', false],
                ],
            ],
            [
                'stem' => 'জীবনানন্দ দাশ রচিত কাব্যগ্রন্থ-',
                'subject' => 'bangla',
                'explanation' => '<strong>ধূসর পাণ্ডুলিপি</strong>: ‘ধূসর পাণ্ডুলিপি’ (১৯৩৬) রূপসী বাংলার কবি জীবনানন্দ দাশের একটি বিখ্যাত কাব্যগ্রন্থ। তাঁর অন্যান্য কাব্য: ঝরা পালক, বনলতা সেন, রূপসী বাংলা ও বেলা অবেলা কালবেলা।',
                'options' => [
                    ['A', 'ধূসর পাণ্ডুলিপি', true],
                    ['B', 'নাম রেখেছি কোমল গান্ধার', false],
                    ['C', 'একক সন্ধ্যায় বসন্ত', false],
                    ['D', 'অন্ধকারে একা', false],
                ],
            ],
            [
                'stem' => 'মানিক বন্দ্যোপাধ্যায়ের ‘পদ্মানদীর মাঝি’ নামক উপন্যাসের উপজীব্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>জেলে জীবনের বিচিত্র সুখ-দুঃখ</strong>: পদ্মা তীরবর্তী কেতুপুর গ্রামের হোসেন মিঞা, কুবের ও কপিলাসহ জেলে সম্প্রদায়ের জীবিকা, দ্বন্দ্ব এবং তাদের বিচিত্র জীবনসংগ্রাম মানিক বন্দ্যোপাধ্যায়ের ‘পদ্মানদীর মাঝি’ (১৯৩৬) উপন্যাসের মূল উপজীব্য।',
                'options' => [
                    ['A', 'মাঝি-মাল্লার সংগ্রামশীল জীবন', false],
                    ['B', 'জেলে জীবনের বিচিত্র সুখ-দুঃখ', true],
                    ['C', 'চাষী জীবনের করুণ চিত্র', false],
                    ['D', 'চরাবাসীদের দুঃখী জীবন', false],
                ],
            ],
            [
                'stem' => 'কোন বাক্যে নাম পুরুষের ব্যবহার করা হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ওরা কি করে?</strong>: বক্তা ও শ্রোতা ছাড়া অনুপস্থিত তৃতীয় পক্ষকে ব্যাকরণে নাম পুরুষ (Third Person) বলে। ‘ওরা’ হলো নাম পুরুষের বহুবচন রূপ।',
                'options' => [
                    ['A', 'ওরা কি করে?', true],
                    ['B', 'আপনি আসবেন', false],
                    ['C', 'আমরা যাচ্ছি', false],
                    ['D', 'তোরা খাসনে', false],
                ],
            ],
            [
                'stem' => 'মধ্যপদলোপী কর্মধারয় এর দৃষ্টান্ত-',
                'subject' => 'bangla',
                'explanation' => '<strong>হাসি মাখা মুখ – হাসিমুখ</strong>: যে কর্মধারয় সমাসে ব্যাসবাক্যের মধ্যবর্তী ব্যাখ্যামূলক পদ লোপ পায় তাকে মধ্যপদলোপী কর্মধারয় সমাস বলে। এখানে ‘মাখা’ পদটি লোপ পেয়ে ‘হাসিমুখ’ হয়েছে।',
                'options' => [
                    ['A', 'ঘর থেকে ছাড়া - ঘরছাড়া', false],
                    ['B', 'অরুণের মত রাঙা - অরুণরাঙা', false],
                    ['C', 'হাসি মাখা মুখ – হাসিমুখ', true],
                    ['D', 'ক্ষণকাল ব্যাপিয়া স্থায়ী - ক্ষণস্থায়ী', false],
                ],
            ],
            [
                'stem' => 'কোনটি ঐতিহাসিক নাটক?',
                'subject' => 'bangla',
                'explanation' => '<strong>রক্তাক্ত প্রান্তর</strong>: ১৭৬১ সালের পানিপথের তৃতীয় যুদ্ধের ঐতিহাসিক পটভূমিতে রচিত শহীদ বুদ্ধিজীবী মুনীর চৌধুরীর অমর ঐতিহাসিক নাটক হলো ‘রক্তাক্ত প্রান্তর’ (১৯৬২)।',
                'options' => [
                    ['A', 'শর্মিষ্ঠা', false],
                    ['B', 'রাজসিংহ', false],
                    ['C', 'পলাশীর যুদ্ধ', false],
                    ['D', 'রক্তাক্ত প্রান্তর', true],
                ],
            ],
            [
                'stem' => 'মাইকেল মধুসূদন দত্তের দেশপ্রেমের প্রবল প্রকাশ ঘটেছে-',
                'subject' => 'bangla',
                'explanation' => '<strong>সনেটে</strong>: বিদেশে অবস্থানকালে মাতৃভূমি ও শৈশবের স্মৃতি নিয়ে রচিত মাইকেল মধুসূদন দত্তের চতুর্দশপদী কবিতা বা সনেটগুলোতে (যেমন ‘কপোতাক্ষ নদ’, ‘বঙ্গভাষা’) তাঁর প্রবল স্বদেশপ্রেম ও অনুশোচনা প্রকাশ পেয়েছে।',
                'options' => [
                    ['A', 'মহাকাব্যে', false],
                    ['B', 'নাটকে', false],
                    ['C', 'পত্রকাব্যে', false],
                    ['D', 'সনেটে', true],
                ],
            ],
            [
                'stem' => 'কোন বাক্যে ‘ঢাক্ ঢাক্ গুড় গুড়’ প্রবাদটির বিশেষ অর্থ প্রকাশ পেয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ঢাক্ ঢাক্ গুড় গুড় করে কি লাভ, আসল কথাটি বল</strong>: ‘ঢাক ঢাক গুড় গুড়’ বাগধারার অর্থ কোনো বিষয় গোপন করার চেষ্টা বা লুকোচুরি করা। আসল কথা প্রকাশ করার তাগিদে এই বাক্যে বাগধারাটির যথাযথ অর্থ প্রকাশ পেয়েছে।',
                'options' => [
                    ['A', 'ঢাক্ ঢাক্ গুড় গুড় করে কি লাভ, কাজে লেগে যাও', false],
                    ['B', 'ঢাক্ ঢাক্ গুড় গুড় করে কি লাভ, আসল কথাটি বল', true],
                    ['C', 'ঢাক্ ঢাক্ গুড় গুড় করে কি লাভ, কি খাবে বল', false],
                    ['D', 'ঢাক্ ঢাক্ গুড় গুড় করে কি লাভ, নিজের পায়ে দাঁড়াও', false],
                ],
            ],
            [
                'stem' => 'ইসলামের ইতিহাস ও ঐতিহ্য কোন কাব্যের উপজীব্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>সাত সাগরের মাঝি -ফররুখ আহমদ</strong>: মুসলিম রেনেসাঁর কবি ফররুখ আহমদের বিখ্যাত কাব্যগ্রন্থ ‘সাত সাগরের মাঝি’ (১৯৪৪)-তে ইসলামী ইতিহাস, সিন্ধবাদ, আল কোরআনের আদর্শ ও আরব সংস্কৃতির রূপক প্রাধান্য পেয়েছে।',
                'options' => [
                    ['A', 'জিঞ্জির – কাজী নজরুল ইসলাম', false],
                    ['B', 'সাত সাগরের মাঝি -ফররুখ আহমদ', true],
                    ['C', 'দিলরুবা -আবদুল কাদির', false],
                    ['D', 'নূরনামা – আবদুল হাকিম', false],
                ],
            ],
            [
                'stem' => '‘বন্যেরা বনে সুন্দর, শিশুরা মাতৃক্রোড়ে’ – এ উক্তিটির প্রকৃত তাৎপর্য হচ্ছে-',
                'subject' => 'bangla',
                'explanation' => '<strong>জীব মাত্রই স্বাভাবিক অবস্থানে সুন্দর</strong>: সঞ্জীবচন্দ্র চট্টোপাধ্যায়ের ভ্রমণগ্রন্থ ‘পালামৌ’-এর এ বিখ্যাত উক্তির মূল অন্তর্নিহিত অর্থ হলো প্রত্যেক প্রাণী বা সৃষ্টি তার নিজস্ব প্রাকৃতিক ও স্বাভাবিক পরিবেশেই সর্বাধিক সৌন্দর্যময় ও সার্থক।',
                'options' => [
                    ['A', 'আদিবাসী মানুষ অরণ্য জনপদে বাস করে', false],
                    ['B', 'বনের পশু বনে থাকতে ভালোবাসে', false],
                    ['C', 'জীব মাত্রই স্বাভাবিক অবস্থানে সুন্দর', true],
                    ['D', 'প্রকৃতির রূপ-সৌন্দর্য আদি ও অকৃত্রিম', false],
                ],
            ],

            // ==========================================
            // ২১-৪০: ইংরেজি ভাষা ও সাহিত্য (English)
            // ==========================================
            [
                'stem' => 'Select the answer of the word ‘Stagflation’',
                'subject' => 'english',
                'explanation' => '<strong>economics slow down</strong>: \'Stagflation\' হলো অর্থনীতিতে এমন এক পরিস্থিতি যেখানে অর্থনৈতিক প্রবৃদ্ধির স্থবিরতা বা মন্দা (slow down/stagnant output) এবং একই সাথে উচ্চ বেকারত্ব ও মুদ্রাস্ফীতি বজায় থাকে।',
                'options' => [
                    ['A', 'controlled prices', false],
                    ['B', 'economics slow down', true],
                    ['C', 'a disintegrating government', false],
                    ['D', 'cultural dullness', false],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘Scuttle’?',
                'subject' => 'english',
                'explanation' => '<strong>abandon</strong>: \'Scuttle\' অর্থ ডুবিয়ে দেওয়া, ধ্বংস করা বা কোনো পরিকল্পনা অথবা জাহাজ ইচ্ছাকৃতভাবে পরিত্যাগ করা (abandon deliberately / sink deliberately)।',
                'options' => [
                    ['A', 'to tease', false],
                    ['B', 'abandon', true],
                    ['C', 'pile up', false],
                    ['D', 'gossip', false],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘stanch’?',
                'subject' => 'english',
                'explanation' => '<strong>put an end to</strong>: \'Stanch\' (বা staunch) ক্রিয়াপদটির অর্থ হলো কোনো তরল বা রক্তপ্রবাহের নিঃসরণ বন্ধ করা বা দমন করা (to stop / put an end to the flow of blood or other fluids)।',
                'options' => [
                    ['A', 'to reinforce', false],
                    ['B', 'be weak', false],
                    ['C', 'smooth out', false],
                    ['D', 'put an end to', true],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘Belated’?',
                'subject' => 'english',
                'explanation' => '<strong>tardy</strong>: \'Belated\' অর্থ বিলম্বিত বা দেরিতে হওয়া। এর সমার্থক (Synonym) শব্দ হলো \'Tardy\', \'Delayed\' বা \'Late\'।',
                'options' => [
                    ['A', 'complaining', false],
                    ['B', 'off hand', false],
                    ['C', 'weak', false],
                    ['D', 'tardy', true],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘Sequences’?',
                'subject' => 'english',
                'explanation' => '<strong>to follow</strong>: \'Sequence\' শব্দের অর্থ কোনো নির্দিষ্ট ক্রম বা অনুক্রম অনুসরণ করা (to follow in order / succession)।',
                'options' => [
                    ['A', 'to follow', true],
                    ['B', 'round up', false],
                    ['C', 'withdraw', false],
                    ['D', 'question closely', false],
                ],
            ],
            [
                'stem' => 'What is the meaning of the word ‘euphemism’?',
                'subject' => 'english',
                'explanation' => '<strong>inoffensive expression</strong>: \'Euphemism\' হলো অপ্রীতিকর বা রূঢ় কথার পরিবর্তে ব্যবহৃত ভদ্র ও শালীন অভিব্যক্তি (an inoffensive expression substituted for an offensive or unpleasant one)।',
                'options' => [
                    ['A', 'vague idea', false],
                    ['B', 'inoffensive expression', true],
                    ['C', 'verbal play', false],
                    ['D', 'wise saying', false],
                ],
            ],
            [
                'stem' => '‘The Rainbow’ is -',
                'subject' => 'english',
                'explanation' => '<strong>a novel by D.H. Lawrence</strong>: \'The Rainbow\' (১৯১৫) আধুনিক ইংরেজি সাহিত্যের প্রভাবশালী ব্রিটিশ লেখক ডি. এইচ. লরেন্সের (D.H. Lawrence) একটি বিখ্যাত উপন্যাস।',
                'options' => [
                    ['A', 'a poem by Wordsworth', false],
                    ['B', 'a short story by Somerset Maugham', false],
                    ['C', 'a novel by D.H. Lawrence', true],
                    ['D', 'a verse by Coleridge', false],
                ],
            ],
            [
                'stem' => '‘Tom Jones’ by Henry Fielding was first published in',
                'subject' => 'english',
                'explanation' => '<strong>the 1st half of 18th century</strong>: ইংরেজ ঔপন্যাসিক হেনরি ফিল্ডিংয়ের অমর সৃষ্টি \'The History of Tom Jones, a Foundling\' ১৭৪৯ সালে প্রকাশিত হয়, যা ১৮ শতকের প্রথমার্ধের অন্তর্ভুক্ত।',
                'options' => [
                    ['A', 'the 1st half of 19th century', false],
                    ['B', 'the 2nd half of 18th century', false],
                    ['C', 'the 1st half of 18th century', true],
                    ['D', 'the 2nd half of 19th century', false],
                ],
            ],
            [
                'stem' => 'The literary work ‘Kubla Khan’ is –',
                'subject' => 'english',
                'explanation' => '<strong>a verse by Coleridge</strong>: ইংরেজি রোমান্টিক ধারার বিশিষ্ট কবি স্যামুয়েল টেলর কোলরিজের (S.T. Coleridge) রচিত বিখ্যাত রহস্যঘেরা স্বপ্নময় লিরিক্যাল কবিতা হলো ‘Kubla Khan’ (১৭৯৭)।',
                'options' => [
                    ['A', 'a history by Vincent Smith', false],
                    ['B', 'a verse by Coleridge', true],
                    ['C', 'a drama by Oscar Wilde', false],
                    ['D', 'a short story by Somerset Maugham', false],
                ],
            ],
            [
                'stem' => 'T.S Eliot was born in -',
                'subject' => 'english',
                'explanation' => '<strong>USA</strong>: নোবেলজয়ী আধুনিক কবি টি. এস. এলিয়ট ১৮৮৮ সালে মার্কিন যুক্তরাষ্ট্রের সেন্ট লুইস, মিসৌরিতে জন্মগ্রহণ করেন এবং ১৯২৭ সালে ব্রিটিশ নাগরিকত্ব গ্রহণ করেন।',
                'options' => [
                    ['A', 'Ireland', false],
                    ['B', 'England', false],
                    ['C', 'Wales', false],
                    ['D', 'USA', true],
                ],
            ],
            [
                'stem' => 'What is the real name of the great American short story writer, O’Henry?',
                'subject' => 'english',
                'explanation' => '<strong>William Sydney Porter</strong>: অপ্রত্যাশিত চমকপ্রদ সমাপ্তির জন্য বিশ্বখ্যাত আমেরিকান ছোটগল্পকার ও হেনরি (O. Henry)-র প্রকৃত নাম উইলিয়াম সিডনি পোর্টার।',
                'options' => [
                    ['A', 'Samuel Clemen', false],
                    ['B', 'William Sydney Porter', true],
                    ['C', 'Fitz-James O’Brien', false],
                    ['D', 'William Huntington Wright', false],
                ],
            ],
            [
                'stem' => 'Anything ‘Pernicious’ tends to injure or destroy. Something which has no such harmful effect is',
                'subject' => 'english',
                'explanation' => '<strong>innocuous</strong>: \'Pernicious\' অর্থ মারাত্মক ক্ষতিকর বা ধ্বংসাত্মক। এর বিপরীতার্থক হলো নির্দোষ বা ক্ষতিকর নয় এমন অর্থে \'Innocuous\' (harmless)।',
                'options' => [
                    ['A', 'innocuous', true],
                    ['B', 'innocent', false],
                    ['C', 'immaculate', false],
                    ['D', 'salutary', false],
                ],
            ],
            [
                'stem' => 'Do not worry, English grammar is not – to understand. Which of the following best fits in the blank space?',
                'subject' => 'english',
                'explanation' => '<strong>too difficult</strong>: \'Too + adjective + to-infinitive\' নিয়ম অনুযায়ী বাক্যটিতে \'not too difficult to understand\' (বোঝার জন্য অতিরিক্ত কঠিন নয়) বসবে।',
                'options' => [
                    ['A', 'so difficult', false],
                    ['B', 'very difficult', false],
                    ['C', 'too difficult', true],
                    ['D', 'difficult enough', false],
                ],
            ],
            [
                'stem' => 'We (not have) a holiday since the beginning of the year. Which of the following verb forms best completes the above sentence?',
                'subject' => 'english',
                'explanation' => '<strong>have not had</strong>: \'Since + point of time\' অতীতে শুরু হয়ে বর্তমান পর্যন্ত বজায় থাকলে Present Perfect Tense ব্যবহৃত হয়, তাই \'have not had\' সঠিক।',
                'options' => [
                    ['A', 'did not have', false],
                    ['B', 'have not had', true],
                    ['C', 'are not having', false],
                    ['D', 'had not had', false],
                ],
            ],
            [
                'stem' => 'If I were you, I (handle) the situation more carefully. Which of the following verb forms best completes the above sentence?',
                'subject' => 'english',
                'explanation' => '<strong>would handle</strong>: Second Conditional ক্লজ (\'If + past subjunctive were\') থাকলে প্রধান ক্লজে \'subject + would + base verb\' বসে, অর্থাৎ \'would handle\'।',
                'options' => [
                    ['A', 'would handle', true],
                    ['B', 'will handle', false],
                    ['C', 'handle', false],
                    ['D', 'would have handled', false],
                ],
            ],
            [
                'stem' => 'It’s time (you realize) your mistakes. Which of the following clause best fit in the above sentence?',
                'subject' => 'english',
                'explanation' => '<strong>you realized</strong>: \'It is time / It is high time\'-এর পরে সরাসরি Subject থাকলে পরবর্তী Verb-টি Past Indefinite Form (V2) হয়, তাই \'you realized\' সঠিক।',
                'options' => [
                    ['A', 'you realized', true],
                    ['B', 'that you realize', false],
                    ['C', 'you would realize', false],
                    ['D', 'you have realized', false],
                ],
            ],
            [
                'stem' => 'We have recently entered—an agreement with the Inland Co-operation Society. Which of the following best fit in the blank space?',
                'subject' => 'english',
                'explanation' => '<strong>into</strong>: কোনো আনুষ্ঠানিক চুক্তি বা ব্যবসায়িক শর্তাবলীতে সম্মত হওয়া বোঝাতে উপযুক্ত ইডিয়ম হলো \'enter into an agreement\'।',
                'options' => [
                    ['A', 'inpreposition', false],
                    ['B', 'upon', false],
                    ['C', 'in', false],
                    ['D', 'into', true],
                ],
            ],
            [
                'stem' => 'The boy from the village said, “I Starve than beg.” Which of the following does best completes the above sentence?',
                'subject' => 'english',
                'explanation' => '<strong>would rather</strong>: ভিক্ষা করার চেয়ে অনাহারে থাকা অধিক শ্রেয় বোঝাতে পছন্দ বা অগ্রাধিকারবাচক কাঠামো হিসেবে \'would rather ... than\' ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'better', false],
                    ['B', 'rather', false],
                    ['C', 'would rather', true],
                    ['D', 'would better', false],
                ],
            ],
            [
                'stem' => 'It is too difficult to ‘tolerate’ bad temper for long. Which of the following phrases best replaces ‘tolerate’ in the above sentence?',
                'subject' => 'english',
                'explanation' => '<strong>put up with</strong>: \'Tolerate\' বা সহ্য করার যথাযথ Phrasal Verb হলো \'Put up with\'।',
                'options' => [
                    ['A', 'cope up with', false],
                    ['B', 'put up with', true],
                    ['C', 'stand up with', false],
                    ['D', 'pull up with', false],
                ],
            ],
            [
                'stem' => 'I have never seen such a slow coach like you. This small work has taken you three full months. What does the idiom ‘a slow coach’ mean?',
                'subject' => 'english',
                'explanation' => '<strong>a very lazy person</strong>: ইংরেজি ইডিয়ম \'A slow coach\' দ্বারা এমন ব্যক্তিকে বোঝায় যে কাজকর্মে অতিরিক্ত ধীরগতিসম্পন্ন ও চরম অলস (a very lazy and sluggish person)।',
                'options' => [
                    ['A', 'an irresponsible person', false],
                    ['B', 'a careless person', false],
                    ['C', 'an unthoughtful person', false],
                    ['D', 'a very lazy person', true],
                ],
            ],

            // ==========================================
            // ৪১-৬০: বাংলাদেশ বিষয়াবলী (Bangladesh Affairs)
            // ==========================================
            [
                'stem' => 'প্রাচীন পুণ্ড্রবর্ধন নগর কোন স্থানে অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মহাস্থানগড়</strong>: বগুড়া জেলার শিবগঞ্জ উপজেলায় করতোয়া নদীর পশ্চিম তীরে অবস্থিত মহাস্থানগড়ই হলো প্রাচীন বাংলার প্রাচীনতম নগরী পুণ্ড্রবর্ধন নগরের ধ্বংসাবশেষ।',
                'options' => [
                    ['A', 'ময়নামতি', false],
                    ['B', 'বিক্রমপুর', false],
                    ['C', 'মহাস্থানগড়', true],
                    ['D', 'পাহাড়পুর', false],
                ],
            ],
            [
                'stem' => 'ভাষা আন্দোলনের সময় পাকিস্তানের প্রধানমন্ত্রী কে ছিলেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>খাজা নাজিমউদ্দীন</strong>: ১৯৫২ সালের ২১শে ফেব্রুয়ারির রক্তাক্ত ভাষা আন্দোলনের সময় পাকিস্তানের প্রধানমন্ত্রী ছিলেন খাজা নাজিমউদ্দীন (যিনি ঢাকায় ঘোষণা করেছিলেন "উর্দুই হবে পাকিস্তানের একমাত্র রাষ্ট্রভাষা")।',
                'options' => [
                    ['A', 'খাজা নাজিমউদ্দীন', true],
                    ['B', 'নুরুল আমিন', false],
                    ['C', 'লিয়াকত আলী খান', false],
                    ['D', 'মুহাম্মদ আলী জিন্নাহ', false],
                ],
            ],
            [
                'stem' => 'পূর্ববঙ্গ জমিদারি দখল ও প্রজাস্বত্ব আইন কবে প্রণীত হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৫০</strong>: ১৭৯৩ সালের চিরস্থায়ী বন্দোবস্ত ও জমিদারি প্রথা বিলোপের জন্য পূর্ববঙ্গ আইন পরিষদে ১৯৫০ সালে ‘জমিদারি দখল ও প্রজাস্বত্ব আইন’ (East Bengal State Acquisition and Tenancy Act, 1950) প্রণীত হয়।',
                'options' => [
                    ['A', '১৯৫০', true],
                    ['B', '১৯৪৮', false],
                    ['C', '১৯৪৭', false],
                    ['D', '১৯৫৪', false],
                ],
            ],
            [
                'stem' => 'প্রাচীন গৌড় নগরীর অবশিষ্টাংশ বাংলাদেশের কোন জেলায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>চাঁপাইনবাবগঞ্জ</strong>: প্রাচীন ও মধ্যযুগের বাংলার বিখ্যাত রাজধানী গৌড়ের একাংশ বর্তমান বাংলাদেশের চাঁপাইনবাবগঞ্জ জেলার শিবগঞ্জ উপজেলায় (ছোট সোনা মসজিদ এলাকা) অবস্থিত।',
                'options' => [
                    ['A', 'কুষ্টিয়া', false],
                    ['B', 'বগুড়া', false],
                    ['C', 'কুমিল্লা', false],
                    ['D', 'চাঁপাইনবাবগঞ্জ', true],
                ],
            ],
            [
                'stem' => 'আওয়ামী লীগের ছয় দফা কোন সালে পেশ করা হয়েছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৬৬</strong>: ১৯৬৬ সালের ৫–৬ ফেব্রুয়ারি পাকিস্তানের লাহোরে অনুষ্ঠিত বিরোধী দলসমূহের জাতীয় সম্মেলনে বঙ্গবন্ধু শেখ মুজিবুর রহমান বাঙালির ঐতিহাসিক মুক্তির সনদ ‘ছয় দফা’ পেশ করেন।',
                'options' => [
                    ['A', '১৯৬৫', false],
                    ['B', '১৯৬৬', true],
                    ['C', '১৯৬৭', false],
                    ['D', '১৯৫৫', false],
                ],
            ],
            [
                'stem' => 'রাজশাহী বিশ্ববিদ্যালয় স্থাপিত হয় কত সালে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৫৩</strong>: উত্তরবঙ্গের দ্বিতীয় প্রাচীনতম ও ঐতিহ্যবাহী রাজশাহী বিশ্ববিদ্যালয় ১৯৫৩ সালের ৩১ মার্চ রাজশাহী বিশ্ববিদ্যালয় আইনের মাধ্যমে প্রতিষ্ঠিত হয় এবং একই বছর শিক্ষা কার্যক্রম শুরু করে।',
                'options' => [
                    ['A', '১৯৫২', false],
                    ['B', '১৯৫৩', true],
                    ['C', '১৯৫৪', false],
                    ['D', '১৯৫৫', false],
                ],
            ],
            [
                'stem' => 'সুন্দরবনের আয়তন প্রায় কত বর্গ কিলোমিটার?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৫৮০০ বর্গকিমি</strong>: বিশ্বের বৃহত্তম ম্যানগ্রোভ সুন্দরবনের মোট আয়তন প্রায় ১০,০০০ বর্গকিলোমিটার, যার মধ্যে বাংলাদেশের অংশে রয়েছে প্রায় ৬০% বা প্রায় ৫,৮০০ থেকে ৬,০১৭ বর্গকিলোমিটার।',
                'options' => [
                    ['A', '৩৮০০ বর্গকিমি', false],
                    ['B', '৪১০০ বর্গকিমি', false],
                    ['C', '৫৮০০ বর্গকিমি', true],
                    ['D', '৬৯০০ বর্গকিমি', false],
                ],
            ],
            [
                'stem' => 'জাতীয় স্মৃতিসৌধের স্থপতি কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মাইনুল হোসেন</strong>: সাভারে অবস্থিত জাতীয় স্মৃতিসৌধের (সম্মিলিত প্রয়াস) প্রধান স্থপতি হলেন সৈয়দ মাইনুল হোসেন। এর সাত জোড়া ত্রিভুজাকার দেয়াল স্বাধীনতা সংগ্রামের সাতটি প্রধান পর্যায় নির্দেশ করে।',
                'options' => [
                    ['A', 'হামিদুর রহমান', false],
                    ['B', 'তানভীর কবির', false],
                    ['C', 'মাইনুল হোসেন', true],
                    ['D', 'মাযহারুল ইসলাম', false],
                ],
            ],
            [
                'stem' => 'বীরশ্রেষ্ঠ পদকপ্রাপ্তদের সংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সাত</strong>: ১৯৭১ সালের মহান মুক্তিযুদ্ধে অতুলনীয় সাহসিকতা ও সর্বোচ্চ আত্মত্যাগের স্বীকৃতিস্বরূপ বাংলাদেশ সরকার ৭ জন শ্রেষ্ঠ মুক্তিযোদ্ধাকে সর্বোচ্চ সামরিক খেতাব ‘বীরশ্রেষ্ঠ’ প্রদান করে।',
                'options' => [
                    ['A', 'সাত', true],
                    ['B', 'আট', false],
                    ['C', 'ছয়', false],
                    ['D', 'পাঁচ', false],
                ],
            ],
            [
                'stem' => 'বীরশ্রেষ্ঠ হামিদুর রহমানের পদবী কি ছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সিপাহী</strong>: ১৯৭১ সালের ২৮ অক্টোবর মৌলভীবাজারের কমলগঞ্জের ধলই সীমান্তে পাকিস্তানি হানাদারদের বাংকারে গ্রেনেড হামলা চালিয়ে শাহাদাতবরণকারী বীরশ্রেষ্ঠ হামিদুর রহমান ছিলেন ১ ইস্ট বেঙ্গল রেজিমেন্টের গর্বিত সিপাহী।',
                'options' => [
                    ['A', 'সিপাহী', true],
                    ['B', 'ল্যান্স নায়েক', false],
                    ['C', 'লেফটেন্যান্ট', false],
                    ['D', 'ক্যাপ্টেন', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে শহীদ বুদ্ধিজীবী দিবস-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৪ ডিসেম্বর</strong>: ১৯৭১ সালের ১৪ ডিসেম্বর পাকিস্তানি দখলদার বাহিনী তাদের নিশ্চিত পরাজয় আঁচ করে বাংলাদেশকে মেধা ও মননশূন্য করার ঘৃণ্য চক্রান্তে এদেশের শীর্ষ বুদ্ধিজীবী ও গবেষকদের হত্যা করে। তাই এ দিনটি শহীদ বুদ্ধিজীবী দিবস।',
                'options' => [
                    ['A', '১৪ ডিসেম্বর', true],
                    ['B', '১৬ ডিসেম্বর', false],
                    ['C', '২১ ডিসেম্বর', false],
                    ['D', '২৩ ডিসেম্বর', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের পঞ্চম জাতীয় সংসদ নির্বাচন ১৯৯১ সালের কত তারিখে অনুষ্ঠিত হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২৭ ফেব্রুয়ারি</strong>: এরশাদের স্বৈরশাসনের পতনের পর বিচারপতি শাহাবুদ্দিন আহমদের অন্তর্বর্তী সরকারের অধীনে পঞ্চম জাতীয় সংসদ নির্বাচন ১৯৯১ সালের ২৭ ফেব্রুয়ারি অবাধ ও নিরপেক্ষভাবে অনুষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৬ ফেব্রুয়ারি', false],
                    ['B', '২৭ ফেব্রুয়ারি', true],
                    ['C', '২ মার্চ', false],
                    ['D', '৪ মার্চ', false],
                ],
            ],
            [
                'stem' => 'ব্রহ্মপুত্র নদ হিমালয়ের কোন শৃঙ্গ থেকে উৎপন্ন হয়েছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>কৈলাশ</strong>: ব্রহ্মপুত্র নদ তিব্বতের মানস সরোবরের কাছে হিমালয়ের কৈলাশ পর্বতের চেমায়ুং-দুং হিমবাহ থেকে উৎপন্ন হয়ে তিব্বতে ‘সাঙপো’ এবং আসামে ‘দিহং’ নামে প্রবাহিত হয়ে বাংলাদেশে প্রবেশ করেছে।',
                'options' => [
                    ['A', 'বরাইল', false],
                    ['B', 'কৈলাশ', true],
                    ['C', 'কাঞ্চনজঙ্ঘা', false],
                    ['D', 'গডউইন অস্টিন', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের সবচেয়ে উঁচু পাহাড়ের চূড়ার নাম কি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>গারো</strong>: তৎকালীন সাধারণ জ্ঞানের প্রশ্ন হিসেবে গারো/কেওক্রাডং গৃহীত হতো; আধুনিক জিপিএস পরিমাপে দেশের সর্বোচ্চ পর্বতশৃঙ্গ হলো সাকা হাফং (মোদক তং) ও তাজিংডং (বিজয়)।',
                'options' => [
                    ['A', 'লুসাই', false],
                    ['B', 'গারো', true],
                    ['C', 'কেওক্রাডং', false],
                    ['D', 'জয়ন্তিকা', false],
                ],
            ],
            [
                'stem' => 'বাকল্যান্ড বাঁধ কোন নদীর তীরে অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বুড়িগঙ্গা</strong>: ঢাকার সদরঘাট ও তৎসংলগ্ন এলাকাকে বুড়িগঙ্গার ভাঙন ও প্লাবন থেকে রক্ষার জন্য ১৮৬৪ সালে তৎকালীন ঢাকা ডিভিশনাল কমিশনার চার্লস বাকল্যান্ডের উদ্যোগে বুড়িগঙ্গা নদীর উত্তর তীরে বাকল্যান্ড বাঁধ নির্মিত হয়।',
                'options' => [
                    ['A', 'শীতলক্ষ্যা', false],
                    ['B', 'বুড়িগঙ্গা', true],
                    ['C', 'মেঘনা', false],
                    ['D', 'তুরাগ', false],
                ],
            ],
            [
                'stem' => 'চলন বিল কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>পাবনা ও নাটোর জেলায়</strong>: উত্তরবঙ্গের চলনবিল মূলত পাবনা, নাটোর ও সিরাজগঞ্জ জেলার অংশবিশেষ নিয়ে বিস্তৃত বাংলাদেশের সবচেয়ে বড় প্রাকৃতিক জলাভূমি ও বিল।',
                'options' => [
                    ['A', 'নাটোর জেলায়', false],
                    ['B', 'নাটোর ও বগুড়া জেলায়', false],
                    ['C', 'পাবনা ও নাটোর জেলায়', true],
                    ['D', 'সিরাজগঞ্জ ও নাটোর জেলায়', false],
                ],
            ],
            [
                'stem' => 'ফারাক্কা বাঁধ বাংলাদেশের সীমান্ত থেকে কত দূরে অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৬.৫ কিমি</strong>: ভারতের পশ্চিমবঙ্গ রাজ্যের মুর্শিদাবাদ জেলায় গঙ্গার ওপর নির্মিত ফারাক্কা ব্যারেজটি বাংলাদেশের চাঁপাইনবাবগঞ্জ সীমান্ত থেকে মাত্র প্রায় ১৬.৫ কিলোমিটার উজানে অবস্থিত।',
                'options' => [
                    ['A', '২৪.৭ কিমি', false],
                    ['B', '২১.০ কিমি', false],
                    ['C', '১৯.৩ কিমি', false],
                    ['D', '১৬.৫ কিমি', true],
                ],
            ],
            [
                'stem' => '‘দহগ্রাম’ ছিটমহল কোন জেলায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>লালমনিরহাট</strong>: ঐতিহাসিক তিনবিঘা করিডোর দ্বারা মূল ভূখণ্ডের সাথে সার্বক্ষণিক সংযুক্ত দহগ্রাম ও আঙ্গরপোতা ছিটমহলটি লালমনিরহাট জেলার পাটগ্রাম উপজেলায় অবস্থিত।',
                'options' => [
                    ['A', 'নীলফামারী', false],
                    ['B', 'কুড়িগ্রাম', false],
                    ['C', 'লালমনিরহাট', true],
                    ['D', 'দিনাজপুর', false],
                ],
            ],
            [
                'stem' => '‘আমার ভাইয়ের রক্তে রাঙানো একুশে ফেব্রুয়ারি,আমি কি ভুলিতে পারি’- গানটির সুরকার কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>আলতাফ মাহমুদ</strong>: আব্দুল গাফফার চৌধুরী রচিত এ অমর অমর একুশের শোক সঙ্গীতের কালজয়ী ও বহুল প্রচলিত সুরকার হলেন শহীদ আলতাফ মাহমুদ (প্রথম সুরকার ছিলেন আব্দুল লতিফ)।',
                'options' => [
                    ['A', 'আবদুল লতিফ', false],
                    ['B', 'আবদুল আহাদ', false],
                    ['C', 'আলতাফ মাহমুদ', true],
                    ['D', 'মাহমুদুন্নবী', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে ডিগ্রিপ্রাপ্ত চিকিৎসক প্রতি জনসংখ্যা কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>প্রায় ৪৭৯৭ জন</strong>: ১৯৯১-৯২ সালের সরকারি পরিসংখ্যান অনুযায়ী তৎকালীন বাংলাদেশে ডিগ্রিপ্রাপ্ত রেজিস্টার্ড চিকিৎসক প্রতি জনসংখ্যা ছিল প্রায় ৪৭৯৭ জন।',
                'options' => [
                    ['A', 'প্রায় ৪৭৯৭ জন', true],
                    ['B', 'প্রায় ৪৫৭২ জন', false],
                    ['C', 'প্রায় ৯৭৯১ জন', false],
                    ['D', 'প্রায় ৮২১২ জন', false],
                ],
            ],

            // ==========================================
            // ৬১-৮০: আন্তর্জাতিক বিষয়াবলী (International Affairs)
            // ==========================================
            [
                'stem' => '১৯৯১ সালের Business International এর সমীক্ষায় জীবনযাত্রার ব্যয়ভার (Living cost) সবচেয়ে বেশি-',
                'subject' => 'international',
                'explanation' => '<strong>টোকিওতে</strong>: ১৯৯০-এর দশকের শুরুতে জাপানের প্রবল অর্থনৈতিক সমৃদ্ধির কারণে রাজধানী টোকিও বিশ্বের সবচেয়ে ব্যয়বহুল শহর হিসেবে বিজনেস ইন্টারন্যাশনালের সূচকে চিহ্নিত হয়েছিল।',
                'options' => [
                    ['A', 'টোকিওতে', true],
                    ['B', 'নিউইয়র্ক', false],
                    ['C', 'তেহরানে', false],
                    ['D', 'আবিদজানে', false],
                ],
            ],
            [
                'stem' => 'উৎপাদিত পণ্য বিক্রয় হিসাব অনুযায়ী ১৯৯০ সালে সর্ববৃহৎ বিক্রেতা-',
                'subject' => 'international',
                'explanation' => '<strong>আইবিএম</strong>: ফরচুন ৫০০ গ্লোবাল কোম্পানির বার্ষিক বাণিজ্যিক পণ্য বিক্রয় হিসাবে আন্তর্জাতিক কম্পিউটার জায়ান্ট ইন্টারন্যাশনাল বিজনেস মেশিনস (IBM) ১৯৯০ সালে শীর্ষে ছিল।',
                'options' => [
                    ['A', 'আইবিএম', true],
                    ['B', 'জেনারেল মটরস', false],
                    ['C', 'রয়াল ডাচ/শেল', false],
                    ['D', 'ইক্সন', false],
                ],
            ],
            [
                'stem' => 'আঞ্চলিক ভিত্তিতে জীবন প্রত্যাশা (Life expectancy) সবচেয়ে বেশি-',
                'subject' => 'international',
                'explanation' => '<strong>অস্ট্রেলিয়া ও নিউজিল্যান্ডে</strong>: উচ্চমানের চিকিৎসা, প্রাকৃতিক পরিবেশ ও উন্নত জীবনযাত্রার মানের কারণে ওশেনিয়া অঞ্চলের উন্নত দুটি দেশ অস্ট্রেলিয়া ও নিউজিল্যান্ডে আঞ্চলিক ভিত্তিতে গড় আয়ু বা জীবন প্রত্যাশা সর্বোচ্চ ছিল।',
                'options' => [
                    ['A', 'ইউরোপে', false],
                    ['B', 'উত্তর আমেরিকায়', false],
                    ['C', 'মধ্য এশিয়ায়', false],
                    ['D', 'অস্ট্রেলিয়া ও নিউজিল্যান্ডে', true],
                ],
            ],
            [
                'stem' => '১৯৮৮ সালের সমীক্ষায় জনপ্রতি বিদ্যুৎ খরচ সবচেয়ে বেশি কোন দেশে?',
                'subject' => 'international',
                'explanation' => '<strong>পাকিস্তানে</strong>: তৎকালীন দক্ষিণ এশিয়ার দেশগুলোর মধ্যে মাথাপিছু বিদ্যুৎ ব্যবহারে পাকিস্তান ভারত, শ্রীলঙ্কা ও বাংলাদেশের চেয়ে এগিয়ে শীর্ষে ছিল।',
                'options' => [
                    ['A', 'ভারতে', false],
                    ['B', 'পাকিস্তানে', true],
                    ['C', 'শ্রীলঙ্কায়', false],
                    ['D', 'বাংলাদেশে', false],
                ],
            ],
            [
                'stem' => '১৯৯০ সালের সমীক্ষায় এশিয়ার কোন দেশ থেকে আগত যুক্তরাষ্ট্রে বসবাসকারীদের সংখ্যা সবচেয়ে বেশি?',
                'subject' => 'international',
                'explanation' => '<strong>ভারত</strong>: মার্কিন জনশুমারি ব্যুরোর ১৯৯০ সালের তথ্য অনুযায়ী এশিয়ার দেশগুলো থেকে আগত দক্ষ পেশাজীবী ও অভিবাসীদের মধ্যে ভারত শীর্ষস্থানে অবস্থান করেছিল।',
                'options' => [
                    ['A', 'ফিলিপাইন', false],
                    ['B', 'জাপান', false],
                    ['C', 'চীন', false],
                    ['D', 'ভারত', true],
                ],
            ],
            [
                'stem' => '১৯৮৯ সালের সমীক্ষা অনুসারে সবচেয়ে বেশি চাল রপ্তানি কারক দেশ-',
                'subject' => 'international',
                'explanation' => '<strong>থাইল্যান্ড</strong>: ১৯৮০ ও ৯০-এর দশকে আন্তর্জাতিক চাল রপ্তানি বাজারে থাইল্যান্ড ছিল বিশ্বের সর্ববৃহৎ চাল রপ্তানিকারক দেশ।',
                'options' => [
                    ['A', 'চীন', false],
                    ['B', 'যুক্তরাষ্ট্র', false],
                    ['C', 'পাকিস্তান', false],
                    ['D', 'থাইল্যান্ড', true],
                ],
            ],
            [
                'stem' => '‘এশিয়া ওয়াচ’ কর্তৃক উদ্ঘাটিত কোন অপরাধের জন্য চীনের বিরুদ্ধে যুক্তরাষ্ট্র Special 301 প্রয়োগ করার বিবেচনা করে?',
                'subject' => 'international',
                'explanation' => '<strong>জুন ১৯৮৯ সালে তিয়ানমেন স্কয়ারে সংঘটিত ট্রাজেডি</strong>: ১৯৮৯ সালের জুনে বেইজিংয়ের তিয়ানমেন স্কয়ারে গণতন্ত্রকামী বিক্ষোভকারীদের ওপর সেনাবাহিনীর বর্বর অভিযানের পর যুক্তরাষ্ট্র চীনের ওপর বাণিজ্য ও মানবাধিকার নীতিমালায় কঠোর নিষেধাজ্ঞা আরোপ করে।',
                'options' => [
                    ['A', 'জুন ১৯৮৯ সালে তিয়ানমেন স্কয়ারে সংঘটিত ট্রাজেডি', true],
                    ['B', 'জেলখানার কয়েদীদের শ্রমে উৎপাদিত দ্রব্য', false],
                    ['C', 'পাকিস্তানের কাছে মিসাইল বিক্রি', false],
                    ['D', 'আলজেরিয়ার কাছে পারমাণবিক যুদ্ধাস্ত্রের প্রযুক্তি বিক্রয়', false],
                ],
            ],
            [
                'stem' => 'এশিয়ার অর্থনৈতিক উন্নয়নের লক্ষ্যে নতুন জোটগুলোর মধ্যে কোনটিকে অ্যাসকাপ (ESCAP) সবচেয়ে বেশি উপযোগী বিবেচনা করে?',
                'subject' => 'international',
                'explanation' => '<strong>APEC</strong>: ১৯৮৯ সালে ক্যানবেরায় প্রতিষ্ঠিত এশিয়া-প্যাসিফিক ইকোনমিক কো-অপারেশন (APEC)-কে জাতিসংঘ অ্যাসকাপ এশীয় অঞ্চলের সামগ্রিক অর্থনৈতিক সমৃদ্ধির সবচেয়ে সম্ভাবনাময় জোট হিসেবে স্বীকৃতি দেয়।',
                'options' => [
                    ['A', 'APEC', true],
                    ['B', 'CREC', false],
                    ['C', 'EAEG', false],
                    ['D', 'ECO', false],
                ],
            ],
            [
                'stem' => '‘জেনারেল এগ্রিমেন্ট অন ট্যারিফ অ্যান্ড ট্রেড’ (GATT) একমাত্র বহুমুখী সহায়ক সংস্থা হিসেবে বর্তমানে বিশ্ব বাণিজ্যের কত অংশের সমন্বয় সাধন করে থাকে?',
                'subject' => 'international',
                'explanation' => '<strong>প্রায় ৯০ শতাংশ</strong>: দ্বিতীয় বিশ্বযুদ্ধোত্তর শুল্ক ও বাণিজ্য সমন্বয়কারী আন্তর্জাতিক চুক্তি ‘গ্যাট’ (GATT) বিশ্ব বাণিজ্যের প্রায় ৯০ ভাগ নিয়ন্ত্রণ ও সমন্বয় করত, যা পরবর্তীতে ১৯৯৫ সালে WTO-তে রূপ নেয়।',
                'options' => [
                    ['A', 'প্রায় ৭৫ শতাংশ', false],
                    ['B', 'প্রায় ৮০ শতাংশ', false],
                    ['C', 'প্রায় ৮৫ শতাংশ', false],
                    ['D', 'প্রায় ৯০ শতাংশ', true],
                ],
            ],
            [
                'stem' => 'মিয়ানমারের ১৯৯০ সালের মে মাসে অনুষ্ঠিত সাধারণ নির্বাচনে বিপুলভাবে বিজয়ী হয়েও কোন পার্টি সামরিক জান্তার কাছ থেকে ক্ষমতা লাভ করতে পারেনি?',
                'subject' => 'international',
                'explanation' => '<strong>এনএলডি</strong>: অং সান সু চির নেতৃত্বাধীন ন্যাশনাল লিগ ফর ডেমোক্রেসি (NLD) ১৯৯০ সালের মে মাসের নির্বাচনে নিরঙ্কুশ সংখ্যাগরিষ্ঠতা অর্জন করলেও বর্মি সামরিক জান্তা (SLORC) ফল প্রত্যাখ্যান করে সু চিসহ নেতাদের অন্তরীণ করে।',
                'options' => [
                    ['A', 'এনডিএফ', false],
                    ['B', 'এলএনডি', false],
                    ['C', 'এনএলডি', true],
                    ['D', 'বিএসপিপি', false],
                ],
            ],
            [
                'stem' => '১৯৯০ সালের কোন তারিখে পূর্ব ও পশ্চিম জার্মানি পুনরায় একটি রাষ্ট্র গঠন করে?',
                'subject' => 'international',
                'explanation' => '<strong>৩ অক্টোবর মাঝরাতে</strong>: ঐতিহাসিক বার্লিন প্রাচীর পতনের পর ১৯৯০ সালের ৩ অক্টোবর মধ্যরাতে পূর্ব ও পশ্চিম জার্মানি আনুষ্ঠানিকভাবে একত্রিত হয়। দিনটি ‘জার্মান ঐক্য দিবস’ (German Unity Day) হিসেবে পালিত হয়।',
                'options' => [
                    ['A', '২ অক্টোবর সকালে', false],
                    ['B', '২ অক্টোবর মাঝরাতে', false],
                    ['C', '১ অক্টোবর দুপুরে', false],
                    ['D', '৩ অক্টোবর মাঝরাতে', true],
                ],
            ],
            [
                'stem' => '‘ইউনিডো’ (UNIDO) এর প্রধান কার্যালয় কোথায় অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>ভিয়েনা</strong>: জাতিসংঘের শিল্প উন্নয়ন সংস্থা United Nations Industrial Development Organization (UNIDO)-এর সদর দপ্তর অস্ট্রিয়ার রাজধানী ভিয়েনায় অবস্থিত।',
                'options' => [
                    ['A', 'টোকিও', false],
                    ['B', 'প্যারিস', false],
                    ['C', 'নিউইয়র্ক', false],
                    ['D', 'ভিয়েনা', true],
                ],
            ],
            [
                'stem' => '‘পিএলও’ এর ন্যাশনাল কাউন্সিল কর্তৃক আন্তর্জাতিক শান্তি সম্মেলন অনুষ্ঠানের প্রস্তাব সম্পর্কে ১৯৮৮ সনে জাতিসংঘ কোথায় রেজুলেশন গ্রহণ করে?',
                'subject' => 'international',
                'explanation' => '<strong>নিউইয়র্ক</strong>: ১৯৮৮ সালের ডিসেম্বরে ফিলিস্তিনিদের আত্মনিয়ন্ত্রণ অধিকার এবং আন্তর্জাতিক মধ্যপ্রাচ্য শান্তি সম্মেলন আয়োজনের পক্ষে জাতিসংঘ সাধারণ পরিষদ নিউইয়র্কে যুগান্তকারী রেজুলেশন পাস করে।',
                'options' => [
                    ['A', 'নিউইয়র্ক', true],
                    ['B', 'প্যারিস', false],
                    ['C', 'জেনেভা', false],
                    ['D', 'ভিয়েনা', false],
                ],
            ],
            [
                'stem' => '‘International Institute on Ageing’ কোথায় প্রতিষ্ঠিত হয়েছে?',
                'subject' => 'international',
                'explanation' => '<strong>ভ্যালেটা</strong>: জাতিসংঘ কর্তৃক বয়স্ক ও প্রবীণ জনগোষ্ঠীর কল্যাণ ও গবেষণার লক্ষ্যে প্রতিষ্ঠিত আন্তর্জাতিক সংস্থা ‘International Institute on Ageing’ (INIA) মাল্টার রাজধানী ভ্যালেটাতে অবস্থিত।',
                'options' => [
                    ['A', 'জেনেভা', false],
                    ['B', 'রোম', false],
                    ['C', 'প্যারিস', false],
                    ['D', 'ভ্যালেটা', true],
                ],
            ],
            [
                'stem' => 'কখন থেকে এশীয় উন্নয়ন ব্যাংকের লেনদেন শুরু হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৬৬ সাল থেকে</strong>: ফিলিপাইনের ম্যানিলায় সদর দপ্তর অবস্থিত এশীয় উন্নয়ন ব্যাংক (ADB) ১৯৬৬ সালের ১৯ ডিসেম্বর প্রতিষ্ঠিত হয় এবং একই মাস থেকে আনুষ্ঠানিকভাবে লেনদেন ও ঋণ সহায়তা প্রদান শুরু করে।',
                'options' => [
                    ['A', '১৯৬৬ সাল থেকে', true],
                    ['B', '১৯৬৭ সাল থেকে', false],
                    ['C', '১৯৬৮ সাল থেকে', false],
                    ['D', '১৯৮৯ সাল থেকে', false],
                ],
            ],
            [
                'stem' => 'কোন দেশ প্রথম ওপেক (OPEC) সংঘ প্রতিষ্ঠার উদ্যোগ গ্রহণ করেছিল?',
                'subject' => 'international',
                'explanation' => '<strong>ভেনিজুয়েলা</strong>: ১৯৬০ সালে বাগদাদ সম্মেলনে আন্তর্জাতিক তেল উত্তোলন ও রপ্তানিকারক দেশসমূহের জোট ওপেক (OPEC) প্রতিষ্ঠার প্রধান রূপকার ও উদ্যোক্তা দেশ ছিল লাতিন আমেরিকার তেলসমৃদ্ধ রাষ্ট্র ভেনিজুয়েলা।',
                'options' => [
                    ['A', 'কুয়েত', false],
                    ['B', 'নাইজেরিয়া', false],
                    ['C', 'সৌদি আরব', false],
                    ['D', 'ভেনিজুয়েলা', true],
                ],
            ],
            [
                'stem' => 'প্রকৃতি ও প্রাকৃতিক সম্পদ সংরক্ষণ সংস্থার প্রথম অধিবেশন কোথায় অনুষ্ঠিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>রাশিয়ার আশখাবাদে</strong>: আন্তর্জাতিক প্রকৃতি সংরক্ষণ সংস্থা আইইউসিএন (IUCN)-এর ঐতিহাসিক বৈশ্বিক সাধারণ অধিবেশন অনুষ্ঠিত হয়েছিল আশখাবাদে (বর্তমান তুর্কমেনিস্তান, সাবেক সোভিয়েত ইউনিয়ন)।',
                'options' => [
                    ['A', 'জাপানের নাগাসাকিতে', false],
                    ['B', 'অস্ট্রেলিয়ার ক্যানবেরায়', false],
                    ['C', 'রাশিয়ার আশখাবাদে', true],
                    ['D', 'কানাডার ভেনকুবারে', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘের কারিগরি সহায়তা কার্যক্রম সংশ্লিষ্ট বিভিন্ন তহবিল ও সংস্থার মধ্যে সমন্বয়ের দায়িত্ব পালনকারী বিভাগের নাম কি?',
                'subject' => 'international',
                'explanation' => '<strong>UNDP</strong>: জাতিসংঘের বিশ্বব্যাপী টেকসই আর্থ-সামাজিক উন্নয়ন ও কারিগরি সহায়তার মূল সমন্বয়ক ও বাস্তবায়নকারী সংস্থা হলো United Nations Development Programme (UNDP)।',
                'options' => [
                    ['A', 'UNDP', true],
                    ['B', 'DTCD', false],
                    ['C', 'UNFPA', false],
                    ['D', 'UNEP', false],
                ],
            ],
            [
                'stem' => '১৯৯১ সালের উইম্বলডন টেনিস প্রতিযোগিতায় কে শিরোপা লাভ করেন?',
                'subject' => 'international',
                'explanation' => '<strong>মাইকেল স্টিচ</strong>: ১৯৯১ সালের অল ইংল্যান্ড লন টেনিস উইম্বলডন চ্যাম্পিয়নশিপের পুরুষ একক ফাইনালে বরিস বেকারকে হারিয়ে জার্মানির মাইকেল স্টিচ গ্র্যান্ড স্ল্যাম ট্রফি জয় করেন।',
                'options' => [
                    ['A', 'মাইকেল চ্যাং', false],
                    ['B', 'জিন ফিলিপস', false],
                    ['C', 'মাইকেল স্টিচ', true],
                    ['D', 'পিট সাম্প্রাস', false],
                ],
            ],
            [
                'stem' => 'কোন দেশটি ‘আসিয়ান’ (ASEAN) জোটভুক্ত নয়?',
                'subject' => 'international',
                'explanation' => '<strong>দক্ষিণ কোরিয়া</strong>: দক্ষিণ-পূর্ব এশীয় ১০টি দেশের আঞ্চলিক অর্থনৈতিক জোট হলো আসিয়ান (ASEAN)। দক্ষিণ কোরিয়া পূর্ব এশিয়ার দেশ হওয়ায় এটি আসিয়ানের সদস্য নয়।',
                'options' => [
                    ['A', 'সিঙ্গাপুর', false],
                    ['B', 'মালয়েশিয়া', false],
                    ['C', 'থাইল্যান্ড', false],
                    ['D', 'দক্ষিণ কোরিয়া', true],
                ],
            ],

            // ==========================================
            // ৮১-৯০: গাণিতিক যুক্তি ও মানসিক দক্ষতা (Math)
            // ==========================================
            [
                'stem' => 'একটি ১০,০০০ টাকার বিলের উপর এককালীন ৪০% কমতি এবং পরপর ৩৬% ও ৪% কমতির পার্থক্য কত টাকা?',
                'subject' => 'math',
                'explanation' => '<strong>১৪৪</strong>: এককালীন কমতি = ৪০%। পরপর ৩৬% ও ৪% কমতির নিট কমতি = $৩৬ + ৪ - (৩৬ \times ৪ / ১০০) = ৪০ - ১.৪৪ = ৩৮.৫৬\%$। কমতির পার্থক্য = $৪০\% - ৩৮.৫৬\% = ১.৪৪\%$। ১০,০০০ টাকার ১.৪৪% = ১৪৪ টাকা।',
                'options' => [
                    ['A', 'শূন্য', false],
                    ['B', '১৪৪', true],
                    ['C', '২৫৬', false],
                    ['D', '৪০০', false],
                ],
            ],
            [
                'stem' => 'কোন পরীক্ষায় একজন ছাত্র n সংখ্যক প্রশ্নের প্রথম ২০টি প্রশ্ন হতে ১৫টি প্রশ্নের শুদ্ধ উত্তর দেয় এবং বাকি প্রশ্নগুলোর এক তৃতীয়াংশের শুদ্ধ উত্তর দিতে পারে। এভাবে সে যদি ৫০% প্রশ্নের শুদ্ধ উত্তর দিয়ে থাকে তবে ঐ পরীক্ষায় প্রশ্নের সংখ্যা কত ছিল?',
                'subject' => 'math',
                'explanation' => '<strong>৫০টি</strong>: সমীকরণ: $১৫ + (n - ২০)/৩ = n/২ \implies n/২ - n/৩ = ১৫ - ২০/৩ \implies n/৬ = ২৫/৩ \implies n = ৫০$।',
                'options' => [
                    ['A', '২০টি', false],
                    ['B', '৩০টি', false],
                    ['C', '৪০টি', false],
                    ['D', '৫০টি', true],
                ],
            ],
            [
                'stem' => 'একটি লোক খাড়া উত্তর দিকে m মাইল অতিক্রম করে প্রতি মাইল ২ মিনিটে এবং খাড়া দক্ষিণ দিকে পূর্ব স্থানে ফিরে আসে প্রতি মিনিটে ২ মাইল হিসেবে। লোকটির গড় গতিবেগ ঘণ্টায় কত মাইল?',
                'subject' => 'math',
                'explanation' => '<strong>৪৮</strong>: যাওয়ার গতি = প্রতি মাইল ২ মিনিট = ঘণ্টায় ৩০ মাইল। ফেরার গতি = প্রতি মিনিটে ২ মাইল = ঘণ্টায় ১২০ মাইল। গড় গতিবেগ = $২ \times ৩০ \times ১২০ / (৩০ + ১২০) = ৭২০০ / ১৫০ = ৪৮$ মাইল/ঘণ্টা।',
                'options' => [
                    ['A', '৪৫', false],
                    ['B', '৪৮', true],
                    ['C', '৭৫', false],
                    ['D', '২৪', false],
                ],
            ],
            [
                'stem' => 'যদি x³ + hx + 10 = 0 এর একটি সমাধান 2 হয়, তবে h এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>-9</strong>: $x = 2$ বসালে: $২^৩ + h(২) + ১০ = ০ \implies ৮ + ২h + ১০ = ০ \implies ২h = -১৮ \implies h = -৯$।',
                'options' => [
                    ['A', '10', false],
                    ['B', '9', false],
                    ['C', '-9', true],
                    ['D', '-2', false],
                ],
            ],
            [
                'stem' => 'বালক ও বালিকার একটি দলে নিম্নরূপ খেলা হচ্ছে। প্রথম বালক ৫ জন বালিকার সঙ্গে খেলছে, দ্বিতীয় বালক ৬ জন বালিকার সঙ্গে খেলছে, এভাবে শেষ বালক সব কটি বালিকার সঙ্গে খেলছে। যদি b বালকের সংখ্যা এবং g বালিকার সংখ্যা প্রকাশ করে, তবে b = কত?',
                'subject' => 'math',
                'explanation' => '<strong>b = g - 4</strong>: ১ম বালকের সাথী ৫ জন ($১ + ৪$), ২য় বালকের সাথী ৬ জন ($২ + ৪$)। অতএব $b$-তম বালকের সাথী বালিকা সংখ্যা $g = b + ৪ \implies b = g - ৪$।',
                'options' => [
                    ['A', 'b = g', false],
                    ['B', 'b = g/5', false],
                    ['C', 'b = g - 4', true],
                    ['D', 'b = g - 5', false],
                ],
            ],
            [
                'stem' => '[২ - ৩(২ - ৩)⁻¹]⁻¹ এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>১/৫</strong>: বন্ধনীর ভেতর: $(২ - ৩) = -১ \implies (-১)^{-১} = -১$। তাহলে $২ - ৩(-১) = ২ + ৩ = ৫$। অতএব $[৫]^{-১} = ১/৫$।',
                'options' => [
                    ['A', '৫', false],
                    ['B', '-৫', false],
                    ['C', '১/৫', true],
                    ['D', '-১/৫', false],
                ],
            ],
            [
                'stem' => 'একটি গোল মুদ্রা টেবিলে রাখা হলো। এই মুদ্রার চারপাশে একই মুদ্রা কতটি রাখা যেতে পারে যেন তারা মাঝের মুদ্রাটিকে এবং তাদের দু’পাশে রাখা দুটি মুদ্রাকে স্পর্শ করে?',
                'subject' => 'math',
                'explanation' => '<strong>৬</strong>: একই ব্যাসার্ধবিশিষ্ট একটি কেন্দ্রীয় মুদ্রাকে ঘিরে স্পর্শ করে সমান মাপের ঠিক ৬টি মুদ্রা সমদূরত্বে স্থাপন করা সম্ভব, কারণ কেন্দ্রে প্রতিটি মুদ্রা ৬০° কোণ তৈরি করে ($৩৬০^\circ / ৬০^\circ = ৬$)।',
                'options' => [
                    ['A', '৪', false],
                    ['B', '৬', true],
                    ['C', '৮', false],
                    ['D', '১০', false],
                ],
            ],
            [
                'stem' => 'y= 3x +2, y= -3x + 2 , y = -2 দ্বারা গঠিত জ্যামিতিক চিত্রটি কোনটি হবে?',
                'subject' => 'math',
                'explanation' => '<strong>একটি সমদ্বিবাহু ত্রিভুজ</strong>: রেখা দুটির ঢাল $+৩$ এবং $-৩$ এবং উভয় রেখাই y-অক্ষে $(০, ২)$ বিন্দুতে মিলিত হয়। y-অক্ষের সাপেক্ষে প্রতিসম হওয়ায় $y = -২$ ভূমির সাথে অপর দুটি বাহু সমান হয়, ফলে এটি একটি সমদ্বিবাহু ত্রিভুজ।',
                'options' => [
                    ['A', 'একটি সমকোণী ত্রিভুজ', false],
                    ['B', 'একটি সমবাহু ত্রিভুজ', false],
                    ['C', 'একটি সমদ্বিবাহু ত্রিভুজ', true],
                    ['D', 'একটি বিষমবাহু ত্রিভুজ', false],
                ],
            ],
            [
                'stem' => 'একটি সমবাহু ষড়ভুজের অভ্যন্তরে অঙ্কিত বৃহত্তম বৃত্তের ক্ষেত্রফল 100π হলে ঐ ষড়ভুজের ক্ষেত্রফল কত?',
                'subject' => 'math',
                'explanation' => '<strong>200√3</strong>: বৃত্তের ক্ষেত্রফল $\pi r^2 = ১০০\pi \implies r = ১০$। ষড়ভুজের অন্তর্বৃত্তের ব্যাসার্ধ $r = (\sqrt{৩}/২) a \implies a = ২০/\sqrt{৩}$। ষড়ভুজের ক্ষেত্রফল = $৬ \times (\sqrt{৩}/৪) a^2 = (৩\sqrt{৩}/২) \times (৪০০/৩) = ২০০\sqrt{৩}$।',
                'options' => [
                    ['A', '200', false],
                    ['B', '200√2', false],
                    ['C', '200√3', true],
                    ['D', '200', false],
                ],
            ],
            [
                'stem' => '৩২ এর ২ ভিত্তিক লগারিদম কত?',
                'subject' => 'math',
                'explanation' => '<strong>৫</strong>: $\log_2 (৩২) = \log_2 (২^৫) = ৫ \log_2 (২) = ৫ \times ১ = ৫$।',
                'options' => [
                    ['A', '৩', false],
                    ['B', '৪', false],
                    ['C', '৫', true],
                    ['D', '৬', false],
                ],
            ],

            // ==========================================
            // ৯১-১০০: সাধারণ বিজ্ঞান ও প্রযুক্তি (Science)
            // ==========================================
            [
                'stem' => 'কোনটি চৌম্বক পদার্থ?',
                'subject' => 'science',
                'explanation' => '<strong>কোবাল্ট</strong>: লোহা, নিকেল ও কোবাল্ট হলো তীব্র আকর্ষণ ক্ষমতাসম্পন্ন ফেরোচৌম্বক (Ferromagnetic) পদার্থ। পারদ, বিসমাথ ও এন্টিমনি ডায়াচৌম্বক পদার্থ।',
                'options' => [
                    ['A', 'পারদ', false],
                    ['B', 'বিসমাথ', false],
                    ['C', 'এন্টিমনি', false],
                    ['D', 'কোবাল্ট', true],
                ],
            ],
            [
                'stem' => 'একজন সাধারণ মানুষের দেহে মোট কত টুকরা হাড় থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>২০৬</strong>: একজন পরিণত প্রাপ্তবয়স্ক মানবদেহের কঙ্কালতন্ত্রে মোট ২০৬টি অস্থি বা হাড় থাকে। (নবজাতক অবস্থায় প্রায় ৩০০টি হাড় থাকে, যা পরবর্তীতে পরস্পরের সাথে সংযুক্ত হয়)।',
                'options' => [
                    ['A', '২০৬', true],
                    ['B', '৩০৬', false],
                    ['C', '৪০৬', false],
                    ['D', '৫০৬', false],
                ],
            ],
            [
                'stem' => 'কোন মৌলিক অধাতু সাধারণ তাপমাত্রায় তরল থাকে?',
                'subject' => 'science',
                'explanation' => '<strong>ব্রোমিন</strong>: ব্রোমিন ($Br$) হলো পর্যায় সারণির একমাত্র অধাতব মৌলিক পদার্থ যা সাধারণ কক্ষ তাপমাত্রায় তরল অবস্থায় থাকে। পারদ তরল ধাতু।',
                'options' => [
                    ['A', 'ব্রোমিন', true],
                    ['B', 'পারদ', false],
                    ['C', 'আয়োডিন', false],
                    ['D', 'জেনন', false],
                ],
            ],
            [
                'stem' => 'উচ্চ পর্বতের চূড়ায় উঠলে নাক দিয়ে রক্তপাতের সম্ভাবনা থাকে; কারণ উচ্চ চূড়ায়-',
                'subject' => 'science',
                'explanation' => '<strong>বায়ুর চাপ কম</strong>: সমুদ্রপৃষ্ঠ থেকে অনেক উঁচুতে বায়ুমণ্ডলের ঘনত্ব ও চাপ কমে যায়। কিন্তু মানবদেহের রক্তনালীর অভ্যন্তরীণ চাপ অপরিবর্তিত থাকায় ভেতরের অতিরিক্ত চাপের প্রভাবে নাকের সংবেদনশীল রক্তনালী ফেটে রক্তপাত হতে পারে।',
                'options' => [
                    ['A', 'অক্সিজেন কম', false],
                    ['B', 'ঠাণ্ডা বেশি', false],
                    ['C', 'বায়ুর চাপ বেশি', false],
                    ['D', 'বায়ুর চাপ কম', true],
                ],
            ],
            [
                'stem' => 'কোন স্থানে মধ্যাকর্ষণজনিত ত্বরণ ৯ গুণ করলে সেখানে একটি সরল দোলকের দোলনকাল কতগুণ বাড়বে বা কমবে?',
                'subject' => 'science',
                'explanation' => '<strong>৩ গুণ কমবে</strong>: সরল দোলকের দোলনকাল $T = ২\pi \sqrt{L/g}$। অভিকর্ষজ ত্বরণ $g$-এর মান ৯ গুণ করা হলে দোলনকাল $T \propto ১/\sqrt{g} = ১/\sqrt{৯} = ১/৩$ গুণ হবে, অর্থাৎ ৩ গুণ হ্রাস পাবে।',
                'options' => [
                    ['A', '৯ গুণ বাড়বে', false],
                    ['B', '৯ গুণ কমবে', false],
                    ['C', '৩ গুণ বাড়বে', false],
                    ['D', '৩ গুণ কমবে', true],
                ],
            ],
            [
                'stem' => 'কোন মাধ্যমে শব্দের গতি সবচেয়ে বেশি?',
                'subject' => 'science',
                'explanation' => '<strong>লোহা</strong>: মাধ্যমের অণুগুলোর ঘনত্ব ও স্থিতিস্থাপকতা বেশি হওয়ায় কঠিন মাধ্যমে শব্দের গতিবেগ সর্বাধিক। লোহায় শব্দের বেগ প্রায় ৫,১৩০ মিটার/সেকেন্ড, পানিতে ১,৪৯০ মি/সে এবং বায়ুতে প্রায় ৩৩২-৩৪০ মি/সেকেন্ড।',
                'options' => [
                    ['A', 'শূন্য', false],
                    ['B', 'লোহা', true],
                    ['C', 'পানি', false],
                    ['D', 'বাতাস', false],
                ],
            ],
            [
                'stem' => 'সমটান সম্পন্ন একটি টানা তারের দৈর্ঘ্য দ্বিগুণ করলে কম্পাঙ্কের কতটা পরিবর্তন ঘটবে?',
                'subject' => 'science',
                'explanation' => '<strong>অর্ধেক হবে</strong>: তারের আড় কম্পনের সূত্রানুযায়ী কম্পাঙ্ক তারের কার্যকরী দৈর্ঘ্যের ব্যস্তানুপাতিক ($f \propto ১/L$)। টান অপরিবর্তিত রেখে দৈর্ঘ্য দ্বিগুণ করলে কম্পাঙ্ক পূর্বের অর্ধেক হবে।',
                'options' => [
                    ['A', 'অর্ধেক হবে', true],
                    ['B', 'দ্বিগুণ হবে', false],
                    ['C', 'তিনগুণ হবে', false],
                    ['D', 'চারগুণ হবে', false],
                ],
            ],
            [
                'stem' => 'সিনেমাস্কোপ প্রজেক্টরে কোন ধরনের লেন্স ব্যবহৃত হয়?',
                'subject' => 'science',
                'explanation' => '<strong>অবতল</strong>: সিনেমার ওয়াইডস্ক্রিন সিনেমাস্কোপ প্রজেকশনে চিত্রকে অনুভূমিকভাবে প্রসারিত ও সম্প্রসারিত করার জন্য বিশেষ অ্যানামরফিক অবতল লেন্স সিস্টেম ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'উত্তল', false],
                    ['B', 'অবতল', true],
                    ['C', 'জুম', false],
                    ['D', 'সিলিন্ড্রিক্যাল', false],
                ],
            ],
            [
                'stem' => 'পারমাণবিক বোমার আবিষ্কারক কে?',
                'subject' => 'science',
                'explanation' => '<strong>ওপেনহেইমার</strong>: মার্কিন তাত্ত্বিক পদার্থবিদ জে. রবার্ট ওপেনহেইমার (J. Robert Oppenheimer) দ্বিতীয় বিশ্বযুদ্ধকালীন ম্যানহাটন প্রজেক্টের নেতৃত্ব দিয়ে প্রথম পারমাণবিক বোমা উদ্ভাবন করেন, যার কারণে তাঁকে পারমাণবিক বোমার জনক বলা হয়।',
                'options' => [
                    ['A', 'আইনস্টাইন', false],
                    ['B', 'ওপেনহেইমার', true],
                    ['C', 'অটোম্যান', false],
                    ['D', 'রোজেমবার্গ', false],
                ],
            ],
            [
                'stem' => 'মঙ্গল গ্রহে প্রেরিত নভোযান কোনটি?',
                'subject' => 'science',
                'explanation' => '<strong>ভাইকিং</strong>: নাসা কর্তৃক মঙ্গল গ্রহের ভূত্বকে সফলভাবে অবতরণ ও জৈবিক অন্বেষণ চালানোর জন্য ১৯৭৫ সালে প্রেরিত ঐতিহাসিক মনুষ্যবিহীন মহাকাশযান হলো ‘ভাইকিং ১’ ও ‘ভাইকিং ২’।',
                'options' => [
                    ['A', 'সয়ুজ', false],
                    ['B', 'অ্যাপোলো', false],
                    ['C', 'ভয়েজার', false],
                    ['D', 'ভাইকিং', true],
                ],
            ],
        ];

        // 2. Insert all 100 questions, options, tags and link to the 13th BCS exam
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
                'reference_source' => '১৩তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '13th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1992',
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
