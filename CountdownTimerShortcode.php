// Countdown Timer Shortcode
function next_event_shortcodes_init() {
  add_shortcode('next_event', 'next_event_shortcode');
}
add_action('init', 'next_event_shortcodes_init');

function next_event_shortcode ($atts = [])
{
  // normalize attribute keys to lowercase
  $atts = array_change_key_case((array)$atts, CASE_LOWER);
  if (!array_key_exists("date", $atts)) return false;

  $time_remaining = strtotime($atts['date']) - time();

  if ($time_remaining < 0) {
    $time_remaining = 0;
  }

  $total_days_remaining = ceil($time_remaining / (60 * 60 * 24));
  $total_ours_remaining = ceil($time_remaining / 3600 % 24);
  $total_minutes_remaining = ceil($time_remaining / 60 % 60);
  $total_seconds_remaining = ceil($time_remaining % 60);

  if ($total_days_remaining >= 7) {
    $weeks_remaining = sprintf("%d", floor($total_days_remaining / 7));
    $days_remaining = sprintf("%d", $total_days_remaining % 7);
	    echo "
  <div class='next-event'>
  The promotion lasts for:<br />
    $weeks_remaining weeks and $days_remaining days
  </div>";
  } else {
    $weeks_remaining = sprintf("%d", 0);
    $days_remaining = sprintf("%d", $total_days_remaining);
    $ours_remaining = sprintf("%02d", $total_ours_remaining);
    $minutes_remaining = sprintf("%02d", $total_minutes_remaining);
	$seconds_remaining = sprintf("%02d", $total_seconds_remaining);
	    echo "
  <div class='next-event'>
  The promotion lasts for:<br />
    $days_remaining days, $ours_remaining hours and $minutes_remaining minutes
  </div>";
  }
  
}
