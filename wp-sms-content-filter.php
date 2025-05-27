<?php
add_filter('wp_sms_send', 'filter_sms_content', 10, 2);

function filter_sms_content($message, $result) {
    $disallowed_keys = get_option('disallowed_keys', '');
    
    if(!empty($disallowed_keys)) {
        $words = array_filter(array_map('trim', explode("\n", $disallowed_keys)));
        if(!empty($words)) {
            $pattern = '/\b(' . implode('|', array_map('preg_quote', $words)) . ')\b/i';
            $message = preg_replace($pattern, '***', $message);
        }
    }
    
    return $message;
}
