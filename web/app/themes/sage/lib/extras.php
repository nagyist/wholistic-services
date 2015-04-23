<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' <a href="' . get_permalink() . '">' . __('[read more...]', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

// Hide the admin bar
add_filter('show_admin_bar', '__return_false');

function excerpt_more_link($output) {
  if (has_excerpt() && ! is_attachment()) {
    $output .= excerpt_more();
  }
  return $output;
}
add_filter('get_the_excerpt', __NAMESPACE__ . '\\excerpt_more_link');
