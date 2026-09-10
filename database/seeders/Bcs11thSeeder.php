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

class Bcs11thSeeder extends Seeder
{
    public function run(): void
    {
        $bpsc = Organization::where('slug', 'bpsc')->first();
        $examType = ExamType::where('slug', 'bcs-preliminary')->first();
        $examYear = ExamYear::where('year', '11th')->first();
        $admin = User::where('role', 'admin')->first();

        // 1. Create 11th BCS Exam
        $exam = Exam::firstOrCreate(
            ['slug' => '11th-bcs-preliminary'],
            [
                'title_bn' => '১১তম বিসিএস প্রিলিমিনারি প্রশ্ন সমাধান',
                'title_en' => '11th BCS Preliminary Question Solution',
                'description_bn' => '১১তম বিসিএস প্রিলিমিনারি পরীক্ষার পূর্ণাঙ্গ ১০০টি প্রশ্ন ও সঠিক উত্তর সমাধান।',
                'description_en' => 'Complete 100 questions and solutions of the 11th BCS Preliminary Examination.',
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
            'computer' => Subject::where('slug', 'computer-it')->first()?->id,
        ];

        $questionsData = [
            // ==========================================
            // বাংলা ভাষা ও সাহিত্য (১ - ১৮)
            // ==========================================
            [
                'stem' => '‘বৈরাগ্য সাধনে _____ সে আমার নয়।’ শূন্যস্থান পূরণ করুন।',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'আনন্দ', false],
                    ['B', 'মুক্তি', true],
                    ['C', 'বিশ্বাস', false],
                    ['D', 'আশ্বাস', false],
                ],
            ],
            [
                'stem' => 'সমাস ভাষাকে-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'সংক্ষেপ করে', true],
                    ['B', 'বিস্তৃত করে', false],
                    ['C', 'ভাষারূপ ক্ষুণ্ন করে', false],
                    ['D', 'অর্থবোধক করে', false],
                ],
            ],
            [
                'stem' => '‘সূর্য’-এর প্রতিশব্দ-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'সুধাংশু', false],
                    ['B', 'শশাঙ্ক', false],
                    ['C', 'বিধু', false],
                    ['D', 'আদিত্য', true],
                ],
            ],
            [
                'stem' => '‘অর্ধচন্দ্র’-এর অর্থ-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'গলাধাক্কা দেওয়া', true],
                    ['B', 'অমাবস্যা', false],
                    ['C', 'দ্বিতীয়ত', false],
                    ['D', 'কাস্তে', false],
                ],
            ],
            [
                'stem' => 'কোনটি শুদ্ধ?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'সৌজন্যতা', false],
                    ['B', 'সৌজন্যাতা', false],
                    ['C', 'সৌজনতা', false],
                    ['D', 'সৌজন্য', true],
                ],
            ],
            [
                'stem' => 'বেগম রোকেয়ার রচনা কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'ভাষা ও সাহিত্য', false],
                    ['B', 'আয়না', false],
                    ['C', 'লালসালু', false],
                    ['D', 'অবরোধবাসিনী', true],
                ],
            ],
            [
                'stem' => 'বাংলা গীতি কবিতায় ভোরের পাখি কে?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'বিহারীলাল চক্রবর্তী', true],
                    ['B', 'প্যারীচাঁদ মিত্র', false],
                    ['C', 'ঈশ্বরচন্দ্র বিদ্যাসাগর', false],
                    ['D', 'শরৎচন্দ্র চট্টোপাধ্যায়', false],
                ],
            ],
            [
                'stem' => 'কোনটি শুদ্ধ বাক্য?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'একটি গোপনীয় কথা বলি', true],
                    ['B', 'একটি গোপন কথা বলি', false],
                    ['C', 'একটি গোপন কতা বলি', false],
                    ['D', 'একটি গুপ্ত কথা বলি', false],
                ],
            ],
            [
                'stem' => '‘শিষ্টাচার’-এর সমার্থক শব্দ কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'নিষ্ঠা', false],
                    ['B', 'সদাচার', true],
                    ['C', 'সততা', false],
                    ['D', 'সংযম', false],
                ],
            ],
            [
                'stem' => '‘সংশয়’-এর বিপরীতার্থক শব্দ কোনটি?',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'নির্ভয়', false],
                    ['B', 'বিস্ময়', false],
                    ['C', 'প্রত্যয়', true],
                    ['D', 'দ্বিধা', false],
                ],
            ],
            [
                'stem' => '‘ক্ষমার যোগ্য’-এর বাক্য সংকোচন-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'ক্ষমার্হ', true],
                    ['B', 'ক্ষমারার্থী', false],
                    ['C', 'ক্ষমা', false],
                    ['D', 'ক্ষমাপ্রদ', false],
                ],
            ],
            [
                'stem' => '____ সেপ্টেম্বর বিশ্ব সাক্ষরতা দিবস। শূন্যস্থান পূরণ করুন।',
                'subject' => 'international',
                'options' => [
                    ['A', '৮', true],
                    ['B', '৬', false],
                    ['C', '১০', false],
                    ['D', '৫', false],
                ],
            ],
            [
                'stem' => '‘মোস্তফা চরিত’ গ্রন্থের রচয়িতা-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'মুহম্মদ আবদুল হাই', false],
                    ['B', 'মো: বরকতউল্লাহ', false],
                    ['C', 'ড. মুহম্মদ শহীদুল্লাহ', false],
                    ['D', 'মাওলানা আকরম খাঁ', true],
                ],
            ],
            [
                'stem' => '‘আমার দেখা রাজনীতির পঞ্চাশ বছর’ গ্রন্থটির রচয়িতা-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'মুহম্মদ আবদুল হাই', false],
                    ['B', 'ড. মুহম্মদ শহীদুল্লাহ', false],
                    ['C', 'আবুল মনসুর আহমেদ', true],
                    ['D', 'আতাউর রহমান', false],
                ],
            ],
            [
                'stem' => 'পুঁথি সাহিত্যের প্রাচীনতম লেখক-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'ভারতচন্দ্র রায়', false],
                    ['B', 'দৌলত কাজী', false],
                    ['C', 'সৈয়দ হামজা', true],
                    ['D', 'আব্দুল হাকিম', false],
                ],
            ],
            [
                'stem' => '‘চাচা কাহিনীর’ লেখক-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'সৈয়দ শামসুল হক', false],
                    ['B', 'সৈয়দ মুজতবা আলী', true],
                    ['C', 'শওকত ওসমান', false],
                    ['D', 'ফররুখ আহমেদ', false],
                ],
            ],
            [
                'stem' => 'বিভক্তিযুক্ত শব্দ ও ধাতুকে বলে-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'শব্দ', false],
                    ['B', 'কারক', false],
                    ['C', 'পদ', true],
                    ['D', 'ক্রিয়াপদ', false],
                ],
            ],
            [
                'stem' => '‘রাজলক্ষ্মী’ চরিত্রের স্রষ্টা ঔপন্যাসিক-',
                'subject' => 'bangla',
                'options' => [
                    ['A', 'বঙ্কিমচন্দ্র', false],
                    ['B', 'শরৎচন্দ্র', true],
                    ['C', 'তারাশংকর', false],
                    ['D', 'নজরুল ইসলাম', false],
                ],
            ],

            // ==========================================
            // English Language & Literature (১৯ - ৩৪)
            // ==========================================
            [
                'stem' => 'What is the synonym of ‘Incite’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Instigate', true],
                    ['B', 'Permit', false],
                    ['C', 'Urge', false],
                    ['D', 'Deceive', false],
                ],
            ],
            [
                'stem' => 'What is the antonym of ‘Honorary’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Official', false],
                    ['B', 'Honorable', false],
                    ['C', 'Salaried', true],
                    ['D', 'Literary', false],
                ],
            ],
            [
                'stem' => 'What is the verb of the word ‘Ability’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Ableness', false],
                    ['B', 'Able', false],
                    ['C', 'Ably', false],
                    ['D', 'Enable', true],
                ],
            ],
            [
                'stem' => 'Who is the poet of the ‘Victorian Age’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Helen Keller', false],
                    ['B', 'Matthew Arnold', true],
                    ['C', 'Shakespeare', false],
                    ['D', 'Robert Browning', true],
                ],
            ],
            [
                'stem' => 'Who is the author of ‘For Whom the Bell Tolls’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Charles Dickens', false],
                    ['B', 'Homer', false],
                    ['C', 'Lord Tennyson', false],
                    ['D', 'Ernest Hemingway', true],
                ],
            ],
            [
                'stem' => 'Fill in the blank: "He has assured me ___ safety."',
                'subject' => 'english',
                'options' => [
                    ['A', 'with', false],
                    ['B', 'at', false],
                    ['C', 'for', false],
                    ['D', 'of', true],
                ],
            ],
            [
                'stem' => '"May Allah help you" - What kind of sentence is this?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Optative', true],
                    ['B', 'Imperative', false],
                    ['C', 'Assertive', false],
                    ['D', 'Exclamatory', false],
                ],
            ],
            [
                'stem' => '"A rolling stone gathers no moss." What ‘rolling’ is?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Gerund', false],
                    ['B', 'Verbal noun', false],
                    ['C', 'Participle', true],
                    ['D', 'Adjective', false],
                ],
            ],
            [
                'stem' => '"He has been ill ___ Friday last." Fill in the blank.',
                'subject' => 'english',
                'options' => [
                    ['A', 'since', true],
                    ['B', 'in', false],
                    ['C', 'from', false],
                    ['D', 'on', false],
                ],
            ],
            [
                'stem' => 'Which is the noun form of the word ‘beautiful’?',
                'subject' => 'english',
                'options' => [
                    ['A', 'Beauteous', false],
                    ['B', 'Beauty', true],
                    ['C', 'Beautifully', false],
                    ['D', 'Beautify', false],
                ],
            ],
            [
                'stem' => '‘Hold water’ means-',
                'subject' => 'english',
                'options' => [
                    ['A', 'keep water', false],
                    ['B', 'drink water', false],
                    ['C', 'bear examination', true],
                    ['D', 'store water', false],
                ],
            ],
            [
                'stem' => '‘Out and Out’ means-',
                'subject' => 'english',
                'options' => [
                    ['A', 'Not at all', false],
                    ['B', 'Thoroughly', true],
                    ['C', 'To be last', false],
                    ['D', 'Man of outside', false],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence:',
                'subject' => 'english',
                'options' => [
                    ['A', 'Rice is not always happy.', false],
                    ['B', 'The rich is not always happy.', false],
                    ['C', 'The rich is not happy always.', false],
                    ['D', 'The rich are not always happy.', true],
                ],
            ],
            [
                'stem' => 'Choose the correct sentence:',
                'subject' => 'english',
                'options' => [
                    ['A', 'He had been hunged for murder.', false],
                    ['B', 'He has been hunged for murder.', false],
                    ['C', 'He was hanged for murder.', true],
                    ['D', 'He was hunged of murder.', false],
                ],
            ],
            [
                'stem' => '‘Syntax’ means–',
                'subject' => 'english',
                'options' => [
                    ['A', 'Manner of speech', false],
                    ['B', 'Sentence building', true],
                    ['C', 'Supplementary tax', false],
                    ['D', 'Synchronizing act', false],
                ],
            ],
            [
                'stem' => '‘Justice delayed is justice denied’ was stated by–',
                'subject' => 'english',
                'options' => [
                    ['A', 'Disraeli', false],
                    ['B', 'Emerson', false],
                    ['C', 'Gladstone', true],
                    ['D', 'Shakespeare', false],
                ],
            ],

            // ==========================================
            // বাংলাদেশ বিষয়াবলী (৩৫ - ৫২)
            // ==========================================
            [
                'stem' => 'বাংলাদেশের জাতীয় পতাকার মাপের অনুপাত কত?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '৯ : ৫', false],
                    ['B', '৯ : ৪', false],
                    ['C', '১০ : ৬', true],
                    ['D', '৮ : ৬', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের বৃহত্তম নদী কোনটি?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'মেঘনা', true],
                    ['B', 'পদ্মা', false],
                    ['C', 'ব্রহ্মপুত্র', false],
                    ['D', 'যমুনা', false],
                ],
            ],
            [
                'stem' => 'কোন জেলা তুলা চাষের জন্য সবচেয়ে বেশি উপযোগী?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'রাজশাহী', false],
                    ['B', 'ফরিদপুর', false],
                    ['C', 'রংপুর', false],
                    ['D', 'যশোর', true],
                ],
            ],
            [
                'stem' => 'ইউরিয়া সারের কাঁচামাল-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'অপরিশোধিত তেল', false],
                    ['B', 'ক্লিঙ্কার', false],
                    ['C', 'অ্যামোনিয়া', false],
                    ['D', 'মিথেন গ্যাস', true],
                ],
            ],
            [
                'stem' => '‘বাসস’ একটি-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'সংবাদ সংস্থার নাম', true],
                    ['B', 'একটি প্রেস ক্লাবের নাম', false],
                    ['C', 'একটি খবরের কাগজের নাম', false],
                    ['D', 'একটি বিদেশী কোম্পানির নাম', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশে শহীদ বুদ্ধিজীবী দিবস পালিত হয়-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '২৬ মার্চ', false],
                    ['B', '১৬ ডিসেম্বর', false],
                    ['C', '২১ ফেব্রুয়ারি', false],
                    ['D', '১৪ ডিসেম্বর', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের কোন বনভূমি শালবৃক্ষের জন্য বিখ্যাত?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'সিলেটের বনভূমি', false],
                    ['B', 'পার্বত্য চট্টগ্রামের বনভূমি', false],
                    ['C', 'ভাওয়াল ও মধুপুরের বনভূমি', true],
                    ['D', 'খুলনা, বরিশাল ও পটুয়াখালীর বনভূমি', false],
                ],
            ],
            [
                'stem' => 'চীন-বাংলাদেশ মৈত্রী সেতু-১ নির্মাণের প্রধান উদ্দেশ্য-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'ঢাকা শহরকে নদীর ওপারে বিস্তৃত করা', false],
                    ['B', 'বাংলাদেশ ও চীনের মধ্যে সুসম্পর্কের স্থায়ী বন্ধন সৃষ্টি করা', false],
                    ['C', 'ঢাকা-আরিচা রোড যানবাহন চলাচলের চাপ কমানো', false],
                    ['D', 'দেশের দক্ষিণ অঞ্চলের সাথে ঢাকার পরিবহন ব্যবস্থা উন্নত করা', true],
                ],
            ],
            [
                'stem' => 'হরিপুরে তেল আবিষ্কৃত হয়-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '১৯৪৭ সালে', false],
                    ['B', '১৯৮৬ সালে', true],
                    ['C', '১৯৮৫ সালে', false],
                    ['D', '১৯৮৪ সালে', false],
                ],
            ],
            [
                'stem' => '‘মিশুক’-এর স্থপতি কে?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'মোস্তফা মনোয়ার', true],
                    ['B', 'হামিদুর রহমান', false],
                    ['C', 'শামীম শিকদার', false],
                    ['D', 'হামিদুজ্জামান খান', false],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের কোন জেলায় সবচেয়ে বেশি পাট উৎপন্ন হয়?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'রংপুর', false],
                    ['B', 'ময়মনসিংহ', false],
                    ['C', 'টাঙ্গাইল', false],
                    ['D', 'ফরিদপুর', true],
                ],
            ],
            [
                'stem' => 'বাংলাদেশের মোট আবাদযোগ্য জমির পরিমাণ প্রায় কত?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '২ কোটি ৪০ লক্ষ একর', false],
                    ['B', '২ কোটি ৫০ লক্ষ একর', true],
                    ['C', '২ কোটি একর', false],
                    ['D', '২ কোটি ২৫ লক্ষ একর', false],
                ],
            ],
            [
                'stem' => 'উপকূল হতে বাংলাদেশের অর্থনৈতিক সমুদ্রসীমা কত?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', '২৫০ নটিক্যাল মাইল', false],
                    ['B', '২০০ নটিক্যাল মাইল', true],
                    ['C', '২২৫ নটিক্যাল মাইল', false],
                    ['D', '১০ নটিক্যাল মাইল', false],
                ],
            ],
            [
                'stem' => 'মহাস্থানগড় কোন নদীর তীরে অবস্থিত?',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'করতোয়া', true],
                    ['B', 'গঙ্গা', false],
                    ['C', 'ব্রহ্মপুত্র', false],
                    ['D', 'মহানন্দা', false],
                ],
            ],
            [
                'stem' => 'জাতীয় ঔষধ নীতির প্রধান উদ্দেশ্য হলো-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'অপ্রয়োজনীয় এবং ক্ষতিকর ঔষধ প্রস্তুত বন্ধ করা', true],
                    ['B', 'ঔষধ শিল্পে দেশীয় কাঁচামালের ব্যবহার নিশ্চিত করা', false],
                    ['C', 'ঔষধ শিল্পে দেশীয় শিল্পপতিদের অগ্রাধিকার দেয়া', false],
                    ['D', 'বিদেশী শিল্পপতিদের দেশীয় কাঁচামাল ব্যবহারে বাধ্য করা', false],
                ],
            ],
            [
                'stem' => 'বিকেএসপি হলো-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'একটি ক্রীড়া শিক্ষা সংস্থার নাম', true],
                    ['B', 'একটি সংবাদ সংস্থার নাম', false],
                    ['C', 'একটি কিশোর ফুটবল টিমের নাম', false],
                    ['D', 'একটি সঙ্গীত শিক্ষা প্রতিষ্ঠানের নাম', false],
                ],
            ],
            [
                'stem' => '‘মা ও মনি’ হলো-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'একটি উপন্যাসের নাম', false],
                    ['B', 'একটি প্রসাধন শিল্পের নাম', false],
                    ['C', 'একটি ক্রীড়া প্রতিযোগিতার নাম', true],
                    ['D', 'একটি গরিব মা ও মেয়ের গল্প কাহিনী', false],
                ],
            ],
            [
                'stem' => 'প্রাচীন ‘চন্দ্রদ্বীপ’-এর বর্তমান নাম-',
                'subject' => 'bangladesh',
                'options' => [
                    ['A', 'মালদ্বীপ', false],
                    ['B', 'সন্দ্বীপ', false],
                    ['C', 'বরিশাল', true],
                    ['D', 'হাতিয়া', false],
                ],
            ],

            // ==========================================
            // আন্তর্জাতিক বিষয়াবলী (৫৩ - ৬৮)
            // ==========================================
            [
                'stem' => 'আন্তর্জাতিক আণবিক শক্তি সংস্থা (IAEA)-এর সদর দপ্তর-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ভিয়েনা', true],
                    ['B', 'বন', false],
                    ['C', 'জেনেভা', false],
                    ['D', 'রোম', false],
                ],
            ],
            [
                'stem' => 'জাপানের পার্লামেন্টের নাম-',
                'subject' => 'international',
                'options' => [
                    ['A', 'ডায়েট', true],
                    ['B', 'পিনসাস', false],
                    ['C', 'নেসেট', false],
                    ['D', 'শুরা', false],
                ],
            ],
            [
                'stem' => 'আমেরিকাকে এশিয়া থেকে পৃথক করেছে কোন প্রণালী?',
                'subject' => 'international',
                'options' => [
                    ['A', 'ফ্লোরিডা', false],
                    ['B', 'পক', false],
                    ['C', 'জিব্রাল্টার', false],
                    ['D', 'বেরিং', true],
                ],
            ],
            [
                'stem' => 'সাউথ কমিশনের চেয়ারম্যান কে ছিলেন?',
                'subject' => 'international',
                'options' => [
                    ['A', 'জেনারেল সুহার্তো', false],
                    ['B', 'রবার্ট মুগাবে', false],
                    ['C', 'জুলিয়াস নায়ারের', true],
                    ['D', 'ফিদেল ক্যাস্ট্রো', false],
                ],
            ],
            [
                'stem' => 'আন্তর্জাতিক পরিবেশ দিবস পালিত হয়-',
                'subject' => 'international',
                'options' => [
                    ['A', '৭ জুলাই', false],
                    ['B', '৯ মার্চ', false],
                    ['C', '৫ জুন', true],
                    ['D', '২১ মে', false],
                ],
            ],
            [
                'stem' => 'জাতিসংঘ দিবস পালিত হয়-',
                'subject' => 'international',
                'options' => [
                    ['A', '২৪ অক্টোবর', true],
                    ['B', '২৪ আগস্ট', false],
                    ['C', '২৪ ডিসেম্বর', false],
                    ['D', '২৪ নভেম্বর', false],
                ],
            ],
            [
                'stem' => 'নামিবিয়ার রাজধানী-',
                'subject' => 'international',
                'options' => [
                    ['A', 'কারাভু', false],
                    ['B', 'উইন্ডহুক', true],
                    ['C', 'প্রিটোরিয়া', false],
                    ['D', 'কোটাভি', false],
                ],
            ],
            [
                'stem' => 'ইসলামী উন্নয়ন ব্যাংক ঋণ প্রদান করে-',
                'subject' => 'international',
                'options' => [
                    ['A', 'স্বাভাবিক সুদে', false],
                    ['B', 'বিনা সুদে', true],
                    ['C', 'অল্প সুদে', false],
                    ['D', 'অতি সামান্য সুদে', false],
                ],
            ],
            [
                'stem' => 'ওডারনীস নদী-',
                'subject' => 'international',
                'options' => [
                    ['A', 'পূর্ব জার্মানি ও পোল্যান্ডের মধ্যে সীমা নির্ধারক', true],
                    ['B', 'পশ্চিম জার্মানি ও চেক প্রজাতন্ত্রের মধ্যে সীমা নির্ধারক', false],
                    ['C', 'পশ্চিম জার্মানি ও পোল্যান্ডের মধ্যে সীমা নির্ধারক', false],
                    ['D', 'সংযুক্ত জার্মানি ও ফ্রান্সের মধ্যে সীমা নির্ধারক', false],
                ],
            ],
            [
                'stem' => '‘হারারে’-এর পুরাতন নাম-',
                'subject' => 'international',
                'options' => [
                    ['A', 'সলসবেরি', true],
                    ['B', 'ফরমোজা', false],
                    ['C', 'পেট্রোগ্রাড', false],
                    ['D', 'রোডেশিয়া', false],
                ],
            ],
            [
                'stem' => 'পবিত্রভূমি কোনটিকে বলা হয়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'প্যালেস্টাইন', false],
                    ['B', 'জেরুজালেম', true],
                    ['C', 'জেদ্দা', false],
                    ['D', 'তায়েফ', false],
                ],
            ],
            [
                'stem' => 'এডেন কোন দেশের সমুদ্রবন্দর?',
                'subject' => 'international',
                'options' => [
                    ['A', 'ইয়েমেন', true],
                    ['B', 'কাতার', false],
                    ['C', 'ওমান', false],
                    ['D', 'ইরাক', false],
                ],
            ],
            [
                'stem' => 'মালদ্বীপের মুদ্রার নাম কী?',
                'subject' => 'international',
                'options' => [
                    ['A', 'রুপী', false],
                    ['B', 'ডলার', false],
                    ['C', 'পাউন্ড', false],
                    ['D', 'রুপাইয়া', true],
                ],
            ],
            [
                'stem' => '১৯৯২ সালে বিশ্ব অলিম্পিক অনুষ্ঠিত হয় কোথায়?',
                'subject' => 'international',
                'options' => [
                    ['A', 'বার্সেলোনা', true],
                    ['B', 'জুরিখ', false],
                    ['C', 'বার্লিন', false],
                    ['D', 'ব্রাসেলস', false],
                ],
            ],
            [
                'stem' => 'আফটা (AFTA) বলতে কী বোঝায়-',
                'subject' => 'international',
                'options' => [
                    ['A', 'একটি বাণিজ্যিক গোষ্ঠী', true],
                    ['B', 'পূর্ব আফ্রিকার একটি সংবাদ সংস্থা', false],
                    ['C', 'একটি বিমান সংস্থা', false],
                    ['D', 'একটি সামরিক চুক্তি', false],
                ],
            ],
            [
                'stem' => 'আন্তর্জাতিক রোটারি সংস্থার প্রতিষ্ঠাতা-',
                'subject' => 'international',
                'options' => [
                    ['A', 'W. Wilson', false],
                    ['B', 'Paul Harris', true],
                    ['C', 'Baden Powel', false],
                    ['D', 'H. Wilson', false],
                ],
            ],

            // ==========================================
            // গাণিতিক যুক্তি ও মানসিক দক্ষতা (৬৯ - ৮৪)
            // ==========================================
            [
                'stem' => 'চালের মূল্য ১২% কমে যাওয়ায় ৬,০০০ টাকায় পূর্বাপেক্ষা ১ কুইন্টাল চাল বেশি পাওয়া যায়। ১ কুইন্টাল চালের বর্তমান মূল্য কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '৭৫০ টাকা', false],
                    ['B', '৭০০ টাকা', false],
                    ['C', '৭২০ টাকা', true],
                    ['D', '৭৫ টাকা', false],
                ],
            ],
            [
                'stem' => 'একটি আয়তাকার ক্ষেত্রের দৈর্ঘ্য বিস্তারের ৩ গুণ। দৈর্ঘ্য ৪৮ মিটার হলে, ক্ষেত্রটির পরিসীমা কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '১২৮ মিটার', true],
                    ['B', '১৪৪ মিটার', false],
                    ['C', '৬৪ মিটার', false],
                    ['D', '৯৬ মিটার', false],
                ],
            ],
            [
                'stem' => 'ক ঘণ্টায় ১০ কি.মি. এবং খ ঘণ্টায় ১৫ কি.মি. বেগে একই স্থান থেকে রাজশাহীর পথে রওনা হলো। ক ১০.১০ মিনিটের সময় এবং খ ৯.৪০ মিনিটের সময় রাজশাহী পৌঁছল। রওনা হওয়ার স্থান থেকে রাজশাহীর দূরত্ব কত কি.মি.?',
                'subject' => 'math',
                'options' => [
                    ['A', '২০ কি.মি.', false],
                    ['B', '২৫ কি.মি.', false],
                    ['C', '১৫ কি.মি.', true],
                    ['D', '২৮ কি.মি.', false],
                ],
            ],
            [
                'stem' => '১৯, ৩৩, ৫১, ৭৩ .......... পরবর্তী সংখ্যাটি কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '৮৫', false],
                    ['B', '১২১', false],
                    ['C', '৯৯', true],
                    ['D', '৯৮', false],
                ],
            ],
            [
                'stem' => 'একটি ক্রিকেট দলে যতজন স্ট্যাম্প আউট হলো তার দেড়গুণ কট আউট হলো এবং মোট উইকেটের অর্ধেক বোল্ড আউট হলো। এই দলের কতজন কট আউট হলো?',
                'subject' => 'math',
                'options' => [
                    ['A', '৪ জন', false],
                    ['B', '৩ জন', true],
                    ['C', '২ জন', false],
                    ['D', '৫ জন', false],
                ],
            ],
            [
                'stem' => 'একটি বন্দুকের গুলি প্রতি সেকেন্ডে ১৫৪০ ফুট গতিবেগে লক্ষ্যভেদ করে। এক ব্যক্তি বন্দুক ছোঁড়ার ৩ সেকেন্ড পরে লক্ষ্যভেদের শব্দ শুনতে পায়। শব্দের গতি প্রতি সেকেন্ডে ১১০০ ফুট হলে লক্ষ্য বস্তুর দূরত্ব কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '২০২৫ ফুট', false],
                    ['B', '১৯২৫ ফুট', true],
                    ['C', '১৯৭৫ ফুট', false],
                    ['D', '১৮৭৫ ফুট', false],
                ],
            ],
            [
                'stem' => 'একটি বৃত্তের ব্যাসার্ধকে যদি r থেকে বৃদ্ধি করে r + n করা হয়, তবে তার ক্ষেত্রফল দ্বিগুণ হয়। r -এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', 'n / (√2 - 1)', true],
                    ['B', 'n + √2', false],
                    ['C', '√2n', false],
                    ['D', '√2(n + 1)', false],
                ],
            ],
            [
                'stem' => 'a - {a - (a + 1)} = কত?',
                'subject' => 'math',
                'options' => [
                    ['A', 'a - 1', false],
                    ['B', '1', false],
                    ['C', 'a', false],
                    ['D', 'a + 1', true],
                ],
            ],
            [
                'stem' => 'একটি পাত্রে দুধ ও পানির অনুপাত ৫ : ২। যদি পানি অপেক্ষা দুধের পরিমাণ ৬ লিটার বেশি হয় তবে পানির পরিমাণ কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '১৪ লিটার', false],
                    ['B', '৬ লিটার', false],
                    ['C', '১০ লিটার', false],
                    ['D', '৪ লিটার', true],
                ],
            ],
            [
                'stem' => '(15 ÷ 15 × 15) / (15 + 15 এর 15) সরল করলে মান কত হবে?',
                'subject' => 'math',
                'options' => [
                    ['A', '122', false],
                    ['B', '125', false],
                    ['C', '225', true],
                    ['D', '1225', false],
                ],
            ],
            [
                'stem' => 'ক-এর বেতন খ-এর বেতন অপেক্ষা শতকরা ৩৫ টাকা বেশি হলে খ-এর বেতন ক-এর বেতন অপেক্ষা কত টাকা কম?',
                'subject' => 'math',
                'options' => [
                    ['A', '২৭ টাকা', false],
                    ['B', '২৫.৯৩ টাকা', true],
                    ['C', '৪০ টাকা', false],
                    ['D', '২৫.৫০ টাকা', false],
                ],
            ],
            [
                'stem' => '১০টি সংখ্যার যোগফল ৬৪২। এদের প্রথম ৪টির গড় ৫২ এবং শেষের ৫টির গড় ৩৮। পঞ্চম সংখ্যাটি কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '৬০', false],
                    ['B', '৬৪', true],
                    ['C', '৬২', false],
                    ['D', '৫০', false],
                ],
            ],
            [
                'stem' => 'পাশাপাশি দুটি বর্গক্ষেত্রের প্রত্যেক বাহু 20 ফুট। BC = 6, CF = 5 ফুট, DE = কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '১৫ ফুট (প্রশ্নটি ত্রুটিপূর্ণ)', true],
                    ['B', '১২ ফুট', false],
                    ['C', '২০ ফুট', false],
                    ['D', '১৮ ফুট', false],
                ],
            ],
            [
                'stem' => 'যদি a³ – b³ = 513 এবং a – b = 3 হয় তবে, ab এর মান কত?',
                'subject' => 'math',
                'options' => [
                    ['A', '54', true],
                    ['B', '35', false],
                    ['C', '45', false],
                    ['D', '55', false],
                ],
            ],
            [
                'stem' => '(x + 3)(x – 3) কে x² – 6 দিয়ে ভাগ করলে ভাগশেষ কত হবে?',
                'subject' => 'math',
                'options' => [
                    ['A', '-6', false],
                    ['B', '3', false],
                    ['C', '6', false],
                    ['D', '-3', true],
                ],
            ],
            [
                'stem' => '২ টা ১৫ মিনিটের সময় ঘণ্টার কাঁটা ও মিনিটের কাঁটার মধ্যে কত ডিগ্রি কোণ উৎপন্ন হয়?',
                'subject' => 'math',
                'options' => [
                    ['A', '23°', false],
                    ['B', '22 ½°', true],
                    ['C', '20°', false],
                    ['D', '23 ½°', false],
                ],
            ],

            // ==========================================
            // সাধারণ বিজ্ঞান ও প্রযুক্তি (৮৫ - ১০০)
            // ==========================================
            [
                'stem' => 'এক মিটার সমান কত ইঞ্চি?',
                'subject' => 'science',
                'options' => [
                    ['A', '৩৭.৩৯ ইঞ্চি', false],
                    ['B', '৩৯.৩৭ ইঞ্চি', true],
                    ['C', '৩৯.৪৭ ইঞ্চি', false],
                    ['D', '৩৮.৫৫ ইঞ্চি', false],
                ],
            ],
            [
                'stem' => 'ধানের ফুলে পরাগ সংযোগ ঘটে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'বাতাসের সাহায্যে ঝড়ে পড়ে', true],
                    ['B', 'পাতা দ্বারা স্থানান্তরিত হয়ে', false],
                    ['C', 'কীটপতঙ্গের সাহায্যে', false],
                    ['D', 'ফুলে ফুলে সংস্পর্শে', false],
                ],
            ],
            [
                'stem' => 'সমুদ্রপৃষ্ঠে বায়ুর চাপ প্রতি বর্গ সেন্টিমিটারে কত?',
                'subject' => 'science',
                'options' => [
                    ['A', '১০ কি.মি.', false],
                    ['B', '১০ নিউটন', true],
                    ['C', '২৭ কি.মি.', false],
                    ['D', '৫ কি.মি.', false],
                ],
            ],
            [
                'stem' => 'সর্বপ্রথম যে উফশী ধান এ দেশে চালু হয়ে এখনো বর্তমান রয়েছে তা হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'ইরি-৮', true],
                    ['B', 'ইরি-১', false],
                    ['C', 'ইরি-২০', false],
                    ['D', 'ইরি-৩', false],
                ],
            ],
            [
                'stem' => 'ইস্পাত সাধারণ লোহা থেকে ভিন্ন। কারণ এতে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'বিশেষ ধরনের আকরিক ব্যবহার করা হয়েছে', false],
                    ['B', 'সুনিয়ন্ত্রিত পরিমাণ কার্বন রয়েছে', true],
                    ['C', 'লোহাকে টেম্পারিং করা হয়েছে', false],
                    ['D', 'সব বিজাতীয় দ্রব্য বের করে দেয়া হয়েছে', false],
                ],
            ],
            [
                'stem' => 'প্রাকৃতিক গ্যাসের প্রধান উপাদান হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'নাইট্রোজেন গ্যাস', false],
                    ['B', 'মিথেন', true],
                    ['C', 'হাইড্রোজেন গ্যাস', false],
                    ['D', 'কার্বন মনোক্সাইড', false],
                ],
            ],
            [
                'stem' => 'মৌলিক পদার্থের ক্ষুদ্রতম কণা যা রাসায়নিক প্রক্রিয়ায় অংশগ্রহণ করে তাকে বলা হয়-',
                'subject' => 'science',
                'options' => [
                    ['A', 'পরমাণু', true],
                    ['B', 'ইলেকট্রন', false],
                    ['C', 'অণু', false],
                    ['D', 'প্রোটন', false],
                ],
            ],
            [
                'stem' => 'সমুদ্র স্রোতের অন্যতম কারণ-',
                'subject' => 'science',
                'options' => [
                    ['A', 'বায়ু প্রবাহের প্রভাব', true],
                    ['B', 'সমুদ্রের পানিতে তাপ পরিচালনা', false],
                    ['C', 'সমুদ্রের পানিতে ঘনত্বের তারতম্য', false],
                    ['D', 'সমুদ্রের ঘূর্ণিঝড়', false],
                ],
            ],
            [
                'stem' => 'কাজ করার সামর্থ্যকে বলে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'ক্ষমতা', false],
                    ['B', 'কাজ', false],
                    ['C', 'শক্তি', true],
                    ['D', 'বল', false],
                ],
            ],
            [
                'stem' => 'রংধনু সৃষ্টির বেলায় পানির কণাগুলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'দর্পণের কাজ করে', false],
                    ['B', 'আতশীকাচের কাজ করে', false],
                    ['C', 'লেন্সের কাজ করে', false],
                    ['D', 'প্রিজমের কাজ করে', true],
                ],
            ],
            [
                'stem' => 'কাচ তৈরির প্রধান কাঁচামাল হলো-',
                'subject' => 'science',
                'options' => [
                    ['A', 'জিপসাম', false],
                    ['B', 'বালি', true],
                    ['C', 'সাজি মাটি', false],
                    ['D', 'চুনাপাথর', false],
                ],
            ],
            [
                'stem' => 'কম্পিউটারের সফটওয়্যার বলতে বুঝানো হয়-',
                'subject' => 'computer',
                'options' => [
                    ['A', 'এর প্রোগ্রাম বা কর্ম পরিকল্পনার কৌশল', true],
                    ['B', 'তথ্য দেয়া ও তথ্য নেয়ার অংশ বিশেষ', false],
                    ['C', 'যেসব অংশ মুদ্রিত অবস্থায় থাকে', false],
                    ['D', 'কম্পিউটার তৈরির নকশা', false],
                ],
            ],
            [
                'stem' => 'মাইক্রোওয়েভের মাধ্যমে যে টেলিযোগাযোগ ব্যবস্থা আমাদের দেশে প্রচলিত তাতে মাইক্রোওয়েভ অধিকাংশ দূরত্ব অতিক্রম করে-',
                'subject' => 'computer',
                'options' => [
                    ['A', 'ওয়েভ গাইডের মধ্য দিয়ে', true],
                    ['B', 'ভূমি ও আয়নোস্ফিয়ারের মধ্যে প্রতিফলন হতে হবে', false],
                    ['C', 'বিশেষ ধরনের ক্যাবলের মধ্য দিয়ে', false],
                    ['D', 'খোলামেলা জায়গার মধ্য দিয়ে সরল রেখায়', false],
                ],
            ],
            [
                'stem' => 'মানুষের ক্রোমোজোমের সংখ্যা কত?',
                'subject' => 'science',
                'options' => [
                    ['A', '২৪ জোড়া', false],
                    ['B', '২৬ জোড়া', false],
                    ['C', '২৩ জোড়া', true],
                    ['D', '২৫ জোড়া', false],
                ],
            ],
            [
                'stem' => 'সৌরকোষের বিদ্যুৎ রাতেও ব্যবহার করা সম্ভব যদি এর সঙ্গে থাকে-',
                'subject' => 'science',
                'options' => [
                    ['A', 'ট্রান্সফরমার', false],
                    ['B', 'জেনারেটর', false],
                    ['C', 'স্টোরেজ ব্যাটারি', true],
                    ['D', 'ক্যাপাসিটর', false],
                ],
            ],
            [
                'stem' => 'বৈদ্যুতিক পাখা ধীরে ধীরে ঘুরলে বিদ্যুৎ খরচ-',
                'subject' => 'science',
                'options' => [
                    ['A', 'একই হয়', true],
                    ['B', 'বেশি হয়', false],
                    ['C', 'কম হয়', false],
                    ['D', 'খুব কম হয়', false],
                ],
            ],
        ];

        // 2. Insert all 100 questions, their options, tags, and link to the 11th BCS exam
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
                'reference_source' => '১১তম বিসিএস প্রিলিমিনারি পরীক্ষা',
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
                'tag_value' => '11th BCS',
            ]);

            QuestionTag::create([
                'question_id' => $question->id,
                'tag_type' => 'year',
                'tag_value' => '1990',
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
