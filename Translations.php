add_filter( 'gettext', 'cyb_filter_gettext', 10, 3 );
function cyb_filter_gettext( $translated, $original, $domain ) {
    // Use the text string exactly as it is in the translation file
    if ( $translated == "Улична адреса" ) {
        $translated = "Адреса";
    }
  if ( $original == "Checkout" ) {
        $translated = "Кон наплата";
    }
    return $translated;
}

// For some cases
add_filter( 'gettext_with_context', 'cyb_filter_gettext_with_context', 10, 4 );
function cyb_filter_gettext_with_context( $translated, $original, $context, $domain ) {
    if ( $translated == "За Испорака" ) {
        $translated = "Испорака до дома:<br />•до 5 кг = 150 ден<br />•од 5 до 10кг = 180 ден<br />•над 10 кг = 250 ден";
    }
    return $translated;
}
