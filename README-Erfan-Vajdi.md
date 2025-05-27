# WP SMS Content Filter Integration - Assignment Submission

## Project Overview
**Objective:** Implement a content filtering system for WP SMS that censors disallowed words from outgoing SMS messages using WordPress' native disallowed keys list.

### Key Implementation Points

1. **Core Integration Approach**  
   Modified the WP SMS plugin to include a custom filtering module:
   - Added filter hook to `wp_sms_send`
   - Integrated with WordPress' native `disallowed_keys` option
   - Implemented whole-word matching with regex

2. **File Structure Modifications**
wp-sms/
 wp-sms.php # Main plugin file
 sms-content-filter.php # Filter implementation


3. **Technical Implementation**  
Added in `sms-content-filter.php`:
```php
add_filter('wp_sms_send', 'sms_content_filter', 10, 2);

function sms_content_filter($message, $sms) {
    $disallowed = get_option('disallowed_keys');
    if ($disallowed) {
        $words = array_filter(array_map('trim', explode("\n", $disallowed)));
        if (!empty($words)) {
            $pattern = '/\b(' . implode('|', array_map('preg_quote', $words)) . ')\b/i';
            return preg_replace($pattern, '***', $message);
        }
    }
    return $message;
}

