<?php

namespace App\Helpers;

class String
{
    static public function acronym($phrase)
    {
        $acronym = '';

        foreach (explode(' ', $phrase) as $word) {
            $acronym .= mb_substr($word, 0, 1, 'utf-8');
        }

        return $acronym;
    }
}

