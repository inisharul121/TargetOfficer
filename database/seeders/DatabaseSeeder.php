<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamSection;
use App\Models\ExamType;
use App\Models\ExamYear;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionTag;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@targetofficer.com'],
            [
                'name' => 'System Admin',
                'phone' => '01700000001',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'target_exam' => '47th BCS Preliminary',
                'coins' => 500,
                'daily_streak' => 12,
                'longest_streak' => 15,
                'last_active_date' => now()->toDateString(),
            ]
        );

        $student = User::firstOrCreate(
            ['email' => 'candidate@targetofficer.com'],
            [
                'name' => 'Tanvir Ahmed',
                'phone' => '01800000002',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'target_exam' => '47th BCS Preliminary',
                'coins' => 240,
                'daily_streak' => 5,
                'longest_streak' => 9,
                'last_active_date' => now()->toDateString(),
            ]
        );

        // 2. Organizations / Setter Bodies
        $bpsc = Organization::firstOrCreate(['slug' => 'bpsc'], [
            'name_en' => 'Bangladesh Public Service Commission',
            'name_bn' => 'বাংলাদেশ সরকারী কর্ম কমিশন (বিপিএসসি)',
            'code' => 'BPSC',
            'is_question_setter' => true,
            'description' => 'Official conducting body for BCS and Non-Cadre examinations.',
        ]);

        $buet = Organization::firstOrCreate(['slug' => 'buet'], [
            'name_en' => 'BUET Testing Authority',
            'name_bn' => 'বুয়েট পরীক্ষা কর্তৃপক্ষ',
            'code' => 'BUET',
            'is_question_setter' => true,
            'description' => 'Technical and analytical question setter for Bank Jobs, Power Sector & IT Cadres.',
        ]);

        $iba = Organization::firstOrCreate(['slug' => 'iba'], [
            'name_en' => 'IBA, University of Dhaka',
            'name_bn' => 'আইবিএ, ঢাকা বিশ্ববিদ্যালয়',
            'code' => 'IBA',
            'is_question_setter' => true,
            'description' => 'Renowned for rigorous English, Analytical & Critical Reasoning exams.',
        ]);

        $bb = Organization::firstOrCreate(['slug' => 'bangladesh-bank'], [
            'name_en' => 'Bangladesh Bank (BSCRC)',
            'name_bn' => 'বাংলাদেশ ব্যাংক (ব্যাংকার্স সিলেকশন)',
            'code' => 'BB',
            'is_question_setter' => false,
            'description' => 'Central bank of Bangladesh and Combined 8 Banks recruiting body.',
        ]);

        $arts = Organization::firstOrCreate(['slug' => 'arts-faculty'], [
            'name_en' => 'Arts Faculty, University of Dhaka',
            'name_bn' => 'কলা অনুষদ, ঢাকা বিশ্ববিদ্যালয়',
            'code' => 'ARTS',
            'is_question_setter' => true,
            'description' => 'Specialized in General Knowledge, Literature, and Social Sciences.',
        ]);

        // 3. Exam Types & Years
        $bcsPreli = ExamType::firstOrCreate(['slug' => 'bcs-preliminary'], [
            'organization_id' => $bpsc->id,
            'name_en' => 'BCS Preliminary',
            'name_bn' => 'বিসিএস প্রিলিমিনারি',
        ]);

        $bankOfficer = ExamType::firstOrCreate(['slug' => 'bank-officer-general'], [
            'organization_id' => $bb->id,
            'name_en' => 'Combined Bank Senior Officer',
            'name_bn' => 'সমন্বিত ব্যাংক সিনিয়র অফিসার',
        ]);

        $year46 = ExamYear::firstOrCreate(['year' => '46th'], [
            'name_en' => '46th BCS Exam',
            'name_bn' => '৪৬তম বিসিএস',
        ]);

        $year45 = ExamYear::firstOrCreate(['year' => '45th'], [
            'name_en' => '45th BCS Exam',
            'name_bn' => '৪৫তম বিসিএস',
        ]);

        // 4. Subjects & Topics
        $subjectsData = [
            [
                'name_bn' => 'বাংলা ভাষা ও সাহিত্য',
                'name_en' => 'Bangla Language & Literature',
                'slug' => 'bangla',
                'color' => '#10B981',
                'icon' => 'book-open',
                'topics' => [
                    ['name_bn' => 'প্রাচীন ও মধ্যযুগ', 'name_en' => 'Ancient & Medieval Era', 'slug' => 'ancient-medieval'],
                    ['name_bn' => 'আধুনিক যুগ ও কবি-সাহিত্যিক', 'name_en' => 'Modern Literature', 'slug' => 'modern-literature'],
                    ['name_bn' => 'বাংলা ব্যাকরণ ও ধ্বনিতত্ত্ব', 'name_en' => 'Grammar & Phonetics', 'slug' => 'grammar-phonetics'],
                ],
            ],
            [
                'name_bn' => 'English Language & Literature',
                'name_en' => 'English Language & Literature',
                'slug' => 'english',
                'color' => '#3B82F6',
                'icon' => 'languages',
                'topics' => [
                    ['name_bn' => 'Parts of Speech & Idioms', 'name_en' => 'Parts of Speech & Idioms', 'slug' => 'grammar-vocabulary'],
                    ['name_bn' => 'English Literary Periods & Figures', 'name_en' => 'Literary Periods', 'slug' => 'literary-periods'],
                ],
            ],
            [
                'name_bn' => 'বাংলাদেশ বিষয়াবলী',
                'name_en' => 'Bangladesh Affairs',
                'slug' => 'bangladesh-affairs',
                'color' => '#EC4899',
                'icon' => 'map-pin',
                'topics' => [
                    ['name_bn' => 'মুক্তিযুদ্ধ ও সংবিধান', 'name_en' => 'Liberation War & Constitution', 'slug' => 'liberation-constitution'],
                    ['name_bn' => 'অর্থনীতি ও জাতীয় অর্জন', 'name_en' => 'Economy & National Achievements', 'slug' => 'economy-achievements'],
                ],
            ],
            [
                'name_bn' => 'আন্তর্জাতিক বিষয়াবলী',
                'name_en' => 'International Affairs',
                'slug' => 'international-affairs',
                'color' => '#8B5CF6',
                'icon' => 'globe',
                'topics' => [
                    ['name_bn' => 'আন্তর্জাতিক সংস্থা ও চুক্তি', 'name_en' => 'Global Treaties & Organizations', 'slug' => 'organizations-treaties'],
                    ['name_bn' => 'ভূরাজনীতি ও সমসাময়িক বিশ্ব', 'name_en' => 'Geopolitics & Current World', 'slug' => 'geopolitics'],
                ],
            ],
            [
                'name_bn' => 'গাণিতিক যুক্তি ও মানসিক দক্ষতা',
                'name_en' => 'Mathematical Reasoning & Mental Ability',
                'slug' => 'math-mental-ability',
                'color' => '#F59E0B',
                'icon' => 'calculator',
                'topics' => [
                    ['name_bn' => 'বীজগণিত ও সূচক-লগারিদম', 'name_en' => 'Algebra & Exponents', 'slug' => 'algebra-log'],
                    ['name_bn' => 'পাটিগণিত ও শতকরা', 'name_en' => 'Arithmetic & Percentages', 'slug' => 'arithmetic'],
                    ['name_bn' => 'জ্যামিতি ও পরিমিতি', 'name_en' => 'Geometry & Mensuration', 'slug' => 'geometry'],
                ],
            ],
            [
                'name_bn' => 'কম্পিউটার ও তথ্যপ্রযুক্তি',
                'name_en' => 'Computer & Information Technology',
                'slug' => 'computer-it',
                'color' => '#06B6D4',
                'icon' => 'cpu',
                'topics' => [
                    ['name_bn' => 'কম্পিউটার সংগঠন ও মেমোরি', 'name_en' => 'Architecture & Memory', 'slug' => 'architecture-memory'],
                    ['name_bn' => 'ইন্টারনেট ও নেটওয়ার্ক সিকিউরিটি', 'name_en' => 'Networking & Cybersecurity', 'slug' => 'network-security'],
                ],
            ],
        ];

        $topicMap = [];
        foreach ($subjectsData as $index => $subData) {
            $subject = Subject::firstOrCreate(['slug' => $subData['slug']], [
                'name_bn' => $subData['name_bn'],
                'name_en' => $subData['name_en'],
                'color' => $subData['color'],
                'icon' => $subData['icon'],
                'order' => $index + 1,
                'is_active' => true,
            ]);

            foreach ($subData['topics'] as $tIndex => $topData) {
                $topic = Topic::firstOrCreate(['subject_id' => $subject->id, 'slug' => $topData['slug']], [
                    'name_bn' => $topData['name_bn'],
                    'name_en' => $topData['name_en'],
                    'order' => $tIndex + 1,
                ]);
                $topicMap[$subData['slug'] . '.' . $topData['slug']] = $topic->id;
            }
        }

        // 5. Rich Questions with LaTeX, Options, Explanations & Setter Tags
        $questionsPool = [
            // Bangla
            [
                'subject_slug' => 'bangla',
                'topic_slug' => 'grammar-phonetics',
                'setter' => $bpsc->id,
                'stem_bn' => '‘কোনটি শুদ্ধ বানান?’',
                'stem_en' => 'Which one is the correct spelling in Bangla?',
                'difficulty' => 'medium',
                'options' => [
                    ['A', 'মুহূর্মুহু', 'Muhurmuhu', false],
                    ['B', 'মুহুর্যুহু', 'Muhuryuhu', false],
                    ['C', 'মুহূর্তমুহু', 'Muhurtomuhu', false],
                    ['D', 'মুহুর্মুহু', 'Muhurmuhu', true],
                ],
                'explanation_bn' => 'সঠিক বানান হলো ‘মুহুর্মুহু’ (ম-এ হ্রস্ব উ, হ-এ দীর্ঘ ঊ + রেফ, ম-এ হ্রস্ব উ, হ-এ হ্রস্ব উ)। এর অর্থ বারবার বা ক্ষণে ক্ষণে।',
                'reference' => 'বাংলা একাডেমি প্রমিত বাংলা ব্যাকরণ',
                'tags' => ['45th BCS', 'BPSC Pattern', 'বানান শুদ্ধি'],
            ],
            [
                'subject_slug' => 'bangla',
                'topic_slug' => 'ancient-medieval',
                'setter' => $arts->id,
                'stem_bn' => 'চর্যাপদের সবচেয়ে বেশি পদ কে রচনা করেছেন?',
                'stem_en' => 'Who composed the highest number of padas in Charyapada?',
                'difficulty' => 'easy',
                'options' => [
                    ['A', 'লুইপা', 'Luipa', false],
                    ['B', 'কাহ্নপা', 'Kahnapa', true],
                    ['C', 'ভুসুকুপা', 'Bhusukupa', false],
                    ['D', 'শবরপা', 'Shaborpa', false],
                ],
                'explanation_bn' => 'কাহ্নপা চর্যাপদের সর্বাধিক পদ (১৩টি) রচনা করেছেন। দ্বিতীয় সর্বোচ্চ পদ রচয়িতা হলেন ভুসুকুপা (৮টি)। লুইপা চর্যাপদের আদি কবি হিসেবে স্বীকৃত।',
                'reference' => 'লাল নীল দীপাবলি - হুমায়ুন আজাদ',
                'tags' => ['44th BCS', 'Arts Faculty Pattern', 'চর্যাপদ'],
            ],
            // English
            [
                'subject_slug' => 'english',
                'topic_slug' => 'grammar-vocabulary',
                'setter' => $iba->id,
                'stem_bn' => 'What is the antonym of the word "EPHEMERAL"?',
                'stem_en' => 'What is the antonym of the word "EPHEMERAL"?',
                'difficulty' => 'medium',
                'options' => [
                    ['A', 'Transient', 'Transient', false],
                    ['B', 'Perpetual', 'Perpetual', true],
                    ['C', 'Fleeting', 'Fleeting', false],
                    ['D', 'Momentary', 'Momentary', false],
                ],
                'explanation_bn' => 'Ephemeral মানে ক্ষণস্থায়ী। এর Antonym বা বিপরীত শব্দ হলো Perpetual (চিরস্থায়ী, অবিরাম)। Transient ও Fleeting হলো এর Synonyms।',
                'reference' => 'Barron’s GRE Vocabulary Guide',
                'tags' => ['IBA Pattern', 'Bank AD', 'Vocabulary'],
            ],
            [
                'subject_slug' => 'english',
                'topic_slug' => 'literary-periods',
                'setter' => $bpsc->id,
                'stem_bn' => 'Who is known as the "Poet of Sensuousness" in English literature?',
                'stem_en' => 'Who is known as the "Poet of Sensuousness" in English literature?',
                'difficulty' => 'easy',
                'options' => [
                    ['A', 'William Wordsworth', 'William Wordsworth', false],
                    ['B', 'John Keats', 'John Keats', true],
                    ['C', 'P. B. Shelley', 'P. B. Shelley', false],
                    ['D', 'Lord Byron', 'Lord Byron', false],
                ],
                'explanation_bn' => 'John Keats is renowned as the "Poet of Sensuousness" and "Poet of Beauty" due to vivid imagery appealing to the senses in his poems like Ode to a Nightingale.',
                'reference' => 'An ABC of English Literature - Dr. M Mofizar Rahman',
                'tags' => ['43rd BCS', 'Romantic Era', 'English Literature'],
            ],
            // Math with LaTeX
            [
                'subject_slug' => 'math-mental-ability',
                'topic_slug' => 'algebra-log',
                'setter' => $buet->id,
                'stem_bn' => 'যদি $x + \\frac{1}{x} = 3$ হয়, তবে $x^3 + \\frac{1}{x^3}$ এর মান কত?',
                'stem_en' => 'If $x + \\frac{1}{x} = 3$, what is the value of $x^3 + \\frac{1}{x^3}$?',
                'difficulty' => 'medium',
                'options' => [
                    ['A', '18', '18', true],
                    ['B', '27', '27', false],
                    ['C', '36', '36', false],
                    ['D', '9', '9', false],
                ],
                'explanation_bn' => 'আমরা জানি, $a^3 + b^3 = (a+b)^3 - 3ab(a+b)$। সুতরাং, $x^3 + \\frac{1}{x^3} = (3)^3 - 3(1)(3) = 27 - 9 = 18$।',
                'reference' => 'মাধ্যমিক বীজগণিত (৯ম-১০ম শ্রেণি)',
                'tags' => ['BUET Pattern', '45th BCS', 'Algebra Formula'],
            ],
            [
                'subject_slug' => 'math-mental-ability',
                'topic_slug' => 'arithmetic',
                'setter' => $buet->id,
                'stem_bn' => 'একটি দ্রব্যের ক্রয়মূল্য ও বিক্রয়মূল্যের অনুপাত $5:6$ হলে শতকরা লাভ কত?',
                'stem_en' => 'If the ratio of cost price to selling price is $5:6$, what is the profit percentage?',
                'difficulty' => 'easy',
                'options' => [
                    ['A', '10%', '10%', false],
                    ['B', '15%', '15%', false],
                    ['C', '20%', '20%', true],
                    ['D', '25%', '25%', false],
                ],
                'explanation_bn' => 'ধরি ক্রয়মূল্য $5x$ এবং বিক্রয়মূল্য $6x$। লাভ $= 6x - 5x = x$। শতকরা লাভ $= \\frac{x}{5x} \\times 100\\% = 20\\%$।',
                'reference' => 'Bank Math Shortcut Series',
                'tags' => ['Combined 8 Banks', 'BUET Pattern', 'Percentage'],
            ],
            // Bangladesh Affairs
            [
                'subject_slug' => 'bangladesh-affairs',
                'topic_slug' => 'liberation-constitution',
                'setter' => $bpsc->id,
                'stem_bn' => 'বাংলাদেশের সংবিধানের কত নম্বর অনুচ্ছেদে ‘চিন্তা ও বিবেকের স্বাধীনতা’ নিশ্চিত করা হয়েছে?',
                'stem_en' => 'Which article of Bangladesh Constitution guarantees Freedom of Thought and Conscience?',
                'difficulty' => 'medium',
                'options' => [
                    ['A', '৩৯(১) অনুচ্ছেদ', 'Article 39(1)', true],
                    ['B', '৩৯(২) অনুচ্ছেদ', 'Article 39(2)', false],
                    ['C', '২৭ অনুচ্ছেদ', 'Article 27', false],
                    ['D', '৩২ অনুচ্ছেদ', 'Article 32', false],
                ],
                'explanation_bn' => 'সংবিধানের ৩৯(১) অনুচ্ছেদে চিন্তা ও বিবেকের স্বাধীনতার নিশ্চয়তা দান করা হইয়াছে এবং ৩৯(২) অনুচ্ছেদে বাক ও ভাব প্রকাশের স্বাধীনতা এবং সংবাদপত্রের স্বাধীনতার বিধান রয়েছে।',
                'reference' => 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান',
                'tags' => ['46th BCS', 'BPSC Pattern', 'Constitution'],
            ],
            // Computer & IT
            [
                'subject_slug' => 'computer-it',
                'topic_slug' => 'architecture-memory',
                'setter' => $buet->id,
                'stem_bn' => 'নিচের কোনটি কম্পিউটারের দ্রুততম মেমোরি (Fastest Memory)?',
                'stem_en' => 'Which of the following is the fastest memory in a computer?',
                'difficulty' => 'easy',
                'options' => [
                    ['A', 'RAM (DRAM)', 'RAM (DRAM)', false],
                    ['B', 'CPU Register', 'CPU Register', true],
                    ['C', 'Cache Memory (L1)', 'Cache Memory (L1)', false],
                    ['D', 'SSD NVMe', 'SSD NVMe', false],
                ],
                'explanation_bn' => 'মেমোরি হায়ারার্কি অনুযায়ী CPU Register হলো দ্রুততম, এর পরেই Cache Memory (L1, L2, L3), তারপর RAM এবং সবশেষে Secondary Storage (SSD/HDD)।',
                'reference' => 'Computer Architecture & Organization - Morris Mano',
                'tags' => ['IT Cadre', 'BUET Pattern', 'Hardware Architecture'],
            ],
        ];

        $createdQuestionIds = [];
        foreach ($questionsPool as $qData) {
            $subj = Subject::where('slug', $qData['subject_slug'])->first();
            $topicId = $topicMap[$qData['subject_slug'] . '.' . $qData['topic_slug']] ?? null;

            $question = Question::create([
                'subject_id' => $subj->id,
                'topic_id' => $topicId,
                'setter_organization_id' => $qData['setter'],
                'stem_bn' => $qData['stem_bn'],
                'stem_en' => $qData['stem_en'],
                'difficulty' => $qData['difficulty'],
                'default_marks' => 1.00,
                'negative_marks' => 0.50,
                'explanation_bn' => $qData['explanation_bn'],
                'reference_source' => $qData['reference'],
                'status' => 'published',
                'created_by' => $admin->id,
                'verified_by' => $admin->id,
            ]);

            $createdQuestionIds[] = $question->id;

            foreach ($qData['options'] as $idx => $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_letter' => $opt[0],
                    'option_text_bn' => $opt[1],
                    'option_text_en' => $opt[2],
                    'is_correct' => $opt[3],
                    'order' => $idx + 1,
                ]);
            }

            foreach ($qData['tags'] as $tag) {
                QuestionTag::create([
                    'question_id' => $question->id,
                    'tag_type' => 'pattern',
                    'tag_value' => $tag,
                ]);
            }
        }

        // 6. Pre-Configured Official Exams
        $exam1 = Exam::create([
            'title_bn' => '৪৬তম বিসিএস স্পেশাল মডেল টেস্ট - ০১ (পূর্ণাঙ্গ প্রস্তুতি)',
            'title_en' => '46th BCS Special Model Test - 01 (Comprehensive)',
            'slug' => '46th-bcs-special-model-test-01',
            'description_bn' => 'বিপিএসসি প্রশ্নকর্তা প্যাটার্ন অনুসারে সাজানো পূর্ণাঙ্গ মডেল টেস্ট। নেগেটিভ মার্কিং ০.৫০।',
            'exam_mode' => 'timed_mock',
            'organization_id' => $bpsc->id,
            'exam_type_id' => $bcsPreli->id,
            'exam_year_id' => $year46->id,
            'total_questions' => count($createdQuestionIds),
            'total_marks' => count($createdQuestionIds),
            'duration_minutes' => 15,
            'pass_percentage' => 50.00,
            'negative_mark_per_question' => 0.50,
            'is_published' => true,
            'is_premium' => false,
            'allow_pause' => false,
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'show_instant_result' => true,
            'created_by' => $admin->id,
        ]);

        $exam2 = Exam::create([
            'title_bn' => 'বুয়েট প্যাটার্ন ব্যাংক সিনিয়র অফিসার (IT & Analytical) প্র্যাকটিস',
            'title_en' => 'BUET Pattern Bank Senior Officer (IT & Analytical) Practice',
            'slug' => 'buet-pattern-bank-senior-officer-practice',
            'description_bn' => 'বুয়েটের বিগত বছরের প্রশ্ন বিশ্লেষণ করে তৈরি স্পেশাল প্র্যাকটিস টেস্ট। সাথে বিস্তারিত সমাধান।',
            'exam_mode' => 'practice',
            'organization_id' => $buet->id,
            'exam_type_id' => $bankOfficer->id,
            'exam_year_id' => $year46->id,
            'total_questions' => count($createdQuestionIds),
            'total_marks' => count($createdQuestionIds),
            'duration_minutes' => 0, // Untimed practice
            'pass_percentage' => 40.00,
            'negative_mark_per_question' => 0.25,
            'is_published' => true,
            'is_premium' => false,
            'allow_pause' => true,
            'shuffle_questions' => false,
            'shuffle_options' => false,
            'show_instant_result' => true,
            'created_by' => $admin->id,
        ]);

        $exam3 = Exam::create([
            'title_bn' => 'ডেইলি স্পিড কুইজ - আজকের দৈনিক বিষয়াবলী ও গণিত',
            'title_en' => 'Daily Speed Micro-Quiz - General Knowledge & Math',
            'slug' => 'daily-speed-quiz-today',
            'description_bn' => 'মাত্র ৫ মিনিটের দৈনিক রিভিশন কুইজ। আপনার দৈনিক স্ট্রাইক বজায় রাখুন!',
            'exam_mode' => 'daily_quiz',
            'total_questions' => 5,
            'total_marks' => 5,
            'duration_minutes' => 5,
            'pass_percentage' => 60.00,
            'negative_mark_per_question' => 0.50,
            'is_published' => true,
            'is_premium' => false,
            'allow_pause' => false,
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'show_instant_result' => true,
            'created_by' => $admin->id,
        ]);

        foreach ($createdQuestionIds as $idx => $qid) {
            ExamQuestion::create([
                'exam_id' => $exam1->id,
                'question_id' => $qid,
                'marks' => 1.00,
                'negative_marks' => 0.50,
                'order' => $idx + 1,
            ]);

            ExamQuestion::create([
                'exam_id' => $exam2->id,
                'question_id' => $qid,
                'marks' => 1.00,
                'negative_marks' => 0.25,
                'order' => $idx + 1,
            ]);

            if ($idx < 5) {
                ExamQuestion::create([
                    'exam_id' => $exam3->id,
                    'question_id' => $qid,
                    'marks' => 1.00,
                    'negative_marks' => 0.50,
                    'order' => $idx + 1,
                ]);
            }
        }

        // 7. Badges
        $badges = [
            [
                'name_bn' => 'প্রথম পরীক্ষা সম্পন্ন',
                'name_en' => 'First Step Officer',
                'code' => 'FIRST_EXAM',
                'icon' => 'award',
                'description_bn' => 'টার্গেট অফিসারে আপনার প্রথম মডেল টেস্ট সফলভাবে সম্পন্ন করার জন্য অর্জিত।',
                'reward_coins' => 50,
            ],
            [
                'name_bn' => '৭ দিনের স্টাডি স্ট্রাইক',
                'name_en' => '7-Day Study Warrior',
                'code' => 'STREAK_7_DAYS',
                'icon' => 'flame',
                'description_bn' => 'টানা ৭ দিন প্ল্যাটফর্মে নিয়মিত পরীক্ষা দিয়ে স্ট্রাইক ধরে রাখার স্বীকৃতি।',
                'reward_coins' => 100,
            ],
            [
                'name_bn' => 'বিসিএস নির্ভুল স্নাইপার (Accuracy 90%+)',
                'name_en' => 'Accuracy Sniper',
                'code' => 'ACCURACY_SNIPER',
                'icon' => 'target',
                'description_bn' => 'কোনো মডেল টেস্টে ৯০% এর বেশি নির্ভুল উত্তর দিয়ে নেগেটিভ মার্কিং এড়িয়ে যাওয়ার জন্য।',
                'reward_coins' => 150,
            ],
            [
                'name_bn' => 'বুয়েট প্যাটার্ন মাস্টার',
                'name_en' => 'BUET Pattern Master',
                'code' => 'BUET_MASTER',
                'icon' => 'shield-check',
                'description_bn' => 'বুয়েট প্যাটার্ন ব্যাংক ও অ্যানালিটিক্যাল পরীক্ষায় শীর্ষ স্কোর অর্জনকারী।',
                'reward_coins' => 200,
            ],
        ];

        foreach ($badges as $bData) {
            Badge::firstOrCreate(['code' => $bData['code']], $bData);
        }
    }
}
