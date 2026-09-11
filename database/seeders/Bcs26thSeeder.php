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

class Bcs26thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '26th')->first() ?? ExamYear::firstOrCreate(['year' => '26th'], [
            'name_en' => '26th BCS Exam',
            'name_bn' => '২৬তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 26th BCS Exam (200 Questions)
        $exam = Exam::firstOrCreate(
            ['slug' => '26th-bcs-preliminary'],
            [
                'title_bn' => '২৬তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '26th BCS Preliminary Question Solution',
                'description_bn' => '২৬তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ২০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 200 questions, answers, and comprehensive explanations of the 26th BCS Preliminary Examination.',
                'exam_mode' => 'previous_year',
                'organization_id' => $bpsc?->id,
                'exam_type_id' => $examType?->id,
                'exam_year_id' => $examYear?->id,
                'total_questions' => 200,
                'total_marks' => 200.00,
                'duration_minutes' => 120,
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
                'stem' => 'Ballad কি?',
                'subject' => 'bangla',
                'explanation' => '<strong>গীতিকা</strong>: \'Ballad\' ইংরেজি সাহিত্যের একটি বিশেষ রূপ যার বাংলা পরিভাষা হলো \'গীতিকা\' বা লোকগাথা (যেমন: মৈমনসিংহ গীতিকা)। এটি মূলত গান গেয়ে বর্ণিত কাহিনীকাব্য।',
                'options' => [
                    ['A', 'লোকগীতি', false],
                    ['B', 'লোকগাঁথা', false],
                    ['C', 'গীতিকা', true],
                    ['D', 'গাথা', false],
                ],
            ],
            [
                'stem' => '‘শাহনামা’ মৌলিক গ্রন্থটি কার?',
                'subject' => 'bangla',
                'explanation' => '<strong>ফেরদৌসী</strong>: পারস্যের জাতীয় মহাকবি আবুল কাসেম ফেরদৌসী রচিত বিশ্ববিখ্যাত মহাকাব্য হলো ‘শাহনামা’ (Shahnameh), যা প্রাচীন পারস্যের রাজাদের বীরত্বগাথা নিয়ে রচিত।',
                'options' => [
                    ['A', 'মালিক জয়সী', false],
                    ['B', 'ফেরদৌসী', true],
                    ['C', 'সৈয়দ হামজা', false],
                    ['D', 'কাজী দৌলত উজির বাহরাম খাঁ', false],
                ],
            ],
            [
                'stem' => 'ড. মুহম্মদ শহীদুল্লাহ্’র বাংলা সাহিত্যের ইতিহাস গ্রন্থের নাম-',
                'subject' => 'bangla',
                'explanation' => '<strong>বাংলা সাহিত্যের কথা</strong>: ভাষাবিদ ড. মুহম্মদ শহীদুল্লাহ রচিত বাংলা সাহিত্যের সুপ্রসিদ্ধ ইতিহাস গ্রন্থের নাম ‘বাংলা সাহিত্যের কথা’ (প্রাচীন ও মধ্যযুগ)।',
                'options' => [
                    ['A', 'বঙ্গভাষা ও সাহিত্য', false],
                    ['B', 'বাংলা সাহিত্যের কথা', true],
                    ['C', 'বাঙ্গালা সাহিত্যের ইতিহাস', false],
                    ['D', 'বাংলা সাহিত্যের ইতিবৃত্ত', false],
                ],
            ],
            [
                'stem' => '‘চৌ-হদ্দি’ শব্দটি কোন কোন ভাষার শব্দ মিলে হয়েছে?',
                'subject' => 'bangla',
                'explanation' => '<strong>ফারসি + আরবি</strong>: ‘চৌ-হদ্দি’ একটি মিশ্র শব্দ। এতে ‘চৌ’ (চার) ফারসি শব্দ এবং ‘হদ্দি’ (সীমা) আরবি শব্দ থেকে এসেছে।',
                'options' => [
                    ['A', 'বাংলা + ফারসি', false],
                    ['B', 'সংস্কৃত + ফারসি', false],
                    ['C', 'ফারসি + আরবি', true],
                    ['D', 'সংস্কৃত + আরবি', false],
                ],
            ],
            [
                'stem' => '‘রুপ লাগি আঁখি ঝুরে গুণে মন ভোর’ কার রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>জ্ঞানদাস</strong>: বৈষ্ণব পদাবলীর অন্যতম শ্রেষ্ঠ পদকর্তা জ্ঞানদাসের শ্রীরাধার রূপানুরাগ বিষয়ক অমর ও বহুল পঠিত পদ এটি।',
                'options' => [
                    ['A', 'চণ্ডীদাস', false],
                    ['B', 'জ্ঞানদাস', true],
                    ['C', 'বিদ্যাপতি', false],
                    ['D', 'লোচনদাস', false],
                ],
            ],
            [
                'stem' => '‘সাজাহান’ নাটকের প্রথম রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>দ্বিজেন্দ্রলাল রায়</strong>: ঐতিহাসিক নাটক ‘সাজাহান’ (১৯০৯)-এর রচয়িতা প্রখ্যাত নাট্যকার দ্বিজেন্দ্রলাল রায় (ডি. এল. রায়)।',
                'options' => [
                    ['A', 'ক্ষীরোদপ্রসাদ বিদ্যাবিনোদ', false],
                    ['B', 'তুলসী লাহিড়ী', false],
                    ['C', 'দ্বিজেন্দ্রলাল রায়', true],
                    ['D', 'বলাইচাঁদ মুখোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => '‘নেমেসিস’ নাটকে নূরুল মোমেন কোন বিষয়কে তুলে ধরেছেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>ঊনপঞ্চাশের মন্বন্তর</strong>: নাট্যকার নূরুল মোমেন রচিত নিরীক্ষাধর্মী একাঙ্ক নাটক ‘নেমেসিস’ (১৯৪৪)-এ ১৯৪৩ সালের (বাংলা ১৩৪৯) ভয়াবহ দ্বিতীয় বিশ্বযুদ্ধকালীন মন্বন্তর ও সামাজিক বিপর্যয় তুলে ধরা হয়েছে।',
                'options' => [
                    ['A', 'দ্বিতীয় বিশ্বযুদ্ধ', false],
                    ['B', 'বায়ান্নর ভাষা আন্দোলন', false],
                    ['C', 'ঊনপঞ্চাশের মন্বন্তর', true],
                    ['D', 'একাত্তরের মুক্তিযুদ্ধ', false],
                ],
            ],
            [
                'stem' => 'ভারতচন্দ্র রায়গুণাকর কোন রাজসভার কবি?',
                'subject' => 'bangla',
                'explanation' => '<strong>কৃষ্ণনগর রাজসভা</strong>: মধ্যযুগের শেষ বড় কবি ভারতচন্দ্র রায়গুণাকর নদীয়ার কৃষ্ণনগরের রাজা কৃষ্ণচন্দ্রের রাজসভার প্রধান সভাকবি ছিলেন।',
                'options' => [
                    ['A', 'আরাকান রাজসভা', false],
                    ['B', 'কৃষ্ণনগর রাজসভা', true],
                    ['C', 'রাজা গণেশের রাজসভা', false],
                    ['D', 'লক্ষণ সেনের রাজসভা', false],
                ],
            ],
            [
                'stem' => '‘যা কিছু হারায় গিন্নী বলেন, কেষ্টা বেটাই চোর’- এখানে ‘হারায়’ কোন ধাতু?',
                'subject' => 'bangla',
                'explanation' => '<strong>প্রযোজক ধাতু</strong>: মূল ধাতুর (হার্) সাথে \'আ\' প্রত্যয় যুক্ত হয়ে যখন অন্যের দ্বারা কার্য সম্পাদিত হওয়া বোঝায়, তখন তাকে প্রযোজক বা ণিজন্ত ধাতু বলে।',
                'options' => [
                    ['A', 'প্রযোজ্য ধাতু', false],
                    ['B', 'ভাববাচ্যের ধাতু', false],
                    ['C', 'সংযোগমূলক ধাতু', false],
                    ['D', 'নাম ধাতু', true],
                ],
            ],
            [
                'stem' => '‘মহুয়া’ পালাটির রচয়িতা-',
                'subject' => 'bangla',
                'explanation' => '<strong>দ্বিজ কানাই</strong>: দীনেশচন্দ্র সেন সম্পাদিত ‘মৈমনসিংহ গীতিকা’র অন্যতম জনপ্রিয় রূপকথাধর্মী প্রণয়োপাখ্যান ‘মহুয়া’ পালার রচয়িতা হলেন লোককবি দ্বিজ কানাই।',
                'options' => [
                    ['A', 'দ্বিজ কানাই', true],
                    ['B', 'মনসুর বয়াতি', false],
                    ['C', 'নয়নচাঁদ ঘোষ', false],
                    ['D', 'দ্বিজ ঈশান', false],
                ],
            ],
            [
                'stem' => 'ফোর্ট উইলিয়াম কলেজে বাংলা বিভাগ খোলা হয়-',
                'subject' => 'bangla',
                'explanation' => '<strong>১৮০১ সালে</strong>: ব্রিটিশ ভারতে ইংরেজ সিভিলিয়ানদের দেশীয় ভাষা শিক্ষার জন্য ১৮০০ সালে ফোর্ট উইলিয়াম কলেজ প্রতিষ্ঠিত হয় এবং ১৮০১ সালে উইলিয়াম কেরির নেতৃত্বে বাংলা বিভাগ চালু করা হয়।',
                'options' => [
                    ['A', '১৮০০ সালে', false],
                    ['B', '১৮০১ সালে', true],
                    ['C', '১৮০২ সালে', false],
                    ['D', '১৮০৪ সালে', false],
                ],
            ],
            [
                'stem' => 'কে সর্বপ্রথম বাংলা টাইপ সহযোগে বাংলা ব্যাকরণ মুদ্রণ করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>ব্রাসি হ্যালহেড</strong>: ন্যাথানিয়েল ব্রাসি হ্যালহেড ১৭৭৮ সালে চার্লস উইলকিন্সের নকশাকৃত ধাতব বাংলা হরফ সহযোগে প্রথম বাংলা ব্যাকরণ \'A Grammar of the Bengal Language\' হুগলি থেকে মুদ্রণ করেন।',
                'options' => [
                    ['A', 'স্যার উইলিয়াম জোন্স', false],
                    ['B', 'স্যার উইলিয়াম কেরি', false],
                    ['C', 'রাজীব লোচন মুখোপাধ্যায়', false],
                    ['D', 'ব্রাসি হ্যালহেড', true],
                ],
            ],
            [
                'stem' => '‘তত্ত্ববোধিনী’ পত্রিকায় সম্পাদক ছিলেন-',
                'subject' => 'bangla',
                'explanation' => '<strong>অক্ষয়কুমার দত্ত</strong>: ১৮৪৩ সালে দেবেন্দ্রনাথ ঠাকুরের উদ্যোগে প্রতিষ্ঠিত তত্ত্ববোধিনী সভার মুখপত্র ‘তত্ত্ববোধিনী পত্রিকা’-র প্রথম ও প্রধান সম্পাদক ছিলেন যুক্তিবাদী প্রাবন্ধিক অক্ষয়কুমার দত্ত।',
                'options' => [
                    ['A', 'ঈশ্বরচন্দ্র গুপ্ত', false],
                    ['B', 'বঙ্কিমচন্দ্র চট্টোপাধ্যায়', false],
                    ['C', 'অক্ষয়কুমার দত্ত', true],
                    ['D', 'প্যারীচাঁদ মিত্র', false],
                ],
            ],
            [
                'stem' => 'কোনটি দীনবন্ধু মিত্রের রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>কমলে কামিনী</strong>: নাট্যকার দীনবন্ধু মিত্রের নাটকগুলোর মধ্যে রয়েছে নীলদর্পণ, সধবার একাদশী, বিয়ে পাগলা বুড়ো, কমলে কামিনী, জামাইবারিক এবং লীলাবতী।',
                'options' => [
                    ['A', 'কমলে কামিনী', true],
                    ['B', 'চক্ষুদান', false],
                    ['C', 'বিধবা বিবাহ', false],
                    ['D', 'ভদ্রার্জুন', false],
                ],
            ],
            [
                'stem' => 'কোন গ্রন্থটি মহাকাব্য?',
                'subject' => 'bangla',
                'explanation' => '<strong>বৃত্রসংহার</strong>: হেমচন্দ্র বন্দ্যোপাধ্যায় রচিত পৌরাণিক কাহিনীভিত্তিক বিখ্যাত মহাকাব্য হলো ‘বৃত্রসংহার’ (১৮৭৫-৭৭)।',
                'options' => [
                    ['A', 'অবকাশ রঞ্জিনী', false],
                    ['B', 'বৃত্রসংহার', true],
                    ['C', 'বিরহ বিলাপ', false],
                    ['D', 'বীরাঙ্গনা কাব্য', false],
                ],
            ],
            [
                'stem' => '‘বত্রিশ সিংহাসন’ কার রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>মৃত্যুঞ্জয় বিদ্যালঙ্কার</strong>: ফোর্ট উইলিয়াম কলেজের সংস্কৃত ও বাংলা পণ্ডিত মৃত্যুঞ্জয় বিদ্যালঙ্কার ১৮০২ সালে সংস্কৃত গ্রন্থ অবলম্বনে ‘বত্রিশ সিংহাসন’ গদ্যগ্রন্থ রচনা করেন।',
                'options' => [
                    ['A', 'মৃত্যুঞ্জয় বিদ্যালঙ্কার', true],
                    ['B', 'রাজীব লোচন মুখোপাধ্যায়', false],
                    ['C', 'বিদ্যাসাগর', false],
                    ['D', 'রামরাম বসু', false],
                ],
            ],
            [
                'stem' => '‘ঠকচাচা’ চরিত্রটি কোন উপন্যাসের?',
                'subject' => 'bangla',
                'explanation' => '<strong>আলালের ঘরের দুলাল</strong>: প্যারীচাঁদ মিত্র (টেকচাঁদ ঠাকুর) রচিত বাংলা সাহিত্যের প্রথম উপন্যাস ‘আলালের ঘরের দুলাল’ (১৮৫৮)-এর বিখ্যাত ধূর্ত চরিত্র হলো ‘ঠকচাচা’।',
                'options' => [
                    ['A', 'হুতোম প্যাঁচার নকশা', false],
                    ['B', 'আলালের ঘরের দুলাল', true],
                    ['C', 'সধবার একাদশী', false],
                    ['D', 'বুড়ো শালিকের ঘাড়ে রোঁ', false],
                ],
            ],
            [
                'stem' => '‘উদাসীন পথিকের মনের কথা’ কোন জাতীয় রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>আত্মজৈবনিক উপন্যাস</strong>: মীর মশাররফ হোসেন রচিত ‘উদাসীন পথিকের মনের কথা’ (১৮৯০) মূলত নীল বিদ্রোহের পটভূমিতে রচিত একটি ঐতিহাসিক আত্মজৈবনিক উপন্যাস।',
                'options' => [
                    ['A', 'নাটক', false],
                    ['B', 'কাব্য', false],
                    ['C', 'আত্মজৈবনিক উপন্যাস', true],
                    ['D', 'গীতি কবিতার সংকলন', false],
                ],
            ],
            [
                'stem' => '‘তাজকেরাতুল আউলিয়া’ অবলম্বনে ‘তাপসমালা’ কে রচনা করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>গিরিশচন্দ্র সেন</strong>: ফারসি সুফি সাধক ফরিদউদ্দিন আত্তারের ‘তাজকেরাতুল আউলিয়া’ অবলম্বনে মুসলিম সুফি ও সাধকদের জীবনীগ্রন্থ ‘তাপসমালা’ রচনা করেন ভাই গিরিশচন্দ্র সেন।',
                'options' => [
                    ['A', 'মুন্সী আব্দুল লতিফ', false],
                    ['B', 'কাজী আকরাম হোসেন', false],
                    ['C', 'গিরিশচন্দ্র সেন', true],
                    ['D', 'শেখ আব্দুল জব্বার', false],
                ],
            ],
            [
                'stem' => 'কোন নাটকটি সেলিম আল দীনের?',
                'subject' => 'bangla',
                'explanation' => '<strong>মুনতাসীর ফ্যান্টাসী</strong>: নাট্যচার্য সেলিম আল দীন রচিত রূপক ও সামাজিক ব্যঙ্গাত্মক নাটক হলো ‘মুনতাসীর ফ্যান্টাসী’।',
                'options' => [
                    ['A', 'মুনতাসীর ফ্যান্টাসী', true],
                    ['B', 'পায়ের আওয়াজ পাওয়া যায়', false],
                    ['C', 'কবর', false],
                    ['D', 'বহুব্রীহি', false],
                ],
            ],
            [
                'stem' => 'আন্তর্জাতিক মাতৃভাষা দিবস কোন সালে স্বীকৃত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৯৯</strong>: ১৯৯৯ সালের ১৭ নভেম্বর ইউনেস্কোর ৩০তম সাধারণ অধিবেশনে বাংলাদেশের ২১শে ফেব্রুয়ারিকে আন্তর্জাতিক মাতৃভাষা দিবস হিসেবে ঐতিহাসিক স্বীকৃতি প্রদান করা হয়।',
                'options' => [
                    ['A', '১৯৯৮', false],
                    ['B', '১৯৯৯', true],
                    ['C', '২০০০', false],
                    ['D', '২০০১', false],
                ],
            ],
            [
                'stem' => 'বাংলা একাডেমি কোন সালে প্রতিষ্ঠিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৯৫৫ সালে</strong>: ভাষা আন্দোলনের প্রেক্ষিতে ১৯৫৫ সালের ৩ ডিসেম্বর ঢাকার বর্ধমান হাউসে বাংলা ভাষা, সাহিত্য ও সংস্কৃতি গবেষণার শীর্ষ জাতীয় প্রতিষ্ঠান বাংলা একাডেমি প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৫৪ সালে', false],
                    ['B', '১৯৫৫ সালে', true],
                    ['C', '১৯৫৬ সালে', false],
                    ['D', '১৯৫৭ সালে', false],
                ],
            ],
            [
                'stem' => '‘দারিদ্র্য’ কবিতাটি নজরুল ইসলামের কোন কাব্যের অন্তর্ভুক্ত?',
                'subject' => 'bangla',
                'explanation' => '<strong>সিন্ধু হিন্দোল</strong>: কাজী নজরুল ইসলামের বিখ্যাত কাব্যগ্রন্থ ‘সিন্ধু হিন্দোল’ (১৯২৭)-এ অমর ও বিখ্যাত কবিতা ‘দারিদ্র্য’ অন্তর্ভুক্ত হয়েছে (\'হে দারিদ্র্য, তুমি মোরে করেছ মহান...\')।',
                'options' => [
                    ['A', 'সাম্যবাদী', false],
                    ['B', 'বিষের বাঁশী', false],
                    ['C', 'সিন্ধু হিন্দোল', true],
                    ['D', 'নতুন চাঁদ', false],
                ],
            ],
            [
                'stem' => 'কোন শব্দটি ফারসি?',
                'subject' => 'bangla',
                'explanation' => '<strong>পেরেশান</strong>: \'পেরেশান\' (উদ্বিগ্ন/বিব্রত) একটি খাঁটি ফারসি ভাষার শব্দ। মুসাফির, তকদির ও মজলুম আরবি শব্দ।',
                'options' => [
                    ['A', 'মুসাফির', false],
                    ['B', 'তকদির', false],
                    ['C', 'পেরেশান', true],
                    ['D', 'মজলুম', false],
                ],
            ],
            [
                'stem' => 'উপসর্গ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>অতি</strong>: \'অতি\' হলো একটি সংস্কৃত (তৎসম) উপসর্গ (যেমন: অতিক্রম, অতিরিক্ত)। \'থেকে\', \'চেয়ে\', \'দ্বারা\' হলো অনুসর্গ বা অনুসর্গীয় অব্যয়।',
                'options' => [
                    ['A', 'অতি', true],
                    ['B', 'থেকে', false],
                    ['C', 'চেয়ে', false],
                    ['D', 'দ্বারা', false],
                ],
            ],
            [
                'stem' => 'দাপ্তরিক কোন শব্দটি ইংরেজি ভাষা থেকে আগত?',
                'subject' => 'bangla',
                'explanation' => '<strong>এজেন্ট</strong>: \'এজেন্ট\' (Agent) ইংরেজি ভাষা থেকে বাংলা দাপ্তরিক ও প্রশাসনিক ভাষায় সরাসরি গৃহীত একটি পারিভাষিক ঋণশব্দ।',
                'options' => [
                    ['A', 'আইন', false],
                    ['B', 'দাখিল', false],
                    ['C', 'এজেন্ট', true],
                    ['D', 'মুচলেকা', false],
                ],
            ],
            [
                'stem' => '‘নেমেসিস’ কোন জাতীয় রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>নাটক</strong>: ‘নেমেসিস’ নূরুল মোমেন রচিত একটি বিখ্যাত মনস্তাত্ত্বিক একাঙ্ক নাটক।',
                'options' => [
                    ['A', 'কাব্য', false],
                    ['B', 'নাটক', true],
                    ['C', 'উপন্যাস', false],
                    ['D', 'গীতি কবিতা', false],
                ],
            ],
            [
                'stem' => '‘তোমার সৃষ্টির পথ রেখেছ আকীর্ণ করি’- রবীন্দ্রনাথের কোন কাব্যের কবিতা?',
                'subject' => 'bangla',
                'explanation' => '<strong>শেষলেখা</strong>: রবীন্দ্রনাথ ঠাকুরের জীবনাবসানের পর প্রকাশিত সর্বশেষ কাব্যগ্রন্থ ‘শেষলেখা’ (১৯৪১)-র ১৩ সংখ্যক বিখ্যাত অন্তিম কবিতা এটি।',
                'options' => [
                    ['A', 'পূরবী', false],
                    ['B', 'শেষলেখা', true],
                    ['C', 'আকাশ প্রদীপ', false],
                    ['D', 'সেঁজুতি', false],
                ],
            ],
            [
                'stem' => '‘জয়গুন’ কোন উপন্যাসের চরিত্র?',
                'subject' => 'bangla',
                'explanation' => '<strong>সূর্য-দীঘল বাড়ী</strong>: কথাশিল্পী আবু ইসহাক রচিত মন্বন্তর ও গ্রামীণ কুসংস্কারের পটভূমিতে অমর উপন্যাস ‘সূর্য-দীঘল বাড়ী’ (১৯৫৫)-র সংগ্রামী প্রধান নারী চরিত্র জয়গুন।',
                'options' => [
                    ['A', 'জননী', false],
                    ['B', 'সূর্য-দীঘল বাড়ী', true],
                    ['C', 'সারেং বৌ', false],
                    ['D', 'হাজার বছর ধরে', false],
                ],
            ],
            [
                'stem' => '‘নবান্ন’ শব্দটি কোন প্রক্রিয়ায় গঠিত?',
                'subject' => 'bangla',
                'explanation' => '<strong>সন্ধি</strong>: নব + অন্ন = নবান্ন (স্বরসন্ধি: অ + অ = আ)। অতএব শব্দটি মূলত সন্ধি প্রক্রিয়ায় গঠিত।',
                'options' => [
                    ['A', 'সমাস', false],
                    ['B', 'সন্ধি', true],
                    ['C', 'প্রত্যয়', false],
                    ['D', 'উপসর্গ', false],
                ],
            ],
            [
                'stem' => 'কোনটির অর্থ পক্ব অর্থে প্রকাশ পায়?',
                'subject' => 'bangla',
                'explanation' => '<strong>পাকা আম</strong>: \'পাকা আম\' শব্দবন্ধে \'পাকা\' শব্দটি ফল পেকে যাওয়া বা পরিপক্ব (পক্ব) অর্থে ব্যবহৃত হয়েছে। পাকা বাড়ি = স্থায়ী, পাকা রং = দীর্ঘস্থায়ী।',
                'options' => [
                    ['A', 'পাকা বাড়ি', false],
                    ['B', 'পাকা রং', false],
                    ['C', 'পাকা কাজ', false],
                    ['D', 'পাকা আম', true],
                ],
            ],
            [
                'stem' => '‘পাখি সব করে রব রাতি পোহাইল’- পঙ্‌ক্তিটির রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>মদনমোহন তর্কালংকার</strong>: শিশুশিক্ষার পথিকৃৎ পন্ডিত মদনমোহন তর্কালংকারের ‘শিশুশিক্ষা’ প্রথম ভাগের সুপ্রসিদ্ধ ‘প্রভাত’ কবিতার প্রারম্ভিক পঙ্‌ক্তি এটি।',
                'options' => [
                    ['A', 'রামনারায়ণ তর্করত্ন', false],
                    ['B', 'মদনমোহন তর্কালংকার', true],
                    ['C', 'বিহারীলাল চক্রবর্তী', false],
                    ['D', 'কৃষ্ণচন্দ্র মজুমদার', false],
                ],
            ],
            [
                'stem' => '‘বনফুল’ কার ছদ্মনাম?',
                'subject' => 'bangla',
                'explanation' => '<strong>বলাইচাঁদ মুখোপাধ্যায়</strong>: বিশিষ্ট কথাসাহিত্যিক ও ক্ষুদ্র গল্পের জনক ডা. বলাইচাঁদ মুখোপাধ্যায়ের সাহিত্যিক ছদ্মনাম ছিল ‘বনফুল’।',
                'options' => [
                    ['A', 'প্রমথ চৌধুরী', false],
                    ['B', 'বলাইচাঁদ মুখোপাধ্যায়', true],
                    ['C', 'যতীন্দ্রমোহন বাগচী', false],
                    ['D', 'মোহিতলাল মজুমদার', false],
                ],
            ],
            [
                'stem' => 'কাজী নজরুল ইসলামের উপন্যাস কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>মৃত্যুক্ষুধা</strong>: কাজী নজরুল ইসলামের তিনটি উপন্যাস হলো: ‘বাঁধন-হারা’, ‘মৃত্যুক্ষুধা’ এবং ‘কুহেলিকা’।',
                'options' => [
                    ['A', 'মৃত্যুক্ষুধা', true],
                    ['B', 'আলেয়া', false],
                    ['C', 'ঝিলিমিলি', false],
                    ['D', 'মধুমালা', false],
                ],
            ],
            [
                'stem' => '‘যে-ই তার দর্শন পেলাম, সে-ই আমরা প্রস্থান করলাম।’ এটি কোন জাতীয় বাক্য?',
                'subject' => 'bangla',
                'explanation' => '<strong>মিশ্র বাক্য</strong>: নিত্য সম্বন্ধীয় সাপেক্ষ সর্বনাম (যে-ই...সে-ই) দ্বারা একটি প্রধান খণ্ডবাক্য ও একটি আশ্রিত খণ্ডবাক্য যুক্ত থাকায় এটি মিশ্র বা জটিল বাক্য।',
                'options' => [
                    ['A', 'সরল বাক্য', false],
                    ['B', 'যৌগিক বাক্য', false],
                    ['C', 'মৌলিক বাক্য', false],
                    ['D', 'মিশ্র বাক্য', true],
                ],
            ],
            [
                'stem' => '‘লাঠালাঠি’- এটি কোন সমাস?',
                'subject' => 'bangla',
                'explanation' => '<strong>ব্যতিহার বহুব্রীহি সমাস</strong>: একই বিশেষ্যের পুনরাবৃত্তি এবং ক্রিয়ার পারস্পরিক প্রতিক্রিয়া বোঝালে তাকে ব্যতিহার বহুব্রীহি সমাস বলে (লাঠিতে লাঠিতে যে লড়াই = লাঠালাঠি)।',
                'options' => [
                    ['A', 'প্রাদি সমাস', false],
                    ['B', 'ব্যতিহার বহুব্রীহি সমাস', true],
                    ['C', 'তৎপুরুষ সমাস', false],
                    ['D', 'কর্মধারয় সমাস', false],
                ],
            ],
            [
                'stem' => '‘ভানুসিংহ ঠাকুরের পদাবলী’-এর রচয়িতা কে?',
                'subject' => 'bangla',
                'explanation' => '<strong>রবীন্দ্রনাথ ঠাকুর</strong>: কিশোর বয়সে বৈষ্ণব পদাবলীর অনুকরণে ব্রজবুলি ভাষায় রবীন্দ্রনাথ ঠাকুর ‘ভানুসিংহ ঠাকুর’ ছদ্মনামে এই বিখ্যাত পদাবলী রচনা করেন।',
                'options' => [
                    ['A', 'ভানু বন্দ্যোপাধ্যায়', false],
                    ['B', 'চণ্ডীদাস', false],
                    ['C', 'রবীন্দ্রনাথ ঠাকুর', true],
                    ['D', 'ভারতচন্দ্র চট্টোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => 'প্র, পরা, অপ-',
                'subject' => 'bangla',
                'explanation' => '<strong>সংস্কৃত উপসর্গ</strong>: বাংলা ভাষায় সংস্কৃত বা তৎসম উপসর্গ মোট ২০টি, যার মধ্যে প্র, পরা, অপ, সম, নি ইত্যাদি অন্যতম।',
                'options' => [
                    ['A', 'বাংলা উপসর্গ', false],
                    ['B', 'সংস্কৃত উপসর্গ', true],
                    ['C', 'বিদেশী উপসর্গ', false],
                    ['D', 'উপসর্গ স্থানীয় অব্যয়', false],
                ],
            ],
            [
                'stem' => 'টা, টি, খানা ইত্যাদি-',
                'subject' => 'bangla',
                'explanation' => '<strong>পদাশ্রিত নির্দেশক</strong>: কয়েকটি শব্দাংশ বা প্রত্যয় কোনো পদের সাথে যুক্ত হয়ে তার নির্দিষ্টতা বা অনির্দিষ্টতা জ্ঞাপন করে, এদের পদাশ্রিত নির্দেশক (Definite Articles) বলা হয়।',
                'options' => [
                    ['A', 'পদাশ্রিত নির্দেশক', true],
                    ['B', 'প্রকৃতি', false],
                    ['C', 'বিভক্তি', false],
                    ['D', 'উপসর্গ', false],
                ],
            ],
            [
                'stem' => 'কাজী নজরুল ইসলাম কোন কবিতা রচনার জন্য কারাবরণ করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>আনন্দময়ীর আগমনে</strong>: ১৯২২ সালে ‘ধূমকেতু’ পত্রিকার পূজা সংখ্যায় ব্রিটিশবিরোধী বিপ্লবাত্মক কবিতা ‘আনন্দময়ীর আগমনে’ প্রকাশের কারণে রাজদ্রোহের অভিযোগে নজরুলকে এক বছরের সশ্রম কারাদণ্ড দেওয়া হয়।',
                'options' => [
                    ['A', 'বিদ্রোহী', false],
                    ['B', 'প্রলয়োল্লাস', false],
                    ['C', 'আনন্দময়ীর আগমনে', true],
                    ['D', 'নারী', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence.',
                'subject' => 'english',
                'explanation' => '<strong>Everybody has gone there.</strong>: \'Everybody\', \'Everyone\', \'Nobody\' ইত্যাদি Indefinite Pronoun-এর পর verb সর্বদা singular (\'has gone\') হয়।',
                'options' => [
                    ['A', 'Everybody have gone there.', false],
                    ['B', 'Everybody are gone there.', false],
                    ['C', 'Everybody has gone there.', true],
                    ['D', 'Everybody has went there.', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence.',
                'subject' => 'english',
                'explanation' => '<strong>The train is running on time</strong>: সময়সূচি বা সময়মাফিক চলার ক্ষেত্রে \'on time\' (at the scheduled time) বসে।',
                'options' => [
                    ['A', 'The train is running in time', false],
                    ['B', 'The train is running on time', true],
                    ['C', 'The train is running with time', false],
                    ['D', 'The train is running to time', false],
                ],
            ],
            [
                'stem' => 'Choose the correct preposition. My brother has no interest ––– music.',
                'subject' => 'english',
                'explanation' => '<strong>in</strong>: কোনো বিষয়, শিল্প বা বিদ্যায় আগ্রহ প্রকাশ করতে appropriate preposition হিসেবে \'interest in\' বসে।',
                'options' => [
                    ['A', 'for', false],
                    ['B', 'in', true],
                    ['C', 'with', false],
                    ['D', 'at', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank with right option. I am looking forward––––you.',
                'subject' => 'english',
                'explanation' => '<strong>to seeing</strong>: \'Look forward to\'-এর পরে verb আসলে তার সাথে সর্বদা \'ing\' যুক্ত হয় (gerund): \'looking forward to seeing you\'।',
                'options' => [
                    ['A', 'to seeing', true],
                    ['B', 'seeing', false],
                    ['C', 'to see', false],
                    ['D', 'to have seen', false],
                ],
            ],
            [
                'stem' => 'Choose the correct form (passive) of- ‘Who will do the work?’',
                'subject' => 'english',
                'explanation' => '<strong>By whom will the work be done?</strong>: \'Who\' যুক্ত interrogative বাক্যের passive নিয়ম: By whom + auxiliary verb (will) + object (\'the work\') + be + V3 (\'done\')?',
                'options' => [
                    ['A', 'Who will be done the work?', false],
                    ['B', 'Who will done the work?', false],
                    ['C', 'By whom will the work be done?', true],
                    ['D', 'Whom will the work be done?', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence.',
                'subject' => 'english',
                'explanation' => '<strong>I had looked for a good doctor before I met you.</strong>: \'Before\'-এর পূর্ববর্তী ক্লজটি Past Perfect (had + V3) এবং পরবর্তী ক্লজটি Past Indefinite (V2) হয়।',
                'options' => [
                    ['A', 'I have looked for a good doctor before I met you.', false],
                    ['B', 'I had looked for a good doctor before I met you.', true],
                    ['C', 'I looked for a good doctor before I had met you.', false],
                    ['D', 'I am looking for a good doctor before meeting you.', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank with correct preposition. He is devoid –––Commonsense.',
                'subject' => 'english',
                'explanation' => '<strong>of</strong>: \'Devoid of\' একটি appropriate preposition, যার অর্থ বর্জিত বা শূন্য (completely lacking in something)।',
                'options' => [
                    ['A', 'of', true],
                    ['B', 'from', false],
                    ['C', 'introduction', false],
                    ['D', 'at', false],
                ],
            ],
            [
                'stem' => 'Select the right word. He ran fast lest he––– miss the train.',
                'subject' => 'english',
                'explanation' => '<strong>should</strong>: কনজাংশন \'Lest\'-এর পরে subject-এর সাথে সর্বদা \'should\' (অথবা \'might\') বসে: \'lest he should miss the train\'।',
                'options' => [
                    ['A', 'can', false],
                    ['B', 'should', true],
                    ['C', 'could', false],
                    ['D', 'has', false],
                ],
            ],
            [
                'stem' => 'The Arabian Nights–––still a great favourite.',
                'subject' => 'english',
                'explanation' => '<strong>is</strong>: \'The Arabian Nights\' একটি বিখ্যাত একক বই বা গল্প সংকলনের নাম, তাই নাম plural দেখালেও verb singular (\'is\') হয়।',
                'options' => [
                    ['A', 'has', false],
                    ['B', 'are', false],
                    ['C', 'is', true],
                    ['D', 'were', false],
                ],
            ],
            [
                'stem' => 'Choose the correct preposition. The police is looking ––– the case',
                'subject' => 'english',
                'explanation' => '<strong>into</strong>: কোনো মামলা বা অপরাধ তদন্ত করা বোঝাতে Phrasal verb \'look into\' (to investigate) বসে।',
                'options' => [
                    ['A', 'after', false],
                    ['B', 'on', false],
                    ['C', 'up', false],
                    ['D', 'into', true],
                ],
            ],
            [
                'stem' => 'Choose the correct spelling.',
                'subject' => 'english',
                'explanation' => '<strong>ascertain</strong>: সঠিক বানান হলো A-s-c-e-r-t-a-i-n (ascertain), যার অর্থ নিশ্চিত হওয়া বা নিরূপণ করা।',
                'options' => [
                    ['A', 'ascertain', true],
                    ['B', 'assertain', false],
                    ['C', 'asertain', false],
                    ['D', 'asartain', false],
                ],
            ],
            [
                'stem' => 'Select the correct sentence.',
                'subject' => 'english',
                'explanation' => '<strong>The man who stole my bag was tall</strong>: Relative clause \'who stole my bag\' সরাসরি তার antecedent \'The man\'-এর পরে বসবে, ফলে বাক্যটি সুস্পষ্ট ও ব্যাকরণগতভাবে নিখুঁত হয়।',
                'options' => [
                    ['A', 'The man was tall who stole my bag', false],
                    ['B', 'The man stole my bag who was tall', false],
                    ['C', 'The man who stole my bag was tall', true],
                    ['D', 'The man was tall who is stealing tall my bag', false],
                ],
            ],
            [
                'stem' => 'Complete the sentence with the correct verb from: ‘Neela ––– her hand when she was cooking dinner.',
                'subject' => 'english',
                'explanation' => '<strong>burnt</strong>: যখন একটি চলমান কাজ (was cooking) চলাকালীন অন্য একটি তাৎক্ষণিক একক ঘটনা ঘটে, তখন সেই তাৎক্ষণিক ঘটনাটি Past Indefinite Tense (\'burnt\') হয়।',
                'options' => [
                    ['A', 'is burning', false],
                    ['B', 'burnt', true],
                    ['C', 'will burn', false],
                    ['D', 'was burning', false],
                ],
            ],
            [
                'stem' => 'Choose the correct preposition. The tree has been blown ––– by the storm.',
                'subject' => 'english',
                'explanation' => '<strong>away</strong>: ঝড়ে গাছ বা কোনো বস্তু উড়িয়ে বা ফেলে দেওয়া বোঝাতে \'blow away\' বা \'blow down\' বসে।',
                'options' => [
                    ['A', 'away', true],
                    ['B', 'up', false],
                    ['C', 'off', false],
                    ['D', 'out', false],
                ],
            ],
            [
                'stem' => 'Identify the correct passive form of ‘He is going to open a shop.’',
                'subject' => 'english',
                'explanation' => '<strong>A shop is going to be opened by him</strong>: \'Be going to\' যুক্ত বাক্যের passive গঠন: Object (\'A shop\') + is/are going to be + V3 (\'opened\') + by him।',
                'options' => [
                    ['A', 'He is being gone to open a shop', false],
                    ['B', 'A shop is being gone opened by him', false],
                    ['C', 'A shop will be opened by him', false],
                    ['D', 'A shop is going to be opened by him', true],
                ],
            ],
            [
                'stem' => 'Identify the correct synonym for the word ‘Magnanimous.’',
                'subject' => 'english',
                'explanation' => '<strong>generous</strong>: \'Magnanimous\' শব্দের অর্থ উদারমনা বা মহানুভব। এর সবচেয়ে কাছাকাছি সমার্থক শব্দ হলো \'generous\' বা \'noble\'।',
                'options' => [
                    ['A', 'generous', true],
                    ['B', 'unkind', false],
                    ['C', 'revengeful', false],
                    ['D', 'friendly', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank with the correct phrase: ––– your shoes before entering the mosque.',
                'subject' => 'english',
                'explanation' => '<strong>put off</strong>: পোশাক বা জুতো খুলে ফেলা বোঝাতে Phrasal Verb হিসেবে \'put off\' বা \'take off\' ব্যবহৃত হয়। পরিধান করার ক্ষেত্রে \'put on\'।',
                'options' => [
                    ['A', 'put out', false],
                    ['B', 'put off', true],
                    ['C', 'put away', false],
                    ['D', 'put on', false],
                ],
            ],
            [
                'stem' => 'Fill in the blank with the correct phrase: He ––– arrested if he had tried to leave the country.',
                'subject' => 'english',
                'explanation' => '<strong>would have been</strong>: 3rd Conditional বাক্যে passive রূপে main clause-এ \'would have been + V3\' বসে: \'would have been arrested\'।',
                'options' => [
                    ['A', 'would', false],
                    ['B', 'could be', false],
                    ['C', 'would have been', true],
                    ['D', 'must be', false],
                ],
            ],
            [
                'stem' => 'Choose the right word to fill the blank: Two of the children have to sleep in one bed, but the other three have ––– ones.',
                'subject' => 'english',
                'explanation' => '<strong>separate</strong>: বাকি তিনজন ভিন্ন ভিন্ন বা পৃথক বিছানায় ঘুমাতে পারে বোঝাতে \'separate ones\' (পৃথক/আলাদা বিছানা) উপযুক্ত বিশেষণ।',
                'options' => [
                    ['A', 'different', false],
                    ['B', 'separate', true],
                    ['C', 'complete', false],
                    ['D', 'lonely', false],
                ],
            ],
            [
                'stem' => 'Choose the right word to fill the blank: The Democratic party’s candidate ––– defeat in the small hours of the morning.',
                'subject' => 'english',
                'explanation' => '<strong>accepted</strong>: নির্বাচনে পরাজয় মেনে নেওয়া বা স্বীকার করে নেওয়ার ক্ষেত্রে প্রাকৃতিক ও উপযুক্ত ক্রিয়াপদ হলো \'accepted defeat\' (বা conceded defeat)।',
                'options' => [
                    ['A', 'consented', false],
                    ['B', 'agreed', false],
                    ['C', 'accepted', true],
                    ['D', 'granted', false],
                ],
            ],
            [
                'stem' => 'The proper function of the press is surely to ––– the man in the street with facts.',
                'subject' => 'english',
                'explanation' => '<strong>provide</strong>: কাউকে তথ্য সরবরাহ করার ক্ষেত্রে গঠন হলো \'provide someone with something\'। অতএব \'provide the man in the street with facts\' সম্পূর্ণ নির্ভুল।',
                'options' => [
                    ['A', 'equip', false],
                    ['B', 'deliver', false],
                    ['C', 'proffer', false],
                    ['D', 'provide', true],
                ],
            ],
            [
                'stem' => 'Choose the right word to fill the blank: Since his retirement, Mr. Chowdhury, who was ––– a teacher, has written four novels.',
                'subject' => 'english',
                'explanation' => '<strong>formerly</strong>: পূর্বে শিক্ষক ছিলেন বোঝাতে \'formerly\' (আগে/এককালে) শব্দটি ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'usually', false],
                    ['B', 'presently', false],
                    ['C', 'already', false],
                    ['D', 'formerly', true],
                ],
            ],
            [
                'stem' => 'Choose the right word to fill the blank: I should appreciate it if you could complete this work –––Thursday.',
                'subject' => 'english',
                'explanation' => '<strong>by</strong>: কোনো নির্দিষ্ট সময়সীমার মধ্যে বা তার পূর্বেই কাজ সম্পন্ন করা বোঝাতে \'by Thursday\' (বৃহস্পতিবারের মধ্যে) বসে।',
                'options' => [
                    ['A', 'till', false],
                    ['B', 'untill', false],
                    ['C', 'upto', false],
                    ['D', 'by', true],
                ],
            ],
            [
                'stem' => 'Choose the right word to fill the blank: It will be your task to make sure the ––– of traffic is maintained without interruption.',
                'subject' => 'english',
                'explanation' => '<strong>flow</strong>: যানবাহনের নিরবচ্ছিন্ন স্বাভাবিক গতিশীলতা বোঝাতে উপযুক্ত ইংরেজি শব্দ হলো \'flow of traffic\'।',
                'options' => [
                    ['A', 'circulation', false],
                    ['B', 'flow', true],
                    ['C', 'current', false],
                    ['D', 'procession', false],
                ],
            ],
            [
                'stem' => '‘Paediatric’ relates to the treatment of:',
                'subject' => 'english',
                'explanation' => '<strong>Children</strong>: \'Paediatrics\' হলো চিকিৎসা বিজ্ঞানের যে শাখায় শিশুদের (Children) রোগ ও স্বাস্থ্যসেবা নিয়ে আলোচনা করা হয়।',
                'options' => [
                    ['A', 'Adults', false],
                    ['B', 'Children', true],
                    ['C', 'Women', false],
                    ['D', 'Old people', false],
                ],
            ],
            [
                'stem' => 'The word ‘ecological’ is related to –––:',
                'subject' => 'english',
                'explanation' => '<strong>Environment</strong>: \'Ecological\' শব্দটি জীব ও তার পরিবেশের (Environment) আন্তঃসম্পর্ককে নির্দেশ করে।',
                'options' => [
                    ['A', 'Demography', false],
                    ['B', 'Pollution', false],
                    ['C', 'Atmosphere', false],
                    ['D', 'Environment', true],
                ],
            ],
            [
                'stem' => 'The correct spelling is ––',
                'subject' => 'english',
                'explanation' => '<strong>Humorous</strong>: শব্দটির সঠিক বানান H-u-m-o-r-o-u-s (Humorous), যার অর্থ রসাত্মক বা আমোদজনক।',
                'options' => [
                    ['A', 'Humorious', false],
                    ['B', 'Humorous', true],
                    ['C', 'Humorius', false],
                    ['D', 'Humurious', false],
                ],
            ],
            [
                'stem' => 'A ‘pilgrim’ is a person who undertakes a journey to a –––.',
                'subject' => 'english',
                'explanation' => '<strong>Holy place</strong>: \'Pilgrim\' (তীর্থযাত্রী) হলো সেই ব্যক্তি যিনি কোনো পবিত্র ধর্মীয় স্থান (holy place) দর্শনে যাত্রা করেন।',
                'options' => [
                    ['A', 'Mosque', false],
                    ['B', 'A new country', false],
                    ['C', 'Holy place', true],
                    ['D', 'Bazar', false],
                ],
            ],
            [
                'stem' => 'A person who writes about his own life writes –––.',
                'subject' => 'english',
                'explanation' => '<strong>An autobiography</strong>: কোনো লেখক যখন নিজের জীবনের কাহিনী নিজেই লেখেন, তখন তাকে \'autobiography\' (আত্মজীবনী) বলা হয়।',
                'options' => [
                    ['A', 'A biography', false],
                    ['B', 'A diary', false],
                    ['C', 'A chronicle', false],
                    ['D', 'An autobiography', true],
                ],
            ],
            [
                'stem' => 'What is the meaning of ‘White Elephant’?',
                'subject' => 'english',
                'explanation' => '<strong>A very costly or troublesome possession</strong>: \'White Elephant\' ইডিয়মটির অর্থ এমন কোনো সম্পত্তি বা উদ্যোগ যার রক্ষণাবেক্ষণ অত্যন্ত ব্যয়বহুল কিন্তু কোনো বাস্তব উপকারে আসে না।',
                'options' => [
                    ['A', 'An elephant of white colour', false],
                    ['B', 'A hoarder', false],
                    ['C', 'A black marketer', false],
                    ['D', 'A very costly or troublesome possession', true],
                ],
            ],
            [
                'stem' => 'If we want concrete proof, we are looking for––.',
                'subject' => 'english',
                'explanation' => '<strong>Clear evidence</strong>: \'Concrete proof\' বলতে কোনো সন্দেহের অবকাশহীন সুস্পষ্ট ও বাস্তব প্রমাণ (clear and definite evidence) বোঝায়।',
                'options' => [
                    ['A', 'Building material', false],
                    ['B', 'Something to cover a path', false],
                    ['C', 'Clear evidence', true],
                    ['D', 'A cement Mixer', false],
                ],
            ],
            [
                'stem' => 'The lights have been blown-by the strong wind.',
                'subject' => 'english',
                'explanation' => '<strong>Out</strong>: বাতাসের ঝাপটায় বাতি নিভে যাওয়ার ক্ষেত্রে উপযুক্ত Phrasal Verb হলো \'blown out\'।',
                'options' => [
                    ['A', 'Out', true],
                    ['B', 'Away', false],
                    ['C', 'Up', false],
                    ['D', 'Off', false],
                ],
            ],
            [
                'stem' => 'As the sun –––, I decided to go out.',
                'subject' => 'english',
                'explanation' => '<strong>Was shining</strong>: বাইরে যাওয়ার সিদ্ধান্ত নেওয়ার মুহূর্তে সূর্য কিরণ দিচ্ছিল বোঝাতে Past Continuous Tense (\'was shining\') যথাযথ।',
                'options' => [
                    ['A', 'Has shone', false],
                    ['B', 'Shine', false],
                    ['C', 'Shines', false],
                    ['D', 'Was shining', true],
                ],
            ],
            [
                'stem' => 'Maiden speech means––',
                'subject' => 'english',
                'explanation' => '<strong>First speech</strong>: \'Maiden speech\' বলতে কোনো ব্যক্তি (বিশেষত সংসদ সদস্য) কর্তৃক প্রদত্ত জীবনের প্রথম ভাষণ (the first speech delivered by someone) বোঝায়।',
                'options' => [
                    ['A', 'Late speech', false],
                    ['B', 'Early speech', false],
                    ['C', 'Final speech', false],
                    ['D', 'First speech', true],
                ],
            ],
            [
                'stem' => '‘Out and out’ means-',
                'subject' => 'english',
                'explanation' => '<strong>Thoroughly</strong>: ইংরেজি ইডিয়ম \'out and out\' বলতে বোঝায় পুরোপুরি বা হাড়ে হাড়ে (thoroughly, completely)।',
                'options' => [
                    ['A', 'Not at all', false],
                    ['B', 'Brave', false],
                    ['C', 'Thoroughly', true],
                    ['D', 'Whole heatedly', false],
                ],
            ],
            [
                'stem' => 'He divided the money ____ the two children.',
                'subject' => 'english',
                'explanation' => '<strong>Between</strong>: দুজনের মধ্যে কোনো কিছু বণ্টন করা বোঝালে \'between\' বসে; দুইয়ের অধিকের মধ্যে বণ্টন বোঝাতে \'among\' বসে।',
                'options' => [
                    ['A', 'over', false],
                    ['B', 'In between', false],
                    ['C', 'Among', false],
                    ['D', 'Between', true],
                ],
            ],
            [
                'stem' => 'No one can ____ that he is clever.',
                'subject' => 'english',
                'explanation' => '<strong>Deny</strong>: কোনো বাস্তব সত্য বা দাবি অস্বীকার করার ক্ষেত্রে উপযুক্ত verb হলো \'deny\'।',
                'options' => [
                    ['A', 'Deny', true],
                    ['B', 'Defy', false],
                    ['C', 'Denounce', false],
                    ['D', 'Discard', false],
                ],
            ],
            [
                'stem' => 'Do not make a noise while your father ––.',
                'subject' => 'english',
                'explanation' => '<strong>Is sleeping</strong>: \'While\' যুক্ত ক্লজটি প্রধান কাজের সাথে সমসাময়িক চলমান অবস্থা নির্দেশ করে, তাই এটি Present Continuous Tense (\'is sleeping\') হবে।',
                'options' => [
                    ['A', 'Is sleeping', true],
                    ['B', 'Has slept', false],
                    ['C', 'Asleep', false],
                    ['D', 'Is being asleep', false],
                ],
            ],
            [
                'stem' => 'He gave up ––– football when he got married.',
                'subject' => 'english',
                'explanation' => '<strong>Playing</strong>: \'Give up\' (পরিত্যাগ করা) একটি Prepositional Phrase, যার পরে কোনো verb আসলে তার Gerund রূপ (verb + ing, অর্থাৎ \'playing\') বসে।',
                'options' => [
                    ['A', 'Of playing', false],
                    ['B', 'To play', false],
                    ['C', 'Playing', true],
                    ['D', 'Play', false],
                ],
            ],
            [
                'stem' => 'He has been ill ____ Friday last.',
                'subject' => 'english',
                'explanation' => '<strong>Since</strong>: নির্দিষ্ট অতীত বিন্দু বা নির্দিষ্ট বার/তারিখ থেকে কোনো কাজ বর্তমান পর্যন্ত চলমান বোঝালে (Point of time) তার পূর্বে \'since\' বসে।',
                'options' => [
                    ['A', 'From', false],
                    ['B', 'On', false],
                    ['C', 'In', false],
                    ['D', 'Since', true],
                ],
            ],
            [
                'stem' => 'ঢাকায় বাংলার রাজধানী স্থাপনের সময় মোগল সুবেদার কে ছিলেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ইসলাম খান</strong>: ১৬১০ সালে সুবেদার ইসলাম খান চিশতি বাংলার রাজধানী রাজমহল থেকে ঢাকায় স্থানান্তর করেন এবং এর নাম দেন জাহাঙ্গীরনগর।',
                'options' => [
                    ['A', 'ইসলাম খান', true],
                    ['B', 'ইব্রাহীম খান', false],
                    ['C', 'শায়েস্তা খান', false],
                    ['D', 'মীর জুমলা', false],
                ],
            ],
            [
                'stem' => 'শিক্ষা বিভাগের ট্রেনিংয়ের শীর্ষ প্রতিষ্ঠান কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নায়েম</strong>: মাধ্যমিক ও উচ্চশিক্ষা স্তরের শিক্ষকদের প্রশিক্ষণ ও শিক্ষা প্রশাসনের শীর্ষ জাতীয় প্রতিষ্ঠান হলো নায়েম (National Academy for Educational Management - NAEM)।',
                'options' => [
                    ['A', 'বিয়াম', false],
                    ['B', 'নায়েম', true],
                    ['C', 'টিটিসি', false],
                    ['D', 'ইউজিসি', false],
                ],
            ],
            [
                'stem' => '‘সাবাশ বাংলাদেশ’ ভাস্কর্যটির শিল্পী কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নিতুন কুণ্ডু</strong>: রাজশাহী বিশ্ববিদ্যালয় প্রাঙ্গণে অবস্থিত মুক্তিযুদ্ধের অনন্য ভাস্কর্য ‘সাবাশ বাংলাদেশ’-এর শিল্পী হলেন প্রখ্যাত ভাস্কর নিতুন কুণ্ডু।',
                'options' => [
                    ['A', 'হামিদুজ্জামান', false],
                    ['B', 'নিতুন কুণ্ডু', true],
                    ['C', 'মৃণাল হক', false],
                    ['D', 'শামীম শিকদার', false],
                ],
            ],
            [
                'stem' => '‘সূর্য দীঘল বাড়ি’ চলচ্চিত্রের পরিচালক কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>শেখ নিয়ামত শাকের</strong>: আবু ইসহাকের উপন্যাস অবলম্বনে নির্মিত বিখ্যাত মুক্তিযুদ্ধোত্তর বাস্তববাদী চলচ্চিত্র ‘সূর্য দীঘল বাড়ি’ (১৯৭৯)-র যৌথ পরিচালক ছিলেন শেখ নিয়ামত আলী ও মসিহউদ্দিন শাকের।',
                'options' => [
                    ['A', 'শেখ নিয়ামত শাকের', true],
                    ['B', 'জহির রায়হান', false],
                    ['C', 'সুভাষ দত্ত', false],
                    ['D', 'খান আতা', false],
                ],
            ],
            [
                'stem' => 'স্টক শেয়ারে প্রবর্তিত নতুন পদ্ধতি কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ডিম্যাট</strong>: স্টক এক্সচেঞ্জে কাগুজে শেয়ার সার্টিফিকেটের বদলে ইলেকট্রনিক পদ্ধতিতে শেয়ার সংরক্ষণ ও লেনদেনের আধুনিক ব্যবস্থাকে ডিম্যাটেরিয়ালাইজেশন বা সংক্ষেপে ডিম্যাট (Demat) বলা হয়।',
                'options' => [
                    ['A', 'ডিভিডেন্ড', false],
                    ['B', 'ডিভ্যালু', false],
                    ['C', 'ডিম্যাট', true],
                    ['D', 'ডিসকাউন্ট', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে চিনি শিল্পের ট্রেনিং ইনস্টিটিউট কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ঈশ্বরদী</strong>: পাবনা জেলার ঈশ্বরদীতে বাংলাদেশ সুগারক্রপ গবেষণা ইনস্টিটিউট ও চিনি শিল্পের কারিগরি প্রশিক্ষণ ইনস্টিটিউট অবস্থিত।',
                'options' => [
                    ['A', 'দিনাজপুর', false],
                    ['B', 'রংপুর', false],
                    ['C', 'ঈশ্বরদী', true],
                    ['D', 'যশোর', false],
                ],
            ],
            [
                'stem' => 'মানবাধিকার দিবস পালিত হয় কবে?',
                'subject' => 'international',
                'explanation' => '<strong>১০ ডিসেম্বর</strong>: ১৯৪৮ সালের ১০ ডিসেম্বর জাতিসংঘ সাধারণ পরিষদে ঐতিহাসিক সার্বজনীন মানবাধিকার ঘোষণা (UDHR) গৃহীত হওয়ার স্মরণে প্রতি বছর ১০ ডিসেম্বর আন্তর্জাতিক মানবাধিকার দিবস পালিত হয়।',
                'options' => [
                    ['A', '২৬ জুন', false],
                    ['B', '১ আগস্ট', false],
                    ['C', '১ মে', false],
                    ['D', '১০ ডিসেম্বর', true],
                ],
            ],
            [
                'stem' => 'শহীদ চান্দু স্টেডিয়াম কোন শহরে অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বগুড়া</strong>: বগুড়া শহরে অবস্থিত শহীদ চান্দু স্টেডিয়াম আন্তর্জাতিক ক্রিকেট ম্যাচ আয়োজনের সুযোগপ্রাপ্ত অন্যতম দৃষ্টিনন্দন ক্রিকেট ভেন্যু।',
                'options' => [
                    ['A', 'রাজশাহী', false],
                    ['B', 'বগুড়া', true],
                    ['C', 'কুমিল্লা', false],
                    ['D', 'চট্টগ্রাম', false],
                ],
            ],
            [
                'stem' => 'বাংলা একাডেমির প্রথম মহাপরিচালক কে ছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>ড. মযহারুল ইসলাম</strong>: বাংলা একাডেমির প্রথম পরিচালক ছিলেন ড. মুহাম্মদ এনামুল হক (১৯৫৬)। পরবর্তীতে পদমর্যাদা উন্নীত করে মহাপরিচালক (DG) করা হলে প্রথম মহাপরিচালক নিযুক্ত হন ফোকলোরবিদ ড. মযহারুল ইসলাম (১৯৭২)।',
                'options' => [
                    ['A', 'প্রফেসর আব্দুল হাই', false],
                    ['B', 'ড. মুহম্মদ শহীদুল্লাহ্', false],
                    ['C', 'কাজী মোতাহার হোসেন', false],
                    ['D', 'ড. মযহারুল ইসলাম', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের সর্ববৃহৎ ঈদের জামাত সাধারণত কোথায় হয়ে থাকে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>শোলাকিয়া-কিশোরগঞ্জ</strong>: ঐতিহাসিক কিশোরগঞ্জের শোলাকিয়া ময়দান ঐতিহ্যগতভাবে দেশের সর্ববৃহৎ ঈদের জামাতের জন্য পরিচিত (বর্তমানে দিনাজপুরের গোর-এ-শহীদ ময়দানেও বিশাল জামাত অনুষ্ঠিত হয়)।',
                'options' => [
                    ['A', 'বায়তুল মোকাররম-ঢাকা', false],
                    ['B', 'শাহ মখদুম মসজিদ-রাজশাহী', false],
                    ['C', 'জাতীয় ঈদগাহ-ঢাকা', false],
                    ['D', 'শোলাকিয়া-কিশোরগঞ্জ', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের জিডিপিতে কৃষিখাতের অবদান কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১১.০২% (অর্থনৈতিক সমীক্ষা ২০২৪)</strong>: ঐতিহাসিক বিসিএস পরীক্ষার সময়ে কৃষির অবদান অনেক বেশি হলেও অর্থনৈতিক সমীক্ষা ২০২৪ অনুযায়ী বর্তমানে বাংলাদেশের জিডিপিতে কৃষিখাতের অবদান ১১.০২%।',
                'options' => [
                    ['A', '৭০ শতাংশ', false],
                    ['B', '৭৩ শতাংশ', false],
                    ['C', '৭৫ শতাংশ', true],
                    ['D', '৭৭ শতাংশ', false],
                ],
            ],
            [
                'stem' => 'দক্ষিণ তালপট্টি দ্বীপ কোন নদীর মোহনায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>হাড়িয়াভাঙ্গা</strong>: ভারত ও বাংলাদেশের সীমানা নদী হাড়িয়াভাঙ্গার মোহনায় বঙ্গোপসাগরে অবস্থিত ছিল অধুনালুপ্ত দক্ষিণ তালপট্টি দ্বীপ (ভারতে নিউ মুর দ্বীপ নামে পরিচিত)।',
                'options' => [
                    ['A', 'রূপসা', false],
                    ['B', 'বালেশ্বর', false],
                    ['C', 'হাড়িয়াভাঙ্গা', true],
                    ['D', 'ভৈরব', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে মোট আবাদযোগ্য জমির পরিমাণ কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২ কোটি একর (প্রায় ৮৮.২৯ লক্ষ হেক্টর)</strong>: বাংলাদেশ পরিসংখ্যান ব্যুরোর তথ্যমতে দেশে মোট আবাদযোগ্য জমির পরিমাণ প্রায় ২ কোটি একর বা প্রায় ৮৮.২৯ লক্ষ হেক্টর।',
                'options' => [
                    ['A', '২ কোটি ৪০ লক্ষ একর', false],
                    ['B', '২ কোটি ৫০ লক্ষ একর', false],
                    ['C', '২ কোটি ২৫ লক্ষ একর', false],
                    ['D', '২ কোটি একর', true],
                ],
            ],
            [
                'stem' => 'বাংলা নববর্ষ পহেলা বৈশাখ চালু করেছিলেন-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সম্রাট আকবর</strong>: ফসলি সনের সংস্কার করে খাজনা আদায় সহজতর করতে মুঘল সম্রাট আকবর ১৫৮৪ সালে পহেলা বৈশাখ কেন্দ্রিক সৌরভিত্তিক বাংলা সনের আনুষ্ঠানিক প্রবর্তন করেন।',
                'options' => [
                    ['A', 'ইলিয়াস শাহ', false],
                    ['B', 'ফখরুদ্দিন মোবারক শাহ', false],
                    ['C', 'সম্রাট আকবর', true],
                    ['D', 'সম্রাট বাবর', false],
                ],
            ],
            [
                'stem' => '‘কান্তজী মন্দির’ কোন জেলায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>দিনাজপুর</strong>: দিনাজপুর জেলার কাহারোল উপজেলায় ঢেঁপা নদীর তীরে অবস্থিত অষ্টাদশ শতকের অপূর্ব পোড়ামাটির টেরাকোটা অলংকরণে সমৃদ্ধ ঐতিহাসিক মন্দির হলো কান্তজী বা কান্তনগর মন্দির।',
                'options' => [
                    ['A', 'জয়পুরহাট', false],
                    ['B', 'কুমিল্লা', false],
                    ['C', 'রাঙামাটি', false],
                    ['D', 'দিনাজপুর', true],
                ],
            ],
            [
                'stem' => 'মহাখালী ফ্লাইওভারে কয়টি স্প্যান আছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯ টি</strong>: ২০০৪ সালে নির্মিত ঢাকা শহরের প্রথম আধুনিক ফ্লাইওভার মহাখালী ফ্লাইওভারে মোট ১৯টি স্প্যান রয়েছে।',
                'options' => [
                    ['A', '১৭ টি', false],
                    ['B', '১৮ টি', false],
                    ['C', '১৯ টি', true],
                    ['D', '২১ টি', false],
                ],
            ],
            [
                'stem' => 'চলতি আর্থিক বাজেটে কৃষিতে ভর্তুকি কত টাকা ধরা হয়েছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৬০০ কোটি টাকা (তৎকালীন)</strong>: ২৬তম বিসিএস পরীক্ষার সমসাময়িক জাতীয় বাজেটে কৃষিতে ৬০০ কোটি টাকা ভর্তুকি বরাদ্দ ছিল (যা সাম্প্রতিক বাজেটে ১৭ হাজার কোটি টাকার উপরে)।',
                'options' => [
                    ['A', '৩০০ কোটি টাকা', false],
                    ['B', '৪০০ কোটি টাকা', false],
                    ['C', '৫০০ কোটি টাকা', false],
                    ['D', '৬০০ কোটি টাকা', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের সীমান্তবর্তী কোন জেলার সাথে ভারতের কোন সংযোগ নেই?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বান্দরবান</strong>: বান্দরবান পার্বত্য জেলার সীমানা কেবল মিয়ানমারের সাথে সংযুক্ত, এর সাথে ভারতের কোনো সীমান্ত সংযোগ নেই।',
                'options' => [
                    ['A', 'বান্দরবান', true],
                    ['B', 'চাঁপাইনবাবগঞ্জ', false],
                    ['C', 'পঞ্চগড়', false],
                    ['D', 'দিনাজপুর', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের একমাত্র মৎস্য গবেষণা ইনস্টিটিউট কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ময়মনসিংহ</strong>: বাংলাদেশ মৎস্য গবেষণা ইনস্টিটিউট (BFRI)-এর মূল সদর দপ্তর ও গবেষণা কেন্দ্র ময়মনসিংহে বাংলাদেশ কৃষি বিশ্ববিদ্যালয় ক্যাম্পাস সংলগ্ন এলাকায় অবস্থিত।',
                'options' => [
                    ['A', 'রাজশাহী', false],
                    ['B', 'ঢাকা', false],
                    ['C', 'চট্টগ্রাম', false],
                    ['D', 'চাঁদপুর', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের একমাত্র পাহাড়ি দ্বীপ কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মহেশখালী</strong>: কক্সবাজার জেলায় অবস্থিত আদিনাথ মন্দির খ্যাত মহেশখালী দ্বীপ হলো বাংলাদেশের একমাত্র পাহাড়ি বৈশিষ্ট্যমণ্ডিত সাগর দ্বীপ।',
                'options' => [
                    ['A', 'সেন্টমার্টিন', false],
                    ['B', 'মহেশখালী', true],
                    ['C', 'ছেঁড়া দ্বীপ', false],
                    ['D', 'নিঝুম দ্বীপ', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে সর্বপ্রথম ডিজিটাল টেলিফোন ব্যবস্থা কবে চালু হয়?',
                'subject' => 'science',
                'explanation' => '<strong>৪ জানুয়ারি, ১৯৯০</strong>: বাংলাদেশে প্রথমবারের মতো ডিজিটাল টেলিফোন এক্সচেঞ্জ ও নেটওয়ার্ক ১৯৯০ সালের ৪ জানুয়ারি ঢাকায় উদ্বোধন করা হয়।',
                'options' => [
                    ['A', '৪ জানুয়ারি, ১৯৯০', true],
                    ['B', '৩ ফেব্রুয়ারি, ১৯৯০', false],
                    ['C', '৩ মার্চ, ১৯৯০', false],
                    ['D', '৪ জানুয়ারি, ১৯৯১', false],
                ],
            ],
            [
                'stem' => 'সংবিধানের কোন অনুচ্ছেদ অনুযায়ী বাংলাদেশের নাগরিকগণ বাংলাদেশী বলে পরিচিত হবেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৬ (২)</strong>: বাংলাদেশ সংবিধানের ৬(২) অনুচ্ছেদে বর্ণিত রয়েছে— \'বাংলাদেশের জনগণ জাতি হিসাবে বাঙালী এবং নাগরিকগণ বাংলাদেশী বলিয়া পরিচিত হইবেন।\' (পঞ্চদশ সংশোধনীর পর)।',
                'options' => [
                    ['A', '৬ (১)', false],
                    ['B', '৬ (২)', true],
                    ['C', '৭', false],
                    ['D', '৮', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ OIC-এর সদস্য হয় কোন সনে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৭৪</strong>: জাতির পিতা বঙ্গবন্ধু শেখ মুজিবুর রহমানের নেতৃত্বে ১৯৭৪ সালের ফেব্রুয়ারিতে লাহোরে অনুষ্ঠিত দ্বিতীয় শীর্ষ সম্মেলনে বাংলাদেশ আনুষ্ঠানিকভাবে ইসলামিক সহযোগিতা সংস্থার (OIC) সদস্যপদ লাভ করে।',
                'options' => [
                    ['A', '১৯৭৩', false],
                    ['B', '১৯৭৪', true],
                    ['C', '১৯৭৫', false],
                    ['D', '১৯৭৬', false],
                ],
            ],
            [
                'stem' => 'কতজন ব্যক্তি নিয়ে গ্রাম সরকার গঠিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৫ জন</strong>: ২০০৩ সালের গ্রাম সরকার আইন অনুযায়ী একজন গ্রাম প্রধান এবং ১৪ জন সদস্যসহ সর্বমোট ১৫ সদস্য বিশিষ্ট গ্রাম সরকার কাঠামোর বিধান রাখা হয়েছিল (পরবর্তীতে আদালত কর্তৃক এটি অবৈধ ঘোষিত হয়)।',
                'options' => [
                    ['A', '৯ জন', false],
                    ['B', '১১ জন', false],
                    ['C', '১৩ জন', false],
                    ['D', '১৫ জন', true],
                ],
            ],
            [
                'stem' => 'মুক্তিযুদ্ধ বিষয়ক মন্ত্রণালয় কোন সনে গঠিত হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>২০০১ সনে</strong>: মুক্তিযোদ্ধাদের কল্যাণ, স্মৃতি সংরক্ষণ ও মুক্তিযুদ্ধবিষয়ক কার্যক্রম সমন্বয়ের লক্ষ্যে ২০০১ সালের ২৩ অক্টোবর মুক্তিযুদ্ধ বিষয়ক মন্ত্রণালয় প্রতিষ্ঠা করা হয়।',
                'options' => [
                    ['A', '১৯৯২ সনে', false],
                    ['B', '২০০০ সনে', false],
                    ['C', '২০০১ সনে', true],
                    ['D', '২০০২ সনে', false],
                ],
            ],
            [
                'stem' => 'ভারতের সাথে বাংলাদেশের সীমান্ত জেলা কয়টি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৩০</strong>: বাংলাদেশের সীমান্তবর্তী জেলা মোট ৩২টি; এর মধ্যে ভারতের সাথে সীমান্ত রয়েছে ৩০টি জেলার (মিয়ানমারের সাথে ৩টি, যার মধ্যে রাঙ্গামাটি উভয় দেশের সীমান্তেই পড়েছে)।',
                'options' => [
                    ['A', '২৮', false],
                    ['B', '৩০', true],
                    ['C', '৩১', false],
                    ['D', '৩৫', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশ কোন সনে বিশ্ব বাণিজ্য সংস্থার সদস্য হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৯৫</strong>: বিশ্ব বাণিজ্য সংস্থা (WTO) প্রতিষ্ঠার প্রথম দিন অর্থাৎ ১৯৯৫ সালের ১ জানুয়ারি বাংলাদেশ এর প্রতিষ্ঠাতা সদস্য হিসেবে যোগদান করে।',
                'options' => [
                    ['A', '১৯৯১', false],
                    ['B', '১৯৯৪', false],
                    ['C', '১৯৯২', false],
                    ['D', '১৯৯৫', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের প্রথম বেসরকারি ব্যাংক কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>আরব-বাংলাদেশ ব্যাংক</strong>: ১৯৮২ সালের ১২ এপ্রিল প্রতিষ্ঠিত \'আরব-বাংলাদেশ ব্যাংক লিমিটেড\' (বর্তমানে এবি ব্যাংক পিএলসি) বাংলাদেশের প্রথম বেসরকারি বাণিজ্যিক ব্যাংক।',
                'options' => [
                    ['A', 'ন্যাশনাল ব্যাংক', false],
                    ['B', 'আরব-বাংলাদেশ ব্যাংক', true],
                    ['C', 'আইএফআইসি ব্যাংক', false],
                    ['D', 'দি সিটি ব্যাংক', false],
                ],
            ],
            [
                'stem' => 'SPARRSO কোন মন্ত্রণালয়ের অধীন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>প্রতিরক্ষা মন্ত্রণালয়</strong>: বাংলাদেশ মহাকাশ গবেষণা ও দূর অনুধাবন প্রতিষ্ঠান (SPARRSO) বাংলাদেশ সরকারের প্রতিরক্ষা মন্ত্রণালয়ের প্রশাসনিক নিয়ন্ত্রণে পরিচালিত হয়।',
                'options' => [
                    ['A', 'শিল্প মন্ত্রণালয়', false],
                    ['B', 'শিক্ষা মন্ত্রণালয়', false],
                    ['C', 'পরিবেশ মন্ত্রণালয়', false],
                    ['D', 'প্রতিরক্ষা মন্ত্রণালয়', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে রঙিন টিভি সম্প্রচার কোন সনে শুরু হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৮০</strong>: বাংলাদেশ টেলিভিশনে (BTV) ১৯৮০ সালের ১ ডিসেম্বর থেকে নিয়মিত পূর্ণাঙ্গ রঙিন অনুষ্ঠান সম্প্রচার শুরু হয়।',
                'options' => [
                    ['A', '১৯৭৯', false],
                    ['B', '১৯৮০', true],
                    ['C', '১৯৮১', false],
                    ['D', '১৯৮২', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের বৃহত্তম সেচ প্রকল্প কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>তিস্তা সেচ প্রকল্প</strong>: নীলফামারী, রংপুর ও দিনাজপুর জেলাব্যাপী বিস্তৃত তিস্তা নদীর ডালিয়া ব্যারেজ কেন্দ্রিক তিস্তা সেচ প্রকল্প হলো বাংলাদেশের সর্ববৃহৎ সেচ প্রকল্প।',
                'options' => [
                    ['A', 'গঙ্গা-কপোতাক্ষ প্রকল্প', false],
                    ['B', 'তিস্তা সেচ প্রকল্প', true],
                    ['C', 'কাপ্তাই সেচ প্রকল্প', false],
                    ['D', 'ফেনী সেচ প্রকল্প', false],
                ],
            ],
            [
                'stem' => '‘মনপুরা-৭০’ কী?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>একটি চিত্রশিল্প</strong>: ১৯৭০ সালের ১২ নভেম্বরের ভয়াবহ ঘূর্ণিঝড় ও জলোচ্ছ্বাসের মর্মান্তিক ক্ষয়ক্ষতির ওপর শিল্পাচার্য জয়নুল আবেদিন কর্তৃক অঙ্কিত বিখ্যাত ৬৫ ফুট দীর্ঘ স্ক্রল পেইন্টিং হলো ‘মনপুরা-৭০’।',
                'options' => [
                    ['A', 'একটি উপজেলা', false],
                    ['B', 'একটি নদীবন্দর', false],
                    ['C', 'একটি উপন্যাস', false],
                    ['D', 'একটি চিত্রশিল্প', true],
                ],
            ],
            [
                'stem' => 'কোন আইন সংস্কার করে ‘র‌্যাব’ (Rapid Action Battalion) গঠন করা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>আর্মড পুলিশ ব্যাটালিয়ন অ্যাক্ট ১৯৭৯</strong>: ২০০৪ সালে \'The Armed Police Battalions Ordinance, 1979\' সংশোধন করে এলিট ফোর্স হিসেবে র‍্যাপিড অ্যাকশন ব্যাটালিয়ন (RAB) গঠন করা হয়।',
                'options' => [
                    ['A', 'ডিএমপি অ্যাক্ট-১৯৭৬', false],
                    ['B', 'ডিবি পুলিশ অ্যাক্ট ১৯৮৩', false],
                    ['C', 'র‍্যাপিড একশন ব্যাটালিয়ন অ্যাক্ট ২০০৩', false],
                    ['D', 'আর্মড পুলিশ ব্যাটালিয়ন অ্যাক্ট ১৯৭৯', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের কোন প্রতিষ্ঠান মাইক্রোক্রেডিট সম্মেলনের অন্যতম উদ্যোক্তা?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>গ্রামীণ ব্যাংক</strong>: ১৯৯৭ সালে ওয়াশিংটনে অনুষ্ঠিত প্রথম বৈশ্বিক মাইক্রোক্রেডিট সামিটের অন্যতম প্রধান সংগঠক ও উদ্যোক্তা ছিল নোবেলজয়ী প্রতিষ্ঠান গ্রামীণ ব্যাংক।',
                'options' => [
                    ['A', 'চার্টার্ড ব্যাংক', false],
                    ['B', 'ন্যাশনাল ব্যাংক', false],
                    ['C', 'গ্রামীণ ব্যাংক', true],
                    ['D', 'এবি ব্যাংক', false],
                ],
            ],
            [
                'stem' => '‘ইরাটম’ কী?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>উন্নত জাতের ধান</strong>: বাংলাদেশ পরমাণু কৃষি গবেষণা ইনস্টিটিউট (BINA) উদ্ভাবিত উচ্চ ফলনশীল ও মিউটেশন জাতের আউশ/আমন ধান হলো \'ইরাটম-২৪\' ও \'ইরাটম-৩৮\'।',
                'options' => [
                    ['A', 'উন্নত জাতের ধান', true],
                    ['B', 'উন্নত জাতের ইক্ষু', false],
                    ['C', 'উন্নত জাতের পাট', false],
                    ['D', 'উন্নত জাতের চা', false],
                ],
            ],
            [
                'stem' => 'গ্রিন হাউজ ইফেক্টের জন্য বাংলাদেশে কোন ধরনের ক্ষতি হতে পারে?',
                'subject' => 'science',
                'explanation' => '<strong>নিম্নভূমি নিমজ্জিত হবে</strong>: বৈশ্বিক উষ্ণায়ন ও মেরু অঞ্চলের বরফ গলার ফলে সমুদ্রপৃষ্ঠের উচ্চতা বৃদ্ধি পেয়ে বাংলাদেশের প্রায় ১৭-২০% নিম্নাঞ্চলীয় উপকূলীয় ভূমি লবণাক্ত পানিতে নিমজ্জিত হতে পারে।',
                'options' => [
                    ['A', 'নিম্নভূমি নিমজ্জিত হবে', true],
                    ['B', 'ক্রমশ উত্তাপ বেড়ে যাবে', false],
                    ['C', 'বৃষ্টিপাত কমে যাবে', false],
                    ['D', 'বৃষ্টিপাতের পরিমাণ বাড়বে', false],
                ],
            ],
            [
                'stem' => 'বেসরকারি বিল কাকে বলে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>সংসদ সদস্যদের উত্থাপিত বিল</strong>: সংসদে সরকারের কোনো মন্ত্রী ব্যতীত অন্য যেকোনো সাধারণ সংসদ সদস্য (সরকারি দল বা বিরোধী দলের সদস্য) কর্তৃক উত্থাপিত আইন প্রস্তাবকে বেসরকারি বিল (Private Member\'s Bill) বলে।',
                'options' => [
                    ['A', 'স্পিকার যে বিলকে বেসরকারি বলে ঘোষণা দেন', false],
                    ['B', 'সংসদ সদস্যদের উত্থাপিত বিল', true],
                    ['C', 'বিরোধী দলের সদস্যদের উত্থাপিত বিল', false],
                    ['D', 'রাষ্ট্রপতি কর্তৃক ঘোষিত বিল', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে কৃষিক্ষেত্রে ‘বলাকা’ ও ‘দোয়েল’ নাম দুটি কিসের?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>উন্নতজাতের গম শস্য</strong>: বাংলাদেশে গম চাষের সম্প্রসারণে উদ্ভাবিত উচ্চ ফলনশীল জাত হলো \'বলাকা\' ও \'দোয়েল\'।',
                'options' => [
                    ['A', 'দুটি কৃষি যন্ত্রপাতির নাম', false],
                    ['B', 'দুটি কৃষি সংস্থার নাম', false],
                    ['C', 'উন্নতজাতের গম শস্য', true],
                    ['D', 'কৃষি খামারের নাম', false],
                ],
            ],
            [
                'stem' => 'প্রথম আইসিসি ট্রফিতে বাংলাদেশ দলের অধিনায়ক কে ছিলেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>শফিকুল হক হীরা</strong>: ১৯৭৯ সালে ইংল্যান্ডে অনুষ্ঠিত প্রথম আইসিসি ট্রফিতে বাংলাদেশ জাতীয় ক্রিকেট দলের নেতৃত্ব দিয়েছিলেন উইকেটরক্ষক-ব্যাটার শফিকুল হক হীরা।',
                'options' => [
                    ['A', 'গাজী আশরাফ হোসেন লিপু', false],
                    ['B', 'আকরাম খান', false],
                    ['C', 'আমিনুল ইসলাম বুলবুল', false],
                    ['D', 'শফিকুল হক হীরা', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের কোথায় সুরমা ও কুশিয়ারা নদী মিলিত হয়ে মেঘনা নাম ধারণ করেছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>আজমিরীগঞ্জ</strong>: আসামের বরাক নদী সুরমা ও কুশিয়ারা শাখায় বিভক্ত হয়ে বাংলাদেশে প্রবেশ করে হবিগঞ্জের আজমিরীগঞ্জের কাছে মিলিত হয়ে কালনী নামে এবং ভৈরবের কাছে এসে পূর্ণাঙ্গ মেঘনা নাম ধারণ করে।',
                'options' => [
                    ['A', 'ভৈরব', false],
                    ['B', 'চাঁদপুর', false],
                    ['C', 'দেওয়ানগঞ্জ', false],
                    ['D', 'আজমিরীগঞ্জ', true],
                ],
            ],
            [
                'stem' => 'নাসাউ কোন দেশটির রাজধানী?',
                'subject' => 'international',
                'explanation' => '<strong>বাহামা দ্বীপপুঞ্জ</strong>: আটলান্টিক মহাসাগরের ক্যারিবীয় অঞ্চলের দ্বীপরাষ্ট্র বাহামা দ্বীপপুঞ্জের (Bahamas) রাজধানী ও বৃহত্তম নগরী হলো নাসাউ (Nassau)।',
                'options' => [
                    ['A', 'নিকোবর দ্বীপপুঞ্জ', false],
                    ['B', 'মাদাগাস্কার দ্বীপপুঞ্জ', false],
                    ['C', 'বাহামা দ্বীপপুঞ্জ', true],
                    ['D', 'ফিজি দ্বীপপুঞ্জ', false],
                ],
            ],
            [
                'stem' => 'জাপানের পার্লামেন্টের নাম কী?',
                'subject' => 'international',
                'explanation' => '<strong>ডায়েট</strong>: জাপানের দ্বিকক্ষ বিশিষ্ট আইনসভা বা পার্লামেন্টকে আনুষ্ঠানিকভাবে \'জাতীয় ডায়েট\' (National Diet / Kokkai) বলা হয়।',
                'options' => [
                    ['A', 'রাইখস্ট্যাগ', false],
                    ['B', 'রিকসড্যাগ', false],
                    ['C', 'ফোকেটিং', false],
                    ['D', 'ডায়েট', true],
                ],
            ],
            [
                'stem' => 'শান্তির জন্য প্রথম কোন মহিলা নোবেল পুরস্কার পান?',
                'subject' => 'international',
                'explanation' => '<strong>মাদার তেরেসা (অপশনের মধ্যে) / বার্থাভন সুটনার</strong>: শান্তিতে প্রথম নারী নোবেল বিজয়ী ব্যারনেস বার্থা ফন সুটনার (১৯০৫, অস্ট্রিয়া)। অপশনের ৪ জনের মধ্যে প্রথম নোবেল শান্তি পুরস্কার লাভ করেন মাদার তেরেসা (১৯৭৯)।',
                'options' => [
                    ['A', 'আলভা মায়ারডাল', false],
                    ['B', 'অংসান সুচি', false],
                    ['C', 'শিরিন এবাদি', false],
                    ['D', 'মাদার তেরেসা', true],
                ],
            ],
            [
                'stem' => 'আটলান্টিক সনদে যুক্তরাষ্ট্র এবং ব্রিটিশের পক্ষে স্বাক্ষর করেন কে কে?',
                'subject' => 'international',
                'explanation' => '<strong>ফ্রাঙ্কলিন ডি রুজভেল্ট ও উইনস্টন চার্চিল</strong>: দ্বিতীয় বিশ্বযুদ্ধ চলাকালে ১৯৪১ সালের ১৪ আগস্ট মার্কিন প্রেসিডেন্ট ফ্রাঙ্কলিন ডি. রুজভেল্ট এবং ব্রিটিশ প্রধানমন্ত্রী উইনস্টন চার্চিল যুদ্ধোত্তর শান্তির রূপরেখা হিসেবে ঐতিহাসিক আটলান্টিক সনদে স্বাক্ষর করেন।',
                'options' => [
                    ['A', 'রোনাল্ড রিগ্যান ও মার্গারেট থেচার', false],
                    ['B', 'জর্জ ডব্লিউ বুশ ও টনি ব্লেয়ার', false],
                    ['C', 'জিমি কার্টার ও রানী দ্বিতীয় এলিজাবেথ', false],
                    ['D', 'ফ্রাঙ্কলিন ডি রুজভেল্ট ও উইনস্টন চার্চিল', true],
                ],
            ],
            [
                'stem' => 'গ্রিনপিস (Green peace) কোন দেশের পরিবেশবাদী গ্রুপ?',
                'subject' => 'international',
                'explanation' => '<strong>হল্যান্ড</strong>: আন্তর্জাতিক পরিবেশবাদী আন্দোলন সংস্থা গ্রিনপিস ১৯৭১ সালে কানাডায় সূচিত হলেও এর আন্তর্জাতিক প্রধান কার্যালয় নেদারল্যান্ডসের (হল্যান্ড) রাজধানী আমস্টারডামে অবস্থিত।',
                'options' => [
                    ['A', 'হল্যান্ড', true],
                    ['B', 'পোল্যান্ড', false],
                    ['C', 'ফিনল্যান্ড', false],
                    ['D', 'নিউজিল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'ব্রিটেনের রানী কোন দেশটির সাংবিধানিক রাষ্ট্রপ্রধান নন?',
                'subject' => 'international',
                'explanation' => '<strong>ফিজি</strong>: ফিজি ১৯৮৭ সালে সামরিক অভ্যুত্থানের পর প্রজাতন্ত্র ঘোষিত হয়ে ব্রিটিশ রাজতন্ত্র থেকে বের হয়ে আসে, তাই রানী বা রাজা ফিজির রাষ্ট্রপ্রধান নন।',
                'options' => [
                    ['A', 'ফিজি', true],
                    ['B', 'কানাডা', false],
                    ['C', 'অস্ট্রিয়া', false],
                    ['D', 'অস্ট্রেলিয়া', false],
                ],
            ],
            [
                'stem' => 'ফ্রান্সের মহান সম্রাট নেপোলিয়নের জীবনাবসান হয় কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>সেন্ট হেলেনা দ্বীপে</strong>: ওয়াটারলু যুদ্ধে চূড়ান্ত পরাজয়ের পর ব্রিটিশরা ফরাসি সম্রাট নেপোলিয়ন বোনাপার্টকে দক্ষিণ আটলান্টিক মহাসাগরের প্রত্যন্ত সেন্ট হেলেনা দ্বীপে নির্বাসিত করে, যেখানে ১৮২১ সালের ৫ মে তাঁর জীবনাবসান ঘটে।',
                'options' => [
                    ['A', 'ওয়াটার লু নামক স্থানে', false],
                    ['B', 'দ্বীপ এলনাবার্তে', false],
                    ['C', 'ভার্সাই নগরীতে', false],
                    ['D', 'সেন্ট হেলেনা দ্বীপে', true],
                ],
            ],
            [
                'stem' => 'গারুদা কোন দেশের বিমান সংস্থা?',
                'subject' => 'international',
                'explanation' => '<strong>ইন্দোনেশিয়া</strong>: গারুদা ইন্দোনেশিয়া (Garuda Indonesia) হলো দক্ষিণ-পূর্ব এশিয়ার দেশ ইন্দোনেশিয়ার জাতীয় পতাকাবাহী বিমান সংস্থা।',
                'options' => [
                    ['A', 'গ্রিস', false],
                    ['B', 'জার্মানি', false],
                    ['C', 'ইন্দোনেশিয়া', true],
                    ['D', 'নেদারল্যান্ডস', false],
                ],
            ],
            [
                'stem' => 'কোনটি ভারতের সেভেন সিস্টারস রাজ্যসমূহের অন্তর্ভুক্ত নয়?',
                'subject' => 'international',
                'explanation' => '<strong>কেরালা</strong>: উত্তর-পূর্ব ভারতের সাতটি রাজ্য (আসাম, মেঘালয়, ত্রিপুরা, মিজোরাম, মনিপুর, নাগাল্যান্ড ও অরুণাচল)-কে \'সেভেন সিস্টার্স\' বলা হয়। কেরালা হলো দক্ষিণ ভারতের একটি রাজ্য।',
                'options' => [
                    ['A', 'কেরালা', true],
                    ['B', 'ত্রিপুরা', false],
                    ['C', 'মণিপুর', false],
                    ['D', 'মিজোরাম', false],
                ],
            ],
            [
                'stem' => 'ফিলিস্তিনের প্রেসিডেন্ট ইয়াসির আরাফাত-এর আনুষ্ঠানিক অন্ত্যোষ্টিক্রিয়া অনুষ্ঠানে যোগদানের জন্য বিশ্বের বিভিন্ন দেশের রাষ্ট্রপ্রধান/ সরকারপ্রধানগণ কোথায় মিলিত হন?',
                'subject' => 'international',
                'explanation' => '<strong>কায়রো</strong>: ২০০৪ সালের ১১ নভেম্বর প্যারিসে চিকিৎসাধীন অবস্থায় ইয়াসির আরাফাত মৃত্যুবরণ করলে ১২ নভেম্বর মিশরের রাজধানী কায়রোতে বিশ্বনেতাদের উপস্থিতিতে তাঁর আনুষ্ঠানিক রাষ্ট্রীয় অন্ত্যেষ্টিক্রিয়া অনুষ্ঠিত হয়।',
                'options' => [
                    ['A', 'রামাল্লা', false],
                    ['B', 'প্যারিস', false],
                    ['C', 'কায়রো', true],
                    ['D', 'জেরুজালেম', false],
                ],
            ],
            [
                'stem' => 'United Nations Conference on Trade and Development (UNCTAD)-এর সদর দপ্তর কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>জেনেভায়</strong>: ১৯৬৪ সালে প্রতিষ্ঠিত জাতিসংঘের বাণিজ্য ও উন্নয়ন বিষয়ক সংস্থা আঙ্কটাড (UNCTAD)-এর মূল সদর দপ্তর সুইজারল্যান্ডের জেনেভায় অবস্থিত।',
                'options' => [
                    ['A', 'হেগে', false],
                    ['B', 'জেনেভায়', true],
                    ['C', 'নিউইয়র্কে', false],
                    ['D', 'ক্যানবেরায়', false],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্রের প্রেসিডেন্ট নির্বাচিত হতে হলে ন্যূনতম কত ইলেক্ট্রোরাল ভোটের প্রয়োজন?',
                'subject' => 'international',
                'explanation' => '<strong>২৭০</strong>: মার্কিন যুক্তরাষ্ট্রের মোট ৫৩৮টি ইলেক্টোরাল কলেজ ভোটের মধ্যে সাধারণ সংখ্যাগরিষ্ঠতা হিসেবে অন্তত ২৭০টি ইলেক্টোরাল ভোট পেলে কোনো প্রার্থী প্রেসিডেন্ট নির্বাচিত হন।',
                'options' => [
                    ['A', '২৭২', false],
                    ['B', '২৭১', false],
                    ['C', '২৭০', true],
                    ['D', '২৬৮', false],
                ],
            ],
            [
                'stem' => 'ইন্টারপোলের সদর দপ্তর কোথায় অবস্থিত?',
                'subject' => 'international',
                'explanation' => '<strong>লিওঁ</strong>: আন্তর্জাতিক পুলিশ সংস্থা ইন্টারপোল (INTERPOL)-এর বৈশ্বিক প্রধান কার্যালয় ফ্রান্সের লিওঁ (Lyon) নগরীতে অবস্থিত।',
                'options' => [
                    ['A', 'লন্ডন', false],
                    ['B', 'লিওঁ', true],
                    ['C', 'রোম', false],
                    ['D', 'প্যারিস', false],
                ],
            ],
            [
                'stem' => 'ফিলিস্তিনিদের মাতৃভূমিতে কখন ইসরাইল রাষ্ট্র প্রতিষ্ঠিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৪৮</strong>: ব্রিটিশ ম্যান্ডেট অবসানের পরপরই ডেভিড বেন-গুরিয়নের ঘোষণায় ১৯৪৮ সালের ১৪ মে ফিলিস্তিন ভূখণ্ডে ইহুদি রাষ্ট্র ইসরাইল আনুষ্ঠানিকভাবে প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৪৮', true],
                    ['B', '১৯৫০', false],
                    ['C', '১৯৬৭', false],
                    ['D', '১৯৭০', false],
                ],
            ],
            [
                'stem' => 'পশ্চিম তিমুর-এর বর্তমান মর্যাদা কি?',
                'subject' => 'international',
                'explanation' => '<strong>ইন্দোনেশিয়ার একটি অঙ্গরাজ্য</strong>: তিমুর দ্বীপের পূর্ব অংশ ২০০২ সালে স্বাধীন পূর্ব তিমুর (তিমুর-লেস্তে) রাষ্ট্র হলেও পশ্চিম তিমুর ইন্দোনেশিয়ার পূর্ব নুসা টেঙ্গারা প্রদেশের একটি অবিচ্ছেদ্য অংশ।',
                'options' => [
                    ['A', 'ইন্দোনেশিয়ার একটি অঙ্গরাজ্য', true],
                    ['B', 'একটি স্বাধীন দেশ', false],
                    ['C', 'অস্ট্রেলিয়ার একটি প্রদেশ', false],
                    ['D', 'কোনোটিই সঠিক নয়', false],
                ],
            ],
            [
                'stem' => 'কফি আনান আফ্রিকা মহাদেশ থেকে নিয়োগকৃত জাতিসংঘের কততম মহাসচিব?',
                'subject' => 'international',
                'explanation' => '<strong>দ্বিতীয়</strong>: ঘানার নাগরিক কফি আনান আফ্রিকা মহাদেশ থেকে নির্বাচিত দ্বিতীয় জাতিসংঘ মহাসচিব (প্রথম আফ্রিকান মহাসচিব ছিলেন মিশরের বুত্রোস বুত্রোস-ঘালি)।',
                'options' => [
                    ['A', 'প্রথম', false],
                    ['B', 'তৃতীয়', false],
                    ['C', 'দ্বিতীয়', true],
                    ['D', 'চতুর্থ', false],
                ],
            ],
            [
                'stem' => 'TI -এর সদর দপ্তর কোথায়?',
                'subject' => 'international',
                'explanation' => '<strong>বার্লিন</strong>: বিশ্বব্যাপী দুর্নীতি বিরোধী নাগরিক সংস্থা ট্রান্সপারেন্সি ইন্টারন্যাশনাল (Transparency International - TI)-এর আন্তর্জাতিক সচিবালয় জার্মানির রাজধানী বার্লিনে অবস্থিত।',
                'options' => [
                    ['A', 'ম্যানিলা', false],
                    ['B', 'বার্লিন', true],
                    ['C', 'ব্যাংকক', false],
                    ['D', 'সিঙ্গাপুর', false],
                ],
            ],
            [
                'stem' => '২০০৪ সালে শান্তির জন্য নোবেল পুরস্কার লাভ করেন কোন দেশের নাগরিক?',
                'subject' => 'international',
                'explanation' => '<strong>কেনিয়া</strong>: গ্রিন বেল্ট আন্দোলনের প্রতিষ্ঠাতা এবং আফ্রিকার পরিবেশ ও নারী অধিকারকর্মী অধ্যাপক ওয়াঙ্গারি মাথাই ২০০৪ সালে প্রথম আফ্রিকান নারী হিসেবে শান্তিতে নোবেল পুরস্কার অর্জন করেন।',
                'options' => [
                    ['A', 'ব্রাজিল', false],
                    ['B', 'ইরান', false],
                    ['C', 'সুইডেন', false],
                    ['D', 'কেনিয়া', true],
                ],
            ],
            [
                'stem' => 'ভারতীয় লোকসভার নির্বাচিত সদস্য সংখ্যা কত?',
                'subject' => 'international',
                'explanation' => '<strong>৫৪৩</strong>: ভারতীয় সংবিধানের ১০৪তম সংশোধনীতে অ্যাংলো-ইন্ডিয়ান কোটা বিলুপ্তির পর লোকসভায় বর্তমানে সরাসরি জনগণের ভোটে নির্বাচিত আসন সংখ্যা ৫৪৩টি।',
                'options' => [
                    ['A', '৫৪৫', false],
                    ['B', '৫৪৩', true],
                    ['C', '৬১০', false],
                    ['D', '৪১৫', false],
                ],
            ],
            [
                'stem' => 'সুয়েজ খাল কোন দুটি সাগরকে সংযোজিত করে?',
                'subject' => 'international',
                'explanation' => '<strong>লোহিত সাগর ও ভূমধ্যসাগর</strong>: ১৮৬৯ সালে মিসরে নির্মিত মানবসৃষ্ট সুয়েজ খাল উত্তর ভূমধ্যসাগরকে দক্ষিণের লোহিত সাগরের সাথে সরাসরি যুক্ত করেছে।',
                'options' => [
                    ['A', 'লোহিত সাগর ও ভূমধ্যসাগর', true],
                    ['B', 'ভূমধ্যসাগর ও আরব সাগর', false],
                    ['C', 'লোহিত সাগর ও আরব সাগর', false],
                    ['D', 'ভূমধ্যসাগর ও কাস্পিয়ান সাগর', false],
                ],
            ],
            [
                'stem' => 'কোন তারিখে আন্তর্জাতিক পরিবেশ দিবস পালিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>৫ জুন</strong>: ১৯৭২ সালের স্টকহোম মানব পরিবেশ সম্মেলনের উদ্বোধনী স্মারক হিসেবে জাতিসংঘ সাধারণ পরিষদ কর্তৃক প্রতি বছর ৫ জুন বিশ্ব পরিবেশ দিবস পালিত হয়।',
                'options' => [
                    ['A', '৫ জুলাই', false],
                    ['B', '২১ মার্চ', false],
                    ['C', '৫ জুন', true],
                    ['D', '২১ জুন', false],
                ],
            ],
            [
                'stem' => 'লেবানন কোন দেশের কাছ থেকে স্বাধীনতা লাভ করে?',
                'subject' => 'international',
                'explanation' => '<strong>ফ্রান্স</strong>: প্রথম বিশ্বযুদ্ধের পর লীগ অব নেশনস ম্যান্ডেটের অধীনে লেবানন ফ্রান্সের শাসনাধীন ছিল। ১৯৪৩ সালের ২২ নভেম্বর দেশটি ফ্রান্সের কাছ থেকে স্বাধীনতা লাভ করে।',
                'options' => [
                    ['A', 'ব্রিটেন', false],
                    ['B', 'ফ্রান্স', true],
                    ['C', 'তুরস্ক', false],
                    ['D', 'স্পেন', false],
                ],
            ],
            [
                'stem' => 'গ্রিনিচ মান সময়ের সঙ্গে বাংলাদেশের সময়ের পার্থক্য কত ঘণ্টা?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ছয় ঘণ্টা</strong>: বাংলাদেশ ৯০° পূর্ব দ্রাঘিমাংশে অবস্থিত। প্রতি ডিগ্রি দ্রাঘিমার জন্য ৪ মিনিট সময়ের পার্থক্য বিবেচনায় ৯০ × ৪ = ৩৬০ মিনিট বা ৬ ঘণ্টা (GMT+6)।',
                'options' => [
                    ['A', 'ছয় ঘণ্টা', true],
                    ['B', 'আট ঘণ্টা', false],
                    ['C', 'দশ ঘণ্টা', false],
                    ['D', 'পাঁচ ঘণ্টা', false],
                ],
            ],
            [
                'stem' => 'ভারতের কোন রাজ্যের রাজধানী ইম্ফল?',
                'subject' => 'international',
                'explanation' => '<strong>মনিপুর</strong>: উত্তর-পূর্ব ভারতের পার্বত্য অঙ্গরাজ্য মনিপুরের (Manipur) রাজধানী হলো ঐতিহাসিক শহর ইম্ফল (Imphal)।',
                'options' => [
                    ['A', 'মিজোরাম', false],
                    ['B', 'অরুণাচল', false],
                    ['C', 'মণিপুর', true],
                    ['D', 'মেঘালয়', false],
                ],
            ],
            [
                'stem' => 'ইউরো মুদ্রা কখন চালু হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৯৯ সালের ১ জানুয়ারি</strong>: ইউরোপীয় ইউনিয়নের অভিন্ন মুদ্রা ইউরো ১৯৯৯ সালের ১ জানুয়ারি হিসাব-নিকাশ ও ব্যাংক লেনদেনের জন্য এবং ২০০২ সালের ১ জানুয়ারি কাগুজে নোট ও কয়েন হিসেবে সাধারণের জন্য চালু হয়।',
                'options' => [
                    ['A', '১৯৯৭ সালের ১ জানুয়ারি', false],
                    ['B', '২০০০ সালের ১ মার্চ', false],
                    ['C', '২০০১ সালের ১ জানুয়ারি', false],
                    ['D', '১৯৯৮ সালের ১ নভেম্বর', true],
                ],
            ],
            [
                'stem' => 'সহস্রাব্দ উন্নয়ন লক্ষ্যসমূহের সময়সীমা নির্ধারণ করা হয়েছে কোন সাল পর্যন্ত?',
                'subject' => 'international',
                'explanation' => '<strong>২০১৫</strong>: ২০০০ সালে জাতিসংঘে গৃহীত মিলেনিয়াম ডেভেলপমেন্ট গোলস (MDG)-এর ৮টি প্রধান লক্ষ্যের বাস্তবায়ন সময়সীমা ছিল ২০০০ থেকে ২০১৫ সাল পর্যন্ত (যার পর SDG শুরু হয়)।',
                'options' => [
                    ['A', '২০১০', false],
                    ['B', '২০১৫', true],
                    ['C', '২০২০', false],
                    ['D', '২০২৫', false],
                ],
            ],
            [
                'stem' => 'আবু সায়েফ গেরিলা গোষ্ঠী কোন দেশে তৎপর?',
                'subject' => 'international',
                'explanation' => '<strong>ফিলিপাইন</strong>: দক্ষিণ ফিলিপাইনের বাসিলান ও সুলু দ্বীপপুঞ্জ ভিত্তিক বিচ্ছিন্নতাবাদী চরমপন্থী সশস্ত্র গেরিলা দল হলো আবু সায়েফ (Abu Sayyaf)।',
                'options' => [
                    ['A', 'ইরাক', false],
                    ['B', 'ফিলিপাইন', true],
                    ['C', 'ইন্দোনেশিয়া', false],
                    ['D', 'থাইল্যান্ড', false],
                ],
            ],
            [
                'stem' => 'মাদার তেরেসা কোন দেশে জন্মগ্রহণ করেন?',
                'subject' => 'international',
                'explanation' => '<strong>মেসিডোনিয়া</strong>: নোবেলজয়ী সেবাব্রতী মাদার তেরেসা ১৯১০ সালের ২৬ আগস্ট তৎকালীন অটোমান সাম্রাজ্যের অধীন মেসিডোনিয়ার রাজধানী স্কোপিয়ে (Skopje) শহরে একটি আলবেনীয় পরিবারে জন্মগ্রহণ করেন।',
                'options' => [
                    ['A', 'আলবেনিয়া', false],
                    ['B', 'মেসিডোনিয়া', true],
                    ['C', 'সার্বিয়া', false],
                    ['D', 'ইতালি', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘের প্রথম মহাসচিব কে ছিলেন?',
                'subject' => 'international',
                'explanation' => '<strong>ট্রিগভেলি</strong>: জাতিসংঘের প্রথম মহাসচিব হিসেবে নরওয়ের রাজনীতিবিদ ও কূটনীতিক ট্রিগভে হালাভদান লি (Trygve Lie) ১৯৪৬ থেকে ১৯৫২ সাল পর্যন্ত দায়িত্ব পালন করেন।',
                'options' => [
                    ['A', 'কুর্ট ওয়াল্ডহেইম', false],
                    ['B', 'পেরেজ দ্য কুয়েলার', false],
                    ['C', 'ট্রিগভেলি', true],
                    ['D', 'উ থান্ট', false],
                ],
            ],
            [
                'stem' => 'নারীর প্রতি সকল বৈষম্য নির্মূল কনভেনশন (UN CEDAW) স্বাক্ষরিত হয়-',
                'subject' => 'international',
                'explanation' => '<strong>১৯৭৯ সালে</strong>: ১৯৭৯ সালের ১৮ ডিসেম্বর জাতিসংঘ সাধারণ পরিষদে নারীর অধিকার সুরক্ষার আন্তর্জাতিক সনদ \'Convention on the Elimination of All Forms of Discrimination Against Women\' গৃহীত ও স্বাক্ষরিত হয়।',
                'options' => [
                    ['A', '১৯৭৫ সালে', false],
                    ['B', '১৯৭৬ সালে', false],
                    ['C', '১৯৭৯ সালে', true],
                    ['D', '১৯৮৯ সালে', false],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্রের একজন প্রেসিডেন্ট ১২ বছর ক্ষমতায় ছিলেন। তিনি হচ্ছেন-',
                'subject' => 'international',
                'explanation' => '<strong>ফ্রাঙ্কলিন রুজভেল্ট</strong>: একমাত্র মার্কিন প্রেসিডেন্ট হিসেবে ফ্রাঙ্কলিন ডি. রুজভেল্ট টানা চারবার নির্বাচনে জয়ী হয়ে মহামন্দা ও দ্বিতীয় বিশ্বযুদ্ধকালে দীর্ঘ ১২ বছর (১৯৩৩-১৯৪৫) দায়িত্ব পালন করেন।',
                'options' => [
                    ['A', 'জেমস মনরো', false],
                    ['B', 'ফ্রাঙ্কলিন রুজভেল্ট', true],
                    ['C', 'হ্যারি এস ট্রুম্যান', false],
                    ['D', 'তথ্যটি সঠিক নয়', false],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্রের কোন স্টেট-এ নির্বাচকমণ্ডলীর ভোটের (Electoral vote) সংখ্যা বেশি?',
                'subject' => 'international',
                'explanation' => '<strong>ক্যালিফোর্নিয়া</strong>: সর্বাধিক জনসংখ্যার কারণে মার্কিন যুক্তরাষ্ট্রের ৫০টি অঙ্গরাজ্যের মধ্যে ক্যালিফোর্নিয়া অঙ্গরাজ্যে সর্বোচ্চ সংখ্যক (বর্তমানে ৫৪টি) ইলেক্টোরাল কলেজ ভোট রয়েছে।',
                'options' => [
                    ['A', 'নিউইয়র্ক', false],
                    ['B', 'ক্যালিফোর্নিয়া', true],
                    ['C', 'টেক্সাস', false],
                    ['D', 'ফ্লোরিডা', false],
                ],
            ],
            [
                'stem' => 'শেনজেন চুক্তি হচ্ছে-',
                'subject' => 'international',
                'explanation' => '<strong>অবাধ চলাচল সংক্রান্ত চুক্তি</strong>: ১৯৮৫ সালে স্বাক্ষরিত শেনজেন চুক্তি (Schengen Agreement) ইউরোপের সদস্য দেশগুলোর অভ্যন্তরীণ সীমান্ত নিয়ন্ত্রণ তুলে দিয়ে পাসপোর্টবিহীন অবাধ চলাচলের নিশ্চয়তা দেয়।',
                'options' => [
                    ['A', 'বাণিজ্য চুক্তি', false],
                    ['B', 'অবাধ চলাচল সংক্রান্ত চুক্তি', true],
                    ['C', 'কর হ্রাস করা চুক্তি', false],
                    ['D', 'এর কোনোটিই নয়', false],
                ],
            ],
            [
                'stem' => 'অভিন্ন ইউরোপ গঠনের লক্ষ্যে ম্যাসট্রিচট চুক্তি অনুমোদনের জন্য কোন দেশ দুবার গণভোটের আয়োজন করেছিল?',
                'subject' => 'international',
                'explanation' => '<strong>ডেনমার্ক</strong>: ইউরোপীয় ইউনিয়ন প্রতিষ্ঠার ম্যাসট্রিখট চুক্তি অনুমোদনে ১৯৯২ সালে ডেনমার্কের জনগণ প্রথম গণভোটে এটি প্রত্যাখ্যান করে, পরবর্তীতে ১৯৯৩ সালে সংশোধিত শর্তে দ্বিতীয় গণভোটে অনুমোদন দেয়।',
                'options' => [
                    ['A', 'লুক্সেমবার্গ', false],
                    ['B', 'আয়ারল্যান্ড', false],
                    ['C', 'গ্রিস', false],
                    ['D', 'ডেনমার্ক', true],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্র ইউনিয়নে কোন স্টেট সর্বশেষে যোগ দেয়?',
                'subject' => 'international',
                'explanation' => '<strong>হাওয়াই</strong>: প্রশান্ত মহাসাগরীয় দ্বীপপুঞ্জ হাওয়াই ১৯৫৯ সালের ২১ আগস্ট যুক্তরাষ্ট্রের ৫০তম এবং সর্বশেষ অঙ্গরাজ্য হিসেবে ইউনিয়নে যোগ দেয়।',
                'options' => [
                    ['A', 'হাওয়াই', true],
                    ['B', 'অ্যারিজোনা', false],
                    ['C', 'টেক্সাস', false],
                    ['D', 'ফ্লোরিডা', false],
                ],
            ],
            [
                'stem' => 'জাপান ও রাশিয়ার মধ্যকার বিরোধপূর্ণ দ্বীপটির নাম কী?',
                'subject' => 'international',
                'explanation' => '<strong>কুরিল দ্বীপপুঞ্জ</strong>: দ্বিতীয় বিশ্বযুদ্ধের পর থেকে ওখোটস্ক সাগরে অবস্থিত কুরিল দ্বীপপুঞ্জের দক্ষিণ অংশ (জাপানের উত্তরাঞ্চলীয় অঞ্চল) নিয়ে জাপান ও রাশিয়ার মধ্যে দীর্ঘস্থায়ী সীমানা বিরোধ বিদ্যমান।',
                'options' => [
                    ['A', 'কুরিল দ্বীপপুঞ্জ', true],
                    ['B', 'মার্শাল দ্বীপপুঞ্জ', false],
                    ['C', 'দিয়াগো গার্সিয়া', false],
                    ['D', 'গ্রেট বেরিয়ার রিফ', false],
                ],
            ],
            [
                'stem' => 'যুক্তরাষ্ট্রের কোন স্টেটটি ফ্রান্সের নিকট থেকে ক্রয় করা হয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>লুইসিয়ানা</strong>: ১৮০৩ সালে মার্কিন প্রেসিডেন্ট থমাস জেফারসনের আমলে যুক্তরাষ্ট্র ফ্রান্সের নেপোলিয়ন সরকারের কাছ থেকে ১৫ মিলিয়ন ডলারে বিশাল লুইসিয়ানা অঞ্চল ক্রয় করে।',
                'options' => [
                    ['A', 'লুইসিয়ানা', true],
                    ['B', 'উইসকনসিন', false],
                    ['C', 'ফ্লোরিডা', false],
                    ['D', 'নেবারাস্কা', false],
                ],
            ],
            [
                'stem' => 'উরুগুয়ে রাউন্ডের সংলাপ কত বছর ধরে চলেছিল?',
                'subject' => 'international',
                'explanation' => '<strong>৮ বছর</strong>: ১৯৮৬ সালে উরুগুয়ের পুন্তা দেল এস্তেতে শুরু হয়ে ১৯৯৪ সালে মরক্কোর মারাকেশে স্বাক্ষরের মধ্য দিয়ে দীর্ঘ ৮ বছর ব্যাপী সংলাপের সফল সমাপ্তি ঘটে এবং বিশ্ব বাণিজ্য সংস্থা (WTO) প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '২ বছর', false],
                    ['B', '৮ বছর', true],
                    ['C', '৫ বছর', false],
                    ['D', '৬ বছর', false],
                ],
            ],
            [
                'stem' => 'বিশ্বব্যাংকের SOFT LOAN WINDOW হলো-',
                'subject' => 'international',
                'explanation' => '<strong>IDA</strong>: বিশ্বব্যাংক গ্রুপের আন্তর্জাতিক উন্নয়ন সংস্থা (International Development Association - IDA) স্বল্পোন্নত ও দরিদ্র দেশগুলোকে দীর্ঘমেয়াদে নামমাত্র বা সুদমুক্ত ঋণ প্রদান করায় একে \'সহজ শর্তের জানালা\' বা Soft Loan Window বলা হয়।',
                'options' => [
                    ['A', 'MIGA', false],
                    ['B', 'IBRD', false],
                    ['C', 'IDA', true],
                    ['D', 'IFC', false],
                ],
            ],
            [
                'stem' => 'IAEA -এর নির্বাহী প্রধান হলেন-',
                'subject' => 'international',
                'explanation' => '<strong>মোহাম্মদ আল বারাদি (তৎকালীন)</strong>: আন্তর্জাতিক পরমাণু শক্তি সংস্থা (IAEA)-এর তৎকালীন মহাপরিচালক ছিলেন মিসরের ড. মোহাম্মদ আল বারাদি (বর্তমানে রাফায়েল মারিয়ানো গ্রসি)।',
                'options' => [
                    ['A', 'মোহাম্মদ আল বারাদি', true],
                    ['B', 'আমর মুসা', false],
                    ['C', 'আয়াদ আলাওয়ি', false],
                    ['D', 'হামিদ কারজাই', false],
                ],
            ],
            [
                'stem' => 'কোন ভিটামিন ক্ষতস্থান হতে রক্ত পড়া বন্ধ করতে সাহায্য করে?',
                'subject' => 'science',
                'explanation' => '<strong>ভিটামিন কে</strong>: ভিটামিন কে রক্ত তঞ্চনকারী বা ক্লটিং উপাদান যেমন প্রোথ্রম্বিন সংশ্লেষে সহায়তা করে রক্ত জমাট বাঁধতে সাহায্য করে।',
                'options' => [
                    ['A', 'ভিটামিন সি', false],
                    ['B', 'ভিটামিন বি', false],
                    ['C', 'ভিটামিন বি২', false],
                    ['D', 'ভিটামিন কে', true],
                ],
            ],
            [
                'stem' => 'আকাশে বিজলী চমকায়-',
                'subject' => 'science',
                'explanation' => '<strong>মেঘের অসংখ্য পানি ও বরফ কণার মধ্যে চার্জ সঞ্চিত হলে</strong>: বজ্রবাহী কিউমুলোনিম্বাস মেঘের ঊর্ধ্বাকাশে পানি ও বরফ কণার পারস্পরিক ঘর্ষণে ধনাত্মক ও ঋণাত্মক স্থির বৈদ্যুতিক চার্জ সঞ্চিত হয়ে তীব্র বৈদ্যুতিক ডিসচার্জ ঘটে, যাকে আমরা বিদ্যুৎ চমকানো বলি।',
                'options' => [
                    ['A', 'দুই খণ্ড মেঘ পর পর এলে', false],
                    ['B', 'মেঘের মধ্যে বিদ্যুৎ কোষ তৈরি হলে', false],
                    ['C', 'মেঘ বিদ্যুৎ পরিবাহী অবস্থায় এলে', false],
                    ['D', 'মেঘের অসংখ্য পানি ও বরফ কণার মধ্যে চার্জ সঞ্চিত হলে', true],
                ],
            ],
            [
                'stem' => 'বিদ্যুৎবাহী তারে পাখি বসলে সাধারণত বিদ্যুৎ স্পৃষ্ট হয় না, কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>মাটির সঙ্গে সংযোগ হয় না</strong>: পাখি কেবল একটিমাত্র তারের ওপর দুই পা রেখে বসলে তার দুই পায়ের মধ্যে কোনো বিভব পার্থক্য তৈরি হয় না এবং মাটির সাথে আর্থিং সংযোগ না থাকায় শরীরের মধ্য দিয়ে কোনো তড়িৎ প্রবাহিত হয় না।',
                'options' => [
                    ['A', 'পাখির গায়ে বিদ্যুত্রোধী আবরণ থাকে', false],
                    ['B', 'পাখির দেহের ভিতর দিয়ে বিদ্যুৎ প্রবাহিত হয় না', false],
                    ['C', 'বিদ্যুৎ স্পৃষ্ট হলেও পাখি মরে না', false],
                    ['D', 'মাটির সঙ্গে সংযোগ হয় না', true],
                ],
            ],
            [
                'stem' => 'সালোকসংশ্লেষণ সবচেয়ে বেশি পরিমাণে হয়-',
                'subject' => 'science',
                'explanation' => '<strong>লাল আলোতে</strong>: ক্লোরোফিল লাল (৬৫০-৭০০ ন্যানোমিটার) ও নীল বর্ণের আলো সবচেয়ে বেশি শোষণ করে, যার মধ্যে লাল আলোতে সালোকসংশ্লেষণের হার সর্বোচ্চ থাকে।',
                'options' => [
                    ['A', 'সবুজ আলোতে', false],
                    ['B', 'নীল আলোতে', false],
                    ['C', 'লাল আলোতে', true],
                    ['D', 'বেগুনী আলোতে', false],
                ],
            ],
            [
                'stem' => 'ম্যালিক এসিড-',
                'subject' => 'science',
                'explanation' => '<strong>টমেটোতে পাওয়া যায়</strong>: ম্যালিক এসিড মূলত আপেল, টমেটো ও চেরি ফলে পাওয়া যায়। (লেবুতে সাইট্রিক এসিড, আমলকীতে এসকরবিক এসিড, আঙুরে টারটারিক এসিড থাকে)।',
                'options' => [
                    ['A', 'আমলকিতে পাওয়া যায়', false],
                    ['B', 'কমলালেবুতে পাওয়া যায়', false],
                    ['C', 'আঙ্গুরে পাওয়া যায়', false],
                    ['D', 'টমেটোতে পাওয়া যায়', true],
                ],
            ],
            [
                'stem' => 'হাড় ও দাঁতকে মজবুত করে-',
                'subject' => 'science',
                'explanation' => '<strong>ফসফরাস</strong>: অস্থি ও দন্ত গঠনে ক্যালসিয়ামের সাথে প্রধান খনিজ হিসেবে ফসফরাস (ক্যালসিয়াম ফসফেট আকারে) অপরিহার্য ভূমিকা পালন করে।',
                'options' => [
                    ['A', 'আয়োডিন', false],
                    ['B', 'আয়রন', false],
                    ['C', 'ম্যাগনেসিয়াম', false],
                    ['D', 'ফসফরাস', true],
                ],
            ],
            [
                'stem' => 'নিউমোনিয়া রোগে আক্রান্ত হয় মানব দেহের-',
                'subject' => 'science',
                'explanation' => '<strong>ফুসফুস</strong>: নিউমোকক্কাস বা স্ট্রেপ্টোকক্কাস ব্যাকটেরিয়ার সংক্রমণে মানুষের ফুসফুসের অ্যালভিওলাইতে প্রদাহ ও তরল জমা হওয়ার সংক্রমণ ব্যাধি হলো নিউমোনিয়া।',
                'options' => [
                    ['A', 'ফুসফুস', true],
                    ['B', 'যকৃত', false],
                    ['C', 'কিডনি', false],
                    ['D', 'প্লীহা', false],
                ],
            ],
            [
                'stem' => 'শুষ্ক বরফ বলা হয়-',
                'subject' => 'science',
                'explanation' => '<strong>হিমায়িত কার্বন-ডাই-অক্সাইডকে</strong>: -৭৮.৫° সেলসিয়াস তাপমাত্রায় শীতল ও জমাটবদ্ধ কঠিন কার্বন ডাই অক্সাইডকে \'শুষ্ক বরফ\' (Dry Ice) বলা হয়, কারণ এটি গলে তরল না হয়ে সরাসরি বাষ্পীভূত হয়।',
                'options' => [
                    ['A', 'হিমায়িত অক্সিজেনকে', false],
                    ['B', 'হিমায়িত কার্বন মনোক্সাইডকে', false],
                    ['C', 'হিমায়িত কার্বন-ডাই-অক্সাইডকে', true],
                    ['D', 'ক্যালসিয়াম অক্সাইডকে', false],
                ],
            ],
            [
                'stem' => 'বৈদ্যুতিক ইস্ত্রি এবং হিটারে ব্যবহৃত হয়-',
                'subject' => 'science',
                'explanation' => '<strong>নাইক্রোম তার</strong>: নিকেল ও ক্রোমিয়ামের সংকর ধাতু \'নাইক্রোম\' (Nichrome)-এর উচ্চ রোধাঙ্ক ও অতি উচ্চ গলনাঙ্কের কারণে হিটিং এলিমেন্ট হিসেবে ব্যবহৃত হয়।',
                'options' => [
                    ['A', 'টাংস্টেন তার', false],
                    ['B', 'নাইক্রোম তার', true],
                    ['C', 'এন্টিমনি তার', false],
                    ['D', 'কপার তার', false],
                ],
            ],
            [
                'stem' => 'শব্দের তীব্রতা নির্ণায়ক যন্ত্র-',
                'subject' => 'science',
                'explanation' => '<strong>অডিও মিটার</strong>: শব্দের তীব্রতা বা মানব কর্ণের শ্রবণ সংবেদনশীলতা পরিমাপের যন্ত্র হলো অডিওমিটার (Audio meter)।',
                'options' => [
                    ['A', 'অডিও মিটার', true],
                    ['B', 'অ্যামিটার', false],
                    ['C', 'অডিওফোন', false],
                    ['D', 'অলটিমিটার', false],
                ],
            ],
            [
                'stem' => 'ডিজিটাল ঘড়ি বা ক্যালকুলেটরে কালচে অনুজ্জ্বল যে লেখা ফুটে ওঠে তা কিসের ভিত্তিতে তৈরি?',
                'subject' => 'science',
                'explanation' => '<strong>সিলিকন চিপ / এলসিডি</strong>: ডিজিটাল ক্যালকুলেটর ও ঘড়ির ডিসপ্লেতে লিকুইড ক্রিস্টাল ডিসপ্লে (LCD) এবং অভ্যন্তরীণ সার্কিটে মাইক্রোপ্রসেসর হিসেবে ক্ষুদ্র সিলিকন ইন্টিগ্রেটেড চিপ কাজ করে।',
                'options' => [
                    ['A', 'এলইডি', false],
                    ['B', 'আইসি', false],
                    ['C', 'এলসিডি', false],
                    ['D', 'সিলিকন চিপ', true],
                ],
            ],
            [
                'stem' => 'দিনাজপুর জেলার বড়পুকুরিয়ায় কোন খনিজ প্রকল্পের কাজ চলছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>কয়লা</strong>: দিনাজপুরের পার্বতীপুর উপজেলার বড়পুকুরিয়ায় দেশের বৃহত্তম ভূগর্ভস্থ বাণিজ্যিক কয়লা খনি প্রকল্প বাস্তবায়িত হয়েছে।',
                'options' => [
                    ['A', 'কঠিন শিলা', false],
                    ['B', 'কয়লা', true],
                    ['C', 'চুনাপাথর', false],
                    ['D', 'কাদামাটি', false],
                ],
            ],
            [
                'stem' => 'Adult Cell ক্লোন করে যে ভেড়ার জন্ম হয়েছে তার নাম দেয়া হয়েছে-',
                'subject' => 'science',
                'explanation' => '<strong>ডলি</strong>: ১৯৯৬ সালে স্কটল্যান্ডের রোজলিন ইনস্টিটিউটে বিজ্ঞানী ইয়ান উইলমুট কর্তৃক প্রাপ্তবয়স্ক স্তনকোষ ক্লোন করে সফলভাবে উদ্ভাবিত প্রথম স্তন্যপায়ী ক্লোন ভেড়ার নাম রাখা হয় \'ডলি\' (Dolly)।',
                'options' => [
                    ['A', 'শেলী', false],
                    ['B', 'ডলি', true],
                    ['C', 'মলি', false],
                    ['D', 'নেলী', false],
                ],
            ],
            [
                'stem' => 'বৃত্তের পরিধি ও ব্যাসের অনুপাত-',
                'subject' => 'math',
                'explanation' => '<strong>২২/৭</strong>: বৃত্তের পরিধি (2πr) ও ব্যাসের (2r) অনুপাত ধ্রুবক পাই (π), যার ঐতিহাসিক আসন্ন ভগ্নাংশ মান হলো ২২/৭।',
                'options' => [
                    ['A', '৩', false],
                    ['B', '২২/৭', true],
                    ['C', '২৫/৯', false],
                    ['D', 'প্রায় ৫', false],
                ],
            ],
            [
                'stem' => 'মানুষের ক্রোমোজোমের সংখ্যা কত?',
                'subject' => 'science',
                'explanation' => '<strong>২৩ জোড়া</strong>: প্রতিটি সুস্থ মানব দেহকোষে মোট ৪৬টি বা ২৩ জোড়া ক্রোমোজোম বিদ্যমান (যার মধ্যে ২২ জোড়া অটোজোম এবং ১ জোড়া সেক্স ক্রোমোজোম)।',
                'options' => [
                    ['A', '২৫ জোড়া', false],
                    ['B', '২৬ জোড়া', false],
                    ['C', '২৩ জোড়া', true],
                    ['D', '২৪ জোড়া', false],
                ],
            ],
            [
                'stem' => 'সমুদ্রপৃষ্ঠে বায়ুর চাপ প্রতি বর্গ সে.মি. এ-',
                'subject' => 'science',
                'explanation' => '<strong>১০ নিউটন</strong>: প্রমাণ বায়ুমণ্ডলীয় চাপ সমুদ্রপৃষ্ঠে প্রায় ১.০১ × ১০⁵ প্যাসকেল (N/m²), যা প্রতি বর্গ সেন্টিমিটারে প্রায় ১০ নিউটন (10 N/cm²) বলের সমান।',
                'options' => [
                    ['A', '৫ কি.মি.', false],
                    ['B', '১০ কি.মি.', false],
                    ['C', '২৭ কি.মি.', false],
                    ['D', '১০ নিউটন', true],
                ],
            ],
            [
                'stem' => 'কাচ তৈরির প্রধান কাঁচামাল হলো-',
                'subject' => 'science',
                'explanation' => '<strong>বালি</strong>: সাধারণ কাচ তৈরির প্রধানতম কাঁচামাল হলো সিলিকা বা কোয়ার্টজ বালি (Silicon dioxide - SiO2)।',
                'options' => [
                    ['A', 'শাজিমাটি', false],
                    ['B', 'চুনাপাথর', false],
                    ['C', 'জিপসাম', false],
                    ['D', 'বালি', true],
                ],
            ],
            [
                'stem' => 'জীবাশ্ম জ্বালানি দহনের ফলে বায়ুমণ্ডলে যে গ্রিন হাউজ গ্যাসের পরিমাণ সব চাইতে বেশি বৃদ্ধি পাচ্ছে-',
                'subject' => 'science',
                'explanation' => '<strong>কার্বন-ডাই-অক্সাইড</strong>: কয়লা, খনিজ তেল ও প্রাকৃতিক গ্যাসের মতো জীবাশ্ম জ্বালানি পোড়ানোর ফলে বায়ুমণ্ডলে সর্বাধিক পরিমাণে কার্বন ডাই অক্সাইড (CO2) নির্গত হচ্ছে যা বৈশ্বিক উষ্ণায়নের প্রধান চালিকাশক্তি।',
                'options' => [
                    ['A', 'জলীয় বাষ্প', false],
                    ['B', 'ক্লোরোফ্লোরো কার্বন', false],
                    ['C', 'কার্বন-ডাই-অক্সাইড', true],
                    ['D', 'মিথেন', false],
                ],
            ],
            [
                'stem' => 'বস্তুর ওজন কোথায় সবচেয়ে বেশি?',
                'subject' => 'science',
                'explanation' => '<strong>মেরু অঞ্চলে</strong>: পৃথিবীর আকৃতি কমলালেবুর মতো উত্তর-দক্ষিণে কিছুটা চাপা হওয়ায় মেরু অঞ্চলে পৃথিবীর কেন্দ্র থেকে দূরত্ব (ব্যাসার্ধ R) সর্বনিম্ন, ফলে সেখানে অভিকর্ষজ ত্বরণ \'g\' সর্বোচ্চ এবং বস্তুর ওজনও সর্বাধিক হয়।',
                'options' => [
                    ['A', 'খনির ভিতর', false],
                    ['B', 'পাহাড়ের উপর', false],
                    ['C', 'মেরু অঞ্চলে', true],
                    ['D', 'বিষুব অঞ্চলে', false],
                ],
            ],
            [
                'stem' => 'নাইট্রোজেন গ্যাস থেকে কোন সার প্রস্তুত করা হয়?',
                'subject' => 'science',
                'explanation' => '<strong>ইউরিয়া</strong>: হেবার বস প্রণালীতে বায়ুমণ্ডলের নাইট্রোজেন ও হাইড্রোজেন থেকে অ্যামোনিয়া এবং পরবর্তীতে কার্বন ডাই অক্সাইডের সাথে বিক্রিয়া ঘটিয়ে সর্বাধিক ব্যবহৃত নাইট্রোজেনঘটিত সার \'ইউরিয়া\' [CO(NH2)2] উৎপন্ন করা হয়।',
                'options' => [
                    ['A', 'টিএসপি', false],
                    ['B', 'সবুজ সার', false],
                    ['C', 'পটাশ', false],
                    ['D', 'ইউরিয়া', true],
                ],
            ],
            [
                'stem' => '১, ৩, ৬, ১০, ১৫, ২১ ....... ধারাটির দশম পদ-',
                'subject' => 'math',
                'explanation' => '<strong>৫৫</strong>: ধারাটির পদগুলো ত্রিভুজাকার সংখ্যা (Triangular numbers): ১ম পদ = ১, ২য় পদ = ১+২ = ৩, ৩য় পদ = ১+২+৩ = ৬, ... ১০ম পদ = ১+২+৩+...+১০ = (১০ × ১১)/২ = ৫৫।',
                'options' => [
                    ['A', '৪৫', false],
                    ['B', '৫৫', true],
                    ['C', '৬২', false],
                    ['D', '৬৫', false],
                ],
            ],
            [
                'stem' => 'পিতা ও মাতার বয়সের গড় ৪৫ বছর। আবার পিতা, মাতা ও এক পুত্রের বয়সের গড় ৩৬ বছর। পুত্রের বয়স-',
                'subject' => 'math',
                'explanation' => '<strong>১৮ বছর</strong>: পিতা ও মাতার মোট বয়স = ৪৫ × ২ = ৯০ বছর। পিতা, মাতা ও পুত্রের মোট বয়স = ৩৬ × ৩ = ১০৮ বছর। অতএব পুত্রের বয়স = ১০৮ - ৯০ = ১৮ বছর।',
                'options' => [
                    ['A', '৯ বছর', false],
                    ['B', '১৪ বছর', false],
                    ['C', '১৫ বছর', false],
                    ['D', '১৮ বছর', true],
                ],
            ],
            [
                'stem' => 'একটি জারে দুধ ও পানির অনুপাত ৫ : ১। দুধের পরিমাণ যদি পানি অপেক্ষা ৮ লিটার বেশি হয় তবে পানির পরিমাণ কত?',
                'subject' => 'math',
                'explanation' => '<strong>২ লিটার</strong>: ধরি দুধের পরিমাণ ৫x এবং পানি x লিটার। পার্থক্য = ৫x - x = ৪x। প্রশ্নমতে, ৪x = ৮ => x = ২ লিটার। অতএব পানির পরিমাণ ২ লিটার।',
                'options' => [
                    ['A', '২ লিটার', true],
                    ['B', '৪ লিটার', false],
                    ['C', '৬ লিটার', false],
                    ['D', '১০ লিটার', false],
                ],
            ],
            [
                'stem' => 'টাকায় ৩টি করে লেবু কিনে টাকায় ২টি করে বিক্রি করলে শতকরা কত লাভ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>৫০%</strong>: ৩টির ক্রয়মূল্য ১ টাকা => ১টির ক্রয়মূল্য = ১/৩ টাকা। ২টির বিক্রয়মূল্য ১ টাকা => ১টির বিক্রয়মূল্য = ১/২ টাকা। লাভ = ১/২ - ১/৩ = ১/৬ টাকা। শতকরা লাভ = [(১/৬) / (১/৩)] × ১০০% = (৩/৬) × ১০০% = ৫০%।',
                'options' => [
                    ['A', '৫০%', true],
                    ['B', '৩০%', false],
                    ['C', '৩৩%', false],
                    ['D', '৩১%', false],
                ],
            ],
            [
                'stem' => '১২ জন শ্রমিক ৩ দিনে ৭২০ টাকা আয় করে। তবে ৯ জন শ্রমিক সমপরিমাণ টাকা আয় করবে-',
                'subject' => 'math',
                'explanation' => '<strong>৪ দিনে</strong>: ১২ জন শ্রমিক ৩ দিনে আয় করে ৭২০ টাকা => মোট শ্রমদিবস = ১২ × ৩ = ৩৬ জন-দিন। ৯ জন শ্রমিকের ৩৬ জন-দিন কাজ করতে সময় লাগবে = ৩৬ / ৯ = ৪ দিন।',
                'options' => [
                    ['A', '৫ দিনে', false],
                    ['B', '৪ দিনে', true],
                    ['C', '৬ দিনে', false],
                    ['D', '৩ দিনে', false],
                ],
            ],
            [
                'stem' => 'লঞ্চ ও স্রোতের গতিবেগ যথাক্রমে ঘণ্টায় ১৮ কি.মি. ও ৬ কি.মি.। নদীপথে ৪৮ কি.মি. অতিক্রম করে পুনরায় ফিরে আসতে সময় লাগবে-',
                'subject' => 'math',
                'explanation' => '<strong>৬ ঘণ্টা</strong>: অনুকূলে বেগ = ১৮ + ৬ = ২৪ কিমি/ঘণ্টা। অনুকূলে সময় = ৪৮ / ২৪ = ২ ঘণ্টা। প্রতিকূলে বেগ = ১৮ - ৬ = ১২ কিমি/ঘণ্টা। প্রতিকূলে সময় = ৪৮ / ১২ = ৪ ঘণ্টা। মোট সময় = ২ + ৪ = ৬ ঘণ্টা।',
                'options' => [
                    ['A', '১০ ঘণ্টা', false],
                    ['B', '৫ ঘণ্টা', false],
                    ['C', '৬ ঘণ্টা', true],
                    ['D', '৮ ঘণ্টা', false],
                ],
            ],
            [
                'stem' => 'কোন সংখ্যার ১/২ অংশের সাথে ৬ যোগ করলে সংখ্যাটির ২/৩ অংশ হবে। সংখ্যাটি কত?',
                'subject' => 'math',
                'explanation' => '<strong>৩৬</strong>: ধরি সংখ্যাটি x। প্রশ্নমতে, x/২ + ৬ = ২x/৩ => ২x/৩ - x/২ = ৬ => (৪x - ৩x)/৬ = ৬ => x/৬ = ৬ => x = ৩৬।',
                'options' => [
                    ['A', '৫৩', false],
                    ['B', '৬৩', false],
                    ['C', '৩৬', true],
                    ['D', '৩৫', false],
                ],
            ],
            [
                'stem' => '৪৩ থেকে ৬০ এর মধ্যে মৌলিক সংখ্যার সংখ্যা-',
                'subject' => 'math',
                'explanation' => '<strong>৪</strong>: ৪৩ থেকে ৬০ এর মধ্যে অবস্থিত মৌলিক সংখ্যাগুলো হলো: ৪৩, ৪৭, ৫৩ এবং ৫৯। সর্বমোট ৪টি।',
                'options' => [
                    ['A', '৫', false],
                    ['B', '৩', false],
                    ['C', '৭', false],
                    ['D', '৪', true],
                ],
            ],
            [
                'stem' => 'যদি p একটি মৌলিক সংখ্যা হয় তবে √p-',
                'subject' => 'math',
                'explanation' => '<strong>একটি অমূলদ সংখ্যা</strong>: যেকোনো মৌলিক সংখ্যার বর্গমূল সর্বদা একটি অমূলদ সংখ্যা (যেমন: √2, √3, √5, √7 ইত্যাদি)।',
                'options' => [
                    ['A', 'একটি স্বাভাবিক সংখ্যা', false],
                    ['B', 'একটি পূর্ণ সংখ্যা', false],
                    ['C', 'একটি মূলদ সংখ্যা', false],
                    ['D', 'একটি অমূলদ সংখ্যা', true],
                ],
            ],
            [
                'stem' => '(√3 . √5)⁴ এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>225</strong>: (√3 × √5)⁴ = (√15)⁴ = [(√15)²]² = 15² = 225।',
                'options' => [
                    ['A', '30', false],
                    ['B', '60', false],
                    ['C', '225', true],
                    ['D', '15', false],
                ],
            ],
            [
                'stem' => 'ক এবং খ একত্রে একটি কাজ ১২ দিনে করতে পারে। ক একা কাজটি ২০ দিনে করতে পারে, খ একা কাজটি করতে পারবে-',
                'subject' => 'math',
                'explanation' => '<strong>৩০ দিনে</strong>: খ-এর ১ দিনের কাজ = ১/১২ - ১/২০ = (৫ - ৩)/৬০ = ২/৬০ = ১/৩০ অংশ। অতএব খ একা সম্পূর্ণ কাজটি ৩০ দিনে করতে পারবে।',
                'options' => [
                    ['A', '২৫ দিনে', false],
                    ['B', '৩০ দিনে', true],
                    ['C', '৩৫ দিনে', false],
                    ['D', '৪০ দিনে', false],
                ],
            ],
            [
                'stem' => '৭২ সংখ্যাটির মোট ভাজক আছে-',
                'subject' => 'math',
                'explanation' => '<strong>১২টি</strong>: ৭২ এর মৌলিক উৎপাদকে বিশ্লেষণ: ৭২ = ২³ × ৩²। মোট ভাজক সংখ্যা = (৩ + ১) × (২ + ১) = ৪ × ৩ = ১২টি।',
                'options' => [
                    ['A', '৯টি', false],
                    ['B', '১০টি', false],
                    ['C', '১১টি', false],
                    ['D', '১২টি', true],
                ],
            ],
            [
                'stem' => 'দুটি ক্রমিক পূর্ণসংখ্যা নির্ণয় করুন, যাদের বর্গের অন্তর ৪৭-',
                'subject' => 'math',
                'explanation' => '<strong>২৩ এবং ২৪</strong>: দুটি ক্রমিক সংখ্যার বর্গের অন্তর হলো সংখ্যা দুটির যোগফল। সংখ্যা দুটি x ও (x + 1) হলে: (x + 1)² - x² = ৪৭ => 2x + 1 = ৪৭ => 2x = ৪৬ => x = ২৩। অতএব সংখ্যা দুটি ২৩ এবং ২৪।',
                'options' => [
                    ['A', '২১ এবং ২২', false],
                    ['B', '২২ এবং ২৩', false],
                    ['C', '২৩ এবং ২৪', true],
                    ['D', '২৪ এবং ২৫', false],
                ],
            ],
            [
                'stem' => 'x+y = 8, x−y= 6 হলে, x² + y² এর মান-',
                'subject' => 'math',
                'explanation' => '<strong>50</strong>: আমরা জানি, 2(x² + y²) = (x + y)² + (x - y)² = 8² + 6² = 64 + 36 = 100 => x² + y² = 100 / 2 = 50।',
                'options' => [
                    ['A', '40', false],
                    ['B', '60', false],
                    ['C', '50', true],
                    ['D', '80', false],
                ],
            ],
            [
                'stem' => '(a + 1/a) = √3 হলে, a² + (1/a²) এর মান-',
                'subject' => 'math',
                'explanation' => '<strong>1</strong>: a² + 1/a² = (a + 1/a)² - 2 = (√3)² - 2 = 3 - 2 = 1।',
                'options' => [
                    ['A', '6', false],
                    ['B', '4', false],
                    ['C', '2', false],
                    ['D', '1', true],
                ],
            ],
            [
                'stem' => 'একটি বর্গক্ষেত্রের বাহুর দৈর্ঘ্য ৮ ফুট হলে, ঐ বর্গক্ষেত্রের কর্ণের ওপর অঙ্কিত বর্গক্ষেত্রের ক্ষেত্রফল কত?',
                'subject' => 'math',
                'explanation' => '<strong>১২৮ বর্গফুট</strong>: বর্গক্ষেত্রের কর্ণ = বাহু × √২ = ৮√২ ফুট। কর্ণের ওপর অঙ্কিত বর্গক্ষেত্রের ক্ষেত্রফল = (কর্ণ)² = (৮√২)² = ৬৪ × ২ = ১২৮ বর্গফুট।',
                'options' => [
                    ['A', '১৫৬ বর্গফুট', false],
                    ['B', '১৬৪ বর্গফুট', false],
                    ['C', '১২৮ বর্গফুট', true],
                    ['D', '২১৮ বর্গফুট', false],
                ],
            ],
            [
                'stem' => '√2 / (√6 + 2) এর মান-',
                'subject' => 'math',
                'explanation' => '<strong>√3 - √2</strong>: হর ও লবকে (√6 - 2) দিয়ে গুণ করি: [√2(√6 - 2)] / (6 - 4) = (√12 - 2√2) / 2 = (2√3 - 2√2) / 2 = √3 - √2।',
                'options' => [
                    ['A', '√3 + √2', false],
                    ['B', '8 - √2', false],
                    ['C', '√3 - √2', true],
                    ['D', '√3 + 2', false],
                ],
            ],
            [
                'stem' => 'x² – 8x – 8y + 16 + y² এর সঙ্গে কত যোগ করলে যোগফল একটি পূর্ণবর্গ হবে?',
                'subject' => 'math',
                'explanation' => '<strong>2xy</strong>: রাশিটি = x² + y² + 16 - 8x - 8y। আমরা জানি (x - y - 4)² = x² + y² + 16 - 2xy - 8x + 8y। কিন্তু এখানে (x + y - 4)² = x² + y² + 16 + 2xy - 8x - 8y। সুতরাং প্রদত্ত রাশির সাথে 2xy যোগ করলে তা (x + y - 4)² পূর্ণবর্গ হয়।',
                'options' => [
                    ['A', '−2xy', false],
                    ['B', '8xy', false],
                    ['C', '6xy', false],
                    ['D', '2xy', true],
                ],
            ],
            [
                'stem' => 'x² – y² + 2y – 1 এর একটি উৎপাদক-',
                'subject' => 'math',
                'explanation' => '<strong>x + y − 1</strong>: x² - (y² - 2y + 1) = x² - (y - 1)² = [x + (y - 1)][x - (y - 1)] = (x + y - 1)(x - y + 1)। অতএব একটি উৎপাদক (x + y - 1)।',
                'options' => [
                    ['A', 'x+y+1', false],
                    ['B', 'x−y', false],
                    ['C', 'x+y−1', true],
                    ['D', 'x−y−1', false],
                ],
            ],
            [
                'stem' => '১৩ সে.মি. ব্যাসার্ধের বৃত্তের কেন্দ্র হতে ৫ সে.মি. দূরত্বে অবস্থিত জ্যা-এর দৈর্ঘ্য-',
                'subject' => 'math',
                'explanation' => '<strong>২৪ সে.মি.</strong>: কেন্দ্র থেকে জ্যা-এর ওপর লম্ব জ্যা-কে সমদ্বিখণ্ডিত করে। সমকোণী ত্রিভুজে পিথাগোরাসের উপপাদ্য অনুসারে: (জ্যা-এর অর্ধেক)² = ১৩² - ৫² = ১৬৯ - ২৫ = ১৪৪ => জ্যা-এর অর্ধেক = ১২ সেমি। সম্পূর্ণ জ্যা = ১২ × ২ = ২৪ সেমি।',
                'options' => [
                    ['A', '২৪ সে.মি.', true],
                    ['B', '১৮ সে.মি.', false],
                    ['C', '১৬ সে.মি.', false],
                    ['D', '১২ সে.মি.', false],
                ],
            ],
        ];

        // 2. Insert all 200 questions, options, tags and link to the 26th BCS exam
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
                'reference_source' => '২৬তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '26th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '2006',
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
