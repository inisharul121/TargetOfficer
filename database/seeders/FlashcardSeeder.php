<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use Illuminate\Database\Seeder;

class FlashcardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            // Category 1: Constitution of Bangladesh
            [
                'category' => 'constitution',
                'category_bn' => 'সংবিধানের গুরুত্বপূর্ণ অনুচ্ছেদ',
                'front_bn' => 'বাংলাদেশ সংবিধানের কোন অনুচ্ছেদে "আইনের দৃষ্টিতে সমতা" নিশ্চিত করা হয়েছে?',
                'front_en' => 'Equality before law in Bangladesh Constitution',
                'back_bn' => '<strong>অনুচ্ছেদ ২৭:</strong> সকল নাগরিক আইনের দৃষ্টিতে সমান এবং আইনের সমান আশ্রয় লাভের অধিকারী।',
                'hint_bn' => 'মৌলিক অধিকার অধ্যায়ের প্রথম অনুচ্ছেদগুলোর একটি।',
                'source_tag' => '৩৮তম ও ৪১তম বিসিএস',
            ],
            [
                'category' => 'constitution',
                'category_bn' => 'সংবিধানের গুরুত্বপূর্ণ অনুচ্ছেদ',
                'front_bn' => 'সংবিধানের কত নম্বর অনুচ্ছেদে "চিন্তা ও বিবেকের স্বাধীনতা এবং বাক-স্বাধীনতা" নিশ্চিত করা হয়েছে?',
                'front_en' => 'Freedom of thought, conscience and speech',
                'back_bn' => '<strong>অনুচ্ছেদ ৩৯:</strong> ৩৯(১) চিন্তা ও বিবেকের স্বাধীনতা এবং ৩৯(২) বাক ও ভাব প্রকাশের স্বাধীনতা এবং সংবাদক্ষেত্রের স্বাধীনতা।',
                'hint_bn' => 'নাগরিকদের মৌলিক অধিকারের সবচেয়ে চর্চিত অনুচ্ছেদ।',
                'source_tag' => '৩৫তম ও ৪৩তম বিসিএস',
            ],
            [
                'category' => 'constitution',
                'category_bn' => 'সংবিধানের গুরুত্বপূর্ণ অনুচ্ছেদ',
                'front_bn' => 'কোন অনুচ্ছেদ অনুযায়ী মহামান্য রাষ্ট্রপতি যে কোনো ব্যক্তির দণ্ড মার্জনা, স্থগিত বা হ্রাস করতে পারেন?',
                'front_en' => 'Pardoning power of the President',
                'back_bn' => '<strong>অনুচ্ছেদ ৪৯:</strong> রাষ্ট্রপতির ক্ষমা প্রদর্শনের বিশেষ অধিকার (Pardoning Power)।',
                'hint_bn' => 'অধ্যায় ৪ (নির্বাহী বিভাগ), রাষ্ট্রপতির বিশেষ ক্ষমতা।',
                'source_tag' => '৪৪তম বিসিএস',
            ],
            [
                'category' => 'constitution',
                'category_bn' => 'সংবিধানের গুরুত্বপূর্ণ অনুচ্ছেদ',
                'front_bn' => 'সংসদ সদস্যদের পদত্যাগ ও ফ্লোর ক্রসিং সম্পর্কিত বিখ্যাত অনুচ্ছেদ কোনটি?',
                'front_en' => 'Vacation of seat on resignation or voting against party',
                'back_bn' => '<strong>অনুচ্ছেদ ৭০:</strong> রাজনৈতিক দল হতে পদত্যাগ বা দলের বিপক্ষে ভোটদান করলে সংশ্লিষ্ট সংসদ সদস্যের আসন শূন্য হবে।',
                'hint_bn' => 'বাংলাদেশের সংসদীয় ব্যবস্থার অত্যন্ত আলোচিত ধারা।',
                'source_tag' => '১০ম, ২৪তম ও ৪০তম বিসিএস',
            ],

            // Category 2: English Vocabulary
            [
                'category' => 'bcs_vocab',
                'category_bn' => 'ইংরেজি শব্দভাণ্ডার (Vocabulary)',
                'front_bn' => 'What is the meaning and synonym of "EPHEMERAL"?',
                'front_en' => 'Ephemeral - Meaning & Synonyms',
                'back_bn' => '<strong>অর্থ:</strong> ক্ষণস্থায়ী, স্বল্পকাল স্থায়ী।<br><strong>Synonyms:</strong> Transient, Fleeting, Short-lived, Evaneascent.<br><strong>Antonyms:</strong> Permanent, Eternal, Perennial.',
                'hint_bn' => 'Something that lasts for a very short time.',
                'source_tag' => '৪১তম বিসিএস ও বাংলাদেশ ব্যাংক AD',
            ],
            [
                'category' => 'bcs_vocab',
                'category_bn' => 'ইংরেজি শব্দভাণ্ডার (Vocabulary)',
                'front_bn' => 'What is the meaning and synonym of "ALTRUISTIC"?',
                'front_en' => 'Altruistic - Meaning & Synonyms',
                'back_bn' => '<strong>অর্থ:</strong> নিঃস্বার্থ, পরহিতৈষী, পরোপকারী।<br><strong>Synonyms:</strong> Philanthropic, Benevolent, Selfless, Charitable.<br><strong>Antonyms:</strong> Selfish, Egoistic.',
                'hint_bn' => 'Opposite of selfish.',
                'source_tag' => '৩৮তম বিসিএস',
            ],
            [
                'category' => 'bcs_vocab',
                'category_bn' => 'ইংরেজি শব্দভাণ্ডার (Vocabulary)',
                'front_bn' => 'What is the meaning and synonym of "UBIQUITOUS"?',
                'front_en' => 'Ubiquitous - Meaning & Synonyms',
                'back_bn' => '<strong>অর্থ:</strong> সর্বত্র বিদ্যমান, সর্বব্যাপী।<br><strong>Synonyms:</strong> Omnipresent, Pervasive, Universal.<br><strong>Antonyms:</strong> Rare, Scarce.',
                'hint_bn' => 'Present, appearing, or found everywhere.',
                'source_tag' => '৪৪তম বিসিএস ও সমন্বিত ৯ ব্যাংক',
            ],

            // Category 3: Bangladesh History & Liberation War
            [
                'category' => 'bangladesh_history',
                'category_bn' => 'বাংলাদেশ ও মুক্তিযুদ্ধ',
                'front_bn' => 'ঐতিহাসিক ৬ দফা দাবি বঙ্গবন্ধু শেখ মুজিবুর রহমান আনুষ্ঠানিকভাবে কবে এবং কোথায় ঘোষণা করেন?',
                'front_en' => 'Historical 6-Point Charter announcement',
                'back_bn' => '<strong>তারিখ ও স্থান:</strong> ১৯৬৬ সালের ৫-৬ ফেব্রুয়ারি লাহোরে অনুষ্ঠিত বিরোধী দলসমূহের জাতীয় সম্মেলনে। পরবর্তীতে ২৩ মার্চ লাহোরে আনুষ্ঠানিকভাবে ঘোষণা করা হয়।',
                'hint_bn' => 'বাঙালির মুক্তির সনদ ও মেঘনাকার্টা।',
                'source_tag' => '৩৭তম ও ৪২তম বিসিএস',
            ],
            [
                'category' => 'bangladesh_history',
                'category_bn' => 'বাংলাদেশ ও মুক্তিযুদ্ধ',
                'front_bn' => 'বাংলাদেশের প্রথম অস্থায়ী সরকার (মুজিবনগর সরকার) কবে শপথ গ্রহণ করে?',
                'front_en' => 'Swearing-in date of Mujibnagar Government',
                'back_bn' => '<strong>তারিখ:</strong> ১৯৭১ সালের ১৭ এপ্রিল মেহেরপুরের বৈদ্যনাথতলার ভবেরপাড়ায় (বর্তমান মুজিবনগর)। গঠন করা হয়েছিল ১০ এপ্রিল ১৯৭১।',
                'hint_bn' => '১০ এপ্রিল গঠন এবং ১৭ এপ্রিল শপথ।',
                'source_tag' => '১১তম, ৩৪তম ও ৪০তম বিসিএস',
            ],

            // Category 4: Math Formulas & Shortcuts
            [
                'category' => 'math_formula',
                'category_bn' => 'গণিত শর্টকাট সূত্র',
                'front_bn' => 'সমান্তর ধারার n-তম পদ এবং প্রথম n-সংখ্যক পদের সমষ্টির সূত্র কী?',
                'front_en' => 'Arithmetic Progression Formula',
                'back_bn' => '<strong>n-তম পদ:</strong> $a + (n-1)d$<br><strong>n-সংখ্যক পদের সমষ্টি (Sₙ):</strong> $\\frac{n}{2} [2a + (n-1)d]$<br>যেখানে, $a$ = প্রথম পদ, $d$ = সাধারণ অন্তর, $n$ = পদসংখ্যা।',
                'hint_bn' => 'বীজগণিতের অপরিহার্য সূত্র।',
                'source_tag' => '১০ম, ৩৫তম ও ৪৪তম বিসিএস',
            ],
            [
                'category' => 'math_formula',
                'category_bn' => 'গণিত শর্টকাট সূত্র',
                'front_bn' => 'সমদ্বিবাহু ত্রিভুজের ক্ষেত্রফল নির্ণয়ের স্ট্যান্ডার্ড সূত্র কোনটি?',
                'front_en' => 'Area of an Isosceles Triangle',
                'back_bn' => '<strong>ক্ষেত্রফল:</strong> $\\frac{b}{4}\\sqrt{4a^2 - b^2}$<br>যেখানে, $a$ = সমান সমান বাহুর দৈর্ঘ্য এবং $b$ = ভূমির দৈর্ঘ্য।',
                'hint_bn' => 'জ্যামিতির বহুবার আসা প্রশ্ন।',
                'source_tag' => '৩৭তম ও ৪৩তম বিসিএস',
            ],
        ];

        foreach ($cards as $card) {
            Flashcard::updateOrCreate(
                [
                    'category' => $card['category'],
                    'front_bn' => $card['front_bn'],
                ],
                $card
            );
        }
    }
}
