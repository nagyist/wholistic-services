<?php
namespace Testeleven\WholisticServices\GForm;
?>
<?php

// Allow us to load jQuery in the footer with Gravity Forms
add_filter('gform_init_scripts_footer', 'Testeleven\WholisticServices\GForm\init_scripts');
function init_scripts() {
return true;
}

// Change the Submit button text to 'Contact Us'
add_filter('gform_submit_button', 'Testeleven\WholisticServices\Gform\submit_button_text', 10, 2);
function submit_button_text($button, $form) {
  return "<button class=\"btn btn-primary\" id='gform_submit_button_{$form["id"]}'>Contact Us</button>";
}