add_filter('wp_sms_send', 'filter_sms_content', 10, 2);

function filter_sms_content($message, $result) {
    // Get disallowed words list
    $disallowed_keys = get_option('disallowed_keys', '');
    
    if(empty($disallowed_keys)) {
        return $message;
    }
    
    // Convert to array and prepare regex pattern
    $words = explode("\n", $disallowed_keys);
    $words = array_map('trim', $words);
    $words = array_filter($words);
    
    if(empty($words)) {
        return $message;
    }
    
    // Create regex pattern
    $pattern = '/\b(' . implode('|', array_map('preg_quote', $words)) . ')\b/i';
    
    // Replace matches with ***
    return preg_replace($pattern, '***', $message);
}
