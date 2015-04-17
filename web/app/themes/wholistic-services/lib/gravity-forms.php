<?php

// Load javascript in the footer
add_filter('gform_init_scripts_footer', '__return_true');

// This is here for if I need it


//add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );
// see https://bjornjohansen.no/load-gravity-forms-js-in-footer

/* function wrap_gform_cdata_open( $content = '' ) {
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
  return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );
function wrap_gform_cdata_close( $content = '' ) {
  $content = ' }, false );';
  return $content;
} */