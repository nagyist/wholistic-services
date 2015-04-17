<?php
namespace Testeleven\WholisticServices\Testimonial;

add_filter('gform_post_data',
	'Testeleven\WholisticServices\Testimonial\change_to_testimonial_post_type', 10, 3);
function change_to_testimonial_post_type($post_data, $form, $entry) {
	// The testimonial form has the id of 2.
	if ($form['id'] != 2) {
		return $post_data;
	}

	$post_data['post_type'] = 'nbs_testimonial';
	return $post_data;

}