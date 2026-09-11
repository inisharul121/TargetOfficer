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

class Bcs16thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '16th')->first() ?? ExamYear::firstOrCreate(['year' => '16th'], [
            'name_en' => '16th BCS Exam',
            'name_bn' => '১৬তম বিসিএস',
        ]);
        $admin = User::where('role', 'admin')->first();

        // 1. Create or retrieve 16th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '16th-bcs-preliminary'],
            [
                'title_bn' => '১৬তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '16th BCS Preliminary Question Solution',
                'description_bn' => '১৬তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন, সঠিক উত্তর ও বিশ্লেষণধর্মী ব্যাখ্যা সমাধান।',
                'description_en' => 'Complete 100 questions, answers, and comprehensive explanations of the 16th BCS Preliminary Examination.',
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
                'stem' => 'Which of the following sentences is correct?',
                'subject' => 'english',
                'explanation' => '<strong>I forbade him to go</strong>: \'Forbid\' ক্রিয়ার past form হলো \'forbade\'। এর পর ব্যক্তিবাচক object বসে এবং পরবর্তীতে infinitive (to + verb) বসে। \'Forbid\' নিজেই নাবোধক শব্দ হওয়ায় এর সাথে অতিরিক্ত \'not\' বা \'from going\' বসে না।',
                'options' => [
                    ['A', 'I forbade him from going', false],
                    ['B', 'I forbade him to go', true],
                    ['C', 'I forbade him going', false],
                    ['D', 'I forbade him not to go', false],
                ],
            ],
            [
                'stem' => 'Which of the following is a correct proverb?',
                'subject' => 'english',
                'explanation' => '<strong>Fools rush in where angels fear to tread</strong>: এটি আলেকজান্ডার পোপের (Alexander Pope) \'An Essay on Criticism\' কাব্যের বিখ্যাত প্রবচন। এর অর্থ হলো মূর্খরা হিতাহিত জ্ঞান না করে এমন ঝুঁকিপূর্ণ জায়গায় নেমে পড়ে যেখানে জ্ঞানীরাও পা ফেলতে ভয় পান।',
                'options' => [
                    ['A', 'Fools rush in where angels fear to tread.', true],
                    ['B', 'Fools rush in where an angel fears to tread.', false],
                    ['C', 'A fools rushes in where an angle fears to tread', false],
                    ['D', 'Fools rush in where the angels fear to tread.', false],
                ],
            ],
            [
                'stem' => 'Which of the following sentences is correct?',
                'subject' => 'english',
                'explanation' => '<strong>Why have you done this?</strong>: Wh-interrogative বাক্যে গঠনরীতি হলো: Wh-word + auxiliary verb (have) + subject (you) + main verb past participle (done) + extension (this)? তাই \'Why have you done this?\' বাক্যটি ব্যাকরণগতভাবে শুদ্ধ।',
                'options' => [
                    ['A', 'Why you have done this?', false],
                    ['B', 'Why did you have done this?', false],
                    ['C', 'Why have you done this?', true],
                    ['D', 'Why you had done this?', false],
                ],
            ],
            [
                'stem' => 'Which of the following sentences is correct?',
                'subject' => 'english',
                'explanation' => '<strong>The shirt which he bought is blue in colour.</strong>: নির্দিষ্ট কোনো শার্ট বোঝাতে definite article \'The\' ব্যবহৃত হয় এবং অপ্রাণিবাচক বস্তু শার্টের ক্ষেত্রে relative pronoun হিসেবে \'which\' বসে।',
                'options' => [
                    ['A', 'That shirt which he bought is blue in colour.', false],
                    ['B', 'The shirt that which he bought is blue in colour.', false],
                    ['C', 'Which shirt he bought is blue in colour.', false],
                    ['D', 'The shirt which he bought is blue in colour.', true],
                ],
            ],
            [
                'stem' => 'The correct passive of ‘Sheila was writing a letter’ is–',
                'subject' => 'english',
                'explanation' => '<strong>A letter was being written by Sheila</strong>: Past Continuous Tense-এর passive voice গঠন নিয়ম: Object-এর subject (\'A letter\') + was/were + being + verb-এর past participle (\'written\') + by + subject-এর object (\'Sheila\')।',
                'options' => [
                    ['A', 'A letter was writing by Sheila', false],
                    ['B', 'A letter was being writing by Sheila', false],
                    ['C', 'A letter was being written by Sheila', true],
                    ['D', 'A letter was been written by Sheila', false],
                ],
            ],
            [
                'stem' => 'কোন গ্রন্থটি ঢাকা হতে প্রথম প্রকাশিত হয়েছিল?',
                'subject' => 'bangla',
                'explanation' => '<strong>নীলদর্পণ</strong>: দীনবন্ধু মিত্রের বিখ্যাত নাটক ‘নীলদর্পণ’ ১৮৬০ সালে ঢাকার বাংলা প্রেস (হরিশচন্দ্র মিত্র প্রতিষ্ঠিত) থেকে প্রথম মুদ্রিত ও প্রকাশিত হয়েছিল। এটি ঢাকায় মুদ্রিত প্রথম নাটক।',
                'options' => [
                    ['A', 'মেঘনাদবধ কাব্য', false],
                    ['B', 'দুর্গেশনন্দিনী', false],
                    ['C', 'নীলদর্পণ', true],
                    ['D', 'অগ্নিবীণা', false],
                ],
            ],
            [
                'stem' => '‘পথিক তুমি কি পথ হারাইয়াছ?’ কথাটি কার?',
                'subject' => 'bangla',
                'explanation' => '<strong>বঙ্কিমচন্দ্র চট্টোপাধ্যায়</strong>: সাহিত্যসম্রাট বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের রোমান্টিক উপন্যাস ‘কপালকুণ্ডলা’ (১৮৬৬)-এর নায়িকা কপালকুণ্ডলার বিখ্যাত অমর উক্তি এটি, যা তিনি নবকুমারকে উদ্দেশ্য করে বলেছিলেন।',
                'options' => [
                    ['A', 'রবীন্দ্রনাথ ঠাকুর', false],
                    ['B', 'বঙ্কিমচন্দ্র চট্টোপাধ্যায়', true],
                    ['C', 'মীর মশাররফ হোসেন', false],
                    ['D', 'শরৎচন্দ্র চট্টোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => 'প্রত্যয়গত ভাবে শুদ্ধ কোনটি?',
                'subject' => 'bangla',
                'explanation' => '<strong>উৎকৃষ্ট</strong>: \'উৎকর্ষ\' শব্দটি নিজেই বিশেষ্য (উৎ + কৃষ্ + অ)। এর সাথে অতিরিক্ত ভাববাচক প্রত্যয় \'তা\' যুক্ত করে \'উৎকর্ষতা\' গঠন করলে তা প্রত্যয়জনিত ভুল হয়। বিশেষণ রূপ হিসেবে \'উৎকৃষ্ট\' (উৎ + কৃষ্ + ত) প্রত্যয়গতভাবে সম্পূর্ণ শুদ্ধ।',
                'options' => [
                    ['A', 'উৎকর্ষতা', false],
                    ['B', 'উৎকর্ষ', false],
                    ['C', 'উৎকৃষ্ট', true],
                    ['D', 'উৎকৃষ্ঠতা', false],
                ],
            ],
            [
                'stem' => '‘অচিন’ শব্দের ‘অ’ উপসর্গটি কোন অর্থে ব্যবহৃত?',
                'subject' => 'bangla',
                'explanation' => '<strong>নঞর্থক</strong>: খাঁটি বাংলা উপসর্গ \'অ\' এখানে \'অচিন\' (যার কোনো চেনা বা পরিচিতি নেই) শব্দে নঞর্থক বা অভাব/নেতিবাচক অর্থে ব্যবহৃত হয়েছে।',
                'options' => [
                    ['A', 'নেতিবাচক', false],
                    ['B', 'বিয়োগান্ত', false],
                    ['C', 'নঞর্থক', true],
                    ['D', 'অজানা', false],
                ],
            ],
            [
                'stem' => 'বাংলায় ইউরোপীয় বণিকদের মধ্যে কারা প্রথম এসেছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>পর্তুগিজরা</strong>: ভাস্কো দা গামার জলপথ আবিষ্কারের পর ভারতবর্ষে এবং বাংলায় ইউরোপীয় বণিকদের মধ্যে প্রথম আগমন ঘটে পর্তুগিজদের (১৪৯৮ সালে ভারতে, এবং ষোড়শ শতকের শুরুর দিকে বাংলায়)।',
                'options' => [
                    ['A', 'ইংরেজরা', false],
                    ['B', 'ফরাসিরা', false],
                    ['C', 'ওলন্দাজরা', false],
                    ['D', 'পর্তুগিজরা', true],
                ],
            ],
            [
                'stem' => 'জিয়া সার কারখানায় উৎপাদিত সারের নাম কী?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ইউরিয়া</strong>: জামালপুর জেলার তারাকান্দিতে অবস্থিত জিয়া সার কারখানা (বর্তমানে যমুনা সার কারখানা)-য় প্রাকৃতিক গ্যাসকে কাঁচামাল হিসেবে ব্যবহার করে ইউরিয়া সার উৎপাদন করা হয়।',
                'options' => [
                    ['A', 'অ্যামোনিয়া', false],
                    ['B', 'সুপার ফসফেট', false],
                    ['C', 'টিএসপি', false],
                    ['D', 'ইউরিয়া', true],
                ],
            ],
            [
                'stem' => '‘সব কটা জানালা খুলে দাও না’ এর গীতিকার কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>মরহুম নজরুল ইসলাম বাবু</strong>: মুক্তিযুদ্ধভিত্তিক কালজয়ী দেশাত্মবোধক গান ‘সব কটা জানালা খুলে দাও না’-এর গীতিকার মরহুম নজরুল ইসলাম বাবু, সুরকার আহমেদ ইমতিয়াজ বুলবুল এবং কণ্ঠশিল্পী সাবিনা ইয়াসমিন।',
                'options' => [
                    ['A', 'মরহুম আলতাফ মাহমুদ', false],
                    ['B', 'মরহুম নজরুল ইসলাম বাবু', true],
                    ['C', 'ড. মনিরুজ্জামান', false],
                    ['D', 'মরহুম ড. আবুহেনা মোস্তফা কামাল', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের জাতীয় পতাকার ডিজাইনার কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>কামরুল হাসান</strong>: বাংলাদেশের বর্তমান জাতীয় পতাকার চূড়ান্ত নকশা ও রূপকার পটুয়া কামরুল হাসান। ১৯৭১ সালে প্রাথমিক পতাকার মাঝে মানচিত্র খচিত নকশা করেছিলেন শিবনারায়ণ দাস।',
                'options' => [
                    ['A', 'জয়নুল আবেদীন', false],
                    ['B', 'কামরুল হাসান', true],
                    ['C', 'হাশেম খান', false],
                    ['D', 'হামিদুর রহমান', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের রাষ্ট্রপতি শাসিত সরকারের পরিবর্তে সংসদীয় শাসনব্যবস্থা চালু হয় সংবিধানের কত নম্বর সংশোধনীর মাধ্যমে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১২</strong>: ১৯৯১ সালে সংবিধানের দ্বাদশ সংশোধনীর মাধ্যমে বাংলাদেশে দীর্ঘ ১৬ বছর পর পুনরায় সংসদীয় পদ্ধতির সরকার ব্যবস্থা চালু হয় এবং রাষ্ট্রপতি পদটি নিয়মতান্ত্রিক করা হয়।',
                'options' => [
                    ['A', '১০', false],
                    ['B', '১১', false],
                    ['C', '১২', true],
                    ['D', '১৩', false],
                ],
            ],
            [
                'stem' => 'Asia Pacific Economic Co-operation (APEC) ফোরামের নভেম্বর, ১৯৯৩-এ অনুষ্ঠিত বৈঠকে কোন সদস্য দেশের সরকার প্রধান অনুপস্থিত ছিলেন?',
                'subject' => 'international',
                'explanation' => '<strong>জাপান</strong>: ১৯৯৩ সালের নভেম্বরে যুক্তরাষ্ট্রের সিয়াটলে অনুষ্ঠিত অ্যাপেক (APEC) শীর্ষ সম্মেলনে জাপানের তৎকালীন প্রধানমন্ত্রী রাজনৈতিক অভ্যন্তরীণ সংকটের কারণে উপস্থিত থাকতে পারেননি।',
                'options' => [
                    ['A', 'মালয়েশিয়া', false],
                    ['B', 'ফিলিপাইন', false],
                    ['C', 'অস্ট্রেলিয়া', false],
                    ['D', 'জাপান', true],
                ],
            ],
            [
                'stem' => 'গিরিজা প্রসাদ কৈরালা কত তারিখে নেপালের প্রধানমন্ত্রীর পদ থেকে পদত্যাগ করেন?',
                'subject' => 'international',
                'explanation' => '<strong>১০ জুলাই, ১৯৯৪</strong>: নেপালি কংগ্রেসের অভ্যন্তরীণ কোন্দল ও সংসদে সরকারের নীতি পাস না হওয়ার প্রেক্ষিতে প্রধানমন্ত্রী গিরিজা প্রসাদ কৈরালা ১৯৯৪ সালের ১০ জুলাই পদত্যাগ করেন।',
                'options' => [
                    ['A', '৮ জুলাই, ১৯৯৪', false],
                    ['B', '৯ জুলাই, ১৯৯৪', false],
                    ['C', '১০ জুলাই, ১৯৯৪', true],
                    ['D', '১১ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => 'Hubble Telescope-এর ত্রুটি সংশোধনকল্পে মহাশূন্যে কোন নভোযানে নভোচারীগণকে প্রেরণ করা হয়েছিল?',
                'subject' => 'science',
                'explanation' => '<strong>Endeavour</strong>: ১৯৯৩ সালের ডিসেম্বরে নাসা স্পেস শাটল \'এন্ডেভার\' (Endeavour - মিশন STS-61)-এর মাধ্যমে নভোচারী পাঠিয়ে মহাশূন্যে হাবল স্পেস টেলিস্কোপের প্রাথমিক ত্রুটিপূর্ণ আয়না সফলভাবে মেরামত করে।',
                'options' => [
                    ['A', 'Endeavour', true],
                    ['B', 'Challenger', false],
                    ['C', 'Pathfinder', false],
                    ['D', 'Apollo', false],
                ],
            ],
            [
                'stem' => 'রুয়ান্ডার প্যাট্রিয়টিক ফ্রন্ট সরকার কবে শপথ গ্রহণ করেন?',
                'subject' => 'international',
                'explanation' => '<strong>১৯ জুলাই, ১৯৯৪</strong>: রুয়ান্ডা গণহত্যার অবসানের পর পল কাগামের নেতৃত্বাধীন রুয়ান্ডান প্যাট্রিয়টিক ফ্রন্ট (RPF) ১৯৯৪ সালের ১৯ জুলাই আনুষ্ঠানিকভাবে নতুন জোট সরকার গঠন ও শপথ গ্রহণ করে।',
                'options' => [
                    ['A', '৮ জুলাই, ১৯৯৪', false],
                    ['B', '১৯ জুলাই, ১৯৯৪', true],
                    ['C', '২৪ জুলাই, ১৯৯৪', false],
                    ['D', '২৭ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => 'পিএলও চেয়ারম্যান ইয়াসির আরাফাত তিউনিসিয়ায় নির্বাসিত জীবন ছেড়ে স্থায়ীভাবে বসবাসের উদ্দেশ্যে কবে গাজা ভূখণ্ডে আসেন?',
                'subject' => 'international',
                'explanation' => '<strong>১ জুলাই, ১৯৯৪</strong>: অসলো চুক্তির ধারাবাহিকতায় দীর্ঘ ২৭ বছরের নির্বাসিত জীবন শেষ করে ফিলিস্তিন মুক্তি সংস্থার (PLO) নেতা ইয়াসির আরাফাত ১৯৯৪ সালের ১ জুলাই ঐতিহাসিক গাজা ভূখণ্ডে পদার্পণ করেন।',
                'options' => [
                    ['A', '১১ জুলাই, ১৯৯৪', false],
                    ['B', '১২ জুলাই, ১৯৯৪', false],
                    ['C', '১৩ জুলাই, ১৯৯৪', false],
                    ['D', '১ জুলাই, ১৯৯৪', true],
                ],
            ],
            [
                'stem' => 'উপকূলে কোনো একটি স্থানে পর পর দুটি জোয়ারের মধ্যে ব্যবধান হলো-',
                'subject' => 'science',
                'explanation' => '<strong>প্রায় ১২ ঘণ্টা</strong>: পৃথিবীর আহ্নিক গতি ও চাঁদের পরিক্রমণ গতির কারণে উপকূলীয় কোনো স্থানে একটি মুখ্য জোয়ারের প্রায় ১২ ঘণ্টা ২৬ মিনিট পর একটি গৌণ জোয়ার সংঘটিত হয়, অর্থাৎ পরপর দুটি জোয়ারের ব্যবধান প্রায় ১২ ঘণ্টা।',
                'options' => [
                    ['A', 'প্রায় ১২ ঘণ্টা', true],
                    ['B', 'প্রায় ২৪ ঘণ্টা', false],
                    ['C', 'প্রায় ৬ ঘণ্টা', false],
                    ['D', 'চাঁদের তিথি অনুসারে ভিন্ন', false],
                ],
            ],
            [
                'stem' => 'নাড়ীর স্পন্দন প্রবাহিত হয়-',
                'subject' => 'science',
                'explanation' => '<strong>ধমনির ভেতর দিয়ে</strong>: হৃৎপিণ্ডের সংকোচন ও প্রসারণের ফলে রক্ত যখন তীব্র বেগে ধমনি (Artery) দিয়ে প্রবাহিত হয়, তখন ধমনির প্রাচীর স্পন্দিত হয়। এই স্পন্দনকেই আমরা নাড়ীর স্পন্দন (Pulse) বলি।',
                'options' => [
                    ['A', 'ধমনির ভেতর দিয়ে', true],
                    ['B', 'শিরার ভেতর দিয়ে', false],
                    ['C', 'স্নায়ুর ভেতর দিয়ে', false],
                    ['D', 'ল্যাকটিয়ালের ভেতর দিয়ে', false],
                ],
            ],
            [
                'stem' => 'চাঁদে কোনো শব্দ করলে তা শোনা যাবে না কেন?',
                'subject' => 'science',
                'explanation' => '<strong>চাঁদে বায়ুমণ্ডল নাই তাই</strong>: শব্দ তরঙ্গ একটি যান্ত্রিক তরঙ্গ, যা সঞ্চালনের জন্য জড় মাধ্যমের প্রয়োজন। চাঁদে কোনো বায়ুমণ্ডল বা বাতাস না থাকায় শব্দ প্রবাহিত হতে পারে না এবং শব্দ শোনা যায় না।',
                'options' => [
                    ['A', 'চাঁদে কোনো জীব নাই তাই', false],
                    ['B', 'চাঁদে কোনো পানি নাই তাই', false],
                    ['C', 'চাঁদে বায়ুমণ্ডল নাই তাই', true],
                    ['D', 'চাঁদের মাধ্যাকর্ষণজনিত ত্বরণ পৃথিবীর মাধ্যাকর্ষণজনিত ত্বরণ অপেক্ষা কম তাই', false],
                ],
            ],
            [
                'stem' => 'বৃত্তের পরিধি ও ব্যাসের অনুপাত-',
                'subject' => 'math',
                'explanation' => '<strong>২২/৭</strong>: বৃত্তের পরিধি ও ব্যাসের অনুপাত একটি ধ্রুব সংখ্যা, যাকে পাই ($\\pi$) বলা হয়। এর আসন্ন ভগ্নাংশ মান হলো ২২/৭ বা ৩.১৪১৫৯...।',
                'options' => [
                    ['A', '৩', false],
                    ['B', '২২/৭', true],
                    ['C', '২৫/৯', false],
                    ['D', 'প্রায় ৫', false],
                ],
            ],
            [
                'stem' => 'রঙিন টেলিভিশন হতে ক্ষতিকর কোন রশ্মি বের হয়?',
                'subject' => 'science',
                'explanation' => '<strong>মৃদু রঞ্জন রশ্মি</strong>: পুরাতন ক্যাথোড রে টিউব (CRT) প্রযুক্তির রঙিন টেলিভিশনে ইলেকট্রন গান থেকে নির্গত তীব্র ইলেকট্রন স্রোত স্ক্রিনে আঘাতের সময় মৃদু এক্স-রে বা মৃদু রঞ্জন রশ্মি উৎপন্ন হতো।',
                'options' => [
                    ['A', 'মৃদু রঞ্জন রশ্মি', true],
                    ['B', 'গামা রশ্মি', false],
                    ['C', 'বিটা রশ্মি', false],
                    ['D', 'কসমিক রশ্মি', false],
                ],
            ],
            [
                'stem' => 'যা চিরস্থায়ী নয়-',
                'subject' => 'bangla',
                'explanation' => '<strong>নশ্বর</strong>: বাক্য সংকোচন: যা চিরস্থায়ী নয় = নশ্বর। অন্যদিকে যা অল্পকাল স্থায়ী হয় = ক্ষণস্থায়ী/ক্ষণিক।',
                'options' => [
                    ['A', 'অস্থায়ী', false],
                    ['B', 'ক্ষণিক', false],
                    ['C', 'ক্ষণস্থায়ী', false],
                    ['D', 'নশ্বর', true],
                ],
            ],
            [
                'stem' => 'Intellectual শব্দের বাংলা অর্থ-',
                'subject' => 'english',
                'explanation' => '<strong>বুদ্ধিজীবী</strong>: ইংরেজি শব্দ \'Intellectual\' বিশেষ্য (noun) হিসেবে ব্যবহৃত হলে তার অর্থ বুদ্ধিজীবী বা প্রজ্ঞাবান ব্যক্তি; আর বিশেষণ হিসেবে অর্থ বুদ্ধিবৃত্তিক বা মননশীল।',
                'options' => [
                    ['A', 'বুদ্ধিমান', false],
                    ['B', 'মননশীল', false],
                    ['C', 'বুদ্ধিজীবী', true],
                    ['D', 'মেধাবী', false],
                ],
            ],
            [
                'stem' => 'কোন নগরীতে মোঘল আমলে সুবে বাংলার রাজধানী ছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ঢাকা</strong>: ১৬১০ খ্রিস্টাব্দে সুবাদার ইসলাম খান চিশতি বাংলার রাজধানী রাজমহল থেকে ঢাকায় স্থানান্তর করেন এবং সম্রাট জাহাঙ্গীরের নামানুসারে এর নাম রাখেন \'জাহাঙ্গীরনগর\'।',
                'options' => [
                    ['A', 'গৌড়', false],
                    ['B', 'সোনারগাঁও', false],
                    ['C', 'ঢাকা', true],
                    ['D', 'হুগলী', false],
                ],
            ],
            [
                'stem' => '‘অবমূল্যায়ন’ ও ‘অবদান’ শব্দ দুটিতে ‘অব’ উপসর্গটি সম্পর্কে কোন মন্তব্যটি ঠিক?',
                'subject' => 'bangla',
                'explanation' => '<strong>দুটি শব্দের উপসর্গটির অর্থ দুই রকম</strong>: ‘অবমূল্যায়ন’ শব্দে ‘অব’ উপসর্গটি হীনতা বা খাটো করা অর্থে ব্যবহৃত হয়েছে, কিন্তু ‘অবদান’ শব্দে ‘অব’ উপসর্গটি মহৎ বা উত্তম কীর্তি অর্থে ব্যবহৃত হয়েছে।',
                'options' => [
                    ['A', 'শব্দ দুটিতে উপসর্গটি মোটামুটি একই অর্থে ব্যবহৃত হয়েছে', false],
                    ['B', 'শব্দ দুটিতে উপসর্গটি একই অর্থে ব্যবহৃত হয়েছে', false],
                    ['C', 'দুটি শব্দে উপসর্গটির অর্থ আপাতবিচারে ভিন্ন হলেও আসল এক', false],
                    ['D', 'দুটি শব্দের উপসর্গটির অর্থ দুই রকম', true],
                ],
            ],
            [
                'stem' => '‘জ্ঞান যেখানে সীমাবদ্ধ, বুদ্ধি সেখানে আড়ষ্ট, মুক্তি সেখানে অসম্ভব।’-এই উক্তিটি কোন পত্রিকার প্রতি সংখ্যায় লেখা থাকত?',
                'subject' => 'bangla',
                'explanation' => '<strong>শিখা</strong>: ১৯২৬ সালে ঢাকায় প্রতিষ্ঠিত \'মুসলিম সাহিত্য সমাজ\'-এর মুখপত্র ছিল বার্ষিক পত্রিকা \'শিখা\'। এর প্রতিটি সংখ্যার শীর্ষদেশে এই নীতিবাক্যটি মুদ্রিত থাকত।',
                'options' => [
                    ['A', 'সওগাত', false],
                    ['B', 'মোহাম্মদী', false],
                    ['C', 'সমকাল', false],
                    ['D', 'শিখা', true],
                ],
            ],
            [
                'stem' => 'একজন দোকানদার ৭ ১/২ % ক্ষতিতে একটি দ্রব্য বিক্রয় করল। যদি দ্রব্যটির ক্রয়মূল্য ১০% কম হতো এবং বিক্রয়মূল্য ৩১ টাকা বেশি হতো, তাহলে তার ২০% লাভ হতো। দ্রব্যটির ক্রয়মূল্য কত?',
                'subject' => 'math',
                'explanation' => '<strong>২০০ টাকা</strong>: ধরি ক্রয়মূল্য ১০০x টাকা। প্রাথমিক বিক্রয়মূল্য = ৯২.৫x টাকা। নতুন ক্রয়মূল্য = ৯০x টাকা। ২০% লাভে নতুন বিক্রয়মূল্য = ৯০x × ১.২ = ১০৮x টাকা। প্রশ্নমতে, ১০৮x - ৯২.৫x = ৩১ => ১৫.৫x = ৩১ => x = ২। অতএব ক্রয়মূল্য = ১০০ × ২ = ২০০ টাকা।',
                'options' => [
                    ['A', '১০০ টাকা', false],
                    ['B', '২০০ টাকা', true],
                    ['C', '৩০০ টাকা', false],
                    ['D', '৪০০ টাকা', false],
                ],
            ],
            [
                'stem' => 'দুই ব্যক্তি একত্রে একটি কাজ ৮ দিনে করতে পারে। প্রথম ব্যক্তি একাকী কাজটি ১২ দিনে করতে পারে। দ্বিতীয় ব্যক্তি একাকী কাজটি কত দিনে করতে পারবে?',
                'subject' => 'math',
                'explanation' => '<strong>২৪ দিনে</strong>: ১ দিনে দুজনের কাজ = ১/৮ অংশ। প্রথম ব্যক্তির ১ দিনের কাজ = ১/১২ অংশ। অতএব দ্বিতীয় ব্যক্তির ১ দিনের কাজ = ১/৮ - ১/১২ = (৩ - ২)/২৪ = ১/২৪ অংশ। সুতরাং দ্বিতীয় ব্যক্তি একাকী কাজটি ২৪ দিনে সম্পন্ন করতে পারবে।',
                'options' => [
                    ['A', '২০ দিনে', false],
                    ['B', '২২ দিনে', false],
                    ['C', '২৪ দিনে', true],
                    ['D', '২৬ দিনে', false],
                ],
            ],
            [
                'stem' => '৫০০ টাকার ৪ বছরের সুদ এবং ৬০০ টাকার ৫ বছরের সুদ একত্রে ৫০০ টাকা হলে সুদের হার কত?',
                'subject' => 'math',
                'explanation' => '<strong>১০%</strong>: ধরি সুদের হার r%। ৫০০ টাকার ৪ বছরের সুদ = (৫০০ × ৪ × r)/১০০ = ২০r। ৬০০ টাকার ৫ বছরের সুদ = (৬০০ × ৫ × r)/১০০ = ৩০r। মোট সুদ = ২০r + ৩০r = ৫০r। প্রশ্নমতে, ৫০r = ৫০০ => r = ১০%।',
                'options' => [
                    ['A', '৫%', false],
                    ['B', '৬%', false],
                    ['C', '১০%', true],
                    ['D', '১২%', false],
                ],
            ],
            [
                'stem' => 'কোন লঘিষ্ঠ সংখ্যার সাথে ৩ যোগ করলে যোগফল ২৪, ৩৬ এবং ৪৮ দ্বারা বিভাজ্য হবে?',
                'subject' => 'math',
                'explanation' => '<strong>১৪১</strong>: ২৪, ৩৬ ও ৪৮ এর ল.সা.গু নির্ণয় করি: ২৪ = ২³ × ৩, ৩৬ = ২² × ৩², ৪৮ = ২⁴ × ৩। ল.সা.গু = ২⁴ × ৩² = ১৪৪। যেহেতু ৩ যোগ করলে ১৪৪ হবে, তাই নির্ণেয় সংখ্যাটি = ১৪৪ - ৩ = ১৪১।',
                'options' => [
                    ['A', '৮৯', false],
                    ['B', '১৪১', true],
                    ['C', '২৪৮', false],
                    ['D', '১৭০', false],
                ],
            ],
            [
                'stem' => 'নিম্নলিখিত চারটি সংখ্যার মধ্যে কোনটির ভাজক সংখ্যা বিজোড়?',
                'subject' => 'math',
                'explanation' => '<strong>১০২৪</strong>: যেকোনো পূর্ণবর্গ সংখ্যার উৎপাদক বা ভাজক সংখ্যা সর্বদা বিজোড় হয়। এখানে ১০২৪ = ৩২², তাই এটি একটি পূর্ণবর্গ সংখ্যা এবং এর মোট ভাজক সংখ্যা বিজোড় (১০২৪ = ২¹⁰, ভাজক সংখ্যা ১০ + ১ = ১১টি)।',
                'options' => [
                    ['A', '২০৪৮', false],
                    ['B', '৫১২', false],
                    ['C', '১০২৪', true],
                    ['D', '৪৮', false],
                ],
            ],
            [
                'stem' => 'জর্ডান ও ইসরাইলের মধ্যে ৪৬ বছরের যুদ্ধাবস্থায় আনুষ্ঠানিক অবসানের লক্ষ্যে কবে জর্ডানের বাদশাহ হোসেন এবং ইসরাইলের প্রধানমন্ত্রী ইসহাক রবিন একটি ঐতিহাসিক ঘোষণায় স্বাক্ষর করেন?',
                'subject' => 'international',
                'explanation' => '<strong>২৬ জুলাই, ১৯৯৪</strong>: ওয়াশিংটনে মার্কিন প্রেসিডেন্ট বিল ক্লিনটনের উপস্থিতিতে জর্ডানের বাদশাহ হোসেন ও ইসরাইলের প্রধানমন্ত্রী ইসহাক রবিন ঐতিহাসিক ওয়াশিংটন ঘোষণায় স্বাক্ষর করে দীর্ঘ ৪৬ বছরের যুদ্ধাবস্থার ইতি টানেন।',
                'options' => [
                    ['A', '২৪ জুলাই, ১৯৯৪', false],
                    ['B', '২৫ জুলাই, ১৯৯৪', false],
                    ['C', '২৬ জুলাই, ১৯৯৪', true],
                    ['D', '২৭ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => 'বি-৫২ কী?',
                'subject' => 'international',
                'explanation' => '<strong>এক ধরনের বোমারু বিমান</strong>: বোয়িং বি-৫২ স্ট্র্যাটোফোর্ট্রেস (Boeing B-52 Stratofortress) হলো মার্কিন যুক্তরাষ্ট্রের দূরপাল্লার দূরপাল্লার কৌশলগত ভারী বোমারু বিমান (Heavy Bomber)।',
                'options' => [
                    ['A', 'এক ধরনের যাত্রীবাহী বিমান', false],
                    ['B', 'এক বিশেষ ধরনের হেলিকপ্টার', false],
                    ['C', 'এক ধরনের বোমারু বিমান', true],
                    ['D', 'ভূমি হতে শূন্যে নিক্ষেপণযোগ্য এক ধরনের ক্ষেপণাস্ত্র', false],
                ],
            ],
            [
                'stem' => '‘Straw vote’ বলতে কী বোঝায়?',
                'subject' => 'english',
                'explanation' => '<strong>Unofficial poll of public opinion</strong>: \'Straw vote\' বা \'Straw poll\' হলো অনানুষ্ঠানিক জনমত যাচাইকরণ বা ভোটাভুটি, যার মাধ্যমে কোনো নির্দিষ্ট বিষয়ে জনগণের মনোভাব বা পূর্বাভাস বোঝা যায়।',
                'options' => [
                    ['A', 'Unofficial poll of public opinion', true],
                    ['B', 'Poll based on random representations', false],
                    ['C', '‘Yes-No’ vote', false],
                    ['D', 'Manipulated elections', false],
                ],
            ],
            [
                'stem' => '‘Rotary International’ কবে প্রতিষ্ঠিত হয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১৯০৫ সালে</strong>: মার্কিন আইনজীবী পল হ্যারিস (Paul P. Harris) কর্তৃক ১৯০৫ সালের ২৩ ফেব্রুয়ারি শিকাগো শহরে আন্তর্জাতিক সামাজিক সেবা সংস্থা রোটারি ইন্টারন্যাশনাল প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯০৩ সালে', false],
                    ['B', '১৯০৫ সালে', true],
                    ['C', '১৯৬১ সালে', false],
                    ['D', '১৯১২ সালে', false],
                ],
            ],
            [
                'stem' => 'বার্লিনের দেয়াল কত সালে নির্মিত হয়েছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৬১ সালে</strong>: স্নায়ুযুদ্ধের সময় পূর্ব জার্মানি ও পশ্চিম জার্মানির বিভাজনরেখা হিসেবে ১৯৬১ সালের ১৩ আগস্ট তৎকালীন কমিউনিস্ট পূর্ব জার্মানি বার্লিনের দেয়াল নির্মাণ শুরু করে (এবং এটি ১৯৮৯ সালের ৯ নভেম্বর ভেঙে ফেলা হয়)।',
                'options' => [
                    ['A', '১৯৪৬ সালে', false],
                    ['B', '১৯৪৮ সালে', false],
                    ['C', '১৯৬১ সালে', true],
                    ['D', '১৯৬২ সালে', false],
                ],
            ],
            [
                'stem' => 'Which of the following sentences correct?',
                'subject' => 'english',
                'explanation' => '<strong>One of my friends is a lawyer</strong>: \'One of\'-এর পরে noun টি সর্বদা plural (\'my friends\') হয়, কিন্তু verb টি singular (\'is\') হয়।',
                'options' => [
                    ['A', 'One of the friends are a lawyer', false],
                    ['B', 'One of my friends is a lawyer', true],
                    ['C', 'One of my friend is a lawyer', false],
                    ['D', 'One of my friends are lawyers', false],
                ],
            ],
            [
                'stem' => 'The word ‘ecological’ is related to––',
                'subject' => 'english',
                'explanation' => '<strong>environment</strong>: \'Ecological\' শব্দটি Ecology (বাস্তুবিদ্যা/পরিবেশবিজ্ঞান) থেকে এসেছে, যা জীব এবং তার চারপাশের পরিবেশের (environment) পারস্পরিক সম্পর্ক নির্দেশ করে।',
                'options' => [
                    ['A', 'atmosphere', false],
                    ['B', 'pollution', false],
                    ['C', 'environment', true],
                    ['D', 'demography', false],
                ],
            ],
            [
                'stem' => 'The synonym of ‘genesis’ is––',
                'subject' => 'english',
                'explanation' => '<strong>beginning</strong>: \'Genesis\' শব্দের অর্থ সূচনা, উৎপত্তি বা প্রারম্ভ। এর যথাযথ সমার্থক শব্দ হলো \'beginning\' বা \'origin\'।',
                'options' => [
                    ['A', 'introduction', false],
                    ['B', 'preface', false],
                    ['C', 'beginning', true],
                    ['D', 'foreword', false],
                ],
            ],
            [
                'stem' => 'The word ‘homogeneous’ means––',
                'subject' => 'english',
                'explanation' => '<strong>Of the same kind</strong>: \'Homogeneous\' শব্দের অর্থ সমজাতীয় বা একই ধরনের (Of the same kind or nature throughout)।',
                'options' => [
                    ['A', 'Of the same kind', true],
                    ['B', 'Of the same place', false],
                    ['C', 'Of the same race', false],
                    ['D', 'Of the same density', false],
                ],
            ],
            [
                'stem' => 'The word ‘imbibe’ means––',
                'subject' => 'english',
                'explanation' => '<strong>to drink</strong>: \'Imbibe\' ক্রিয়াপদের আভিধানিক অর্থ পান করা (to drink alcohol or liquids) কিংবা আত্মস্থ/গ্রহণ করা (to absorb ideas)।',
                'options' => [
                    ['A', 'to learn', false],
                    ['B', 'to tinge', false],
                    ['C', 'to drink', true],
                    ['D', 'to acquire', false],
                ],
            ],
            [
                'stem' => 'স্বাধীন বাংলাদেশে ১০০ টাকার নোট কবে প্রথম চালু করা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪ মার্চ, ১৯৭২</strong>: স্বাধীন বাংলাদেশে প্রথম ১ টাকা ও ১০০ টাকার কাগুজে কারেন্সি নোট ১৯৭২ সালের ৪ মার্চ আনুষ্ঠানিকভাবে বাজারে চালু করা হয়।',
                'options' => [
                    ['A', '২৬ মার্চ, ১৯৭২', false],
                    ['B', '১৬ ডিসেম্বর, ১৯৭২', false],
                    ['C', '৪ মার্চ, ১৯৭২', true],
                    ['D', '৪ জানুয়ারি, ১৯৭৩', false],
                ],
            ],
            [
                'stem' => 'স্বাধীন বাংলাদেশকে কখন মার্কিন যুক্তরাষ্ট্র স্বীকৃতি দান করে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৪ এপ্রিল, ১৯৭২</strong>: ১৯৭১ সালের মহান মুক্তিযুদ্ধে রাজনৈতিক বৈরিতা সত্ত্বেও মার্কিন যুক্তরাষ্ট্র স্বাধীন বাংলাদেশকে আনুষ্ঠানিকভাবে ১৯৭২ সালের ৪ এপ্রিল সার্বভৌম রাষ্ট্র হিসেবে স্বীকৃতি দেয়।',
                'options' => [
                    ['A', '৪ ফেব্রুয়ারি, ১৯৭২', false],
                    ['B', '২৪ জানুয়ারি, ১৯৭২', false],
                    ['C', '১৬ ডিসেম্বর, ১৯৭২', false],
                    ['D', '৪ এপ্রিল, ১৯৭২', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে জাতীয় সংসদে ‘উপজেলা বাতিল’ বিলটি কখন পাস হয়েছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৯৯২ সালে</strong>: এরশাদ সরকারের চালু করা উপজেলা পরিষদ ব্যবস্থা বাতিলের লক্ষ্যে ১৯৯২ সালে ৫ম জাতীয় সংসদে \'স্থানীয় সরকার (উপজেলা পরিষদ ও উপজেলা প্রশাসন পুনর্গঠন) (বাতিল) আইন, ১৯৯২\' পাস হয়।',
                'options' => [
                    ['A', '১৯৯২ সালে', true],
                    ['B', '১৯৯৩ সালে', false],
                    ['C', '১৯৯১ সালে', false],
                    ['D', '১৯৯০ সালে', false],
                ],
            ],
            [
                'stem' => 'ঢাকা পৌরসভা কোন সালে প্রতিষ্ঠিত হয়েছিল?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১৮৬৪ সালে</strong>: ব্রিটিশ ভারতে ১৮৬৪ সালের ১ আগস্ট ঢাকা মিউনিসিপ্যালিটি বা ঢাকা পৌরসভা আনুষ্ঠানিকভাবে প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯০৬ সালে', false],
                    ['B', '১৮৬৪ সালে', true],
                    ['C', '১৯১৯ সালে', false],
                    ['D', '১৯৪০ সালে', false],
                ],
            ],
            [
                'stem' => 'লালবাগের কেল্লা স্থাপন করেন কে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>শায়েস্তা খান</strong>: লালবাগ কেল্লার নির্মাণকাজ ১৬৭৮ সালে সুবাদার মুহাম্মদ আজম শাহ শুরু করলেও তাঁর উত্তরসূরি সুবাদার শায়েস্তা খান এটির ব্যাপক নির্মাণ ও সংস্কার কাজ পরিচালনা করেন।',
                'options' => [
                    ['A', 'শায়েস্তা খান', true],
                    ['B', 'শাহ সুজা', false],
                    ['C', 'টিপু সুলতান', false],
                    ['D', 'ইসলাম খান', false],
                ],
            ],
            [
                'stem' => 'আন্তর্জাতিক অর্থ তহবিল (IMF) কবে হতে এর কার্যক্রম শুরু করে?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৪৭ সাল হতে</strong>: ব্রেটন উডস সম্মেলনের প্রেক্ষিতে ১৯৪৫ সালের ২৭ ডিসেম্বর আইএমএফ চুক্তি স্বাক্ষরিত হলেও এটি আনুষ্ঠানিকভাবে আর্থিক কার্যক্রম শুরু করে ১৯৪৭ সালের ১ মার্চ থেকে।',
                'options' => [
                    ['A', '১৯৪৫ সাল হতে', false],
                    ['B', '১৯৪৬ সাল হতে', false],
                    ['C', '১৯৪৭ সাল হতে', true],
                    ['D', '১৯৪৮ সাল হতে', false],
                ],
            ],
            [
                'stem' => 'NATO কবে প্রতিষ্ঠিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৪৯ সালের ৪ এপ্রিল</strong>: ওয়াশিংটনে উত্তর আটলান্টিক চুক্তি স্বাক্ষরের মাধ্যমে ১২টি প্রতিষ্ঠাতা সদস্য রাষ্ট্র নিয়ে ১৯৪৯ সালের ৪ এপ্রিল সামরিক জোট ন্যাটো (NATO) প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৪৭ সালের ৪ আগস্ট', false],
                    ['B', '১৯৪৯ সালের ৪ এপ্রিল', true],
                    ['C', '১৯৫০ সালের ৪ ফেব্রুয়ারি', false],
                    ['D', '১৯৫১ সালের ৪ মে', false],
                ],
            ],
            [
                'stem' => 'ইয়াল্টা কনফারেন্স কবে অনুষ্ঠিত হয়?',
                'subject' => 'international',
                'explanation' => '<strong>১৯৪৫ সালে</strong>: দ্বিতীয় বিশ্বযুদ্ধ চলাকালে মিত্রবাহিনীর তিন প্রধান নেতা রুজভেল্ট, চার্চিল ও স্ট্যালিনের অংশগ্রহণে ক্রিমিয়ার ইয়াল্টায় ১৯৪৫ সালের ৪-১১ ফেব্রুয়ারি ঐতিহাসিক ইয়াল্টা সম্মেলন অনুষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৩৩ সালে', false],
                    ['B', '১৯৪৩ সালে', false],
                    ['C', '১৯৪৫ সালে', true],
                    ['D', '১৯৪৭ সালে', false],
                ],
            ],
            [
                'stem' => 'ধূমকেতু শুমেকার লেভী-৯ এর ভাঙ্গা টুকরোটি কবে বৃহস্পতি গ্রহে আঘাত হানে?',
                'subject' => 'science',
                'explanation' => '<strong>১৬ জুলাই, ১৯৯৪</strong>: শুমেকার-লেভি ৯ (Shoemaker-Levy 9) ধূমকেতুর খণ্ডাংশ ১৯৯৪ সালের ১৬ জুলাই থেকে ২২ জুলাইয়ের মধ্যে বৃহস্পতি গ্রহের বুকে প্রচণ্ড শক্তিতে আছড়ে পড়ে।',
                'options' => [
                    ['A', '১৫ জুলাই, ১৯৯৪', false],
                    ['B', '১৬ জুলাই, ১৯৯৪', true],
                    ['C', '১৭ জুলাই, ১৯৯৪', false],
                    ['D', '১৮ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => '১৯৯৪-এ নববর্ষের দিনে কার নেতৃত্বাধীন বাহিনী কাবুল শহর আক্রমণ করে?',
                'subject' => 'international',
                'explanation' => '<strong>আবদুর রশীদ দোস্তাম</strong>: ১৯৯৪ সালের ১ জানুয়ারি নববর্ষের দিনে উজবেক জেনারেল আবদুর রশীদ দোস্তামের জুন্দিশ-ই-মিল্লি বাহিনী আফগান প্রেসিডেন্ট বুরহানউদ্দিন রব্বানির সরকারকে হটাতে কাবুলে ব্যাপক আক্রমণ চালায়।',
                'options' => [
                    ['A', 'মজিবুল্লাহ', false],
                    ['B', 'আহমদ শাহ মাসুদ', false],
                    ['C', 'আবদুর রশীদ দোস্তাম', true],
                    ['D', 'গুলবুদ্দীন হেকমতিয়ার', false],
                ],
            ],
            [
                'stem' => 'Something which is obnoxious means that it is–',
                'subject' => 'english',
                'explanation' => '<strong>very unpleasant</strong>: \'Obnoxious\' শব্দের অর্থ অত্যন্ত আপত্তিকর, অপ্রীতিকর বা বিরক্তিকর (extremely unpleasant, offensive, or hateful)।',
                'options' => [
                    ['A', 'very dangerous', false],
                    ['B', 'very pleasant', false],
                    ['C', 'very ugly', false],
                    ['D', 'very unpleasant', true],
                ],
            ],
            [
                'stem' => 'A pilgrim is a person who undertakes a journey to a––',
                'subject' => 'english',
                'explanation' => '<strong>holy place</strong>: \'Pilgrim\' (তীর্থযাত্রী) হলো এমন একজন ব্যক্তি যিনি ধর্মীয় বা আধ্যাত্মিক উদ্দেশ্যে কোনো পবিত্র স্থানে (holy place) গমন করেন।',
                'options' => [
                    ['A', 'holy place', true],
                    ['B', 'a mosque', false],
                    ['C', 'a bazar', false],
                    ['D', 'a new country', false],
                ],
            ],
            [
                'stem' => 'Shakespeare is known mostly for his–',
                'subject' => 'english',
                'explanation' => '<strong>plays</strong>: উইলিয়াম শেক্সপিয়র সনেট ও কাব্য রচনা করলেও তিনি বিশ্বসাহিত্যে প্রধানত তাঁর অমর ৩৭টি কালজয়ী নাটকের (plays / dramas) জন্যই সর্বশ্রেষ্ঠ খ্যাতি লাভ করেন।',
                'options' => [
                    ['A', 'poetry', false],
                    ['B', 'novels', false],
                    ['C', 'autobiography', false],
                    ['D', 'plays', true],
                ],
            ],
            [
                'stem' => 'A person who writes about his own life writes–',
                'subject' => 'english',
                'explanation' => '<strong>an autobiography</strong>: কোনো ব্যক্তি যখন নিজের জীবনবৃত্তান্ত নিজেই লেখেন, তখন তাকে \'autobiography\' (আত্মজীবনী) বলা হয়। অন্যের জীবনী লিখলে তা \'biography\'।',
                'options' => [
                    ['A', 'a chronicle', false],
                    ['B', 'an autobiography', true],
                    ['C', 'a diary', false],
                    ['D', 'a biography', false],
                ],
            ],
            [
                'stem' => 'In which century was the Victorian period?',
                'subject' => 'english',
                'explanation' => '<strong>19th century</strong>: রানী ভিক্টোরিয়ার শাসনকাল (১৮৩৭ - ১৯০১) হলো ইংরেজি সাহিত্যের ভিক্টোরিয়ান যুগ, যা মূলত ঊনবিংশ শতাব্দীর (19th century) অন্তর্গত।',
                'options' => [
                    ['A', '17th century', false],
                    ['B', '18th century', false],
                    ['C', '19th century', true],
                    ['D', '20th century', false],
                ],
            ],
            [
                'stem' => 'কবি কাজী নজরুল ইসলাম ‘সঞ্চিতা’ কাব্যটি কাকে উৎসর্গ করেছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>রবীন্দ্রনাথ ঠাকুর</strong>: কাজী নজরুল ইসলাম তাঁর শ্রেষ্ঠ কবিতা সংকলন গ্রন্থ ‘সঞ্চিতা’ বিশ্বকবি রবীন্দ্রনাথ ঠাকুরকে উৎসর্গ করেছিলেন। পক্ষান্তরে রবীন্দ্রনাথ তাঁর ‘বসন্ত’ নাটকটি নজরুলকে উৎসর্গ করেছিলেন।',
                'options' => [
                    ['A', 'বারীন্দ্রকুমার ঘোষ', false],
                    ['B', 'রবীন্দ্রনাথ ঠাকুর', true],
                    ['C', 'বীরজাসুন্দরী দেবী', false],
                    ['D', 'মুজাফফর আহমদ', false],
                ],
            ],
            [
                'stem' => 'কোন উপন্যাসটির রচয়িতা রবীন্দ্রনাথ?',
                'subject' => 'bangla',
                'explanation' => '<strong>ঘরে-বাইরে</strong>: স্বদেশী আন্দোলনের পটভূমিতে রচিত রাজনৈতিক উপন্যাস ‘ঘরে-বাইরে’ (১৯১৬)-এর রচয়িতা রবীন্দ্রনাথ ঠাকুর। \'বিষবৃক্ষ\' বঙ্কিমচন্দ্রের, \'গণদেবতা\' ও \'আরণ্যক\' যথাক্রমে তারাশঙ্কর ও বিভূতিভূষণের।',
                'options' => [
                    ['A', 'বিষবৃক্ষ', false],
                    ['B', 'গণদেবতা', false],
                    ['C', 'আরণ্যক', false],
                    ['D', 'ঘরে-বাইরে', true],
                ],
            ],
            [
                'stem' => '‘একুশে ফেব্রুয়ারি’ গ্রন্থের সম্পাদক কে ছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>হাসান হাফিজুর রহমান</strong>: ১৯৫৩ সালে প্রকাশিত ভাষা আন্দোলনের প্রথম ঐতিহাসিক সাহিত্য সংকলন ‘একুশে ফেব্রুয়ারি’ গ্রন্থের সম্পাদক ছিলেন হাসান হাফিজুর রহমান।',
                'options' => [
                    ['A', 'হাসান হাফিজুর রহমান', true],
                    ['B', 'বেগম সুফিয়া কামাল', false],
                    ['C', 'মুনীর চৌধুরী', false],
                    ['D', 'আবুল বরকত', false],
                ],
            ],
            [
                'stem' => '‘রোহিণী’ চরিত্রটি কোন উপন্যাসে পাওয়া যায়?',
                'subject' => 'bangla',
                'explanation' => '<strong>কৃষ্ণকান্তের উইল</strong>: বঙ্কিমচন্দ্র চট্টোপাধ্যায়ের মনস্তাত্ত্বিক ট্র্যাজেডি উপন্যাস ‘কৃষ্ণকান্তের উইল’ (১৮৭৮)-এর অন্যতম প্রধান ও আলোচিত নারী চরিত্র হলো বিধবা রোহিনী।',
                'options' => [
                    ['A', 'চরিত্রহীন', false],
                    ['B', 'গৃহদাহ', false],
                    ['C', 'কৃষ্ণকান্তের উইল', true],
                    ['D', 'সংশপ্তক', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের জাতীয় সঙ্গীতে কোন বিষয়টি প্রধানভাবে আছে?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বাংলার প্রকৃতির কথা</strong>: বিশ্বকবি রবীন্দ্রনাথ ঠাকুর রচিত জাতীয় সঙ্গীত ‘আমার সোনার বাংলা’-তে বাংলার মনোরম স্নিগ্ধ রূপ, ফসলের মাঠ, আম্রকুঞ্জ ও শ্যামল প্রকৃতির অপার সৌন্দর্যের জয়গান ফুটে উঠেছে।',
                'options' => [
                    ['A', 'বাংলার প্রকৃতির কথা', true],
                    ['B', 'বাংলার মানুষের কথা', false],
                    ['C', 'বাংলার ইতিহাসের কথা', false],
                    ['D', 'বাংলার সংস্কৃতির কথা', false],
                ],
            ],
            [
                'stem' => 'চতুর্ভুজের চার কোণের অনুপাত ১ : ২ : ২ : ৩ হলে বৃহত্তম কোণের পরিমাণ হবে-',
                'subject' => 'math',
                'explanation' => '<strong>১৩৫°</strong>: চতুর্ভুজের চার কোণের সমষ্টি ৩৬০°। অনুপাতের পদগুলোর যোগফল = ১ + ২ + ২ + ৩ = ৮। অতএব বৃহত্তম কোণটি = ৩৬০° × (৩/৮) = ১৩৫°।',
                'options' => [
                    ['A', '১০০°', false],
                    ['B', '১১৫°', false],
                    ['C', '১৩৫°', true],
                    ['D', '২২৫°', false],
                ],
            ],
            [
                'stem' => 'দুটি ত্রিভুজের মধ্যে কোন উপাদানগুলো সমান হওয়া সত্ত্বেও ত্রিভুজ দুটি সর্বসম নাও হতে পারে?',
                'subject' => 'math',
                'explanation' => '<strong>তিন কোণ</strong>: দুটি ত্রিভুজের অনুরূপ তিনটি কোণ সমান হলে ত্রিভুজ দুটি সদৃশকোণী (similar) হয়, কিন্তু সর্বদা সর্বসম (congruent) নাও হতে পারে, কারণ বাহুর দৈর্ঘ্য ক্ষুদ্র বা বৃহৎ হতে পারে।',
                'options' => [
                    ['A', 'দুই বাহু অন্তর্ভুক্ত কোণ', false],
                    ['B', 'দুই কোণ ও এক বাহু', false],
                    ['C', 'তিন কোণ', true],
                    ['D', 'তিন বাহু', false],
                ],
            ],
            [
                'stem' => 'a : b = 4 : 7 এবং b : c = 5 : 6 হলে a : b : c = কত?',
                'subject' => 'math',
                'explanation' => '<strong>20 : 35 : 42</strong>: ধারাবাহিক অনুপাতে রূপান্তর করি: a : b = (৪ × ৫) : (৭ × ৫) = ২০ : ৩৫ এবং b : c = (৫ × ৭) : (৬ × ৭) = ৩৫ : ৪২। অতএব a : b : c = ২০ : ৩৫ : ৪২।',
                'options' => [
                    ['A', '4 : 7 : 6', false],
                    ['B', '20 : 35 : 24', false],
                    ['C', '20 : 35 : 42', true],
                    ['D', '24 : 35 : 30', false],
                ],
            ],
            [
                'stem' => '(a² + b² – c² + 2ab) / (a² – b² + c² + 2ac) = কত?',
                'subject' => 'math',
                'explanation' => '<strong>(a + b – c)/(a – b + c)</strong>: লব = (a² + 2ab + b²) - c² = (a + b)² - c² = (a + b + c)(a + b - c)। হর = (a² + 2ac + c²) - b² = (a + c)² - b² = (a + c + b)(a + c - b) = (a + b + c)(a - b + c)। কাটাকাটি করলে মান দাঁড়ায় (a + b - c) / (a - b + c)।',
                'options' => [
                    ['A', 'a + b + c', false],
                    ['B', '(a + b – c)/(a – b + c)', true],
                    ['C', '(a – b + c)/(a + b – c)', false],
                    ['D', '(a + b – c)/(a + b + c)', false],
                ],
            ],
            [
                'stem' => 'a + b + c = 9, a² + b² + c² = 29 হলে ab + bc + ca এর মান কত?',
                'subject' => 'math',
                'explanation' => '<strong>২৬</strong>: আমরা জানি, (a + b + c)² = a² + b² + c² + 2(ab + bc + ca) => ৯² = ২৯ + ২(ab + bc + ca) => ৮১ - ২৯ = ২(ab + bc + ca) => ৫২ = ২(ab + bc + ca) => ab + bc + ca = ২৬।',
                'options' => [
                    ['A', '৫২', false],
                    ['B', '৪৬', false],
                    ['C', '২৬', true],
                    ['D', '২২', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের লাগা উত্তরে অবস্থিত-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>পশ্চিমবঙ্গ, মেঘালয় ও আসাম</strong>: বাংলাদেশের উত্তর সীমান্তে ভারতের পশ্চিমবঙ্গ, মেঘালয় ও আসাম রাজ্য স্পর্শ করে আছে।',
                'options' => [
                    ['A', 'নেপাল ও ভুটান', false],
                    ['B', 'পশ্চিমবঙ্গ, মেঘালয় ও আসাম', true],
                    ['C', 'পশ্চিমবঙ্গ ও কুচবিহার', false],
                    ['D', 'পশ্চিমবঙ্গ ও আসাম', false],
                ],
            ],
            [
                'stem' => 'উপমহাদেশের সর্বশেষ গভর্নর জেনারেল কে ছিলেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>লর্ড মাউন্টব্যাটেন</strong>: অবিভক্ত ব্রিটিশ ভারতের শেষ ভাইসরয় ও স্বাধীন ভারতের প্রথম গভর্নর জেনারেল ছিলেন লর্ড লুই মাউন্টব্যাটেন। (উল্লেখ্য, স্বাধীন পাকিস্তানের প্রথম গভর্নর জেনারেল ছিলেন মোহাম্মদ আলী জিন্নাহ)।',
                'options' => [
                    ['A', 'লর্ড মিন্টো', false],
                    ['B', 'লর্ড কার্জন', false],
                    ['C', 'লর্ড মাউন্টব্যাটেন', true],
                    ['D', 'লর্ড ওয়াভেল', false],
                ],
            ],
            [
                'stem' => 'অভ্যন্তরীণ কন্টেইনার ডিপো কোথায় অবস্থিত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>ঢাকা</strong>: ১৯৮৭ সালে বাংলাদেশের প্রথম এবং প্রধান অভ্যন্তরীণ কন্টেইনার ডিপো (Inland Container Depot - ICD) ঢাকার কমলাপুরে স্থাপিত হয়।',
                'options' => [
                    ['A', 'চট্টগ্রাম', false],
                    ['B', 'ঢাকা', true],
                    ['C', 'মংলা', false],
                    ['D', 'খুলনা', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘের জনসংখ্যা সংক্রান্ত ১৯৯৪ সালের রিপোর্ট অনুযায়ী জনসংখ্যার দিক দিয়ে বাংলাদেশের স্থান-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>নবম</strong>: ১৯৯৪ সালে ইউএনএফপিএ (UNFPA)-এর জনসংখ্যা প্রতিবেদনে বাংলাদেশ জনসংখ্যার দিক থেকে বিশ্বে ৯ম স্থানে ছিল। (বর্তমান সর্বশেষ পরিসংখ্যানে বাংলাদেশের স্থান বিশ্বে ৮ম)।',
                'options' => [
                    ['A', 'সপ্তম', false],
                    ['B', 'অষ্টম', false],
                    ['C', 'নবম', true],
                    ['D', 'দশম', false],
                ],
            ],
            [
                'stem' => 'কর্কটক্রান্তি রেখা-',
                'subject' => 'bangladesh',
                'explanation' => '<strong>বাংলাদেশের মধ্যখান দিয়ে গিয়েছে</strong>: ২৩.৫° উত্তর অক্ষাংশ রেখা বা কর্কটক্রান্তি রেখা (Tropic of Cancer) বাংলাদেশের প্রায় মাঝামাঝি অঞ্চল (কুমিল্লা, ফরিদপুর, চুয়াডাঙ্গা প্রভৃতি জেলা) দিয়ে পূর্ব-পশ্চিমে অতিক্রম করেছে।',
                'options' => [
                    ['A', 'বাংলাদেশের উত্তর সীমান্ত দিয়ে গিয়েছে', false],
                    ['B', 'বাংলাদেশের দক্ষিণ সীমান্ত দিয়ে গিয়েছে', false],
                    ['C', 'বাংলাদেশের মধ্যখান দিয়ে গিয়েছে', true],
                    ['D', 'বাংলাদেশ থেকে অনেক দূরে অবস্থিত', false],
                ],
            ],
            [
                'stem' => 'পানির জীব হয়েও বাতাসে নিঃশ্বাস নেয়-',
                'subject' => 'science',
                'explanation' => '<strong>শুশুক</strong>: ডলফিন বা শুশুক জলজ স্তন্যপায়ী প্রাণী। এরা ফুলকার পরিবর্তে ফুসফুসের সাহায্যে বাতাসে শ্বাস-প্রশ্বাস নেয়, তাই নির্দিষ্ট সময় পর পর পানির ওপরে ভেসে ওঠে।',
                'options' => [
                    ['A', 'পটকা মাছ', false],
                    ['B', 'হাঙ্গর', false],
                    ['C', 'শুশুক', true],
                    ['D', 'জেলি ফিস', false],
                ],
            ],
            [
                'stem' => 'পিট কয়লার বৈশিষ্ট্য হলো-',
                'subject' => 'science',
                'explanation' => '<strong>ভিজা ও নরম</strong>: পিট কয়লা কয়লার প্রাথমিক স্তর, যাতে আর্দ্রতার পরিমাণ অনেক বেশি (প্রায় ৮০-৯০%) থাকে এবং এটি নরম ও ভেজা প্রকৃতির হয়ে থাকে।',
                'options' => [
                    ['A', 'মাটির অনেক গভীরে থাকে', false],
                    ['B', 'ভিজা ও নরম', true],
                    ['C', 'পাহাড়ি এলাকায় পাওয়া যায়', false],
                    ['D', 'দহন ক্ষমতা কয়লার তুলনায় অধিক', false],
                ],
            ],
            [
                'stem' => 'আধুনিক মুদ্রণ ব্যবস্থায় ধাতু নির্মিত অক্ষরের প্রয়োজন ফুরাবার কারণ-',
                'subject' => 'science',
                'explanation' => '<strong>ফটো লিথোগ্রাফী</strong>: অফসেট প্রিন্টিং ও আধুনিক ফটো লিথোগ্রাফি প্রযুক্তিতে রাসায়নিক প্লেট ও ফটোগ্রাফিক নেগেটিভ/ডিজিটাল ফাইলের সাহায্যে মুদ্রণ সম্ভব হওয়ায় সিসা বা ধাতব অক্ষরের টাইপসেটিং ব্যবস্থা অপ্রচলিত হয়ে পড়ে।',
                'options' => [
                    ['A', 'কম্পিউটার', false],
                    ['B', 'অফসেট পদ্ধতি', false],
                    ['C', 'ফটো লিথোগ্রাফী', true],
                    ['D', 'প্রসেস ক্যামেরা', false],
                ],
            ],
            [
                'stem' => 'ডিজিটাল টেলিফোনের প্রধান বৈশিষ্ট্য-',
                'subject' => 'science',
                'explanation' => '<strong>ডিজিটাল সিগন্যাল বার্তা প্রেরণ</strong>: ডিজিটাল টেলিফোন এনালগ শব্দের পরিবর্তে শব্দ তরঙ্গকে বাইনারি ডিজিটাল সংকেতে (০ ও ১) রূপান্তর করে দ্রুত ও নিখুঁতভাবে বার্তা বা তথ্য প্রেরণ করে।',
                'options' => [
                    ['A', 'ডিজিটাল সিগন্যাল বার্তা প্রেরণ', true],
                    ['B', 'বোতাম টিপে ডায়াল করা', false],
                    ['C', 'অপটিক্যাল ফাইবারের ব্যবহার', false],
                    ['D', 'নতুন ধরনের মাইক্রোফোন', false],
                ],
            ],
            [
                'stem' => 'আবহাওয়া ৯০% আর্দ্রতা মানে-',
                'subject' => 'science',
                'explanation' => '<strong>বাতাসে জলীয় বাষ্পের পরিমাণ সম্পৃক্ত অবস্থায় ৯০%</strong>: আপেক্ষিক আর্দ্রতা ৯০% বলতে বোঝায় ওই নির্দিষ্ট তাপমাত্রায় বাতাসকে সম্পূর্ণ সম্পৃক্ত করতে যে পরিমাণ জলীয় বাষ্প প্রয়োজন, তার ৯০% জলীয় বাষ্প বর্তমানে উপস্থিত রয়েছে।',
                'options' => [
                    ['A', 'বৃষ্টিপাতের সম্ভাবনা ৯০%', false],
                    ['B', '১০০ ভাগ বাতাসে ৯০ ভাগ জলীয় বাষ্প', false],
                    ['C', 'বাতাসে জলীয় বাষ্পের পরিমাণ সম্পৃক্ত অবস্থায় ৯০%', true],
                    ['D', 'বাতাসে জলীয় বাষ্পের পরিমাণ বৃষ্টিপাতের সময়ের ৯০%', false],
                ],
            ],
            [
                'stem' => '১৯৯৩ সালের ডিসেম্বরে অনুষ্ঠিত রাশিয়ার পার্লামেন্টের নির্বাচনে কোন রাজনৈতিক দলটি সংখ্যাগরিষ্ঠ দল হিসেবে আত্মপ্রকাশ করে?',
                'subject' => 'international',
                'explanation' => '<strong>লিবারেল ডেমোক্রেটিক পার্টি</strong>: ১৯৯৩ সালের ১২ ডিসেম্বর রাশিয়ার ডুমা নির্বাচনে ভ্লাদিমির ঝিরিনোভস্কির উগ্র জাতীয়তাবাদী দল লিবারেল ডেমোক্রেটিক পার্টি অব রাশিয়া (LDPR) চমকপ্রদভাবে সর্বোচ্চ ভোট পেয়ে আত্মপ্রকাশ করেছিল।',
                'options' => [
                    ['A', 'রাশিয়া\'স চয়েস', false],
                    ['B', 'লিবারেল ডেমোক্রেটিক পার্টি', true],
                    ['C', 'সোশ্যাল ডেমোক্রেটিক পার্টি', false],
                    ['D', 'দ্য কমিউনিস্ট পার্টি', false],
                ],
            ],
            [
                'stem' => '১৯৯৪ সালের বিশ্বকাপ ফুটবলে সর্বোচ্চ গোলদাতা কারা?',
                'subject' => 'international',
                'explanation' => '<strong>সালেঙ্কো ও স্টইচকভ</strong>: ১৯৯৪ সালের যুক্তরাষ্ট্র বিশ্বকাপে রাশিয়ার ওলেগ সালেঙ্কো এবং বুলগেরিয়ার রিস্টো স্টইচকভ উভয়েই সর্বোচ্চ ৬টি করে গোল করে যৌথভাবে গোল্ডেন বুট লাভ করেন।',
                'options' => [
                    ['A', 'স্টইচকভ ও রোবের্তো', false],
                    ['B', 'সালেঙ্কো ও অ্যান্ডারসন', false],
                    ['C', 'সালেঙ্কো ও স্টইচকভ', true],
                    ['D', 'অ্যান্ডারসন ও রোবের্তো', false],
                ],
            ],
            [
                'stem' => '১৯৬৫ সালের আগে জাতিসংঘের নিরাপত্তা পরিষদের সদস্য সংখ্যা কত ছিল?',
                'subject' => 'international',
                'explanation' => '<strong>১১ টি</strong>: ১৯৬৫ সালের সনদের সংশোধনের পূর্বে নিরাপত্তা পরিষদের সদস্য সংখ্যা ছিল ১১টি (৫টি স্থায়ী এবং ৬টি অস্থায়ী)। ১৯৬৫ সালের পর অস্থায়ী আসন ১০টিতে উন্নীত করে মোট ১৫টি করা হয়।',
                'options' => [
                    ['A', '১৫ টি', false],
                    ['B', '৬ টি', false],
                    ['C', '১১ টি', true],
                    ['D', '১০ টি', false],
                ],
            ],
            [
                'stem' => 'গাম্বিয়ার সেনাবাহিনী অভ্যুত্থানের মাধ্যমে কবে দেশের ক্ষমতা দখল করে?',
                'subject' => 'international',
                'explanation' => '<strong>২২ জুলাই, ১৯৯৪</strong>: ১৯৯৪ সালের ২২ জুলাই তৎকালীন তরুণ লেফটেন্যান্ট ইয়াহিয়া জামেহ এক রক্তপাতহীন সামরিক অভ্যুত্থানের মাধ্যমে গাম্বিয়ার দীর্ঘকালীন রাষ্ট্রপতি দাউদা জাওয়ারার পতন ঘটিয়ে ক্ষমতা দখল করেন।',
                'options' => [
                    ['A', '২১ জুলাই, ১৯৯৪', false],
                    ['B', '২২ জুলাই, ১৯৯৪', true],
                    ['C', '২৩ জুলাই, ১৯৯৪', false],
                    ['D', '২৪ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => 'নাইজেরিয়ার বিরোধী নেতা মাসুদ আবিওলা কবে নিজেকে নাইজেরিয়ার প্রেসিডেন্ট বলে ঘোষণা করেন?',
                'subject' => 'international',
                'explanation' => '<strong>৭ জুন, ১৯৯৪</strong>: ১৯৯৩ সালের গণতান্ত্রিক নির্বাচনে বিজয়ী হওয়ার পর সামরিক জান্তা ক্ষমতা না দেওয়ায় তৎকালীন বিরোধী নেতা মোশুদ আবিওলা ১৯৯৪ সালের ৭ জুন নিজেকে নাইজেরিয়ার বৈধ প্রেসিডেন্ট ঘোষণা করেন।',
                'options' => [
                    ['A', '৭ জুন, ১৯৯৪', true],
                    ['B', '১১ জুন, ১৯৯৪', false],
                    ['C', '১ জুলাই, ১৯৯৪', false],
                    ['D', '১২ জুলাই, ১৯৯৪', false],
                ],
            ],
            [
                'stem' => '১৪ ডিসেম্বর, ১৯৯৩ তারিখে শহীদ বুদ্ধিজীবীদের স্মৃতিকে স্মরণীয় করে রাখার জন্য ঢাকার মোট কতগুলো সড়কের নামকরণ করা হয়?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৫ টি</strong>: ১৯৯৩ সালের ১৪ ডিসেম্বর শহীদ বুদ্ধিজীবী দিবসে ঢাকা সিটি করপোরেশন শহীদ বুদ্ধিজীবীদের আত্মত্যাগের স্মরণে রাজধানীর ৫টি প্রধান সড়কের নামকরণ করেছিল।',
                'options' => [
                    ['A', '৪ টি', false],
                    ['B', '৫ টি', true],
                    ['C', '৬ টি', false],
                    ['D', '৭ টি', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের ১৯৯৪-৯৫ সালের বাজেটে শিক্ষা খাতে বরাদ্দের পরিমাণ কত?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>১,৮৭৬ কোটি টাকা</strong>: ১৯৯৪-৯৫ অর্থবছরে জাতীয় বাজেটে শিক্ষা খাতে ১,৮৭৬ কোটি টাকা বরাদ্দ প্রদান করা হয়েছিল।',
                'options' => [
                    ['A', '১,৮২৪ কোটি টাকা', false],
                    ['B', '১,৮৪২ কোটি টাকা', false],
                    ['C', '১,৮৭৬ কোটি টাকা', true],
                    ['D', '১,৮৬৭ কোটি টাকা', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের দীর্ঘতম রেলসেতু কোনটি?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>যমুনা রেল সেতু</strong>: ঐতিহ্যগতভাবে দীর্ঘতম রেলসেতু ছিল হার্ডিঞ্জ ব্রিজ (১.৮ কিমি)। তবে সম্প্রতি নির্মিত ৪.৮ কিমি দৈর্ঘ্যের বঙ্গবন্ধু শেখ মুজিব রেলওয়ে সেতু (যমুনা রেল সেতু) বাংলাদেশের দীর্ঘতম ডেডিকেটেড রেলসেতু।',
                'options' => [
                    ['A', 'ভৈরব সেতু', false],
                    ['B', 'হার্ডিঞ্জ সেতু', false],
                    ['C', 'যমুনা রেল সেতু', true],
                    ['D', 'তিস্তা সেতু', false],
                ],
            ],
            [
                'stem' => 'চাকমা শরণার্থীদের দ্বিতীয় দফায় ১ম দিন অর্থাৎ ২১ জুলাই, ১৯৯৪ তারিখে কতজন বাংলাদেশে প্রত্যাবর্তন করেন?',
                'subject' => 'bangladesh',
                'explanation' => '<strong>৩৭৫ জন</strong>: ভারত ও বাংলাদেশের মধ্যে প্রত্যাবাসন চুক্তির আওতায় ১৯৯৪ সালের ২১ জুলাই ত্রিপুরা শরণার্থী শিবির থেকে প্রথম দিনে ৩৭৫ জন চাকমা শরণার্থী বাংলাদেশে ফিরে আসেন।',
                'options' => [
                    ['A', '৩৮৭ জন', false],
                    ['B', '৩৭৫ জন', true],
                    ['C', '৩৫৭ জন', false],
                    ['D', '৩৭৮ জন', false],
                ],
            ],
            [
                'stem' => 'জীবনানন্দ দাশের জন্মস্থান কোন জেলায়?',
                'subject' => 'bangla',
                'explanation' => '<strong>বরিশাল জেলা</strong>: রূপসী বাংলার কবি জীবনানন্দ দাশ ১৮৯৯ সালের ১৭ ফেব্রুয়ারি বরিশাল শহরে জন্মগ্রহণ করেন। তাঁর পৈতৃক নিবাসও ছিল বরিশালে।',
                'options' => [
                    ['A', 'বরিশাল জেলা', true],
                    ['B', 'ফরিদপুর জেলা', false],
                    ['C', 'ঢাকা জেলা', false],
                    ['D', 'রাজশাহী জেলা', false],
                ],
            ],
            [
                'stem' => 'The antonym of ‘indifference’ is–',
                'subject' => 'english',
                'explanation' => '<strong>ardour</strong>: \'Indifference\' অর্থ উদাসীনতা বা অনীহা। এর বিপরীতার্থক শব্দ হলো \'ardour\' (উদ্যম, প্রবল আগ্রহ বা আবেগ)।',
                'options' => [
                    ['A', 'ardour', true],
                    ['B', 'compassion', false],
                    ['C', 'anxiety', false],
                    ['D', 'concern', false],
                ],
            ],
            [
                'stem' => 'Three Score is––',
                'subject' => 'english',
                'explanation' => '<strong>three times twenty</strong>: এক \'score\' সমান ২০ (twenty)। অতএব, \'Three score\' সমান তিন গুণ ২০ (3 × 20 = 60) বা \'three times twenty\'।',
                'options' => [
                    ['A', 'thirty times', false],
                    ['B', 'three hundred times', false],
                    ['C', 'three times twenty', true],
                    ['D', 'more than three', false],
                ],
            ],
            [
                'stem' => 'An ordinance is–',
                'subject' => 'english',
                'explanation' => '<strong>a law</strong>: \'Ordinance\' (অধ্যাদেশ) হলো সংসদ অধিবেশন না থাকলে রাষ্ট্রপ্রধান কর্তৃক জারি করা আইন (a law enacted by executive authority)।',
                'options' => [
                    ['A', 'a book', false],
                    ['B', 'an arms factory', false],
                    ['C', 'a news paper journal', false],
                    ['D', 'a law', true],
                ],
            ],
            [
                'stem' => 'A fantasy is–',
                'subject' => 'english',
                'explanation' => '<strong>an imaginary story</strong>: \'Fantasy\' শব্দের অর্থ কাল্পনিক কাহিনী বা রূপকথাধর্মী সাহিত্য (an imaginary or fanciful story)।',
                'options' => [
                    ['A', 'an imaginary story', true],
                    ['B', 'a funny film', false],
                    ['C', 'a history record', false],
                    ['D', 'a real-life event', false],
                ],
            ],
            [
                'stem' => 'Something that is ‘fresh’ is something–',
                'subject' => 'english',
                'explanation' => '<strong>in fairly good condition</strong>: \'Fresh\' বলতে বোঝায় যা টাটকা, সতেজ বা ভালো অবস্থায় রয়েছে (in fairly good, healthy or undamaged condition)।',
                'options' => [
                    ['A', 'recently printed or published', false],
                    ['B', 'in fairly good condition', true],
                    ['C', 'disrespectful', false],
                    ['D', 'pleasant', false],
                ],
            ],
            [
                'stem' => '‘মানুষেরই মাঝে স্বর্গ-নরক, মানুষেতে সুরাসুর’ এই পঙ্‌ক্তিটি কার রচনা?',
                'subject' => 'bangla',
                'explanation' => '<strong>শেখ ফজলুল করিম</strong>: নীতিবাদী কবি শেখ ফজলুল করিম রচিত ‘স্বর্গ ও নরক’ কবিতার বিখ্যাত পঙ্‌ক্তি এটি: \'কোথায় স্বর্গ, কোথায় নরক, কে বলে তা বহুদূর? মানুষেরই মাঝে স্বর্গ-নরক, মানুষেতে সুরাসুর।\'',
                'options' => [
                    ['A', 'রবীন্দ্রনাথ ঠাকুর', false],
                    ['B', 'কাজী নজরুল ইসলাম', false],
                    ['C', 'শেখ ফজলুল করিম', true],
                    ['D', 'শামসুর রাহমান', false],
                ],
            ],
            [
                'stem' => 'বাংলা একাডেমি কোন বছর প্রতিষ্ঠিত হয়?',
                'subject' => 'bangla',
                'explanation' => '<strong>১৯৫৫ খ্রিস্টাব্দে</strong>: ভাষা আন্দোলনের প্রেক্ষাপটে ১৯৫৫ সালের ৩ ডিসেম্বর (১৩৬২ বঙ্গাব্দের ১৭ অগ্রহায়ণ) ঢাকার বর্ধমান হাউসে বাংলা একাডেমি প্রতিষ্ঠিত হয়।',
                'options' => [
                    ['A', '১৯৫৫ খ্রিস্টাব্দে', true],
                    ['B', '১৩৫৫ বঙ্গাব্দে', false],
                    ['C', '১৯৫২ খ্রিস্টাব্দে', false],
                    ['D', '১৩৫২ বঙ্গাব্দে', false],
                ],
            ],
            [
                'stem' => 'সাধু ভাষা ও চলিত ভাষার পার্থক্য-',
                'subject' => 'bangla',
                'explanation' => '<strong>ক্রিয়াপদ ও সর্বনাম পদের রূপগত ভিন্নতায়</strong>: সাধু ও চলিত ভাষার প্রধান ব্যাকরণিক পার্থক্য পরিলক্ষিত হয় ক্রিয়াপদ (যেমন: করিয়াছি বনাম করেছি) এবং সর্বনাম পদে (যেমন: তাহার বনাম তার)।',
                'options' => [
                    ['A', 'বাক্যের সরল ও জটিল রূপে', false],
                    ['B', 'শব্দের রূপগত ভিন্নতায়', false],
                    ['C', 'তৎসম ও অর্ধতৎসম শব্দের ব্যবহারে', false],
                    ['D', 'ক্রিয়াপদ ও সর্বনাম পদের রূপগত ভিন্নতায়', true],
                ],
            ],
            [
                'stem' => 'সমগ্র পবিত্র কুরআনের প্রথম বাংলা অনুবাদ কে করেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>ভাই গিরিশচন্দ্র সেন</strong>: ব্রাহ্মধর্মীয় পণ্ডিত ভাই গিরিশচন্দ্র সেন ১৮৮১ থেকে ১৮৮৬ সালের মধ্যে সম্পূর্ণ পবিত্র কুরআন শরীফের প্রথম প্রামাণ্য বাংলা অনুবাদ সম্পন্ন করেন।',
                'options' => [
                    ['A', 'গোলাম মোস্তফা', false],
                    ['B', 'ফররুখ আহমদ', false],
                    ['C', 'ভাই গিরিশচন্দ্র সেন', true],
                    ['D', 'সুনীতিকুমার চট্টোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => '‘সমকাল’ পত্রিকার সম্পাদক কে ছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>সিকান্দার আবু জাফর</strong>: ১৯৫৭ সালে ঢাকা থেকে প্রকাশিত প্রগতিশীল সাহিত্য পত্রিকা ‘সমকাল’-এর প্রতিষ্ঠাতা সম্পাদক ছিলেন বিখ্যাত কবি ও নাট্যকার সিকান্দার আবু জাফর।',
                'options' => [
                    ['A', 'মোহাম্মদ আকরম খাঁ', false],
                    ['B', 'তফাজ্জল হোসেন', false],
                    ['C', 'মোহাম্মদ নাসিরউদ্দীন', false],
                    ['D', 'সিকান্দার আবু জাফর', true],
                ],
            ],
            [
                'stem' => '‘সওগাত’ পত্রিকার সম্পাদক কে ছিলেন?',
                'subject' => 'bangla',
                'explanation' => '<strong>মোহাম্মদ নাসিরউদ্দীন</strong>: ১৯১৮ সালে কলকাতা থেকে সচিত্র মাসিক পত্রিকা ‘সওগাত’ প্রকাশিত হয়, যার প্রতিষ্ঠাতা সম্পাদক ছিলেন সাংবাদিকতার পথিকৃৎ মোহাম্মদ নাসিরউদ্দীন।',
                'options' => [
                    ['A', 'কাজী নজরুল ইসলাম', false],
                    ['B', 'আবুল কালাম শামসুদ্দীন', false],
                    ['C', 'খান মুহাম্মদ মঈনুদ্দীন', false],
                    ['D', 'মোহাম্মদ নাসিরউদ্দীন', true],
                ],
            ],
        ];

        // 2. Insert all 100 questions, options, tags and link to the 16th BCS exam
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
                'reference_source' => '১৬তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '16th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1994',
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
