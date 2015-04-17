<?php

namespace Testeleven\WholisticService\Headings;

function clean_up_archive_title($title) {
	if (is_archive()) {
		$title = preg_replace('/Category: /', '', $title);
	}
	return ucfirst($title);
}
add_filter('get_the_archive_title', 'Testeleven\WholisticService\Headings\clean_up_archive_title');