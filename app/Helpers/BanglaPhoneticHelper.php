<?php

namespace App\Helpers;

class BanglaPhoneticHelper
{
    /**
     * Map of common phonetic English / Banglish search keywords to Bengali equivalents.
     */
    protected static array $keywordMap = [
        'charyapad' => 'চর্যাপদ',
        'charjyapad' => 'চর্যাপদ',
        'charya' => 'চর্যা',
        'muktiyuddho' => 'মুক্তিযুদ্ধ',
        'muktijuddho' => 'মুক্তিযুদ্ধ',
        'mukti' => 'মুক্তি',
        'shondhi' => 'সন্ধি',
        'sondhi' => 'সন্ধি',
        'shomash' => 'সমাস',
        'somas' => 'সমাস',
        'karok' => 'কারক',
        'dhoni' => 'ধ্বনি',
        'borno' => 'বর্ণ',
        'shongbidhan' => 'সংবিধান',
        'songbidhan' => 'সংবিধান',
        'shongshod' => 'সংসদ',
        'songshod' => 'সংসদ',
        'bcs' => 'বিসিএস',
        'bpsc' => 'পিএসসি',
        'shohid' => 'শহীদ',
        'shahid' => 'শহীদ',
        'shahitto' => 'সাহিত্য',
        'sahitya' => 'সাহিত্য',
        'probondho' => 'প্রবন্ধ',
        'uponnash' => 'উপন্যাস',
        'upannash' => 'উপন্যাস',
        'natok' => 'নাটক',
        'kobita' => 'কবিতা',
        'rabindranath' => 'রবীন্দ্রনাথ',
        'robindronath' => 'রবীন্দ্রনাথ',
        'nazrul' => 'নজরুল',
        'bangladesh' => 'বাংলাদেশ',
        'dhaka' => 'ঢাকা',
        'bangabandhu' => 'বঙ্গবন্ধু',
        'mujib' => 'মুজিব',
        'padma' => 'পদ্মা',
        'jamuna' => 'যমুনা',
        'meghna' => 'মেঘনা',
        'gonit' => 'গণিত',
        'bijgonit' => 'বীজগণিত',
        'patigonit' => 'পাটিগণিত',
        'jyamiti' => 'জ্যামিতি',
        'shongkha' => 'সংখ্যা',
        'loshagu' => 'ল.সা.গু',
        'goshagu' => 'গ.সা.গু',
        'shudkosa' => 'সুদকষা',
        'shud' => 'সুদ',
        'laav' => 'লাভ',
        'khoti' => 'ক্ষতি',
        'prohori' => 'প্রহরী',
        'bideshi' => 'বিদেশি',
        'deshi' => 'দেশি',
        'totshomo' => 'তৎসম',
        'ogrovashi' => 'অগ্রভাষী',
        'synonym' => 'Synonym',
        'antonym' => 'Antonym',
        'idiom' => 'Idiom',
        'preposition' => 'Preposition',
        'clause' => 'Clause',
    ];

    /**
     * Get search term variations (original + mapped Bengali terms if applicable).
     */
    public static function getSearchTerms(?string $query): array
    {
        if (empty($query)) {
            return [];
        }

        $query = trim($query);
        $terms = [$query];

        $lower = strtolower($query);
        if (isset(self::$keywordMap[$lower])) {
            $terms[] = self::$keywordMap[$lower];
        }

        // Substring / word matches
        $words = preg_split('/\s+/', $lower);
        foreach ($words as $word) {
            if (isset(self::$keywordMap[$word])) {
                $terms[] = self::$keywordMap[$word];
            }
        }

        return array_unique($terms);
    }
}
