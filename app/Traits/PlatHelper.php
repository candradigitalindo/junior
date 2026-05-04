<?php

namespace App\Traits;

trait PlatHelper
{
    /**
     * Format license plate to standard Indonesian format (e.g., BK 1234 ABC).
     *
     * @param string $text
     * @return string|null
     */
    private function plat($text)
    {
        $string = strtoupper(trim($text));
        $pattern = '/^([A-Z]{1,3})(\s|-)*([1-9][0-9]{0,3})(\s|-)*([A-Z]{0,3}|[1-9][0-9]{1,2})$/i';
        
        if (preg_match($pattern, $string)) {
            return trim(strtoupper(preg_replace($pattern, '$1 $3 $5', $string)));
        }

        return $string; // Return original if not matching pattern
    }

    /**
     * Format phone number to international format (62...).
     *
     * @param string $nohp
     * @return string
     */
    private function hp($nohp)
    {
        // Remove spaces, parentheses, and dots
        $nohp = str_replace([" ", "(", ")", "."], "", $nohp);

        // Check if phone number contains only + and digits
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // Check if it starts with +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                return '62' . substr(trim($nohp), 3);
            }
            // Check if it starts with 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                return '62' . substr(trim($nohp), 1);
            }
        }
        return $nohp;
    }
}
