<?php

namespace Database\Seeders;

use App\Models\ExamType;
use App\Models\ExamYear;
use App\Models\Organization;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        // 1. ORGANIZATIONS
        $bpsc = Organization::firstOrCreate(['slug' => 'bpsc'], [
            'name_en' => 'Bangladesh Public Service Commission',
            'name_bn' => 'বাংলাদেশ সরকারি কর্ম কমিশন',
            'code' => 'BPSC',
            'is_question_setter' => true,
            'description' => 'Conducts BCS examinations and recruitments for the civil service of Bangladesh.',
        ]);

        $buet = Organization::firstOrCreate(['slug' => 'buet'], [
            'name_en' => 'Bangladesh University of Engineering and Technology',
            'name_bn' => 'বাংলাদেশ প্রকৌশল বিশ্ববিদ্যালয়',
            'code' => 'BUET',
            'is_question_setter' => true,
            'description' => 'Known for technical and analytical examination patterns.',
        ]);

        $iba = Organization::firstOrCreate(['slug' => 'iba-du'], [
            'name_en' => 'Institute of Business Administration, DU',
            'name_bn' => 'আইবিএ (ঢাকা বিশ্ববিদ্যালয়)',
            'code' => 'IBA',
            'is_question_setter' => true,
            'description' => 'Premier business school setting tests for central bank and commercial banks.',
        ]);

        $bb = Organization::firstOrCreate(['slug' => 'bangladesh-bank'], [
            'name_en' => 'Bangladesh Bank',
            'name_bn' => 'বাংলাদেশ ব্যাংক',
            'code' => 'BB',
            'is_question_setter' => false,
            'description' => 'Central bank of Bangladesh.',
        ]);

        Organization::firstOrCreate(['slug' => 'du-arts'], [
            'name_en' => 'Faculty of Arts, Dhaka University',
            'name_bn' => 'কলা অনুষদ, ঢাকা বিশ্ববিদ্যালয়',
            'code' => 'ARTS',
            'is_question_setter' => true,
            'description' => 'Sets questions for various recruitment examinations.',
        ]);

        // 2. EXAM TYPES
        ExamType::firstOrCreate(['slug' => 'bcs-preliminary'], [
            'organization_id' => $bpsc->id,
            'name_en' => 'BCS Preliminary',
            'name_bn' => 'বিসিএস প্রিলিমিনারি',
        ]);

        ExamType::firstOrCreate(['slug' => 'bcs-written'], [
            'organization_id' => $bpsc->id,
            'name_en' => 'BCS Written',
            'name_bn' => 'বিসিএস লিখিত',
        ]);

        ExamType::firstOrCreate(['slug' => 'bank-officer-general'], [
            'organization_id' => $bb->id,
            'name_en' => 'Combined Bank Senior Officer',
            'name_bn' => 'সমন্বিত ব্যাংক সিনিয়র অফিসার',
        ]);

        ExamType::firstOrCreate(['slug' => 'bank-officer-it'], [
            'organization_id' => $buet->id,
            'name_en' => 'Bank Senior Officer (IT)',
            'name_bn' => 'ব্যাংক সিনিয়র অফিসার (আইটি)',
        ]);

        // 3. EXAM YEARS (10th to 47th BCS)
        for ($i = 10; $i <= 47; $i++) {
            $bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
            $enDigits = ['0','1','2','3','4','5','6','7','8','9'];
            $bnNumber = str_replace($enDigits, $bnDigits, (string) $i);

            ExamYear::firstOrCreate(['year' => "{$i}th"], [
                'name_en' => "{$i}th BCS Exam",
                'name_bn' => "{$bnNumber}তম বিসিএস",
            ]);
        }

        // 4. SUBJECTS & TOPICS
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
                'name_bn' => 'বাংলাদেশ বিষয়াবলী',
                'name_en' => 'Bangladesh Affairs',
                'slug' => 'bangladesh-affairs',
                'color' => '#EC4899',
                'icon' => 'map-pin',
                'topics' => [
                    ['name_bn' => 'মুক্তিযুদ্ধ ও সংবিধান', 'name_en' => 'Liberation War & Constitution', 'slug' => 'liberation-constitution'],
                    ['name_bn' => 'ইতিহাস, অর্থনীতি ও ভৌগোলিক পরিচিতি', 'name_en' => 'History, Economy & Geography', 'slug' => 'history-economy-geography'],
                ],
            ],
            [
                'name_bn' => 'আন্তর্জাতিক বিষয়াবলী',
                'name_en' => 'International Affairs',
                'slug' => 'international-affairs',
                'color' => '#8B5CF6',
                'icon' => 'globe',
                'topics' => [
                    ['name_bn' => 'আন্তর্জাতিক সংস্থা ও চুক্তি', 'name_en' => 'Global Treaties & Organizations', 'slug' => 'organizations-treaties'],
                    ['name_bn' => 'ভূরাজনীতি ও সমসাময়িক বিশ্ব', 'name_en' => 'Geopolitics & Current World', 'slug' => 'geopolitics'],
                ],
            ],
            [
                'name_bn' => 'সাধারণ বিজ্ঞান ও প্রযুক্তি',
                'name_en' => 'General Science & Technology',
                'slug' => 'science-technology',
                'color' => '#EF4444',
                'icon' => 'flask',
                'topics' => [
                    ['name_bn' => 'পদার্থবিজ্ঞান ও রসায়ন', 'name_en' => 'Physics & Chemistry', 'slug' => 'physics-chemistry'],
                    ['name_bn' => 'জীববিজ্ঞান ও স্বাস্থ্য', 'name_en' => 'Biology & Health', 'slug' => 'biology-health'],
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
                    ['name_bn' => 'ইন্টারনেট ও নেটওয়ার্ক সিকিউরিটি', 'name_en' => 'Networking & Cybersecurity', 'slug' => 'network-security'],
                ],
            ],
        ];

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
                Topic::firstOrCreate(['subject_id' => $subject->id, 'slug' => $topData['slug']], [
                    'name_bn' => $topData['name_bn'],
                    'name_en' => $topData['name_en'],
                    'order' => $tIndex + 1,
                ]);
            }
        }
    }
}
