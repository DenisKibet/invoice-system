<?php

// namespace App\Helpers;

function generate_numbers($start, $count, $digits) {
    $result = array();
    for ($n = $start; $n < $start + $count; $n++) {
        $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
    }
    return $result;
// }
// function generate_numbers() {
//     return 123;
}

