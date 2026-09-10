<?php

if (!function_exists('__t')) {
    /**
     * Bilingual translation helper function.
     * Returns English string by default, or Bangla string when current locale is 'bn'.
     */
    function __t(string $bn, string $en): string
    {
        return app()->getLocale() === 'bn' ? $bn : $en;
    }
}
