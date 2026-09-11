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

class Bcs12thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '12th')->first() ?? ExamYear::firstOrCreate(['year' => '12th'], [
            'name_en' => '12th BCS Exam',
            'name_bn' => '১২তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 12th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '12th-bcs-preliminary'],
            [
                'title_bn' => '১২তম বিসিএস (পুলিশ) প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '12th BCS (Police) Preliminary Question Solution',
                'description_bn' => '১২তম বিসিএস (পুলিশ) প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 12th BCS (Police) Preliminary Examination.',
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
            // ১-২১: বাংলা ভাষা ও সাহিত্য (Bangla)
            // ==========================================
            [
                'stem' => 'ক্রিয়া শব্দের মূল অংশকে বলা হয়-',
                'subject' => 'bangla',
                'explanation' => '<strong>ধাতু</strong>: ক্রিয়াপদকে বিশ্লেষণ করলে যে অবিভাজ্য মূল অংশটি পাওয়া যায় তাকে ধাতু বা ক্রিয়ামূল বলে। যেমন: ‘পড়ছে’ ক্রিয়ার ধাতু হলো ‘পড়্’।',
                'options' => [
                    ['A', 'বিভক্তি', false],
                    ['B', 'ধাতু', true],
                    ['C', 'প্রত্যয়', false],
                    ['D', 'কৃৎ', false],
                ],
            ],
            [
                'stem' => '“স্বাধীনতা হীনতায় কে বাঁচিতে চায়”- চরণটি কার?',
                'subject' => 'bangla',
                'explanation' => '<strong>রঙ্গলাল বন্দ্যোপাধ্যায়</strong>: কবি রঙ্গলাল বন্দ্যোপাধ্যায়ের বিখ্যাত ঐতিহাসিক আখ্যানকাব্য ‘পদ্মিনী উপাখ্যান’ (১৮৫৮)-এর অন্তর্গত দেশপ্রেমমূলক অমর পঙ্‌ক্তি হলো: “স্বাধীনতা হীনতায় কে বাঁচিতে চায় হে, কে বাঁচিতে চায়? দাসত্ব শৃঙ্খল বল কে পরিবে পায় হে, কে পরিবে পায়?”।',
                'options' => [
                    ['A', 'ঈশ্বরচন্দ্র গুপ্ত', false],
                    ['B', 'মধুসূদন দত্ত', false],
                    ['C', 'হেমচন্দ্র বন্দ্যোপাধ্যায়', false],
                    ['D', 'রঙ্গলাল বন্দ্যোপাধ্যায়', true],
                ],
            ],
            [
                'stem' => 'শুদ্ধ বাক্যটি চিহ্নিত করুন-',
                'subject' => 'bangla',
                'explanation' => '<strong>বিদ্বান ব্যক্তিগণ দারিদ্র্যের শিকার হন</strong>: ‘বিদ্বান’ বানান ব-ফলা যুক্ত। আর দারিদ্র্য বিশেষ্য পদ, এর সাথে পুনরায় তা-প্রত্যয় যুক্ত হয়ে ‘দারিদ্র্যতা’ অশুদ্ধ। সঠিক রূপ ‘দারিদ্র্য’ বা ‘দরিদ্রতা’।',
                'options' => [
                    ['A', 'বিদ্যান ব্যক্তিগণ দরিদ্রের শিকার হন', false],
                    ['B', 'বিদ্যান ব্যক্তিগণ দারিদ্রতার শিকার হন', false],
                    ['C', 'বিদ্বান ব্যক্তিগণ দারিদ্র্যের শিকার হন', true],
                    ['D', 'বিদ্যান ব্যক্তিগণ দরিদ্রতার শিকার হন', false],
                ],
            ],
            [
                'stem' => 'কোন শব্দে বিদেশি উপসর্গ ব্যবহৃত হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>নিমরাজি</strong>: ‘নিম’ একটি ফারসি উপসর্গ, যার অর্থ অর্ধেক বা আংশিক। নিমরাজি শব্দের অর্থ অনিচ্ছাসত্ত্বেও আধা-সম্মত হওয়া। নিখুঁত-এ ‘নি’ খাঁটি বাংলা উপসর্গ, আনমনা-এ ‘আ’ বাংলা উপসর্গ এবং অবহেলা-এ ‘অব’ তৎসম উপসর্গ।',
                'options' => [
                    ['A', 'নিখুঁত', false],
                    ['B', 'আনমনা', false],
                    ['C', 'অবহেলা', false],
                    ['D', 'নিমরাজি', true],
                ],
            ],
            [
                'stem' => 'বাংলা ভাষা এই শব্দ দুটি গ্রহণ করেছে চীনা ভাষা হতে-',
                'subject' => 'bangla',
                'explanation' => '<strong>চা, চিনি</strong>: বাংলা ভাষায় ব্যবহৃত ‘চা’, ‘চিনি’, ‘লিচু’, ‘ইলাচি’ শব্দগুলো চীনা ভাষা থেকে এসেছে। চাকু ও চাকর তুর্কি শব্দ; খদ্দর ও হরতাল গুজরাটি শব্দ; রিকশা জাপানি ও রেস্তোরাঁ ফরাসি শব্দ।',
                'options' => [
                    ['A', 'চাকু, চাকর', false],
                    ['B', 'খদ্দর, হরতাল', false],
                    ['C', 'চা, চিনি', true],
                    ['D', 'রিক্সা, রেস্তোরাঁ', false],
                ],
            ],
            [
                'stem' => 'বাংলা সাহিত্যের ইতিহাসে প্রাচীনতম মুসলমান কবি-',
                'subject' => 'bangla',
                'explanation' => '<strong>শাহ মুহম্মদ সগীর</strong>: সুলতান গিয়াসউদ্দিন আজম শাহের রাজত্বকালে (১৩৮৯–১৪১০ খ্রিষ্টাব্দে) কাব্যচর্চাকারী কবি শাহ মুহম্মদ সগীর বাংলা সাহিত্যের আদি ও প্রাচীনতম মুসলিম কবি হিসেবে স্বীকৃত।',
                'options' => [
                    ['A', 'শাহ মুহম্মদ সগীর', true],
                    ['B', 'সাবিরিদ খান', false],
                    ['C', 'শেখ ফয়জুল্লাহ', false],
                    ['D', 'মুহম্মদ কবির', false],
                ],
            ],
            [
                'stem' => 'মুসলমান কবি রচিত প্রাচীনতম বাংলা কাব্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>ইউসুফ জোলেখা</strong>: মধ্যযুগের আদি মুসলিম কবি শাহ মুহম্মদ সগীর রচিত রোমান্টিক প্রণয়োপাখ্যান ‘ইউসুফ-জোলেখা’ মুসলমান কবিদের মধ্যে রচিত সবচেয়ে প্রাচীন বাংলা কাব্য।',
                'options' => [
                    ['A', 'ইউসুফ জোলেখা', true],
                    ['B', 'রসুল বিজয়', false],
                    ['C', 'নূরনামা', false],
                    ['D', 'শবে মেরাজ', false],
                ],
            ],
            [
                'stem' => '“এখানে যারা প্রাণ দিয়েছে রমনার ঊর্ধ্বমুখী কৃষ্ণচূড়ার নিচে সেখানে আমি কাঁদতে আসিনি।” এর রচয়িতা-',
                'subject' => 'bangla',
                'explanation' => '<strong>মাহবুব উল আলম চৌধুরী</strong>: ১৯৫২ সালের ২১শে ফেব্রুয়ারি ভাষা আন্দোলনের প্রথম শহীদদের স্মরণে রচিত প্রথম কবিতা হলো চট্টগ্রামের ভাষা সৈনিক মাহবুব উল আলম চৌধুরীর “কাঁদতে আসিনি ফাঁসির দাবি নিয়ে এসেছি”।',
                'options' => [
                    ['A', 'জহির রায়হান', false],
                    ['B', 'গাফফার চৌধুরী', false],
                    ['C', 'শামসুর রাহমান', false],
                    ['D', 'মাহবুব উল আলম চৌধুরী', true],
                ],
            ],
            [
                'stem' => 'মধুসূদন দত্ত রচিত ‘বীরাঙ্গনা’-',
                'subject' => 'bangla',
                'explanation' => '<strong>পত্রকাব্য</strong>: মহাকবি মাইকেল মধুসূদন দত্ত ১৮৬২ সালে রোমান কবি ওভিডের অনুসরণে অমিত্রাক্ষর ছন্দে পৌরাণিক নারীদের জবানিতে প্রথম বাংলা পত্রকাব্য ‘বীরাঙ্গনা কাব্য’ রচনা করেন। এতে ১১টি পত্র রয়েছে।',
                'options' => [
                    ['A', 'মহাকাব্য', false],
                    ['B', 'পত্রকাব্য', true],
                    ['C', 'গীতিকাব্য', false],
                    ['D', 'আখ্যানকাব্য', false],
                ],
            ],
            [
                'stem' => '‘রোহিণী’ কোন উপন্যাসের নায়িকা?',
                'subject' => 'bangla',
                'explanation' => '<strong>কৃষ্ণকান্তের উইল</strong>: সাহিত্যসম্রাট বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের অন্যতম শ্রেষ্ঠ মনস্তাত্ত্বিক সামাজিক উপন্যাস ‘কৃষ্ণকান্তের উইল’ (১৮৭৮)-এর প্রধান ও ট্র্যাজিক নারী চরিত্র হলো রোহিণী।',
                'options' => [
                    ['A', 'কৃষ্ণকান্তের উইল', true],
                    ['B', 'চোখের বালি', false],
                    ['C', 'গৃহদাহ', false],
                    ['D', 'পথের পাঁচালী', false],
                ],
            ],
            [
                'stem' => 'নিম্নরেখ কোন শব্দে করণ কারকে শূন্য বিভক্তি ব্যবহৃত হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ঘোড়াকে ‘চাবুক’ মার</strong>: ক্রিয়া নিষ্পত্তির উপায় বা উপকরণকে করণ কারক বলে। এখানে প্রহার করার মাধ্যম হলো ‘চাবুক’ এবং এর সাথে কোনো বিভক্তি যুক্ত নেই (প্রথমা বা শূন্য বিভক্তি)।',
                'options' => [
                    ['A', 'ঘোড়াকে ‘চাবুক’ মার', true],
                    ['B', '‘ডাক্তার’ ডাক', false],
                    ['C', 'গাড়ি ‘স্টেশন’ ছেড়েছে', false],
                    ['D', '‘মুষলধারে’ বৃষ্টি পড়ছে', false],
                ],
            ],
            [
                'stem' => 'রূপসী বাংলার কবি-',
                'subject' => 'bangla',
                'explanation' => '<strong>জীবনানন্দ দাশ</strong>: বাংলার অপরূপ নিসর্গ, রূপ-রস-গন্ধ ও মেঠো রূপের অনন্য রূপকার কবি জীবনানন্দ দাশ ‘রূপসী বাংলার কবি’ বা ‘তিমির হননের কবি’ হিসেবে খ্যাত।',
                'options' => [
                    ['A', 'জসীমউদ্দীন', false],
                    ['B', 'জীবনানন্দ দাশ', true],
                    ['C', 'কালিদাস রায়', false],
                    ['D', 'সত্যেন্দ্রনাথ দত্ত', false],
                ],
            ],
            [
                'stem' => 'এক কথায় প্রকাশ করুন: ‘যা বলা হয়নি’-',
                'subject' => 'bangla',
                'explanation' => '<strong>অনুক্ত</strong>: যা বলা হয়নি = অনুক্ত। যা বলা হয়েছে = উক্ত। যা ব্যক্ত করা যায় না = অব্যক্ত। যা প্রকাশ করা হয়েছে = ব্যক্ত।',
                'options' => [
                    ['A', 'উক্ত', false],
                    ['B', 'অব্যক্ত', false],
                    ['C', 'অনুক্ত', true],
                    ['D', 'ব্যক্ত', false],
                ],
            ],
            [
                'stem' => 'কবিগান রচয়িতা এবং গায়ক হিসেবে এরা উভয়েই পরিচিত-',
                'subject' => 'bangla',
                'explanation' => '<strong>রাম বসু এবং ভোলা ময়রা</strong>: অষ্টাদশ শতাব্দীর শেষভাগ ও ঊনবিংশ শতাব্দীর শুরুতে রাম বসু এবং ভোলা ময়রা দুজনেই বিখ্যাত কবিয়াল, কবিগান রচয়িতা ও গায়ক হিসেবে সমধিক পরিচিত ছিলেন।',
                'options' => [
                    ['A', 'রাম বসু এবং ভোলা ময়রা', true],
                    ['B', 'এন্টনি ফিরিঙ্গি এবং রামপ্রসাদ রায়', false],
                    ['C', 'সাবিরিদ খান এবং দাশরথী রায়', false],
                    ['D', 'আলাওল এবং ভারতচন্দ্র', false],
                ],
            ],
            [
                'stem' => 'বাংলা সাহিত্যের সর্বাধিক সমৃদ্ধ ধারা-',
                'subject' => 'bangla',
                'explanation' => '<strong>গীতিকবিতা</strong>: চর্যাপদের কাল থেকে শুরু করে বৈষ্ণব পদাবলী এবং আধুনিক যুগের কবিতা পর্যন্ত বাংলা সাহিত্যের সর্বাপেক্ষা পুষ্ট, সমৃদ্ধ ও বৈচিত্র্যপূর্ণ ধারা হলো গীতিকবিতা।',
                'options' => [
                    ['A', 'নাটক', false],
                    ['B', 'ছোটগল্প', false],
                    ['C', 'প্রবন্ধ', false],
                    ['D', 'গীতিকবিতা', true],
                ],
            ],
            [
                'stem' => 'কোন শব্দে ধাতুর সঙ্গে প্রত্যয় যুক্ত হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>পাঠক</strong>: ধাতুর সঙ্গে কৃৎপ্রত্যয় যুক্ত হয়ে গঠিত হয়েছে: √পঠ্ (ধাতু) + অক (কৃৎপ্রত্যয়) = পাঠক। বাকিগুলো বিশেষ্য/বিশেষণ শব্দের সাথে তদ্ধিত প্রত্যয় যুক্ত।',
                'options' => [
                    ['A', 'ঠগী', false],
                    ['B', 'পানসা', false],
                    ['C', 'পাঠক', true],
                    ['D', 'সেলামী', false],
                ],
            ],
            [
                'stem' => 'কোন বানানটি শুদ্ধ?',
                'subject' => 'bangla',
                'explanation' => '<strong>পাষাণ</strong>: ণত্ব বিধান অনুসারে মূর্ধন্য-ষ এর পর মূর্ধন্য-ণ হয়। তাই শুদ্ধ বানান ‘পাষাণ’ (অর্থ: পাথর বা নির্দয়)।',
                'options' => [
                    ['A', 'পাষাণ', true],
                    ['B', 'পাষান', false],
                    ['C', 'পাসান', false],
                    ['D', 'পাশান', false],
                ],
            ],
            [
                'stem' => 'বটতলার পুঁথি বলতে বুঝায়-',
                'subject' => 'bangla',
                'explanation' => '<strong>দোভাষী বাংলায় রচিত পুঁথি সাহিত্য</strong>: আঠারো ও উনিশ শতকে কলকাতার বটতলা অঞ্চল থেকে আরবি, ফারসি ও দেশি শব্দের মিশ্রণে মুদ্রিত ‘দোভাষী বাংলা’র পুঁথি সাহিত্যকে বটতলার পুঁথি বলা হতো।',
                'options' => [
                    ['A', 'মধ্যযুগীয় কাব্যের হস্তলিখিত পাণ্ডুলিপি', false],
                    ['B', 'বটতলা নামক স্থানে রচিত কাব্য', false],
                    ['C', 'দোভাষী বাংলায় রচিত পুঁথি সাহিত্য', true],
                    ['D', 'অবিমিশ্র দেশজ বাংলায় রচিত লোকসাহিত্য', false],
                ],
            ],
            [
                'stem' => 'বাগধারা যুগলদের মধ্যে কোন জোড়া সর্বাধিক সমার্থবাচক?',
                'subject' => 'bangla',
                'explanation' => '<strong>বক ধার্মিক; বিড়াল তপস্বী</strong>: ‘বক ধার্মিক’ এবং ‘বিড়াল তপস্বী’ উভয় বাগধারারই অর্থ হলো ভণ্ড সাধু বা কপট ধার্মিক।',
                'options' => [
                    ['A', 'অমাবস্যার চাঁদ; আকাশ কুসুম', false],
                    ['B', 'বক ধার্মিক; বিড়াল তপস্বী', true],
                    ['C', 'রুই-কাতলা; কেউ কেটা', false],
                    ['D', 'বক ধার্মিক; ভিজে বেড়াল', false],
                ],
            ],
            [
                'stem' => 'ড. মুহম্মদ শহীদুল্লাহ ছিলেন প্রধানত-',
                'subject' => 'bangla',
                'explanation' => '<strong>ভাষাতত্ত্ববিদ</strong>: ড. মুহম্মদ শহীদুল্লাহ ছিলেন উপমহাদেশের শীর্ষস্থানীয় বহুভাষাবিদ ও ভাষাতত্ত্ববিদ। তাঁর বিখ্যাত গবেষণাগ্রন্থ ‘বাংলা ভাষার ইতিবৃত্ত’ ও ‘ভাষা ও সাহিত্য’।',
                'options' => [
                    ['A', 'ভাষাতত্ত্ববিদ', true],
                    ['B', 'সাহিত্যের ইতিহাস রচয়িতা', false],
                    ['C', 'ইসলাম প্রচারক', false],
                    ['D', 'সমাজ সংস্কারক', false],
                ],
            ],
            [
                'stem' => '‘মোদের গরব, মোদের আশা/আ মরি বাংলা ভাষা’ রচয়িতা-',
                'subject' => 'bangla',
                'explanation' => '<strong>অতুল প্রসাদ সেন</strong>: বাংলা ভাষার মহিমা ও গৌরব নিয়ে রচিত এ কালজয়ী গানের রচয়িতা ও সুরকার হলেন গীতিকার অতুলপ্রসাদ সেন।',
                'options' => [
                    ['A', 'রামনিধি গুপ্ত', false],
                    ['B', 'রবীন্দ্রনাথ ঠাকুর', false],
                    ['C', 'অতুল প্রসাদ সেন', true],
                    ['D', 'সত্যেন্দ্রনাথ দত্ত', false],
                ],
            ],

            // ==========================================
            // ২২-৩৭: ইংরেজি ভাষা ও সাহিত্য (English)
            // ==========================================
            [
                'stem' => 'What is the verb of the word ‘Shortly’?',
                'subject' => 'english',
                'explanation' => '<strong>Shorten</strong>: \'Shortly\' হলো Adverb, \'Short\' হলো Adjective, \'Shortness\' হলো Noun এবং \'Shorten\' (সংক্ষিপ্ত করা) হলো Verb।',
                'options' => [
                    ['A', 'Short', false],
                    ['B', 'Shorter', false],
                    ['C', 'Shorten', true],
                    ['D', 'Shortness', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence-',
                'subject' => 'english',
                'explanation' => '<strong>Let you and him be witnesses</strong>: \'Let\'-এর পরে Pronoun-এর Objective form (you, him) বসে। সাধারণ ক্রম অনুযায়ী 2nd person এরপর 3rd person (231 rule) বসে, এবং একাধিকার কারণে \'witnesses\' বহুবচন হবে।',
                'options' => [
                    ['A', 'Let he and you be witnesses', false],
                    ['B', 'Let you and him be witnesses', true],
                    ['C', 'Let you and he be witnesses', false],
                    ['D', 'Let you and he be witness', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence-',
                'subject' => 'english',
                'explanation' => '<strong>The police were informed of the matter</strong>: \'Police\' একটি Collective Noun যা সর্বদা Plural হিসেবে ব্যবহৃত হয়, তাই এর সাথে Plural Verb \'were\' বসবে। কাউকে কোনো বিষয়ে অবহিত করার সঠিক কাঠামো \'inform someone of something\'।',
                'options' => [
                    ['A', 'The matter was informed to the police', false],
                    ['B', 'The matter has been informed of the people', false],
                    ['C', 'The police was informed of the matter', false],
                    ['D', 'The police were informed of the matter', true],
                ],
            ],
            [
                'stem' => 'Who, Which, What are-',
                'subject' => 'english',
                'explanation' => '<strong>Relative pronoun</strong>: \'Who\', \'Which\', \'What\', \'That\' ইত্যাদি দুটি ক্লজকে যুক্ত করার সময় Antecedent-কে নির্দেশ করতে Relative Pronoun হিসেবে ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'Demonstrative Pronoun', false],
                    ['B', 'Relative pronoun', true],
                    ['C', 'Reflexive pronoun', false],
                    ['D', 'Indefinite pronoun', false],
                ],
            ],
            [
                'stem' => 'Choose the correct one-',
                'subject' => 'english',
                'explanation' => '<strong>Misspell</strong>: ভুল বানান করা বোঝাতে সঠিক বানান হলো \'Misspell\' (M-i-s-s-p-e-l-l), যাতে ডাবল \'s\' বিদ্যমান।',
                'options' => [
                    ['A', 'Mispel', false],
                    ['B', 'Misspell', true],
                    ['C', 'Mispell', false],
                    ['D', 'Misspel', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank ‘What is the time... your watch?’',
                'subject' => 'english',
                'explanation' => '<strong>by</strong>: ঘড়ির সময় জানার জন্য বা সময় নির্দেশ করতে এপ্রোপ্রিয়েট প্রেপজিশন হিসেবে সর্বদা \'by your watch\' ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'by', true],
                    ['B', 'in', false],
                    ['C', 'at', false],
                    ['D', 'with', false],
                ],
            ],
            [
                'stem' => 'Fill in the blanks ‘Give my ... to him.’',
                'subject' => 'english',
                'explanation' => '<strong>Compliments</strong>: অন্যের প্রতি আন্তরিক শুভেচ্ছা বা সম্মান জ্ঞাপন করতে বহুবচনে \'Compliments\' বা \'Regards\' ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'Warm compliment', false],
                    ['B', 'Compliments', true],
                    ['C', 'Best compliment', false],
                    ['D', 'Heartiest compliment', false],
                ],
            ],
            [
                'stem' => '‘Caesar and Cleopatra’ is-',
                'subject' => 'english',
                'explanation' => '<strong>a play by G.B. Shaw</strong>: \'Caesar and Cleopatra\' (১৮৯৮) হলো বিখ্যাত নোবেলজয়ী নাট্যকার জর্জ বার্নার্ড শ (George Bernard Shaw) রচিত একটি নাটক।',
                'options' => [
                    ['A', 'a tragedy by Shakespeare', false],
                    ['B', 'a play by G.B. Shaw', true],
                    ['C', 'a poem by Lord Byron', false],
                    ['D', 'a novel by S.T. Coleridge', false],
                ],
            ],
            [
                'stem' => 'Who is the greatest modern English dramatist?',
                'subject' => 'english',
                'explanation' => '<strong>George Bernard Shaw</strong>: আধুনিক ইংরেজি নাট্যসাহিত্যের শ্রেষ্ঠ রূপকার হলেন জর্জ বার্নার্ড শ (G.B. Shaw), যিনি ১৯২৫ সালে সাহিত্যে নোবেল পুরস্কার অর্জন করেন।',
                'options' => [
                    ['A', 'Virginia Woolf', false],
                    ['B', 'George Bernard Shaw', true],
                    ['C', 'P.B. Shelley', false],
                    ['D', 'S.T. Coleridge', false],
                ],
            ],
            [
                'stem' => 'Who is the author of ‘A Farewell to Arms’?',
                'subject' => 'english',
                'explanation' => '<strong>Ernest Hemingway</strong>: প্রথম বিশ্বযুদ্ধের অভিজ্ঞতার আলোকে রচিত বিখ্যাত যুদ্ধবিরোধী উপন্যাস \'A Farewell to Arms\' (১৯২৯) মার্কিন নোবেলজয়ী সাহিত্যিক আর্নেস্ট হেমিংওয়ের সৃষ্টি।',
                'options' => [
                    ['A', 'T. S Eliot', false],
                    ['B', 'John Milton', false],
                    ['C', 'Plato', false],
                    ['D', 'Ernest Hemingway', true],
                ],
            ],
            [
                'stem' => 'Who is the most famous satirist in English literature?',
                'subject' => 'english',
                'explanation' => '<strong>Jonathan Swift</strong>: ইংরেজি সাহিত্যের সর্বকালের সর্বশ্রেষ্ঠ ব্যঙ্গ লেখক বা স্যাটায়ারিস্ট হলেন জোনাথন সুইফট (Jonathan Swift), যাঁর অমর ব্যঙ্গাত্মক সৃষ্টি \'Gulliver\'s Travels\' ও \'A Modest Proposal\'।',
                'options' => [
                    ['A', 'Alexander Pope', false],
                    ['B', 'Jonathan Swift', true],
                    ['C', 'William Wordsworth', false],
                    ['D', 'Bulter', false],
                ],
            ],
            [
                'stem' => 'What is the synonym of ‘Delude’?',
                'subject' => 'english',
                'explanation' => '<strong>Deceive</strong>: \'Delude\' অর্থ প্রতারণা করা, ঠকানো বা বিভ্রান্ত করা। এর সমার্থক (Synonym) শব্দ হলো \'Deceive\', \'Mislead\' বা \'Cheat\'।',
                'options' => [
                    ['A', 'Demand', false],
                    ['B', 'Permit', false],
                    ['C', 'Aggravate', false],
                    ['D', 'Deceive', true],
                ],
            ],
            [
                'stem' => 'What is the noun of the word ‘Waste’?',
                'subject' => 'english',
                'explanation' => '<strong>Wastage</strong>: \'Waste\' ক্রিয়ার অপচয় বা বিনষ্ট অংশ নির্দেশক নির্দিষ্ট প্রত্যয়যুক্ত Noun রূপ হলো \'Wastage\'।',
                'options' => [
                    ['A', 'Waste', false],
                    ['B', 'Wasting', false],
                    ['C', 'Wastage', true],
                    ['D', 'Wasteful', false],
                ],
            ],
            [
                'stem' => 'What is the antonym of ‘Queer’?',
                'subject' => 'english',
                'explanation' => '<strong>Orderly</strong>: \'Queer\' অর্থ অস্বাভাবিক, অদ্ভুত, খাপছাড়া বা বিশৃঙ্খল। এর বিপরীতার্থক (Antonym) শব্দ হলো স্বাভাবিক বা সুশৃঙ্খল অর্থে \'Orderly\' বা \'Normal\'।',
                'options' => [
                    ['A', 'Integrated', false],
                    ['B', 'Orderly', true],
                    ['C', 'Abnormal', false],
                    ['D', 'Odd', false],
                ],
            ],
            [
                'stem' => 'What is the adjective of the word ‘Heart’?',
                'subject' => 'english',
                'explanation' => '<strong>Heartening</strong>: \'Heart\' (Noun), \'Hearten\' (Verb - সাহস জোগানো), এবং উৎসাহব্যঞ্জক বা আশাব্যঞ্জক অর্থে এর Adjective হলো \'Heartening\'।',
                'options' => [
                    ['A', 'Heart', false],
                    ['B', 'Hearten', false],
                    ['C', 'Heartening', true],
                    ['D', 'Heartful', false],
                ],
            ],
            [
                'stem' => 'Who is the modern philosopher who was awarded Nobel Prize for literature?',
                'subject' => 'english',
                'explanation' => '<strong>Bertrand Russel</strong>: প্রখ্যাত ব্রিটিশ আধুনিক দার্শনিক, গণিতবিদ ও সমাজচিন্তক বার্ট্রান্ড রাসেল (Bertrand Russell) ১৯৫০ সালে সাহিত্যে নোবেল পুরস্কার লাভ করেন।',
                'options' => [
                    ['A', 'James Baker', false],
                    ['B', 'Dr. Kissinger', false],
                    ['C', 'Bertrand Russel', true],
                    ['D', 'Lenin', false],
                ],
            ],

            // ==========================================
            // ৩৮-৫২: বাংলাদেশ বিষয়াবলী (Bangladesh Affairs)
            // ==========================================
            [
                'stem' => 'ঢাকা থেকে সরাসরি নোয়াখালী যাওয়ার আন্তঃমহানগরী ট্রেনটির নাম-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>উপকূল এক্সপ্রেস</strong>: ঢাকা ও নোয়াখালীর মধ্যে সরাসরি যাতায়াতকারী বাংলাদেশ রেলওয়ের আন্তঃনগর ট্রেনটির নাম ‘উপকূল এক্সপ্রেস’। পারাবত চলে ঢাকা-সিলেট এবং এগারো সিন্ধুর চলে ঢাকা-কিশোরগঞ্জ।',
                'options' => [
                    ['A', 'এগার সিন্ধুর এক্সপ্রেস', false],
                    ['B', 'পারাবত এক্সপ্রেস', false],
                    ['C', 'উপকূল এক্সপ্রেস', true],
                    ['D', 'সৈকত এক্সপ্রেস', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের বৃহত্তম হাওড়-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>হাকালুকি</strong>: মৌলভীবাজার ও সিলেট জেলায় অবস্থিত হাকালুকি হাওড় বাংলাদেশের সবচেয়ে বড় হাওড় (আয়তন প্রায় ১৮১ বর্গকিলোমিটার)। চলনবিল হলো বাংলাদেশের বৃহত্তম বিল।',
                'options' => [
                    ['A', 'পাথরচাওলি', false],
                    ['B', 'হাইল', false],
                    ['C', 'চলনবিল', false],
                    ['D', 'হাকালুকি', true],
                ],
            ],
            [
                'stem' => '‘কিওক্রাডং’ এর উচ্চতা প্রায়-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১২৩০ মিটার</strong>: বান্দরবান জেলায় অবস্থিত ঐতিহ্যবাহী পর্বতশৃঙ্গ কেওক্রাডং-এর উচ্চতা ঐতিহ্যগত পরিমাপে ধরা হয় প্রায় ১,২৩০ মিটার (বা ৪,০৩৫ ফুট)।',
                'options' => [
                    ['A', '১০১০ মিটার', false],
                    ['B', '১৩৫০ মিটার', false],
                    ['C', '১২৩০ মিটার', true],
                    ['D', '১৩৬৪ মিটার', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে বার্ষিক চা উৎপাদনের পরিমাণ হচ্ছে প্রায়-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৯.৩৮ কোটি কেজি</strong>: প্রশ্নকালীন তথ্যানুযায়ী বাংলাদেশে বার্ষিক চা উৎপাদন ছিল প্রায় ৯.৩৮ কোটি কেজি (বর্তমানে এটি বেড়ে প্রায় ১০ কোটি কেজিতে উন্নীত হয়েছে)।',
                'options' => [
                    ['A', '১৪ কোটি কেজি', false],
                    ['B', '১৩ কোটি কেজি', false],
                    ['C', '১০.৫ কোটি কেজি', false],
                    ['D', '৯.৩৮ কোটি কেজি', true],
                ],
            ],
            [
                'stem' => 'ঢাকা মেট্রোপলিটন এলাকার আয়তন কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৫৩০ বর্গমাইল</strong>: রাজউক ও বৃহত্তর মেট্রোপলিটন উন্নয়ন কর্তৃপক্ষের পরিকল্পনাধীন এলাকার আয়তন ছিল প্রায় ১৫৩০ বর্গমাইল (বা প্রায় ১,৫২৮ বর্গকিলোমিটার)।',
                'options' => [
                    ['A', '১৫৩০ বর্গমাইল', true],
                    ['B', '৯০ বর্গমাইল', false],
                    ['C', '১৬০ বর্গমাইল', false],
                    ['D', '৮০ বর্গমাইল', false],
                ],
            ],
            [
                'stem' => 'গঙ্গা নদীর পানি প্রবাহ বৃদ্ধির জন্য বাংলাদেশের প্রস্তাব-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নেপালে জলাধার নির্মাণ</strong>: শুষ্ক মৌসুমে গঙ্গার পানিপ্রবাহ বৃদ্ধির জন্য বাংলাদেশ নেপালের হিমালয় অঞ্চলে জলাধার নির্মাণের প্রস্তাব দিয়েছিল। অপরদিকে ভারত ব্রহ্মপুত্র-গঙ্গা সংযোগ খাল খননের প্রস্তাব দেয়।',
                'options' => [
                    ['A', 'নেপালে জলাধার নির্মাণ', true],
                    ['B', 'গঙ্গা-ব্রহ্মপুত্রের মধ্যে সংযোগ খাল খনন', false],
                    ['C', 'বাংলাদেশের অভ্যন্তরে গঙ্গা বাঁধ নির্মাণ', false],
                    ['D', 'গঙ্গা শাখা নদী সমূহের পানি প্রবাহ বৃদ্ধি', false],
                ],
            ],
            [
                'stem' => 'বিখ্যাত সাধক শাহ সুলতান বলখির মাজার অবস্থিত-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মহাস্থানগড়ে</strong>: একাদশ শতাব্দীর বিখ্যাত সুফি সাধক হজরত শাহ সুলতান বলখী মাহিসওয়ার (র.)-এর মাজার বগুড়া জেলার প্রাচীন ঐতিহাসিক স্থান মহাস্থানগড়ে অবস্থিত।',
                'options' => [
                    ['A', 'মহাস্থানগড়ে', true],
                    ['B', 'শাহাজাদপুরে', false],
                    ['C', 'নেত্রকোনায়', false],
                    ['D', 'রামপালে', false],
                ],
            ],
            [
                'stem' => 'ভারত-বাংলাদেশ যৌথ নদী কমিশনের অন্যতম প্রধান লক্ষ্য-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>দু’দেশের নদীগুলোর নাব্যতা বৃদ্ধি</strong>: ১৯৭২ সালে প্রতিষ্ঠিত যৌথ নদী কমিশনের (JRC) অন্যতম প্রধান উদ্দেশ্য যৌথ ৫৪টি নদীর বন্যা নিয়ন্ত্রণ, পানির ন্যায্য বণ্টন ও নাব্যতা সংরক্ষণ।',
                'options' => [
                    ['A', 'দু’দেশের নদীগুলোর নাব্যতা বৃদ্ধি', true],
                    ['B', 'দু’দেশের নদীগুলোর পলিমাটি অপসারণ', false],
                    ['C', 'বন্যা নিয়ন্ত্রণে দু’দেশের মধ্যে সহযোগিতা', false],
                    ['D', 'দু’দেশের নৌ-পরিবহন ব্যবস্থার উন্নয়ন', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের পতাকা প্রথম উত্তোলন করা হয় কবে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২ মার্চ, ১৯৭১</strong>: ১৯৭১ সালের ২ মার্চ ঢাকা বিশ্ববিদ্যালয়ের ঐতিহাসিক বটতলায় ছাত্র-জনতার উত্তাল সমাবেশে ডাকসুর ভিপি আ স ম আবদুর রব সর্বপ্রথম স্বাধীন বাংলাদেশের জাতীয় পতাকা উত্তোলন করেন।',
                'options' => [
                    ['A', '৭ মার্চ, ১৯৭১', false],
                    ['B', '২ মার্চ, ১৯৭১', true],
                    ['C', '২৬ মার্চ, ১৯৭১', false],
                    ['D', '১৭ এপ্রিল, ১৯৭১', false],
                ],
            ],
            [
                'stem' => '‘গম্ভীরা’ বাংলাদেশের কোন অঞ্চলের লোকসংগীত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>রাজশাহী</strong>: নানা-নাতির সংলাপ ও ব্যঙ্গাত্মক ভাবধারায় সমৃদ্ধ ঐতিহ্যবাহী ‘গম্ভীরা’ রাজশাহী ও চাঁপাইনবাবগঞ্জ অঞ্চলের বিখ্যাত লোকনাট্য ও সঙ্গীত।',
                'options' => [
                    ['A', 'পার্বত্য চট্টগ্রাম', false],
                    ['B', 'সিলেট', false],
                    ['C', 'রাজশাহী', true],
                    ['D', 'রংপুর', false],
                ],
            ],
            [
                'stem' => 'ঢাকার বিখ্যাত তারা মসজিদ তৈরি করেছিলেন-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মির্জা গোলাম পীর</strong>: ঢাকার আরমানিটোলায় উনিশ শতকের শুরুতে জমিদার মির্জা গোলাম পীর (মির্জা আহমদ জান) তারা মসজিদ নির্মাণ করেন। পরে এতে তারকাখচিত চীনা মাটির কারুকাজ যুক্ত হয়।',
                'options' => [
                    ['A', 'শায়েস্তা খান', false],
                    ['B', 'নবাব সলিমুল্লাহ', false],
                    ['C', 'মির্জা আহমদ জান', false],
                    ['D', 'মির্জা গোলাম পীর', true],
                ],
            ],
            [
                'stem' => 'কোন শাসকের সময় থেকে সমগ্র বাংলা ভাষাভাষী অঞ্চল পরিচিত হয়ে ওঠে ‘বাঙ্গালাহ্’ নামে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>শামসুদ্দিন ইলিয়াস শাহ</strong>: ১৩৫২ সালে সুলতান শামসুদ্দিন ইলিয়াস শাহ সমগ্র বাংলাকে ঐক্যবদ্ধ করে ‘শাহ-ই-বাঙ্গালাহ’ উপাধি ধারণ করেন এবং তাঁর সময় থেকেই এ ভূখণ্ড ‘বাঙ্গালাহ’ নামে পরিচিত হয়।',
                'options' => [
                    ['A', 'ফখরুদ্দিন মোবারক শাহ', false],
                    ['B', 'শামসুদ্দিন ইলিয়াস শাহ', true],
                    ['C', 'আকবর', false],
                    ['D', 'ঈশা খাঁ', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে উন্নত মানের কয়লার সন্ধান পাওয়া গিয়েছে-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>জামালগঞ্জে</strong>: ১৯৬২ সালে জয়পুরহাটের জামালগঞ্জে বাংলাদেশের সবচেয়ে গভীর ও উন্নত মানের বিটুমিনাস কয়লার খনি আবিষ্কৃত হয়।',
                'options' => [
                    ['A', 'জামালগঞ্জে', true],
                    ['B', 'জকিগঞ্জে', false],
                    ['C', 'বিজয়পুরে', false],
                    ['D', 'রানীগঞ্জে', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে চীনা মাটির সন্ধান পাওয়া গেছে-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বিজয়পুরে</strong>: নেত্রকোণা জেলার দুর্গাপুর উপজেলার বিজয়পুরে বাংলাদেশের সবচেয়ে সমৃদ্ধ ও উন্নতমানের সাদামাটি বা চীনামাটির খনি অবস্থিত।',
                'options' => [
                    ['A', 'বিজয়পুরে', true],
                    ['B', 'রানীগঞ্জে', false],
                    ['C', 'টেকেনরহাটে', false],
                    ['D', 'বিয়ানী বাজারে', false],
                ],
            ],
            [
                'stem' => 'মহাস্থানগড় এক সময় বাংলার রাজধানী ছিল, তখন তার নাম ছিল-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>পুণ্ড্রনগর</strong>: বগুড়ার মহাস্থানগড় প্রাচীন বাংলার সবচেয়ে প্রাচীন নগর পুণ্ড্রবর্ধন রাজ্যের রাজধানী ছিল, যার প্রাচীন নাম ছিল ‘পুণ্ড্রনগর’।',
                'options' => [
                    ['A', 'মহাস্থান', false],
                    ['B', 'কর্ণসুবর্ণ', false],
                    ['C', 'পুণ্ড্রনগর', true],
                    ['D', 'রামাবতী', false],
                ],
            ],

            // ==========================================
            // ৫৩-৬৫: আন্তর্জাতিক বিষয়াবলী (International Affairs)
            // ==========================================
            [
                'stem' => 'একটি কাঁচা পাটের গাইটের ওজন কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪.৫ মণ</strong>: কাঁচা পাটের একটি আদর্শ বেলের (Bale/গাইট) আন্তর্জাতিক প্রমিত ওজন প্রায় ১৮০ কেজি বা ৪.৫ মণ (৪ মণ ২০ সের)।',
                'options' => [
                    ['A', '৩.৫ মণ', false],
                    ['B', '৪ মণ', false],
                    ['C', '৪.৫ মণ', true],
                    ['D', '৫ মণ', false],
                ],
            ],
            [
                'stem' => '১১ তম এশিয়ান গেমসের উদ্বোধনী ও সমাপনী অনুষ্ঠান যে স্টেডিয়ামে অনুষ্ঠিত হয় তার নাম-',
                'subject' => 'international',
                'explanation' => '<strong>ওয়ার্কার্স স্টেডিয়াম, বেইজিং</strong>: ১৯৯০ সালে চীনের রাজধানী বেইজিংয়ে অনুষ্ঠিত একাদশ এশিয়ান গেমসের উদ্বোধনী ও সমাপনী অনুষ্ঠান বেইজিংয়ের ওয়ার্কার্স স্টেডিয়ামে (Workers’ Stadium) অনুষ্ঠিত হয়েছিল।',
                'options' => [
                    ['A', 'পিংকং স্পোর্টস স্টেডিয়াম', false],
                    ['B', 'বেইজিং স্পোর্টস স্টেডিয়াম', false],
                    ['C', 'ওয়ার্কার্স স্টেডিয়াম, বেইজিং', true],
                    ['D', 'চায়না স্পোর্টস স্টেডিয়াম', false],
                ],
            ],
            [
                'stem' => 'শাত-ইল আরবকে কেন্দ্র করে ইরাক ও ইরানের মধ্যে স্বাক্ষরিত চুক্তির নাম-',
                'subject' => 'international',
                'explanation' => '<strong>আলজিয়ার্স চুক্তি</strong>: ১৯৭৫ সালে আলজেরিয়ার মধ্যস্থতায় শাত-ইল আরব নদীর জলসীমা বিরোধ নিষ্পত্তির জন্য ইরাকের সাদ্দাম হোসেন ও ইরানের শাহ মোহাম্মদ রেজা পাহলভির মধ্যে ‘আলজিয়ার্স চুক্তি’ স্বাক্ষরিত হয়।',
                'options' => [
                    ['A', 'দামেস্ক চুক্তি', false],
                    ['B', 'আলজিয়ার্স চুক্তি', true],
                    ['C', 'কায়রো চুক্তি', false],
                    ['D', 'বৈরুত চুক্তি', false],
                ],
            ],
            [
                'stem' => '‘৫০০ দিনের প্ল্যান’ বলতে বোঝায় যে এ সময়ের মধ্যে-',
                'subject' => 'international',
                'explanation' => '<strong>সোভিয়েত ইউনিয়নের প্রস্তাবিত বাজার অর্থনীতি প্রচলন সম্পন্ন করা</strong>: ১৯৯০ সালে সোভিয়েত ইউনিয়নে মিখাইল গর্বাচেভের আমলে রাষ্ট্রনিয়ন্ত্রিত সমাজতান্ত্রিক অর্থনীতি থেকে দ্রুত বাজার অর্থনীতিতে উত্তরণের জন্য ‘৫০০ দিনের অর্থনৈতিক সংস্কার পরিকল্পনা’ (শাতালিন পরিকল্পনা) গৃহীত হয়েছিল।',
                'options' => [
                    ['A', '‘ওয়ারশ’ জোট ভেঙ্গে দেয়ার প্রকল্প সম্পন্ন করা', false],
                    ['B', 'রুমানিয়াতে গণতান্ত্রিক প্রথা প্রচলন সম্পন্ন করা', false],
                    ['C', 'সোভিয়েত ইউনিয়নের প্রস্তাবিত বাজার অর্থনীতি প্রচলন সম্পন্ন করা', true],
                    ['D', 'পূর্ব জার্মানি হতে সোভিয়েত সৈন্য প্রত্যাহার সম্পন্ন করা', false],
                ],
            ],
            [
                'stem' => 'জেমস গ্রান্টের মতে প্রতিরোধযোগ্য পীড়ায় বিশ্বে প্রতিদিন শিশু মৃত্যুর সংখ্যা-',
                'subject' => 'international',
                'explanation' => '<strong>৪০,০০০</strong>: ইউনিসেফের (UNICEF) নির্বাহী পরিচালক জেমস পি. গ্রান্টের ঐতিহাসিক প্রতিবেদন অনুযায়ী বিশ্বে প্রতিদিন প্রায় ৪০ হাজার শিশু প্রতিরোধযোগ্য রোগ ও অপুষ্টিতে মৃত্যুবরণ করত।',
                'options' => [
                    ['A', '৪,০০,০০০', false],
                    ['B', '৪০,০০০', true],
                    ['C', '৪৪,০০০', false],
                    ['D', '৫৪,০০০', false],
                ],
            ],
            [
                'stem' => 'কোন দেশকে হাজার হ্রদের দেশ বলা হয়?',
                'subject' => 'international',
                'explanation' => '<strong>ফিনল্যান্ড</strong>: উত্তর ইউরোপের স্ক্যান্ডিনেভীয় অঞ্চলের দেশ ফিনল্যান্ডে প্রায় ১ লক্ষ ৮৭ হাজারের বেশি হ্রদ থাকার কারণে দেশটিকে ‘হাজার হ্রদের দেশ’ (Land of a Thousand Lakes) বলা হয়।',
                'options' => [
                    ['A', 'নরওয়ে', false],
                    ['B', 'সুইডেন', false],
                    ['C', 'ফিনল্যান্ড', true],
                    ['D', 'সুইজারল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'পারস্য উপসাগরের আঞ্চলিক জোটের নাম-',
                'subject' => 'international',
                'explanation' => '<strong>GCC</strong>: পারস্য উপসাগরীয় ছয়টি আরব দেশ (সৌদি আরব, কুয়েত, কাতার, সংযুক্ত আরব আমিরাত, বাহরাইন ও ওমান) নিয়ে ১৯৮১ সালে গঠিত রাজনৈতিক ও অর্থনৈতিক জোট হলো Gulf Cooperation Council (GCC)।',
                'options' => [
                    ['A', 'OAE', false],
                    ['B', 'Arab League', false],
                    ['C', 'GCC', true],
                    ['D', 'OAM', false],
                ],
            ],
            [
                'stem' => 'বাস্তিল দুর্গের পতন ঘটেছিল-',
                'subject' => 'international',
                'explanation' => '<strong>১৪ জুলাই, ১৭৮৯</strong>: ১৭৮৯ সালের ১৪ জুলাই ফরাসি বিপ্লবীরা স্বৈরাচারী রাজতন্ত্র ও নির্যাতনের প্রতীক প্যারিসের ঐতিহাসিক বাস্তিল দুর্গ আক্রমণ করে দখল ও ধ্বংস করে। এ দিনটি ফ্রান্সের জাতীয় দিবস।',
                'options' => [
                    ['A', '১৪ জুলাই, ১৭৮৯', true],
                    ['B', '৭ জুন, ১৭৮৮', false],
                    ['C', '৫ অক্টোবর, ১৭৮৮', false],
                    ['D', '২৬ আগস্ট, ১৭৮৮', false],
                ],
            ],
            [
                'stem' => 'কঙ্গো প্রজাতন্ত্রের বর্তমান নাম-',
                'subject' => 'international',
                'explanation' => '<strong>জায়ারে</strong>: ১৯৭১ সালে সাবেক বেলজিয়ান কঙ্গো প্রজাতন্ত্রের নাম পরিবর্তন করে ‘জায়ারে’ (Zaire) রাখা হয়েছিল। পরবর্তীতে ১৯৯৭ সালে এটি ‘গণতান্ত্রিক কঙ্গো প্রজাতন্ত্র’ (DR Congo) নাম ধারণ করে।',
                'options' => [
                    ['A', 'লিওপোল্ডভিল', false],
                    ['B', 'জিম্বাবুয়ে', false],
                    ['C', 'জিবুতি', false],
                    ['D', 'জায়ারে', true],
                ],
            ],
            [
                'stem' => '‘ট্রাফালগার স্কয়ার’ কোন শহরে অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>লন্ডন</strong>: ১৮০৫ সালে ফরাসি ও স্প্যানিশ নৌবহরের বিরুদ্ধে ব্রিটিশ অ্যাডমিরাল নেলসনের ঐতিহাসিক বিজয়ের স্মরণে যুক্তরাজ্যের রাজধানী লন্ডনের কেন্দ্রস্থলে ‘ট্রাফালগার স্কয়ার’ অবস্থিত।',
                'options' => [
                    ['A', 'ওয়াশিংটন', false],
                    ['B', 'প্যারিস', false],
                    ['C', 'মস্কো', false],
                    ['D', 'লন্ডন', true],
                ],
            ],
            [
                'stem' => 'মিশর সুয়েজখাল জাতীয়করণ করেছিল-',
                'subject' => 'international',
                'explanation' => '<strong>১৯৫৬</strong>: ১৯৫৬ সালের ২৬ জুলাই মিশরের তৎকালীন প্রেসিডেন্ট জামাল আবদেল নাসের সুয়েজ খাল জাতীয়করণের ঐতিহাসিক ঘোষণা দেন, যার প্রেক্ষাপটে সুয়েজ যুদ্ধ বা সংকট শুরু হয়েছিল।',
                'options' => [
                    ['A', '১৯৫৬', true],
                    ['B', '১৯৫৫', false],
                    ['C', '১৯৫৪', false],
                    ['D', '১৮৯৫', false],
                ],
            ],
            [
                'stem' => 'জাপান পার্ল হারবার আক্রমণ করে-',
                'subject' => 'international',
                'explanation' => '<strong>৭ ডিসেম্বর, ১৯৪১</strong>: দ্বিতীয় বিশ্বযুদ্ধ চলাকালে ১৯৪১ সালের ৭ ডিসেম্বর জাপান হাওয়াই দ্বীপপুঞ্জে অবস্থিত মার্কিন যুক্তরাষ্ট্রের পার্ল হারবার নৌঘাঁটিতে আকস্মিক বিমান হামলা চালায়, যার ফলে যুক্তরাষ্ট্র সরাসরি যুদ্ধে জড়িয়ে পড়ে।',
                'options' => [
                    ['A', '৭ ডিসেম্বর, ১৯৪১', true],
                    ['B', '২৩ জুন, ১৯৪২', false],
                    ['C', '৩ নভেম্বর, ১৯৪২', false],
                    ['D', '২৬ জুলাই,১৯৪৩', false],
                ],
            ],
            [
                'stem' => 'সৌদি আরবে আমেরিকার সৈন্য মোতায়েনের উদ্দেশ্য-',
                'subject' => 'international',
                'explanation' => '<strong>উপরের সবকটি</strong>: ১৯৯০ সালে সাদ্দাম হোসেন কর্তৃক কুয়েত দখলের পর উপসাগরীয় যুদ্ধের প্রেক্ষাপটে সৌদি আরবকে সম্ভাব্য ইরাকি আক্রমণ থেকে রক্ষা, কুয়েত মুক্তকরণ এবং পশ্চিমা বিশ্বের জন্য তেল সরবরাহ নিরাপদ রাখতে মার্কিন সেনা মোতায়েন করা হয়।',
                'options' => [
                    ['A', 'ইরাকের আক্রমণ হতে সৌদি আরবকে রক্ষা করা', false],
                    ['B', 'ইরাকের কুয়েত দখলের অবসান করা', false],
                    ['C', 'স্বল্পমূল্যে জ্বালানি তেলের সরবরাহ নিশ্চিত করা', false],
                    ['D', 'উপরের সবকটি', true],
                ],
            ],

            // ==========================================
            // ৬৬-৮৩: সাধারণ বিজ্ঞান ও প্রযুক্তি (Science)
            // ==========================================
            [
                'stem' => 'শহরের রাস্তায় ট্রাফিক পুলিশ সাধারণত সাদা ছাতা ও সাদা জামা ব্যবহার করে থাকে কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>তাপ বিকিরণ থেকে বাঁচার জন্য</strong>: সাদা রঙের বস্তু তাপ শোষণ না করে প্রায় সম্পূর্ণ তাপ প্রতিফলিত ও বিকিরণ করে ফিরিয়ে দেয়, ফলে প্রচণ্ড রোদের মধ্যেও শরীর অপেক্ষাকৃত শীতল থাকে।',
                'options' => [
                    ['A', 'সরকারি নির্দেশ', false],
                    ['B', 'দূর থেকে চোখে পড়বে বলে', false],
                    ['C', 'দেখতে সুন্দর লাগে', false],
                    ['D', 'তাপ বিকিরণ থেকে বাঁচার জন্য', true],
                ],
            ],
            [
                'stem' => 'আকাশে বিজলি চমকায়-',
                'subject' => 'science',
                'explanation' => '<strong>মেঘের অসংখ্য পানি ও বরফ কণার মধ্যে চার্জ সঞ্চিত হলে</strong>: বজ্রবাহী মেঘে জলীয়বাষ্প ও বরফকণার পারস্পরিক ঘর্ষণে বিপুল পরিমাণ ধনাত্মক ও ঋণাত্মক স্থির বৈদ্যুতিক আধান বা চার্জ সৃষ্টি হয়। এ আধানের তড়িৎক্ষরণের ফলেই আকাশে তীব্র বিজলি চমকায়।',
                'options' => [
                    ['A', 'দুই খন্ড মেঘ পরস্পর সংঘর্ষে এলে', false],
                    ['B', 'মেঘের অসংখ্য পানি ও বরফ কণার মধ্যে চার্জ সঞ্চিত হলে', true],
                    ['C', 'মেঘে বিদ্যুৎ পরিবাহী কোষ তৈরি হলে', false],
                    ['D', 'মেঘ বিদ্যুৎ পরিবাহী অবস্থায় এলে', false],
                ],
            ],
            [
                'stem' => 'অধিকাংশ ফটোকপি মেশিন কাজ করে-',
                'subject' => 'science',
                'explanation' => '<strong>পোলারয়েড ফটোগ্রাফি পদ্ধতিতে</strong>: ফটোকপিয়ার মূলত স্থির বৈদ্যুতিক আধান এবং আলোকসংবেদী ড্রামের ওপর আলোকসম্পাত প্রক্রিয়ার (জেরোগ্রাফি বা পোলারয়েড ফটোগ্রাফি প্রিন্সিপল) মাধ্যমে কাজ করে।',
                'options' => [
                    ['A', 'অফসেট মুদ্রণ পদ্ধতিতে', false],
                    ['B', 'পোলারয়েড ফটোগ্রাফি পদ্ধতিতে', true],
                    ['C', 'ডিজিটাল ইমেজিং পদ্ধতিতে', false],
                    ['D', 'স্থির বৈদ্যুতিক ইমেজিং পদ্ধতিতে', false],
                ],
            ],
            [
                'stem' => 'যে সর্বোচ্চ শ্রুতি সীমার উপরে মানুষ বধির হতে পারে তা হচ্ছে-',
                'subject' => 'science',
                'explanation' => '<strong>১০৫ ডিবি</strong>: মানুষের জন্য স্বাভাবিক শব্দমাত্রা ৬০-৬৫ ডেসিবেল। সাধারণত ১০৫ ডেসিবেলের বেশি তীব্রতার শব্দের মধ্যে একটানা থাকলে কানের পর্দা ক্ষতিগ্রস্ত হয়ে মানুষ স্থায়ীভাবে বধির হতে পারে।',
                'options' => [
                    ['A', '৭৫ ডিবি', false],
                    ['B', '৯০ ডিবি', false],
                    ['C', '১০৫ ডিবি', true],
                    ['D', '১২০ ডিবি', false],
                ],
            ],
            [
                'stem' => 'কোনো বস্তুকে পানিতে সম্পূর্ণভাবে ডুবালে পানিতে যেখানে এটি রাখা যায় সেখানেই এটি থাকে কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>বস্তুর ঘনত্ব পানির ঘনত্বের সমান</strong>: আর্কিমিডিসের সূত্র ও প্লবতার নীতি অনুযায়ী, নিমজ্জিত বস্তুর ঘনত্ব তরলের ঘনত্বের সমান হলে বস্তুর ওজন ও ঊর্ধ্বমুখী প্লবতা বল সমান হয়, ফলে বস্তুটি তরলের ভেতরে যেকোনো গভীরতায় ভাসমান অবস্থায় স্থির থাকে।',
                'options' => [
                    ['A', 'বস্তুর ঘনত্ব পানির চেয়ে বেশি', false],
                    ['B', 'বস্তুর ঘনত্ব পানির ঘনত্বের চেয়ে কম', false],
                    ['C', 'বস্তুর ঘনত্ব পানির ঘনত্বের সমান', true],
                    ['D', 'বস্তু ও পানির ঘনত্বের মধ্যে নিবিড় সম্পর্ক বিদ্যমান', false],
                ],
            ],
            [
                'stem' => 'পানিতে নৌকার বৈঠা বাঁকা দেখা যাওয়ার কারণ, আলোর-',
                'subject' => 'science',
                'explanation' => '<strong>প্রতিসরণ</strong>: আলো যখন পানি (ঘন মাধ্যম) থেকে বাতাস (হালকা মাধ্যম)-এ প্রবেশ করে, তখন প্রতিসরণের কারণে আলোর রশ্মি অভিলম্ব থেকে দূরে সরে দর্শকের চোখে পৌঁছায়, ফলে নিমজ্জিত অংশটি সামান্য উপরে ও বাঁকা দেখায়।',
                'options' => [
                    ['A', 'প্রতিসরণ', true],
                    ['B', 'পূর্ণ অভ্যন্তরীণ প্রতিফলন', false],
                    ['C', 'বিচ্ছুরণ', false],
                    ['D', 'পোলারায়ন', false],
                ],
            ],
            [
                'stem' => 'রান্না করার হাঁড়ি-পাতিল সাধারণত অ্যালুমিনিয়ামের তৈরি হয়। এর প্রধান কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>এতে দ্রুত তাপ সঞ্চারিত হয়ে খাদ্যদ্রব্য তাড়াতাড়ি সিদ্ধ হয়</strong>: অ্যালুমিনিয়াম একটি অত্যন্ত সুপরিবাহী ধাতু যার তাপ পরিবাহিতা উচ্চ। তাই হাঁড়িতে দ্রুত তাপ ছড়িয়ে খাবার কম সময়ে সিদ্ধ হয়।',
                'options' => [
                    ['A', 'এটি হাল্কা ও দামে সস্তা', false],
                    ['B', 'এটি সব দেশেই পাওয়া যায়', false],
                    ['C', 'এতে দ্রুত তাপ সঞ্চারিত হয়ে খাদ্যদ্রব্য তাড়াতাড়ি সিদ্ধ হয়', true],
                    ['D', 'এটি সহজে ভেঙ্গে যায় না এবং বেশি গরম সহ্য করতে পারে', false],
                ],
            ],
            [
                'stem' => 'রিমোট সেন্সিং বা দূর অনুধাবন বলতে বিশেষভাবে বোঝায়-',
                'subject' => 'science',
                'explanation' => '<strong>উপগ্রহের সাহায্যে দূর থেকে ভূমণ্ডলের অবলোকন</strong>: কোনো বস্তুকে প্রত্যক্ষ স্পর্শ না করে কৃত্রিম উপগ্রহ, বিমান বা ড্রোন-সংযুক্ত সেন্সরের মাধ্যমে ভূপৃষ্ঠের বৈশিষ্ট্য ও উপাত্ত সংগ্রহ করাকে রিমোট সেন্সিং বা দূর অনুধাবন বলে।',
                'options' => [
                    ['A', 'রেডিও ট্রান্সমিটার সহযোগে দূর থেকে তথ্য সংগ্রহ', false],
                    ['B', 'রাডারের সাহায্যে চারদিকের পরিবেশের অবলোকন', false],
                    ['C', 'কোয়াসার প্রভৃতি মহাজাগতিক উৎস থেকে সংকেত অনুধাবন', false],
                    ['D', 'উপগ্রহের সাহায্যে দূর থেকে ভূমণ্ডলের অবলোকন', true],
                ],
            ],
            [
                'stem' => 'পালতোলা নৌকা সম্পূর্ণ অন্য দিকের বাতাসকেও এর সম্মুখ গতিতে ব্যবহার করতে পারে কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>সম্মুখ অভিমুখে বলের উপাংশটিকে কার্যকর রাখা হয়</strong>: সামান্তরিকের বল বিভাজন সূত্রানুযায়ী পালের সাথে বাতাসের কোণকে এমনভাবে বিন্যস্ত করা হয় যাতে পার্শ্বীয় বলকে হাল দিয়ে প্রতিহত করে কেবল সম্মুখমুখী উপাংশ কার্যকর থাকে।',
                'options' => [
                    ['A', 'ক্রিয়ার বদলে প্রতিক্রিয়াটি ব্যবহৃত হয়', false],
                    ['B', 'সম্মুখ অভিমুখে বলের উপাংশটিকে কার্যকর রাখা হয়', true],
                    ['C', 'পালের দড়িতে টানের নিয়ন্ত্রণ বিশেষ দিকে বাতাসকে কার্যকর করে', false],
                    ['D', 'পালের আকৃতিকে সুকৌশলে ব্যবহার করা যায়', false],
                ],
            ],
            [
                'stem' => 'সাধারণ স্টোরেজ ব্যাটারিতে সীসার ইলেক্ট্রোডের সঙ্গে যে তরলটি ব্যবহৃত হয় তা হলো-',
                'subject' => 'science',
                'explanation' => '<strong>সালফিউরিক এসিড</strong>: লেড-এসিড স্টোরেজ ব্যাটারিতে লেড ($Pb$) ও লেড ডাই-অক্সাইড ($PbO_2$) পাতে তড়িৎ-বিশ্লেষ্য (Electrolyte) তরল হিসেবে লঘু সালফিউরিক এসিড ($H_2SO_4$) ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'নাইট্রিক এসিড', false],
                    ['B', 'সালফিউরিক এসিড', true],
                    ['C', 'অ্যামোনিয়াম ক্লোরাইড', false],
                    ['D', 'হাইড্রোক্লোরিক এসিড', false],
                ],
            ],
            [
                'stem' => 'ফুলানো বেলুনের মুখ ছেড়ে দিলে বাতাস বেরিয়ে যাবার সঙ্গে সঙ্গে বেলুনটি ছুটে যায়। কোন ইঞ্জিনের নীতির সঙ্গে এর মিল আছে?',
                'subject' => 'science',
                'explanation' => '<strong>রকেট ইঞ্জিন</strong>: এটি নিউটনের গতির ৩য় সূত্র (প্রত্যেক ক্রিয়ারই একটি সমান ও বিপরীত প্রতিক্রিয়া আছে) অনুসারে কাজ করে। বেলুন থেকে বাতাস বের হওয়ার প্রতিক্রিয়ায় বেলুন এগিয়ে যায়, ঠিক যেভাবে রকেট বা জেট ইঞ্জিন গ্যাস নির্গমনের মাধ্যমে সামনে এগিয়ে চলে।',
                'options' => [
                    ['A', 'বাষ্পীয় ইঞ্জিন', false],
                    ['B', 'অন্তর্দহন ইঞ্জিন', false],
                    ['C', 'স্টারলিং ইঞ্জিন', false],
                    ['D', 'রকেট ইঞ্জিন', true],
                ],
            ],
            [
                'stem' => 'ফিউশন প্রক্রিয়ায়-',
                'subject' => 'science',
                'explanation' => '<strong>একাধিক পরমাণু যুক্ত করে নতুন পরমাণু গঠন করে</strong>: নিউক্লিয়ার ফিউশন প্রক্রিয়ায় একাধিক হালকা নিউক্লিয়াস (যেমন হাইড্রোজেনের আইসোটোপ) অত্যন্ত উচ্চ তাপমাত্রায় সংযুক্ত হয়ে তুলনামূলক ভারী নিউক্লিয়াস (যেমন হিলিয়াম) গঠন করে এবং বিপুল পরিমাণ শক্তি বিমুক্ত হয় (যেমনটি সূর্যের কেন্দ্রে ঘটে)।',
                'options' => [
                    ['A', 'একটি পরমাণু ভেঙ্গে প্রচণ্ড শক্তি সৃষ্টি করে', false],
                    ['B', 'একাধিক পরমাণু যুক্ত করে নতুন পরমাণু গঠন করে', true],
                    ['C', 'ভারী পরমাণু ভেঙ্গে দুটি পরমাণু সৃষ্টি হয়', false],
                    ['D', 'একটি পরমাণু ভেঙ্গে দুটি পরমাণু সৃষ্টি হয়', false],
                ],
            ],
            [
                'stem' => 'প্রবল জোয়ারের কারণ, এ সময়-',
                'subject' => 'science',
                'explanation' => '<strong>সূর্য, চন্দ্র ও পৃথিবী এক সরলরেখায় থাকে</strong>: অমাবস্যা ও পূর্ণিমা তিথিতে চন্দ্র, সূর্য ও পৃথিবী একই সরলরেখায় অবস্থান করলে তাদের সম্মিলিত মহাকর্ষ বলের টানে মহাসাগরে সবচেয়ে প্রবল জোয়ার বা ‘তেজ কটাল’ (Spring Tide) সৃষ্টি হয়।',
                'options' => [
                    ['A', 'চন্দ্র পৃথিবীর সবচেয়ে কাছে থাকে', false],
                    ['B', 'সূর্য ও চন্দ্র পৃথিবীর সঙ্গে সমকোণ করে থাকে', false],
                    ['C', 'পৃথিবী সূর্যের সবচেয়ে কাছে থাকে', false],
                    ['D', 'সূর্য, চন্দ্র ও পৃথিবী এক সরলরেখায় থাকে', true],
                ],
            ],
            [
                'stem' => 'নিচের কোন উক্তিটি সঠিক?',
                'subject' => 'science',
                'explanation' => '<strong>বায়ু একটি মিশ্র পদার্থ</strong>: বায়ুমণ্ডলে নাইট্রোজেন (৭৮%), অক্সিজেন (২১%), আর্গন, কার্বন ডাই-অক্সাইড ইত্যাদি একাধিক মৌলিক ও যৌগিক গ্যাস কোনো রাসায়নিক বিক্রিয়া ছাড়াই নিজ নিজ ধর্ম বজায় রেখে অবস্থান করে, তাই এটি মিশ্র পদার্থ।',
                'options' => [
                    ['A', 'বায়ু একটি যৌগিক পদার্থ', false],
                    ['B', 'বায়ু একটি মৌলিক পদার্থ', false],
                    ['C', 'বায়ু একটি মিশ্র পদার্থ', true],
                    ['D', 'বায়ু বলতে অক্সিজেন ও নাইট্রোজেনকে বোঝায়', false],
                ],
            ],
            [
                'stem' => 'ভৌগোলিকভাবে গুরুত্বপূর্ণ একটি কাল্পনিক রেখা বাংলাদেশের উপর দিয়ে গিয়েছে, সেটি হচ্ছে-',
                'subject' => 'science',
                'explanation' => '<strong>কর্কটক্রান্তি রেখা</strong>: ২৩.৫° উত্তর অক্ষাংশ বিশিষ্ট কর্কটক্রান্তি রেখা (Tropic of Cancer) বাংলাদেশের প্রায় মাঝামাঝি (চুয়াডাঙ্গা, ঝিনাইদহ, মাগুরা, ফরিদপুর, ঢাকা, কুমিল্লা, খাগড়াছড়ি) দিয়ে অতিক্রম করেছে।',
                'options' => [
                    ['A', 'মূল মধ্যরেখা', false],
                    ['B', 'কর্কটক্রান্তি রেখা', true],
                    ['C', 'মকরক্রান্তি রেখা', false],
                    ['D', 'আন্তর্জাতিক তারিখ রেখা', false],
                ],
            ],
            [
                'stem' => 'যে বায়ু সর্বদাই উচ্চচাপ অঞ্চল থেকে নিম্নচাপ অঞ্চলের দিকে প্রবাহিত হয় তাকে বলা হয়-',
                'subject' => 'science',
                'explanation' => '<strong>নিয়ত বায়ু</strong>: পৃথিবীর স্থায়ী উচ্চচাপ বলয় থেকে স্থায়ী নিম্নচাপ বলয়ের দিকে বছরব্যাপী নিয়মিত ও অবিরামভাবে নির্দিষ্ট দিকে প্রবাহিত বায়ুকে নিয়ত বায়ু (Planetary Wind) বলে। যেমন: আয়ন বায়ু, পশ্চিমা বায়ু ও মেরু বায়ু।',
                'options' => [
                    ['A', 'আয়ন বায়ু', false],
                    ['B', 'প্রত্যয়ন বায়ু', false],
                    ['C', 'মৌসুমী বায়ু', false],
                    ['D', 'নিয়ত বায়ু', true],
                ],
            ],
            [
                'stem' => 'গ্রিন হাউজ ইফেক্ট বলতে বোঝায়-',
                'subject' => 'science',
                'explanation' => '<strong>তাপ আটকে পড়ে সার্বিক তাপমাত্রা বৃদ্ধি</strong>: বায়ুমণ্ডলে কার্বন ডাই-অক্সাইড, মিথেন ইত্যাদি গ্রিনহাউস গ্যাসের স্তর সূর্য থেকে আগত ক্ষুদ্র তরঙ্গের তাপ প্রবেশ করতে দিলেও ভূপৃষ্ঠ থেকে বিকিরিত দীর্ঘ তরঙ্গের তাপ মহাশূন্যে ফিরে যেতে বাধা দেয়, ফলে পৃথিবীর গড় তাপমাত্রা বৃদ্ধি পায়।',
                'options' => [
                    ['A', 'সূর্যালোকের অভাবে সালোক সংশ্লেষণে ঘাটতি', false],
                    ['B', 'তাপ আটকে পড়ে সার্বিক তাপমাত্রা বৃদ্ধি', true],
                    ['C', 'প্রাকৃতিক চাষের বদলে ক্রমবর্ধমানভাবে কৃত্রিম চাষের প্রয়োজনীয়তা', false],
                    ['D', 'উপগ্রহের সাহায্যে দূর থেকে ভূমণ্ডলের অবলোকন', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘে রাষ্ট্রপতির ভাষণ অনুযায়ী, বাংলাদেশে শিশুমৃত্যুর হার কমিয়ে আনা হয়েছে প্রতি হাজারে-',
                'subject' => 'science',
                'explanation' => '<strong>৩৯</strong>: জাতিসংঘ সাধারণ পরিষদে উপস্থাপিত পরিসংখ্যান অনুযায়ী বাংলাদেশে স্বাস্থ্যসেবার অগ্রগতির ফলে শিশুমৃত্যুর হার প্রতি হাজারে ৩৯-এ নামিয়ে আনার কথা উল্লেখ করা হয়।',
                'options' => [
                    ['A', '১৩৭', false],
                    ['B', '১২১', false],
                    ['C', '১১৭', false],
                    ['D', '৩৯', true],
                ],
            ],

            // ==========================================
            // ৮৪-৯৯: গাণিতিক যুক্তি ও মানসিক দক্ষতা (Math)
            // ==========================================
            [
                'stem' => 'চিনির মূল্য ২৫% বৃদ্ধি পাওয়াতে একটি পরিবার চিনি খাওয়া এমনভাবে কমাল যে, চিনি বাবদ ব্যয় বৃদ্ধি পেল না। ঐ পরিবার চিনি খাওয়ার খরচ শতকরা কত কমিয়েছিল?',
                'subject' => 'math',
                'explanation' => '<strong>২০%</strong>: ব্যয় অপরিবর্তিত রাখতে ব্যবহার হ্রাসের হার = $[r / (100 + r)] \times 100\% = [25 / 125] \times 100\% = 20\%$।',
                'options' => [
                    ['A', '৩০%', false],
                    ['B', '২৫%', false],
                    ['C', '১৫%', false],
                    ['D', '২০%', true],
                ],
            ],
            [
                'stem' => 'বার্ষিক পরীক্ষায় একটি ছাত্র মোট ক সংখ্যক প্রশ্নের প্রথম ২০টির মধ্যে ১৫টির নির্ভুল উত্তর দিল। বাকি যা প্রশ্ন রইল তার ১/৩ অংশ সে নির্ভুল উত্তর দিল। সমস্ত প্রশ্নের মান সমান। যদি ছাত্র শতকরা ৭৫ ভাগ নম্বর পায় তবে প্রশ্নের সংখ্যা কত ছিল?',
                'subject' => 'math',
                'explanation' => '<strong>২০টি</strong>: ছাত্রটি যদি মোট ২০টি প্রশ্নেরই উত্তর দিয়ে থাকে, তবে প্রথম ২০টির ১৫টিতেই প্রাপ্ত শতকরা নম্বর = $(১৫ / ২০) \times ১০০\% = ৭৫\%$। ফলে বাকি প্রশ্ন না থাকলেও শর্তটি নিখুঁতভাবে পূর্ণ হয়।',
                'options' => [
                    ['A', '১৫টি', false],
                    ['B', '২০টি', true],
                    ['C', '২৫টি', false],
                    ['D', '১৮টি', false],
                ],
            ],
            [
                'stem' => '৫ : ১৮, ৭ : ২ এবং ৩ : ৬ এর মিশ্র অনুপাত কত?',
                'subject' => 'math',
                'explanation' => '<strong>৩৫ : ৭২</strong>: মিশ্র অনুপাতের ক্ষেত্রে পূর্বপদগুলোর গুণফল = $৫ \times ৭ \times ৩ = ১০৫$ এবং উত্তরপদগুলোর গুণফল = $১৮ \times ২ \times ৬ = ২১৬$। অতএব অনুপাত = $১০৫ : ২১৬$। উভয় পদকে ৩ দ্বারা ভাগ করলে পাই $৩৫ : ৭২$।',
                'options' => [
                    ['A', '৭২ : ১০৫', false],
                    ['B', '৭২ : ৩৫', false],
                    ['C', '৩৫ : ৭২', true],
                    ['D', '১০৫ : ৭২', false],
                ],
            ],
            [
                'stem' => 'নৌকা ও স্রোতের বেগ যথাক্রমে ঘণ্টায় ১০ ও ৫ কিলোমিটার। নদীপথে ৪৫ কিলোমিটার দীর্ঘ পথ একবার অতিক্রম করে ফিরে আসতে কত সময় লাগবে-',
                'subject' => 'math',
                'explanation' => '<strong>১২ ঘণ্টা</strong>: অনুকূলে বেগ = ১০ + ৫ = ১৫ কিমি/ঘণ্টা, সময় লাগে ৪৫ ÷ ১৫ = ৩ ঘণ্টা। প্রতিকূলে বেগ = ১০ - ৫ = ৫ কিমি/ঘণ্টা, সময় লাগে ৪৫ ÷ ৫ = ৯ ঘণ্টা। সুতরাং মোট সময় = ৩ + ৯ = ১২ ঘণ্টা।',
                'options' => [
                    ['A', '১২ ঘণ্টা', true],
                    ['B', '১০ ঘণ্টা', false],
                    ['C', '১৫ ঘণ্টা', false],
                    ['D', '২০ ঘণ্টা', false],
                ],
            ],
            [
                'stem' => '২০৫৭৩.৪ মিলিগ্রামে কত কিলোগ্রাম?',
                'subject' => 'math',
                'explanation' => '<strong>০.০২০৫৭৩৪</strong>: ১ কিলোগ্রাম = ১০,০০,০০০ মিলিগ্রাম ($১০^৬$ মিলিগ্রাম)। সুতরাং ২০৫৭৩.৪ মিলিগ্রাম = ২০৫৭৩.৪ ÷ ১০,০০,০০০ = ০.০২০৫৭৩৪ কিলোগ্রাম।',
                'options' => [
                    ['A', '২.০৫৭৩৪', false],
                    ['B', '০.২০৫৭৩৪', false],
                    ['C', '০.০২০৫৭৩৪', true],
                    ['D', '২০.৫৭৩৪০', false],
                ],
            ],
            [
                'stem' => 'x² - 8x - 8y + 16 + y² এর সঙ্গে কত যোগ করলে যোগফল একটি পূর্ণবর্গ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>2xy</strong>: রাশিটি সাজালে পাই $x^2 + y^2 + 16 - 8x - 8y$। এর সাথে $2xy$ যোগ করলে পাই $x^2 + y^2 + 16 + 2xy - 8x - 8y = (x + y)^2 - 2(x + y)(4) + 4^2 = (x + y - 4)^2$, যা একটি পূর্ণবর্গ সংখ্যা।',
                'options' => [
                    ['A', '-2xy', false],
                    ['B', '8xy', false],
                    ['C', '6xy', false],
                    ['D', '2xy', true],
                ],
            ],
            [
                'stem' => '2x² – x – 15 এর উৎপাদক হবে-',
                'subject' => 'math',
                'explanation' => '<strong>(2x + 5)(x - 3)</strong>: মধ্যপদ বিভাজনে $2x^2 - x - 15 = 2x^2 - 6x + 5x - 15 = 2x(x - 3) + 5(x - 3) = (2x + 5)(x - 3)$।',
                'options' => [
                    ['A', '(2x + 5)(x - 3)', true],
                    ['B', '(2x - 5)(x + 3)', false],
                    ['C', '(2x + 3)(x - 5)', false],
                    ['D', '(2x - 3)(x + 5)', false],
                ],
            ],
            [
                'stem' => 'a⁴ + 4 এর উৎপাদক কী কী?',
                'subject' => 'math',
                'explanation' => '<strong>(a² + 2a + 2)(a² - 2a + 2)</strong>: $a^4 + 4 = (a^2)^2 + 2^2 = (a^2 + 2)^2 - 2 \cdot a^2 \cdot 2 = (a^2 + 2)^2 - (2a)^2 = (a^2 + 2a + 2)(a^2 - 2a + 2)$।',
                'options' => [
                    ['A', '(a² + 2a + 2)(a² + 2a - 2)', false],
                    ['B', '(a² + 2a + 2)(a² - 2a + 2)', true],
                    ['C', '(a² - 2a + 2)(a² + 2a - 2)', false],
                    ['D', '(a² - 2a - 2)(a² - 2a + 2)', false],
                ],
            ],
            [
                'stem' => 'p এর মান কত হলে, 4x² – px + 9 একটি পূর্ণবর্গ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>১২</strong>: $4x^2 - px + 9 = (2x)^2 - 2(2x)(3) + 3^2 = (2x - 3)^2 = 4x^2 - 12x + 9$। তুলনা করে পাই $p = 12$।',
                'options' => [
                    ['A', '১০', false],
                    ['B', '৯', false],
                    ['C', '১৭', false],
                    ['D', '১২', true],
                ],
            ],
            [
                'stem' => '৮, ১১, ১৭, ২৯, ৫৩, ...... । পরবর্তী সংখ্যাটি কত?',
                'subject' => 'math',
                'explanation' => '<strong>১০১</strong>: পার্থক্যগুলো যথাক্রমে: ১১ - ৮ = ৩; ১৭ - ১১ = ৬; ২৯ - ১৭ = ১২; ৫৩ - ২৯ = ২৪। অর্থাৎ পার্থক্য প্রতি ধাপে দ্বিগুণ হচ্ছে। অতএব পরবর্তী পার্থক্য হবে ২৪ × ২ = ৪৮। সুতরাং সংখ্যাটি = ৫৩ + ৪৮ = ১০১।',
                'options' => [
                    ['A', '১০১', true],
                    ['B', '১০২', false],
                    ['C', '৭৫', false],
                    ['D', '৫৯', false],
                ],
            ],
            [
                'stem' => 'চারটি সমান বাহু দ্বারা সীমাবদ্ধ একটি ক্ষেত্র যার একটি কোণও সমকোণ নয়, এরূপ চিত্রকে বলা হয়-',
                'subject' => 'math',
                'explanation' => '<strong>রম্বস</strong>: যে চতুর্ভুজের চারটি বাহুই পরস্পর সমান কিন্তু কোণগুলো সমকোণ নয় তাকে রম্বস (Rhombus) বলে। কোণগুলো সমকোণ হলে তা বর্গক্ষেত্র হতো।',
                'options' => [
                    ['A', 'বর্গক্ষেত্র', false],
                    ['B', 'চতুর্ভুজ', false],
                    ['C', 'রম্বস', true],
                    ['D', 'সামান্তরিক', false],
                ],
            ],
            [
                'stem' => 'একটি সুষম বহুভুজের একটি অন্তঃকোণের পরিমাণ ১৩৫° হলে বহুভুজটির বাহুর সংখ্যা হবে-',
                'subject' => 'math',
                'explanation' => '<strong>৮</strong>: একটি অন্তঃকোণ ১৩৫° হলে একটি বহিঃকোণ = ১৮০° - ১৩৫° = ৪৫°। সুষম বহুভুজের বহিঃকোণসমূহের সমষ্টি ৩৬০°। সুতরাং বাহুর সংখ্যা = ৩৬০° ÷ ৪৫° = ৮টি।',
                'options' => [
                    ['A', '৬', false],
                    ['B', '৭', false],
                    ['C', '৮', true],
                    ['D', '১০', false],
                ],
            ],
            [
                'stem' => 'একটি সমবাহু ত্রিভুজের একটি বাহু ১৬ মিটার, ত্রিভুজটির ক্ষেত্রফল কত?',
                'subject' => 'math',
                'explanation' => '<strong>64√3</strong>: সমবাহু ত্রিভুজের ক্ষেত্রফল = $(\sqrt{3}/4) a^2 = (\sqrt{3}/4) \times 16^2 = (\sqrt{3}/4) \times 256 = 64\sqrt{3}$ বর্গমিটার।',
                'options' => [
                    ['A', '192', false],
                    ['B', '32√3', false],
                    ['C', '64√3', true],
                    ['D', '64', false],
                ],
            ],
            [
                'stem' => 'ABD বৃত্তে AB এবং CD দুটি সমান জ্যা পরস্পর p বিন্দুতে ছেদ করলে কোনটি সত্য?',
                'subject' => 'math',
                'explanation' => '<strong>PB=PD</strong>: জ্যামিতিক উপপাদ্য অনুযায়ী, বৃত্তের দুটি সমান জ্যা পরস্পর বৃত্তের অভ্যন্তরে ছেদ করলে একটি জ্যার খণ্ডিতাংশদ্বয় অপর জ্যার অনুরূপ খণ্ডিতাংশদ্বয়ের সমান হয়, অর্থাৎ $PB = PD$।',
                'options' => [
                    ['A', 'PC=PD', false],
                    ['B', 'PA=PB', false],
                    ['C', 'PB=PA', false],
                    ['D', 'PB=PD', true],
                ],
            ],
            [
                'stem' => 'নিচের কোন সংখ্যাটি √২ এবং √৩ এর মধ্যবর্তী মূলদ সংখ্যা?',
                'subject' => 'math',
                'explanation' => '<strong>1.5</strong>: $\sqrt{2} \approx 1.414$ এবং $\sqrt{3} \approx 1.732$। এদের মধ্যবর্তী মূলদ সংখ্যা হলো $1.5 = 3/2$, যা দুটি পূর্ণসংখ্যার অনুপাত।',
                'options' => [
                    ['A', '(√2+√3)/2', false],
                    ['B', '(√2.√3)/2', false],
                    ['C', '1.5', true],
                    ['D', '1.8', false],
                ],
            ],
            [
                'stem' => 'একটি স্কুলে ছাত্রদের ড্রিল করার সময় ৮, ১০ এবং ১২ সারিতে সাজানো যায়। আবার বর্গাকারেও সাজানো যায়। ঐ স্কুলে কমপক্ষে কতজন ছাত্র আছে?',
                'subject' => 'math',
                'explanation' => '<strong>৩৬০০</strong>: ৮, ১০ ও ১২ এর ল.সা.গু. = ১২০ ($= 2^3 \times 3 \times 5 = 2^2 \times 2 \times 3 \times 5$)। একে ক্ষুদ্রতম পূর্ণবর্গ সংখ্যা করতে হলে আরও $2 \times 3 \times 5 = 30$ দিয়ে গুণ করতে হবে। অতএব ছাত্রসংখ্যা = $১২০ \times ৩০ = ৩৬০০$।',
                'options' => [
                    ['A', '৩৬০০', true],
                    ['B', '২৪০০', false],
                    ['C', '১২০০', false],
                    ['D', '৩০০০', false],
                ],
            ],

            // ==========================================
            // ১০০: ট্রাফিক সাধারণ জ্ঞান (Science / General)
            // ==========================================
            [
                'stem' => 'শহরের রাস্তায় ট্রাফিক লাইট যে ক্রম অনুসারে জ্বলে তা হলো-',
                'subject' => 'science',
                'explanation' => '<strong>লাল-হলুদ-সবুজ-হলুদ-লাল</strong>: আন্তর্জাতিক ও বাংলাদেশ ট্রাফিক আইন অনুযায়ী সিগন্যাল চক্রটি হলো: থামার সংকেত ‘লাল’, প্রস্তুতির জন্য ‘হলুদ’, চলার সংকেত ‘সবুজ’, এরপর পুনরায় সতর্কতার জন্য ‘হলুদ’ এবং চূড়ান্তভাবে গাড়ি থামার জন্য ‘লাল’।',
                'options' => [
                    ['A', 'লাল-সবুজ-হলুদ-লাল-সবুজ', false],
                    ['B', 'লাল-হলুদ-সবুজ-লাল-হলুদ', false],
                    ['C', 'লাল-হলুদ-সবুজ-হলুদ-লাল', true],
                    ['D', 'লাল-হলুদ-লাল-সবুজ-হলুদ', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, their options, tags, and link to the 12th BCS exam
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
                'reference_source' => '১২তম বিসিএস (পুলিশ) প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '12th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1991',
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
