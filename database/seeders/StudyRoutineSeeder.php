<?php

namespace Database\Seeders;

use App\Models\StudyRoutine;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class StudyRoutineSeeder extends Seeder
{
    public function run(): void
    {
        $bangla = Subject::where('name_bn', 'like', '%বাংলা%')->first();
        $english = Subject::where('name_bn', 'like', '%ইংরেজি%')->first();
        $bd = Subject::where('name_bn', 'like', '%বাংলাদেশ%')->first();
        $intl = Subject::where('name_bn', 'like', '%আন্তর্জাতিক%')->first();
        $math = Subject::where('name_bn', 'like', '%গণিত%')->first();
        $science = Subject::where('name_bn', 'like', '%বিজ্ঞান%')->first();

        $routines = [
            [
                'day_of_week' => 1,
                'day_name_bn' => 'সোমবার',
                'day_name_en' => 'Monday',
                'subject_id' => $bangla?->id,
                'topic_title_bn' => 'বাংলা ব্যাকরণ: ধ্বনি, বর্ণ, সন্ধি ও বানান শুদ্ধি',
                'topic_title_en' => 'Bengali Grammar: Phonetics, Sandhi & Spelling',
                'syllabus_details_bn' => 'স্বরধ্বনি ও ব্যঞ্জনধ্বনির উচ্চারণ স্থান, ণ-ত্ব ও ষ-ত্ব বিধান, বাংলা একাডেমি প্রমিত বানান নিয়মাবলী এবং বিগত বছরের প্রশ্ন সমাধান।',
                'target_minutes' => 90,
                'target_questions' => 30,
            ],
            [
                'day_of_week' => 2,
                'day_name_bn' => 'মঙ্গলবার',
                'day_name_en' => 'Tuesday',
                'subject_id' => $english?->id,
                'topic_title_bn' => 'English Grammar: Parts of Speech, Clauses & Subject-Verb Agreement',
                'topic_title_en' => 'English Grammar & Vocabulary',
                'syllabus_details_bn' => 'Identification of Noun, Pronoun, Adjective, Adverb; Finite & Non-finite Verbs; Inversion and high-yield rule practice.',
                'target_minutes' => 90,
                'target_questions' => 30,
            ],
            [
                'day_of_week' => 3,
                'day_name_bn' => 'বুধবার',
                'day_name_en' => 'Wednesday',
                'subject_id' => $bd?->id,
                'topic_title_bn' => 'বাংলাদেশ বিষয়াবলী: প্রাচীনকাল থেকে মুক্তিযুদ্ধ ও সংবিধান',
                'topic_title_en' => 'Bangladesh Affairs: History & Constitution',
                'syllabus_details_bn' => 'বঙ্গভঙ্গ, ভাষা আন্দোলন (১৯৫২), ৬ দফা আন্দোলন (১৯৬৬), মুক্তিযুদ্ধ ও সেক্টর কমান্ডারগণ এবং সংবিধানের অনুচ্ছেদ ১-৪৭।',
                'target_minutes' => 120,
                'target_questions' => 40,
            ],
            [
                'day_of_week' => 4,
                'day_name_bn' => 'বৃহস্পতিবার',
                'day_name_en' => 'Thursday',
                'subject_id' => $math?->id,
                'topic_title_bn' => 'গাণিতিক যুক্তি: বাস্তব সংখ্যা, ল.সা.গু-গ.সা.গু ও শতকরা-লাভ-ক্ষতি',
                'topic_title_en' => 'Mathematical Reasoning: Number Systems & Arithmetic',
                'syllabus_details_bn' => 'মৌলিক সংখ্যা নির্ণয়, অনুপাত ও সমানুপাত, ঐকিক নিয়ম এবং মুনাফা-সুদকষা শর্টকাট টেকনিক।',
                'target_minutes' => 90,
                'target_questions' => 25,
            ],
            [
                'day_of_week' => 5,
                'day_name_bn' => 'শুক্রবার',
                'day_name_en' => 'Friday',
                'subject_id' => $intl?->id,
                'topic_title_bn' => 'আন্তর্জাতিক বিষয়াবলী: বৈশ্বিক সংস্থা, চুক্তি ও ভূ-রাজনীতি',
                'topic_title_en' => 'International Affairs: Global Treaties & Organizations',
                'syllabus_details_bn' => 'জাতিসংঘ ও এর অঙ্গসংস্থা (UN, WHO, IMF, World Bank), আন্তর্জাতিক জলবায়ু চুক্তি এবং চলমান সাম্প্রতিক দ্বন্দ্ব।',
                'target_minutes' => 90,
                'target_questions' => 30,
            ],
            [
                'day_of_week' => 6,
                'day_name_bn' => 'শনিবার',
                'day_name_en' => 'Saturday',
                'subject_id' => $science?->id,
                'topic_title_bn' => 'সাধারণ বিজ্ঞান ও আইসিটি: আলো, শব্দ, কম্পিউটার ও সাইবার সিকিউরিটি',
                'topic_title_en' => 'General Science & Information Technology',
                'syllabus_details_bn' => 'মানবদেহ ও রোগবালাই, খাদ্য ও পুষ্টি, নেটওয়ার্কিং প্রোটোকল (TCP/IP), ক্লাউড কম্পিউটিং ও বিসিএস আইসিটি প্রশ্নাবলি।',
                'target_minutes' => 90,
                'target_questions' => 30,
            ],
            [
                'day_of_week' => 7,
                'day_name_bn' => 'রবিবার',
                'day_name_en' => 'Sunday',
                'subject_id' => null,
                'topic_title_bn' => 'সাপ্তাহিক মহা রিভিশন ও ফুল-লেংথ বিসিএস মডেল টেস্ট',
                'topic_title_en' => 'Weekly Grand Revision & Full Mock Test',
                'syllabus_details_bn' => 'সপ্তাহজুড়ে পড়া সকল অধ্যায়ের ভুল উত্তরের ব্যাংক (Mistake Bank) রিভিশন এবং ২০০ নম্বরের পূর্ণাঙ্গ মডেল টেস্ট অনুশীলন।',
                'target_minutes' => 150,
                'target_questions' => 100,
            ],
        ];

        foreach ($routines as $item) {
            StudyRoutine::updateOrCreate(
                ['day_of_week' => $item['day_of_week']],
                $item
            );
        }
    }
}
