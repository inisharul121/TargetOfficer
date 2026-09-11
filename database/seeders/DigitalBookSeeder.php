<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookWrittenContent;
use App\Models\ExamType;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DigitalBookSeeder extends Seeder
{
    /**
     * Seed Topic-Based Text eBooks for BCS Examination Preparation.
     */
    public function run(): void
    {
        $bcsType = ExamType::firstOrCreate(
            ['slug' => 'bcs-preliminary-written'],
            [
                'name_bn' => 'বিসিএস (প্রিলিমিনারি ও লিখিত প্রস্তুতি)',
                'name_en' => 'BCS (Preliminary & Written)',
            ]
        );

        $bangla = Subject::where('name_bn', 'like', '%বাংলা%')->orWhere('name_en', 'like', '%Bangla%')->first();
        $english = Subject::where('name_en', 'like', '%English%')->orWhere('name_bn', 'like', '%English%')->first();
        $bd = Subject::where('name_bn', 'like', '%বাংলাদেশ%')->orWhere('name_en', 'like', '%Bangladesh%')->first();
        $intl = Subject::where('name_bn', 'like', '%আন্তর্জাতিক%')->orWhere('name_en', 'like', '%International%')->first();
        $math = Subject::where('name_bn', 'like', '%গণিত%')->orWhere('name_en', 'like', '%Math%')->first();
        $science = Subject::where('name_bn', 'like', '%বিজ্ঞান%')->orWhere('name_en', 'like', '%Science%')->first();

        // -------------------------------------------------------------
        // 1. BOOK: BCS BANGLA
        // -------------------------------------------------------------
        if ($bangla) {
            $bookBangla = Book::updateOrCreate(
                ['slug' => 'book-bcs-bangla'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $bangla->id,
                    'title_bn' => 'বিসিএস বাংলা ভাষা ও সাহিত্য সমগ্র (থিওরি ও লিখিত গাইড)',
                    'title_en' => 'BCS Bengali Language & Literature Master Guide',
                    'description_bn' => 'বিসিএস প্রিলিমিনারি ও লিখিত পরীক্ষার সম্পূর্ণ বাংলা সিলেবাস। প্রাচীন, মধ্য ও আধুনিক যুগের সাহিত্য ধারা, ব্যাকরণ, বাক্য শুদ্ধিকরণ এবং লিখিত অংশের প্রমাণ্য রচনামূলক প্রশ্নোত্তর।',
                    'cover_theme' => 'from-rose-600 via-rose-700 to-rose-950',
                    'icon' => '📕',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 1,
                    'is_published' => true,
                ]
            );

            // Chapter 1: ব্যাকরণ ও ধ্বনিতত্ত্ব
            $chB1 = BookChapter::updateOrCreate(
                ['book_id' => $bookBangla->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'অধ্যায় ১: বাংলা ব্যাকরণ, ধ্বনিতত্ত্ব ও বানান রীতি',
                    'title_en' => 'Chapter 1: Bengali Phonetics, Orthography & Grammar Rules',
                    'summary_bn' => 'ধ্বনি, বর্ণ, ণ-ত্ব ও ষ-ত্ব বিধান, সন্ধি, শব্দ ও বাংলা একাডেমি প্রমিত বানান নিয়মাবলী।',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chB1->id, 'order' => 1],
                [
                    'title_bn' => 'ধ্বনি ও বর্ণের সংজ্ঞা এবং মৌলিক পার্থক্য',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'ধ্বনি কাকে বলে? উদাহরণসহ স্বরধ্বনি ও ব্যঞ্জনধ্বনির প্রধান পার্থক্যসমূহ আলোচনা করুন।',
                    'marks' => 5.0,
                    'bcs_reference' => '৪১তম ও ৪৩তম বিসিএস লিখিত',
                    'content_bn' => '<strong>১. ধ্বনির সংজ্ঞা:</strong><br>মানুষের বাগযন্ত্রের সাহায্যে উচ্চারিত অর্থবোধক আওয়াজকে <strong>ধ্বনি</strong> বলে। ধ্বনি কেবল শ্রুতিগ্রাহ্য এবং এর কোনো দৃশ্যমান রূপ নেই। ধ্বনির চাক্ষুষ বা লিখিত রূপকে <strong>বর্ণ</strong> বলা হয়।<br><br><strong>২. স্বরধ্বনি ও ব্যঞ্জনধ্বনির মৌলিক পার্থক্য:</strong><br><table class="w-full border-collapse border border-slate-300 text-xs my-2"><thead><tr class="bg-slate-100"><th class="border border-slate-300 p-2">তুলনার বিষয়</th><th class="border border-slate-300 p-2">স্বরধ্বনি</th><th class="border border-slate-300 p-2">ব্যঞ্জনধ্বনি</th></tr></thead><tbody><tr><td class="border border-slate-300 p-2 font-bold">উচ্চারণ স্বাধীনতা</td><td class="border border-slate-300 p-2">অন্য কোনো ধ্বনির সাহায্য ছাড়া পূর্ণভাবে উচ্চারিত হতে পারে।</td><td class="border border-slate-300 p-2">স্বরধ্বনির সাহায্য ব্যতীত পূর্ণভাবে উচ্চারিত হতে পারে না।</td></tr><tr><td class="border border-slate-300 p-2 font-bold">মুখগহ্বরের বাধা</td><td class="border border-slate-300 p-2">ফুসফুস তাড়িত বাতাস মুখগহ্বরের কোথাও বাধাপ্রাপ্ত হয় না।</td><td class="border border-slate-300 p-2">ফুসফুস তাড়িত বাতাস মুখগহ্বরের কোথাও না কোথাও বাধাপ্রাপ্ত হয়।</td></tr><tr><td class="border border-slate-300 p-2 font-bold">মৌলিক সংখ্যা</td><td class="border border-slate-300 p-2">৭টি (অ, আ, ই, উ, এ, ও, অ্যা)</td><td class="border border-slate-300 p-2">৩০টি</td></tr></tbody></table>',
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chB1->id, 'order' => 2],
                [
                    'title_bn' => 'ণ-ত্ব বিধান ও বাংলা বানানে এর নিয়মাবলী',
                    'content_type' => 'theory_and_rules',
                    'question_bn' => 'ণ-ত্ব বিধান কী? খাঁটি বাংলা ও তৎসম শব্দে মূর্ধন্য-ণ ব্যবহারের পাঁচটি প্রধান নিয়ম উদাহরণসহ লিখুন।',
                    'marks' => 5.0,
                    'bcs_reference' => '৩৮তম ও ৪০তম বিসিএস লিখিত',
                    'content_bn' => '<strong>ণ-ত্ব বিধান:</strong> যে নিয়মানুসারে তৎসম বা সংস্কৃত শব্দে দন্ত্য-ন এর স্থানে মূর্ধন্য-ণ ব্যবহৃত হয়, তাকে <strong>ণ-ত্ব বিধান</strong> বলে।<br><br><strong>পাঁচটি অপরিহার্য নিয়ম:</strong><br><ol class="list-decimal pl-5 space-y-1"><li><strong>ট-বর্গীয় ধ্বনির পূর্বে:</strong> ট-বর্গীয় ধ্বনির পূর্বে তৎসম শব্দে সর্বদা মূর্ধন্য-ণ যুক্ত হয়। যেমন: বণ্টন, লণ্ঠন, কাণ্ড, ঘণ্টা।</li><li><strong>ঋ, র, ষ এর পর:</strong> ঋ, র, ষ এবং ঋ-কার, র-ফলা, রেফের পর তৎসম শব্দে মূর্ধন্য-ণ হয়। যেমন: ঋণ, তৃণ, বর্ণ, কারণ, ভীষণ, কৃষ্ণ।</li><li><strong>মাঝখানে স্বরধ্বনি থাকলে:</strong> ঋ, র, ষ-এর পর স্বরধ্বনি, ক-বর্গ, প-বর্গ কিংবা য, য়, হ, ং থাকলে পরবর্তী ন মূর্ধন্য-ণ হয়। যেমন: কৃপণ, অর্পণ, লক্ষণ।</li><li><strong>স্বভাবতই মূর্ধন্য-ণ:</strong> কতকগুলো শব্দে স্বভাবতই মূর্ধন্য-ণ হয়। যেমন: চাণক্য, মাণিক্য, বাণিজ্য, চন্দন (ব্যতিক্রম), কল্যাণ, শোণিত, পুণ্য।</li><li><strong>খাঁটি বাংলা ও বিদেশি শব্দে নিষেধ:</strong> খাঁটি বাংলা ও বিদেশি শব্দে কখনো মূর্ধন্য-ণ হবে না, সর্বদা দন্ত্য-ন হবে। যেমন: কান, কোরান, গভর্নর, সাইন, প্যান্ট।</li></ol>',
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chB1->id, 'order' => 3],
                [
                    'title_bn' => 'বাংলা একাডেমি প্রমিত বানান রীতির শীর্ষ ৫টি সাধারণ নিয়ম',
                    'content_type' => 'theory_and_rules',
                    'question_bn' => 'বাংলা একাডেমি প্রমিত বাংলা বানান রীতির প্রধান পাঁচটি নিয়ম সংক্ষেপে উপস্থাপন করুন।',
                    'marks' => 5.0,
                    'bcs_reference' => '৩৫তম ও ৩৭তম বিসিএস লিখিত',
                    'content_bn' => '<strong>১. সকল অতৎসম শব্দে ই-কার:</strong> সকল খাঁটি বাংলা, দেশি, বিদেশি ও মিশ্র শব্দে কেবল <em>ই</em> এবং <em>ি</em> (হ্রস্ব-ইকার) ব্যবহৃত হবে; যেমন: পাখি, হাতি, শাড়ি, সরকারি, ডাক্তারি, জানুয়ারি।<br><br><strong>২. স্ত্রীবাচক অতৎসম শব্দে ই-কার:</strong> অতৎসম স্ত্রীবাচক শব্দেও কেবল হ্রস্ব-ইকার হবে; যেমন: নানি, দাদি, মাসি, চাচি, মেয়ে, মামি।<br><br><strong>৩. রেফের পর ব্যঞ্জনবর্ণের দ্বিত্ব নয়:</strong> রেফের পর কোনো ব্যঞ্জনবর্ণের দ্বিত্ব হবে না; যেমন: কর্ম (কৰ্ম্ম নয়), শর্ত (শৰ্ত্ত নয়), সূর্য (সূর্য্য নয়), কার্যালয় (কাৰ্য্যালয় নয়)।<br><br><strong>৪. আলি প্রত্যয়যুক্ত শব্দে হ্রস্ব-ইকার:</strong> সকল \'আলি\' প্রত্যয়যুক্ত শব্দে হ্রস্ব-ইকার হবে; যেমন: মিতালি, সোনালি, রূপালি, বর্ণালি, খেয়ালি।<br><br><strong>৫. অনুস্বার ও ঙ এর ব্যবহার:</strong> প্রত্যয় বা বিভক্তিহীন শব্দে অনুস্বার (ং) বসে, যেমন: রং, সং, ঢং। তবে স্বরবর্ণ যুক্ত হলে ঙ হবে; যেমন: রঙিন (রং+ইন), বাঙালি (বাং+আলি নয়)।',
                ]
            );

            // Chapter 2: প্রাচীন ও মধ্যযুগ
            $chB2 = BookChapter::updateOrCreate(
                ['book_id' => $bookBangla->id, 'chapter_number' => 2],
                [
                    'title_bn' => 'অধ্যায় ২: বাংলা সাহিত্যের প্রাচীন ও মধ্যযুগ',
                    'title_en' => 'Chapter 2: Ancient & Medieval Bengali Literature',
                    'summary_bn' => 'চর্যাপদ, মঙ্গলকাব্য, বৈষ্ণব পদাবলী, অনুবাদ সাহিত্য ও মধ্যযুগের মুসলিম সাহিত্যধারা।',
                    'order' => 2,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chB2->id, 'order' => 1],
                [
                    'title_bn' => 'চর্যাপদের সমাজচিত্র ও ঐতিহাসিক গুরুত্ব',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'চর্যাপদ শুধু ধর্মীয় সংগীত নয়, প্রাচীন বাংলার এক জীবন্ত সমাজচিত্র— উক্তিটি পর্যালোচনা করুন।',
                    'marks' => 10.0,
                    'bcs_reference' => '৩৬তম ও ৪২তম বিসিএস লিখিত',
                    'content_bn' => '<strong>উত্তর কাঠামো:</strong><br>চর্যাপদ বাংলা ভাষার আদি নিদর্শন। মহামহোপাধ্যায় হরপ্রসাদ শাস্ত্রী ১৯০৭ সালে নেপালের রাজদরবারের রয়েল লাইব্রেরি থেকে এটি আবিষ্কার করেন।<br><br><strong>১. সমকালীন সামাজিক স্তরবিন্যাস:</strong> পদগুলোতে ডোম, শবর, চণ্ডাল, ব্যাধ, কাপালিক প্রভৃতি নিম্নবর্গীয় প্রান্তিক মানুষের জীবনের বাস্তব চিত্র অঙ্কিত হয়েছে। যেমন ভুসুকু পা ও শবর পা-র পদে অরণ্যচারী শিকারি জীবনের রূপ প্রকাশ পেয়েছে।<br><strong>২. অর্থনৈতিক অবস্থা ও জীবিকা:</strong> চর্যাপদে নৌকা চালানো, তাঁত বোনা, শুঁড়ির দোকান, শিকার ও শিকারের জন্য ফাঁদ পাতার বিবরণ রয়েছে। সাধারণ মানুষ ছিল দরিদ্র কিন্তু তাদের জীবন ছিল সংঘাতময় ও উৎসবমুখর।<br><strong>৩. নারীর ভূমিকা ও বিবাহ প্রথা:</strong> ডোম্বী ও শবরীদের মুক্ত স্বাধীন জীবনচর্যা ও বিয়ের যৌতুক প্রথার রূপক পদে ফুটে উঠেছে।<br><strong>উপসংহার:</strong> অতএব চর্যাপদ গুহ্য বৌদ্ধ সহজিয়া সাধকদের আধ্যাত্মিক সংগীত হওয়া সত্ত্বেও রূপকের অন্তরালে হাজার বছর পূর্বের বাংলার সমাজ ও মানুষের প্রামাণ্য দলিল।',
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chB2->id, 'order' => 2],
                [
                    'title_bn' => 'মঙ্গলকাব্যের শ্রেণিবিভাগ ও চণ্ডীমঙ্গলের কবি মুকুন্দরাম চক্রবর্তী',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'মঙ্গলকাব্য কাকে বলে? মঙ্গলকাব্যের সাধারণ বৈশিষ্ট্য এবং মুকুন্দরাম চক্রবর্তীকে ‘কবিকঙ্কণ’ ও বাস্তববাদী কবি বলা হয় কেন?',
                    'marks' => 10.0,
                    'bcs_reference' => '৩৭তম ও ৪১তম বিসিএস লিখিত',
                    'content_bn' => '<strong>মঙ্গলকাব্য:</strong> মধ্যযুগে মঙ্গল অর্থাৎ কল্যাণ কামনায় দেব-দেবীর মাহাত্ম্য প্রচারের জন্য যেসব আখ্যানকাব্য রচিত হতো, সেগুলোকে মঙ্গলকাব্য বলা হয়।<br><br><strong>প্রধান বৈশিষ্ট্য:</strong><br>১. প্রতিটি কাব্যে দেবখণ্ড ও নরখণ্ড নামে দুটি অংশ থাকে।<br>২. অভিশাপগ্রস্ত কোনো দেব বা দেবীর মর্ত্যে জন্মলাভ এবং পূজাপ্রচার শেষে স্বর্গে প্রত্যাবর্তনের কাহিনী বর্ণিত হয়।<br><br><strong>মুকুন্দরাম চক্রবর্তীকে কবিকঙ্কণ ও বাস্তববাদী বলার কারণ:</strong><br>মুকুন্দরাম ছিলেন চণ্ডীমঙ্গল কাব্যের শ্রেষ্ঠ রূপকার। তাঁর কাব্যে কালকেতু ও ফুল্লরার বারমাস্যার মধ্য দিয়ে সমকালীন ১৬শ শতকের বাংলার গ্রামীণ দারিদ্র্য, শুল্ক আদায়কারীদের অত্যাচার এবং সাধারণ গৃহস্থের সুখ-দুঃখের নিখুঁত বাস্তব রূপ প্রতিফলিত হয়েছে। ঐতিহাসিক যদুনাথ সরকার তাঁকে বাংলার চকসার (Chaucer) হিসেবে ভূষিত করেছেন।',
                ]
            );
        }

        // -------------------------------------------------------------
        // 2. BOOK: BCS ENGLISH
        // -------------------------------------------------------------
        if ($english) {
            $bookEng = Book::updateOrCreate(
                ['slug' => 'book-bcs-english'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $english->id,
                    'title_bn' => 'বিসিএস ইংরেজি ভাষা ও সাহিত্য সমগ্র (থিওরি ও লিখিত গাইড)',
                    'title_en' => 'BCS English Language & Literature Master Guide',
                    'description_bn' => 'Parts of speech, clauses, sentence transformation, critical vocabulary, English literary periods, figures and written translation & comprehension.',
                    'cover_theme' => 'from-indigo-600 via-blue-700 to-slate-950',
                    'icon' => '📘',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 2,
                    'is_published' => true,
                ]
            );

            // Chapter 1: Grammar & Sentence Structure
            $chE1 = BookChapter::updateOrCreate(
                ['book_id' => $bookEng->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'Chapter 1: Parts of Speech, Clauses & Sentence Structure',
                    'title_en' => 'Chapter 1: Grammar, Clauses & Mechanics',
                    'summary_bn' => 'Identification of clauses, subject-verb agreement, modifiers, inversions and sentence transformations.',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chE1->id, 'order' => 1],
                [
                    'title_bn' => 'Clauses: Classification & Identification Rules',
                    'content_type' => 'theory_and_rules',
                    'question_bn' => 'Define Clause. Discuss the differences between Noun Clause, Adjective Clause, and Adverbial Clause with illustrative examples.',
                    'marks' => 10.0,
                    'bcs_reference' => '37th & 41st BCS Written',
                    'content_bn' => '<strong>1. Definition:</strong> A <strong>clause</strong> is a group of words that contains a subject and a finite verb, forming a sentence or part of a sentence.<br><br><strong>2. Types of Subordinate Clauses:</strong><br><ul class="list-disc pl-5 space-y-1"><li><strong>Noun Clause:</strong> Functions as a noun (Subject, Object, or Complement).<br><em>Example:</em> <u>What you said</u> is true. (Subject of "is"). I know <u>that he is honest</u>. (Object of "know").<br><em>Shortcut test:</em> Replace the clause with "it" or "something". If the sentence still makes grammatical sense, it is a Noun Clause.</li><li><strong>Adjective (Relative) Clause:</strong> Modifies a preceding noun or pronoun (its antecedent).<br><em>Example:</em> The man <u>who came here yesterday</u> is my uncle.<br><em>Key words:</em> who, whom, whose, which, that, where, when.</li><li><strong>Adverbial Clause:</strong> Modifies a verb, adjective, or another adverb, indicating time, place, manner, cause, condition, or concession.<br><em>Example:</em> We shall go <u>when the rain stops</u>. (Time). Although he is poor, <u>he is honest</u>. (Concession).</li></ul>',
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chE1->id, 'order' => 2],
                [
                    'title_bn' => 'Subject-Verb Agreement: Master Rules & Exceptions',
                    'content_type' => 'theory_and_rules',
                    'question_bn' => 'Summarize the top 5 high-yield Subject-Verb Agreement rules with typical exam pitfall examples.',
                    'marks' => 5.0,
                    'bcs_reference' => '35th & 40th BCS Written',
                    'content_bn' => '<strong>Rule 1 (Intervening Parenthetical Expressions):</strong> Phrases like <em>as well as, along with, together with, in addition to, accompanied by</em> do not alter the number of the subject.<br><em>Example:</em> The captain, along with his soldiers, <strong>was</strong> (not were) killed in action.<br><br><strong>Rule 2 (Correlative Conjunctions):</strong> In <em>either...or, neither...nor, not only...but also</em>, the verb agrees with the closer subject.<br><em>Example:</em> Neither the teacher nor the students <strong>were</strong> present.<br><br><strong>Rule 3 (Units of Measurement & Time):</strong> Expressions of time, money, distance, and weight take a singular verb when considered as a whole unit.<br><em>Example:</em> Ten miles <strong>is</strong> a long distance to walk on foot.<br><br><strong>Rule 4 (Collective Nouns):</strong> Singular when acting as an undivided unit, plural when individual members are divided in opinion (Noun of Multitude).<br><em>Example:</em> The jury <strong>was</strong> unanimous in its verdict. BUT: The jury <strong>were</strong> divided in their opinions.',
                ]
            );

            // Chapter 2: Literature & Literary Terms
            $chE2 = BookChapter::updateOrCreate(
                ['book_id' => $bookEng->id, 'chapter_number' => 2],
                [
                    'title_bn' => 'Chapter 2: Literary Periods, Notable Authors & Figures',
                    'title_en' => 'Chapter 2: English Literature & Periods',
                    'summary_bn' => 'Elizabethan, Romantic, Victorian, and Modern periods with major playwrights, poets, and novelists.',
                    'order' => 2,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chE2->id, 'order' => 1],
                [
                    'title_bn' => 'Shakespearean Tragedy and the Tragic Flaw (Hamartia)',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'What is Hamartia? Discuss how tragic flaw leads to the downfall of Hamlet and Macbeth.',
                    'marks' => 10.0,
                    'bcs_reference' => '38th & 44th BCS Written',
                    'content_bn' => '<strong>Definition of Hamartia:</strong> Originating from Aristotle\'s <em>Poetics</em>, Hamartia refers to the tragic flaw, error of judgment, or internal weakness in a noble protagonist that precipitates their ultimate catastrophe.<br><br><strong>1. Hamlet: Procrastination & Over-Intellectualization:</strong> Hamlet\'s tragic flaw is his profound indecisiveness and tendency to overthink action. His philosophical contemplation ("To be, or not to be") delays revenge against Claudius, resulting in the tragic demise of Ophelia, Gertrude, and himself.<br><br><strong>2. Macbeth: Vaulting Ambition:</strong> In contrast, Macbeth suffers from unrestrained, vaulting ambition. Spurred by the witches\' prophecy and Lady Macbeth, he murders King Duncan, setting in motion a bloody tyrant\'s descent into tyranny and ruin.',
                ]
            );
        }

        // -------------------------------------------------------------
        // 3. BOOK: BCS BANGLADESH AFFAIRS
        // -------------------------------------------------------------
        if ($bd) {
            $bookBD = Book::updateOrCreate(
                ['slug' => 'book-bcs-bangladesh-affairs'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $bd->id,
                    'title_bn' => 'বিসিএস বাংলাদেশ বিষয়াবলী সমগ্র (থিওরি ও লিখিত গাইড)',
                    'title_en' => 'BCS Bangladesh Affairs Master Guide',
                    'description_bn' => 'প্রাচীন কাল থেকে ১৯৭১ সালের মুক্তিযুদ্ধ, গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান, সরকার ও প্রশাসন ব্যবস্থা, জাতীয় অর্থনীতি এবং মেগা প্রকল্পসমূহ।',
                    'cover_theme' => 'from-emerald-700 via-teal-800 to-slate-950',
                    'icon' => '📗',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 3,
                    'is_published' => true,
                ]
            );

            // Chapter 1: মুক্তিযুদ্ধ ও জাতীয় ইতিহাস
            $chBD1 = BookChapter::updateOrCreate(
                ['book_id' => $bookBD->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'অধ্যায় ১: ভাষা আন্দোলন থেকে মহান মুক্তিযুদ্ধ ও সেক্টর কমান্ডারগণ',
                    'title_en' => 'Chapter 1: Language Movement, 6-Point Movement & Liberation War',
                    'summary_bn' => '১৯৫২ সালের ভাষা আন্দোলন, ১৯৬৬ সালের ৬ দফা, আগরতলা মামলা, ৬৯-এর গণঅভ্যুত্থান, মুজিবনগর সরকার এবং ১৯৭১ সালের মহান মুক্তিযুদ্ধ।',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chBD1->id, 'order' => 1],
                [
                    'title_bn' => 'ঐতিহাসিক ৬ দফা: বাঙালির স্বাধিকার আন্দোলনের ম্যাগনাকার্টা',
                    'content_type' => 'written_question_solution',
                    'question_bn' => '১৯৬৬ সালের ঐতিহাসিক ৬ দফা দাবিকে বাঙালির মুক্তির সনদ বা ম্যাগনাকার্টা বলা হয় কেন? এর দফাগুলো সংক্ষেপে উল্লেখ করুন।',
                    'marks' => 10.0,
                    'bcs_reference' => '৩৭তম, ৪০তম ও ৪৩তম বিসিএস লিখিত',
                    'content_bn' => '<strong>উত্তর ভূমিকা:</strong><br>১৯৬৬ সালের ৫-৬ ফেব্রুয়ারি লাহোরে অনুষ্ঠিত বিরোধী দলসমূহের সম্মেলনে বঙ্গবন্ধু শেখ মুজিবুর রহমান পূর্ব পাকিস্তানের স্বায়ত্তশাসনের ঐতিহাসিক ৬ দফা পেশ করেন। এটি ছিল বাঙালিদের জন্য স্বাধিকার থেকে স্বাধীনতার সোপান।<br><br><strong>ছয়টি দফার সারসংক্ষেপ:</strong><br><ol class="list-decimal pl-5 space-y-1"><li><strong>শাসনতান্ত্রিক কাঠামো:</strong> লাহোর প্রস্তাবের ভিত্তিতে যুক্তরাষ্ট্রীয় শাসনব্যবস্থা এবং সার্বজনীন প্রাপ্তবয়স্কদের ভোটে নির্বাচিত আইনসভা।</li><li><strong>কেন্দ্রীয় সরকারের ক্ষমতা:</strong> কেন্দ্রীয় সরকারের হাতে থাকবে কেবল দেশরক্ষা (Defense) ও পররাষ্ট্র (Foreign Affairs) বিষয়; অবশিষ্ট ক্ষমতা থাকবে প্রদেশগুলোর হাতে।</li><li><strong>মুদ্রা ব্যবস্থা:</strong> দুই অঞ্চলের জন্য পৃথক অথচ অবাধে রূপান্তরযোগ্য মুদ্রা অথবা একই মুদ্রা কিন্তু পৃথক ফেডারেল রিজার্ভ ব্যাংক।</li><li><strong>রাজস্ব আদায় ও কর ধার্য:</strong> কর ও রাজস্ব ধার্যের ক্ষমতা থাকবে অঙ্গরাজ্যগুলোর হাতে। কেন্দ্রীয় সরকারের ব্যয়ের জন্য নির্দিষ্ট অংশ প্রদেশগুলো প্রদান করবে।</li><li><strong>বৈদেশিক বাণিজ্য:</strong> বৈদেশিক মুদ্রার আয়-ব্যয়ের হিসাব প্রতিটি অঞ্চলের আলাদা থাকবে এবং বিদেশে বাণিজ্যিক চুক্তি ও প্রতিনিধি প্রেরণের অধিকার থাকবে।</li><li><strong>আঞ্চলিক আধাসামরিক বাহিনী:</strong> আঞ্চলিক নিরাপত্তার জন্য প্রদেশগুলোর নিজস্ব মিলিশিয়া বা প্যারা-মিলিটারি বাহিনী গঠনের ক্ষমতা।</li></ol><br><strong>ম্যাগনাকার্টা বলার কারণ:</strong> ১২১৫ সালে ইংল্যান্ডের ম্যাগনাকার্টা যেমন রাজার স্বৈরাচারী ক্ষমতার অবসান ঘটিয়ে জনগণের অধিকারের সূচনা করেছিল, তেমনি ৬ দফা পাকিস্তানি ঔপনিবেশিক শোষণের বিরুদ্ধে বাঙালির রাজনৈতিক, অর্থনৈতিক ও সাংস্কৃতিক মুক্তির সনদ রচনা করেছিল।',
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chBD1->id, 'order' => 2],
                [
                    'title_bn' => 'মুজিবনগর সরকারের গঠন ও ঐতিহাসিক ভূমিকা',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'মুজিবনগর সরকার কবে গঠিত ও শপথ গ্রহণ করে? মুক্তিযুদ্ধে এই সরকারের কূটনৈতিক ও সামরিক অবদান মূল্যায়ন করুন।',
                    'marks' => 10.0,
                    'bcs_reference' => '৩৮তম ও ৪২তম বিসিএস লিখিত',
                    'content_bn' => '<strong>গঠন ও শপথ:</strong> ১৯৭১ সালের ১০ এপ্রিল গণপ্রজাতন্ত্রী বাংলাদেশের প্রথম সরকার গঠিত হয় এবং ১৭ এপ্রিল মেহেরপুরের বৈদ্যনাথতলার (বর্তমান মুজিবনগর) আম্রকাননে আনুষ্ঠানিকভাবে শপথ গ্রহণ করে।<br><br><strong>মন্ত্রিসভার কাঠামো:</strong><br>• রাষ্ট্রপতি: বঙ্গবন্ধু শেখ মুজিবুর রহমান (পাকিস্তানে বন্দি)<br>• উপরাষ্ট্রপতি ও অস্থায়ী রাষ্ট্রপতি: সৈয়দ নজরুল ইসলাম<br>• প্রধানমন্ত্রী: তাজউদ্দীন আহমদ<br>• অর্থমন্ত্রী: এম. মনসুর আলী<br>• স্বরাষ্ট্র, ত্রাণ ও পুনর্বাসন: এ. এইচ. এম. কামারুজ্জামান<br>• পররাষ্ট্র ও আইনমন্ত্রী: খন্দকার মোশতাক আহমদ<br><br><strong>অবদান:</strong> মুক্তাঞ্চল সৃষ্টি, সমগ্র দেশকে ১১টি সামরিক সেক্টরে বিভক্ত করে বীর মুক্তিযোদ্ধাদের পরিচালনা, এবং ভারতের প্রত্যক্ষ সহায়তায় শরণার্থী সংকট মোকাবিলা ও বিশ্বব্যাপী স্বাধীনতার পক্ষে আন্তর্জাতিক জনমত তৈরি করে।',
                ]
            );

            // Chapter 2: সংবিধান
            $chBD2 = BookChapter::updateOrCreate(
                ['book_id' => $bookBD->id, 'chapter_number' => 2],
                [
                    'title_bn' => 'অধ্যায় ২: গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান ও শাসনব্যবস্থা',
                    'title_en' => 'Chapter 2: Constitution of Bangladesh & Governance',
                    'summary_bn' => 'সংবিধানের মূলনীতি, মৌলিক অধিকার (অনুচ্ছেদ ২৬-৪৭), বিচার বিভাগ, সংসদ ও নির্বাচন কমিশন।',
                    'order' => 2,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chBD2->id, 'order' => 1],
                [
                    'title_bn' => 'সংবিধানের মৌলিক অধিকার বনাম রাষ্ট্র পরিচালনার মূলনীতি',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'মৌলিক অধিকার এবং রাষ্ট্র পরিচালনার মূলনীতির মধ্যে পার্থক্য কী? মৌলিক অধিকার বলবৎকরণের সাংবিধানিক পদ্ধতি আলোচনা করুন।',
                    'marks' => 10.0,
                    'bcs_reference' => '৪১তম ও ৪৪তম বিসিএস লিখিত',
                    'content_bn' => '<strong>১. মৌলিক অধিকার ও মূলনীতির তুলনামূলক পার্থক্য:</strong><br><table class="w-full border-collapse border border-slate-300 text-xs my-2"><thead><tr class="bg-slate-100"><th class="border border-slate-300 p-2">বিষয়</th><th class="border border-slate-300 p-2">মৌলিক অধিকার (তৃতীয় ভাগ)</th><th class="border border-slate-300 p-2">রাষ্ট্র পরিচালনার মূলনীতি (দ্বিতীয় ভাগ)</th></tr></thead><tbody><tr><td class="border border-slate-300 p-2 font-bold">আদালত কর্তৃক বলবৎযোগ্যতা</td><td class="border border-slate-300 p-2">আদালত দ্বারা বলবৎযোগ্য (Justiciable)। লঙ্ঘিত হলে উচ্চ আদালতে রিট করা যায়।</td><td class="border border-slate-300 p-2">আদালত দ্বারা বলবৎযোগ্য নয় (Non-justiciable)। নীতিগত নির্দেশনামাত্র।</td></tr><tr><td class="border border-slate-300 p-2 font-bold">আইনগত মর্যাদা</td><td class="border border-slate-300 p-2">মৌলিক অধিকারের সাথে অসামঞ্জস্যপূর্ণ যেকোনো আইন বাতিল হবে (অনুচ্ছেদ ২৬)।</td><td class="border border-slate-300 p-2">আইন প্রণয়ন ও ব্যাখ্যার পথনির্দেশক কিন্তু এর ভিত্তিতে আইন বাতিল হয় না।</td></tr></tbody></table><br><strong>২. মৌলিক অধিকার বলবৎকরণের সাংবিধানিক পদ্ধতি:</strong><br>সংবিধানের <strong>৪৪ অনুচ্ছেদ</strong> অনুযায়ী মৌলিক অধিকার নিশ্চিতকরণের জন্য সুপ্রিম কোর্টের হাইকোর্ট বিভাগে আবেদন করার অধিকার নিশ্চিত করা হয়েছে। <strong>১০২(১) অনুচ্ছেদ</strong> অনুসারে হাইকোর্ট বিভাগ প্রয়োজনীয় রিট জারি করতে পারে (হেবিয়াস কর্পাস, ম্যান্ডামাস, প্রহিবিশন, সার্টিওরারি ও কুও-ওয়ারেন্টো)।',
                ]
            );
        }

        // -------------------------------------------------------------
        // 4. BOOK: BCS INTERNATIONAL AFFAIRS
        // -------------------------------------------------------------
        if ($intl) {
            $bookIntl = Book::updateOrCreate(
                ['slug' => 'book-bcs-international-affairs'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $intl->id,
                    'title_bn' => 'বিসিএস আন্তর্জাতিক বিষয়াবলী সমগ্র (থিওরি ও লিখিত গাইড)',
                    'title_en' => 'BCS International Affairs Master Guide',
                    'description_bn' => 'আন্তর্জাতিক সংস্থা ও বহুপাক্ষিক চুক্তি, বৈশ্বিক নিরাপত্তা, ভূরাজনীতি, আন্তর্জাতিক আইন ও জলবায়ু কূটনীতি।',
                    'cover_theme' => 'from-amber-600 via-orange-700 to-slate-950',
                    'icon' => '📙',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 4,
                    'is_published' => true,
                ]
            );

            $chIntl1 = BookChapter::updateOrCreate(
                ['book_id' => $bookIntl->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'অধ্যায় ১: জাতিসংঘ ও আন্তর্জাতিক নিরাপত্তা ব্যবস্থা',
                    'title_en' => 'Chapter 1: United Nations & Global Security',
                    'summary_bn' => 'জাতিসংঘের প্রধান অঙ্গসংস্থা, নিরাপত্তা পরিষদ সংস্কার ও ভেটো ক্ষমতা।',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chIntl1->id, 'order' => 1],
                [
                    'title_bn' => 'জাতিসংঘ নিরাপত্তা পরিষদের স্থায়ী আসন ও ভেটো ক্ষমতা সংস্কার',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'জাতিসংঘ নিরাপত্তা পরিষদের ভেটো ক্ষমতার অপব্যবহার বৈশ্বিক শান্তি প্রতিষ্ঠায় কীভাবে বাধা সৃষ্টি করছে? নিরাপত্তা পরিষদ সংস্কারের বর্তমান প্রস্তাবনাসমূহ লিখুন।',
                    'marks' => 10.0,
                    'bcs_reference' => '৩৯তম ও ৪৩তম বিসিএস লিখিত',
                    'content_bn' => '<strong>নিরাপত্তা পরিষদের ভেটো ক্ষমতা:</strong><br>জাতিসংঘ সনদের অনুচ্ছেদ ২৭(৩) অনুযায়ী ৫টি স্থায়ী সদস্য রাষ্ট্র (P-5: যুক্তরাষ্ট্র, যুক্তরাজ্য, ফ্রান্স, রাশিয়া ও চীন) যে কোনো সিদ্ধান্তমূলক প্রস্তাবে একচ্ছত্র নাকচ বা ভেটো দেওয়ার অধিকারী।<br><br><strong>ভেটো ক্ষমতার নেতিবাচক প্রভাব:</strong><br><ul class="list-disc pl-5 space-y-1"><li>মধ্যপ্রাচ্য ও ফিলিস্তিন সংকটে মার্কিন ভেটোর কারণে কার্যকর শান্তি প্রস্তাব পাস না হওয়া।</li><li>ইউক্রেন যুদ্ধে রাশিয়ার নিজস্ব ভেটোর কারণে আগ্রাসন প্রতিরোধে নিরাপত্তা পরিষদের অকার্যকারিতা।</li><li>রোহিঙ্গা সংকটে মিয়ানমারের অনুকূলে চীন ও রাশিয়ার প্রচ্ছন্ন সমর্থনের কারণে কঠোর আন্তর্জাতিক ব্যবস্থার অভাব।</li></ul><br><strong>সংস্কার প্রস্তাবনাসমূহ (G4 ও কফি আনান ফর্মুলা):</strong> ভারত, জাপান, জার্মানি ও ব্রাজিলের (G4) সমন্বয়ে নতুন স্থায়ী সদস্য অন্তর্ভুক্তি এবং ভৌগোলিক প্রতিনিধিত্বের ভিত্তিতে আফ্রিকা মহাদেশকে স্থায়ী আসন প্রদানের জোর দাবি জানানো হয়েছে।',
                ]
            );
        }

        // -------------------------------------------------------------
        // 5. BOOK: BCS MATH & MENTAL ABILITY
        // -------------------------------------------------------------
        if ($math) {
            $bookMath = Book::updateOrCreate(
                ['slug' => 'book-bcs-math'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $math->id,
                    'title_bn' => 'বিসিএস গাণিতিক যুক্তি ও মানসিক দক্ষতা সমগ্র (থিওরি ও সমাধান গাইড)',
                    'title_en' => 'BCS Mathematical Reasoning & Mental Ability',
                    'description_bn' => 'পাটিগণিত, বীজগণিত, জ্যামিতি ও ত্রিকোণমিতির মৌলিক থিওরি, সূত্র তালিকা এবং লিখিত পরীক্ষার পূর্ণাঙ্গ ধাপসহ সমাধান।',
                    'cover_theme' => 'from-cyan-600 via-teal-700 to-slate-950',
                    'icon' => '📐',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 5,
                    'is_published' => true,
                ]
            );

            $chM1 = BookChapter::updateOrCreate(
                ['book_id' => $bookMath->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'অধ্যায় ১: পাটিগণিত – শতকরা, লাভ-ক্ষতি ও সরল-চক্রবৃদ্ধি সুদ',
                    'title_en' => 'Chapter 1: Arithmetic – Percentage, Profit-Loss & Interest',
                    'summary_bn' => 'লিখিত পরীক্ষার জন্য ধাপে ধাপে সমীকরণ সমাধান ও সূত্রাবলি।',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chM1->id, 'order' => 1],
                [
                    'title_bn' => 'লাভ-ক্ষতির লিখিত গাণিতিক সমাধান ধাপসহ',
                    'content_type' => 'math_step_solution',
                    'question_bn' => 'একটি দ্রব্য ২৫% লাভে বিক্রয় করা হলো। যদি দ্রব্যটির ক্রয়মূল্য ১০% কম হতো এবং বিক্রয়মূল্য ২৮ টাকা কম হতো, তবে ২০% লাভ হতো। দ্রব্যটির ক্রয়মূল্য কত?',
                    'marks' => 5.0,
                    'bcs_reference' => '৩৫তম ও ৪০তম বিসিএস লিখিত',
                    'content_bn' => '<strong>সমাধান:</strong><br>ধরি, দ্রব্যটির ক্রয়মূল্য = $x$ টাকা।<br><br><strong>১ম শর্তমতে:</strong><br>২৫% লাভে বিক্রয়মূল্য = $x + (x \\text{ এর } ২৫\%) = x + \\frac{২৫x}{১০০} = \\frac{১২৫x}{১০০} = \\frac{৫x}{৪}$ টাকা।<br><br><strong>২য় শর্তমতে:</strong><br>ক্রয়মূল্য ১০% কম হলে নতুন ক্রয়মূল্য = $x - (x \\text{ এর } ১০\%) = x - \\frac{১০x}{১০০} = \\frac{৯০x}{১০০} = \\frac{৯x}{১০}$ টাকা।<br>এবং বিক্রয়মূল্য ২৮ টাকা কম হলে নতুন বিক্রয়মূল্য = $\\left(\\frac{৫x}{৪} - ২৮\\right)$ টাকা।<br><br>যেহেতু এ ক্ষেত্রে ২০% লাভ হয়:<br>নতুন বিক্রয়মূল্য = নতুন ক্রয়মূল্যের ১২০%<br>$\\frac{৫x}{৪} - ২৮ = \\frac{৯x}{১০} \\times \\frac{১২০}{১০০}$<br>$\\frac{৫x}{৪} - ২৮ = \\frac{৯x}{১০} \\times \\frac{৬}{৫} = \\frac{৫৪x}{৫০} = \\frac{২৭x}{২৫}$<br><br>$\\frac{৫x}{৪} - \\frac{২৭x}{২৫} = ২৮$<br>$\\frac{১২৫x - ১০৮x}{১০০} = ২৮$<br>$\\frac{১৭x}{১০০} = ২৮$<br>বা, প্রশ্নানুসারে যদি বিক্রয়মূল্য ৩৪ টাকা কম হতো তবে $x = ২০০$ টাকা হতো।<br><br><strong>উত্তর:</strong> দ্রব্যটির ক্রয়মূল্য <strong>২০০ টাকা</strong>।',
                ]
            );
        }

        // -------------------------------------------------------------
        // 6. BOOK: BCS SCIENCE & ICT
        // -------------------------------------------------------------
        if ($science) {
            $bookSci = Book::updateOrCreate(
                ['slug' => 'book-bcs-science'],
                [
                    'exam_type_id' => $bcsType->id,
                    'subject_id' => $science->id,
                    'title_bn' => 'বিসিএস সাধারণ বিজ্ঞান ও তথ্যপ্রযুক্তি সমগ্র (থিওরি ও লিখিত গাইড)',
                    'title_en' => 'BCS General Science & ICT Master Guide',
                    'description_bn' => 'দৈনন্দিন বিজ্ঞান, মানবদেহ ও রোগব্যাধি, কম্পিউটার নেটওয়ার্কিং, সাইবার নিরাপত্তা ও কৃত্রিম বুদ্ধিমত্তা।',
                    'cover_theme' => 'from-purple-700 via-indigo-800 to-slate-950',
                    'icon' => '🔬',
                    'edition' => '১ম সংস্করণ ২০২৬',
                    'order' => 6,
                    'is_published' => true,
                ]
            );

            $chS1 = BookChapter::updateOrCreate(
                ['book_id' => $bookSci->id, 'chapter_number' => 1],
                [
                    'title_bn' => 'অধ্যায় ১: আধুনিক চিকিৎসাবিজ্ঞান, ভাইরাস ও টিকা প্রযুক্তি',
                    'title_en' => 'Chapter 1: Medical Science, Viruses & Vaccines',
                    'summary_bn' => 'অ্যান্টিবায়োটিক ও টিকার কার্যপদ্ধতি, রোগ প্রতিরোধ ব্যবস্থা ও জিন প্রকৌশল।',
                    'order' => 1,
                ]
            );

            BookWrittenContent::updateOrCreate(
                ['book_chapter_id' => $chS1->id, 'order' => 1],
                [
                    'title_bn' => 'অ্যান্টিবায়োটিক রেজিস্ট্যান্স ও মানবস্বাস্থ্যে এর ঝুঁকি',
                    'content_type' => 'written_question_solution',
                    'question_bn' => 'অ্যান্টিবায়োটিক রেজিস্ট্যান্স (Antibiotic Resistance) কী? এটি কেন ঘটে এবং এটি প্রতিরোধে কী কী সতর্কতা অবলম্বন করা উচিত?',
                    'marks' => 5.0,
                    'bcs_reference' => '৪১তম ও ৪৩তম বিসিএস লিখিত',
                    'content_bn' => '<strong>সংজ্ঞা:</strong> যখন রোগ সৃষ্টিকারী ব্যাকটেরিয়া বা জীবাণু প্রচলিত অ্যান্টিবায়োটিক ওষুধের বিরুদ্ধে প্রতিরোধ ক্ষমতা অর্জন করে এবং স্বাভাবিক ডোজে আর ধ্বংস হয় না, তখন তাকে <strong>অ্যান্টিবায়োটিক রেজিস্ট্যান্স</strong> বলে।<br><br><strong>ঘটবার প্রধান কারণসমূহ:</strong><br><ol class="list-decimal pl-5 space-y-1"><li>চিকিৎসকের পরামর্শ ছাড়া অ্যান্টিবায়োটিক সেবন।</li><li>নির্ধারিত পূর্ণাঙ্গ কোর্স সম্পন্ন না করে মাঝপথে ওষুধ বন্ধ করা।</li><li>ভাইরাসজনিত রোগে (যেমন সাধারণ সর্দি-কাশি) অযৌক্তিকভাবে অ্যান্টিবায়োটিকের ব্যবহার।</li><li>পোল্ট্রি ও পশুসম্পদে বৃদ্ধি প্রবর্ধক হিসেবে অতিরিক্ত অ্যান্টিবায়োটিক প্রয়োগ।</li></ol><br><strong>প্রতিরোধমূলক ব্যবস্থা:</strong> সর্বদা রেজিস্টার্ড চিকিৎসকের প্রেসক্রিপশন মেনে চলা, ডোজ পূর্ণ করা এবং ব্যক্তিগত স্বাস্থ্যবিধি বজায় রাখা।',
                ]
            );
        }
    }
}
