<?php 

// app/Helpers/date_helper.php
if (!function_exists('get_relative_time')) {
    function get_relative_time($datetime)
    {
        // Ensure we're working with a valid datetime
        if (!$datetime || $datetime === '0000-00-00 00:00:00') {
            return 'Never Logged In';
        }

        // Convert the datetime string to a timestamp
        $timestamp = strtotime($datetime);
        
        // Get current timestamp
        $now = time();
        
        // Calculate the difference in seconds
        $difference = $now - $timestamp;
        
        // Handling different time ranges more precisely
        if ($difference < 60) {
            return 'just now';
        } elseif ($difference < 3600) {
            $minutes = floor($difference / 60);
            return $minutes . ' ' . ($minutes == 1 ? 'min' : 'mins') . ' ago';
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . ' ' . ($hours == 1 ? 'hour' : 'hours') . ' ago';
        } elseif ($difference < 30 * 86400) {
            $days = floor($difference / 86400);
            return $days . ' ' . ($days == 1 ? 'day' : 'days') . ' ago';
        } elseif ($difference < 365 * 86400) {
            $months = floor($difference / (30 * 86400));
            return $months . ' ' . ($months == 1 ? 'month' : 'months') . ' ago';
        } else {
            $years = floor($difference / (365 * 86400));
            return $years . ' ' . ($years == 1 ? 'year' : 'years') . ' ago';
        }
    }
}