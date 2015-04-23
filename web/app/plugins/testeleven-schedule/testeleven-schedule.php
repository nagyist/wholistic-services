<?php
/**
 * Plugin Name: Testeleven Schedule
 * Text Domain: t11-schedule
 */

namespace Testeleven\Schedule;
use Testeleven\Schedule\Registry;
require_once(__DIR__ . '/class-scheduled-class-registry.php');

class Testeleven_Schedule {
	protected static $instance = null;

	protected $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday',
		'Friday', 'Saturday', 'Sunday');

	protected $time_blocks = array(
		'09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
		'14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
	);

	protected $time_block_conversions = array(
		'09:30' => '9:30am',
		'10:00' => '10:00am',
		'10:30' => '10:30am',
		'11:00' => '11:00am',
		'11:30' => '11:30am',
		'12:00' => 'noon',
		'12:30' => '12:30pm',
		'13:00' => '1:00pm',
		'13:30' => '1:30pm',
		'14:00' => '2:00pm',
		'14:30' => '2:30pm',
		'15:00' => '3:00pm',
		'15:30' => '3:30pm',
		'16:00' => '4:00pm',
		'16:30' => '4:30pm',
		'17:00' => '5:00pm',
		'17:30' => '5:30pm',
	);

	protected $filled_blocks = array(
		'Monday' => array(),
		'Tuesday' => array(),
		'Wednesday' => array(),
		'Thursday' => array(),
		'Friday' => array(),
		'Saturday' => array(),
		'Sunday' => array(),
	);

	public static function get_instance() {
		self::$instance === null && self::$instance = new self;

		return self::$instance;
	}

	protected function __construct() {
		add_action('init', array($this, 'scheduled_class_post_type'));
		add_action('acf/save_post', array($this, 'save_scheduled_class_meta'), 1);
		$this->register_scheduled_class_field_groups();
	}

	public function scheduled_class_post_type() {
		$labels = array(
			'name' => __('Scheduled Classes', 't11-schedule'),
			'singular_name' => __('Scheduled Class', 't11-schedule'),
			'add_new_item' => __('Add New Class', 't11-schedule'),
			'not_found' => __('No classes found', 't11-schedule')
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array('category'),
			'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
		);
		register_post_type('scheduled_class', $args);
	}

	// On save add a meta_data key/value that stores the time_block an an integer.
	// This is used to order retrieved posts.
	public function save_scheduled_class_meta($post_id) {
		// Return if no ACF data is set
		if (get_post_type($post_id) != 'scheduled_class') {
			return;
		}
		if (empty($_POST['acf'])) {
			return;
		}
		$start_time = $_POST['acf']['field_551433daa8bdf'];
		$start_time_int = (int)ltrim(str_replace(':', '', $start_time), 0);
		update_post_meta($post_id, 'start_time_int', $start_time_int);
	}

	// Register the field groups (they are created through the Advanced Custom Field plugin)
	// A scheduled_class has a 'day' (string), 'start-time' (string), 'duration' (number),
	// 'url' (url)
	public function register_scheduled_class_field_groups() {
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_5514337634169',
				'title' => 'Scheduled class details',
				'fields' => array (
					array (
						'key' => 'field_551433855c8ec',
						'label' => 'Day',
						'name' => 'scheduled_day',
						'prefix' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'Monday' => 'Monday',
							'Tuesday' => 'Tuesday',
							'Wednesday' => 'Wednesday',
							'Thursday' => 'Thursday',
							'Friday' => 'Friday',
							'Saturday' => 'Saturday',
							'Sunday' => 'Sunday',
						),
						'default_value' => array (
							'' => '',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
						'disabled' => 0,
						'readonly' => 0,
					),
					array (
						'key' => 'field_551433daa8bdf',
						'label' => 'Start time',
						'name' => 'scheduled_start',
						'prefix' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'00:00' => '00:00',
							'00:30' => '00:30',
							'01:00' => '01:00',
							'01:30' => '01:30',
							'02:00' => '02:00',
							'02:30' => '02:30',
							'03:00' => '03:00',
							'03:30' => '03:30',
							'04:00' => '04:00',
							'04:30' => '04:30',
							'05:00' => '05:00',
							'05:30' => '05:30',
							'06:00' => '06:00',
							'06:30' => '06:30',
							'07:00' => '07:00',
							'07:30' => '07:30',
							'08:00' => '08:00',
							'08:30' => '08:30',
							'09:00' => '09:00',
							'09:30' => '09:30',
							'10:00' => '10:00',
							'10:30' => '10:30',
							'11:00' => '11:00',
							'11:30' => '11:30',
							'12:00' => '12:00',
							'12:30' => '12:30',
							'13:00' => '13:00',
							'13:30' => '13:30',
							'14:00' => '14:00',
							'14:30' => '14:30',
							'15:00' => '15:00',
							'15:30' => '15:30',
							'16:00' => '16:00',
							'16:30' => '16:30',
							'17:00' => '17:00',
							'17:30' => '17:30',
							'18:00' => '18:00',
							'18:30' => '18:30',
							'19:00' => '19:00',
							'19:30' => '19:30',
							'20:00' => '20:00',
							'20:30' => '20:30',
							'21:00' => '21:00',
							'21:30' => '21:30',
							'22:00' => '22:00',
							'22:30' => '22:30',
							'23:00' => '23:00',
							'23:30' => '23:30',
						),
						'default_value' => array (
							'' => '',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
						'disabled' => 0,
						'readonly' => 0,
					),
					array (
						'key' => 'field_551433ffa8be0',
						'label' => 'Duration',
						'name' => 'scheduled_duration',
						'prefix' => '',
						'type' => 'number',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => '',
						'max' => '',
						'step' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
					array (
						'key' => 'field_55143423a8be1',
						'label' => 'Class link',
						'name' => 'scheduled_link',
						'prefix' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'scheduled_class',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
			));

		endif;
	}

	public function draw() {

		// Table head
		$schedule_table = '<table class="schedule-table table">';
		// Start the top row with an empty <th> to go above the 'time' column.
		$schedule_table .= '<thead><tr class="schedule-row"><th></th><th class="schedule-day">';
		$schedule_table .= implode('</th><th class="schedule-day">', $this->days);
		$schedule_table .= '</th></tr></thead><tbody>';

		$schedule_table .= $this->schedule_table();

		$schedule_table .= '</tbody></table>';

		$schedule_list = $this->schedule_list_string();

		return $schedule_table . $schedule_list;
	}

	protected function schedule_table() {
		$output = '';
		// Foreach 'time_block',first, start a row. Then go through the 'days' array.
		// Query to see if the time and day has a class. If it does, use the
		// 'duration_schedule' field data to find all the time slots required for the class.
		// Make sure that these slots are free!
		// If they aren't, print a warning to the screen and exit the loop. If they are
		// free, add the time slots to the 'filled_slots' array. Then fill a <td> element
		// with the post's data and add the element to the output string.
		// If there is no post in the slot check to see if the slot is not in the 'filled_slots'
		// array. If it is free add a <td></td> element to the output string. Otherwise
		// add an empty string.
		// At the end of each row add a </tr>.

		foreach ($this->time_blocks as $time_block_index => $time_block) {
			// Start the row.
			$output .= '<tr><td class="time-block">' . $this->time_block_conversions[$time_block] . '</td>';

			// Go through the columns.
			foreach ($this->days as $day) {
				// Query for an entry at this position.
				$args = array(
					'post_type' => 'scheduled_class',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'scheduled_day',
							'value' => $day
						),
						array(
							'key' => 'scheduled_start',
							'value' => $time_block,
						)
					)
				);
				$query = new \WP_Query($args);

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();

						// Get the post info.
						$title = get_the_title();
						$content = get_the_content();
						// Get the number of table cells the post needs to span.
						$duration = get_field('scheduled_duration') / 0.5;
						$post_categories = get_the_category();
						// classes to represent the categories of the specific post.
						$classes = array('has-class');
						foreach ($post_categories as $post_category) {
							$classes[] = $post_category->slug;
						} // End of $post_categories loop - we now have the categories in the
						// $classes array.
						if (!$link = get_field('scheduled_link')) {
							$link = null;
						} // End of link loop.
						if ($link) {
//							$class_heading = '<a href="'. $link .'" data-toggle="tooltip" title="'. $content .'">'. $title .'</a>';
							$class_heading = '<a href="'. $link .'">'. $title .'</a>';
						} else {
							$class_heading = $title;
						}
						// Process the post here:
						$required_blocks = []; // The time blocks required for the class.
						for ($current_block = $time_block_index;
							$current_block < $time_block_index + $duration; $current_block++) {
							$required_blocks[] = $this->time_blocks[$current_block];
						}

						// Check the filled_slots array to see if it is free for this class.
						$filled_blocks_current_day = $this->filled_blocks[$day];
						foreach ($required_blocks as $required_block) {
							if (in_array($required_block, $filled_blocks_current_day)) {
								$output .= '<td class="alert alert-warning" rowspan="3">You are double booked!'.
								           ' On ' . $day . ' at ' . $time_block . '</td>';
								break 4; // Stop processing the loop.
							} // End of in_array loop.
							// It's not in the filled slots - so add it now.
							$this->filled_blocks[$day][] = $required_block;
						}
						// Create the <td></td>
						$output .= '<td  rowspan="' . $duration .'" ' . $this->add_classes($classes) .
						           'data-toggle="tooltip"' .
						           'data-container="body"' .
						           'title="' . $content . '"' .
						           ' >' . $class_heading . '</td>';

					} // End of while loop.

				} else {  // There were no posts at this position.
					// Check to see if the slot is free.
					$filled_blocks_current_day = $this->filled_blocks[$day];
					if (in_array($time_block, $filled_blocks_current_day)) {
						$output .= '';
					} else {
						$output .= '<td></td>';
					}

				} // End of if/else
			wp_reset_postdata();
			}	// End of columns.

			// End the row
			$output .= '</tr>';
		} // End of rows.
		return $output;
	}

	// A method to create the schedule as a list to be displayed on mobile devices.
	// Todo use the main query to generate this - don't query everything twice

	protected function schedule_list_string() {
		$output = '<div class="schedule-list">';
		foreach ($this->days as $day) {
			$args = array(
				'post_type' => 'scheduled_class',
				'orderby' => 'meta_value_num',
				'meta_key' => 'start_time_int',
				'order' => 'ASC',
				'meta_query' => array(
					'key' => 'scheduled_day',
					'value' => $day,
				),

			);

			$query = new \WP_Query($args);
			if ($query->have_posts()) {
				$output .= '<div class="schedule-day">';
				$output .= '<h2>' . $day . '</h2>';
				$output .= '<ul>';
				while ($query->have_posts()) {
					$query->the_post();
					$link = get_field('scheduled_link');
					$output .= '<li><a href="'. $link .'">' . get_the_title() . '</a></li>';
				}
				$output .= '</ul>';
				$output .= '</div>'; // End of day loop.
			}
		}
		wp_reset_query();
		$output .= '</div>';
		return $output;
	}

	// A function to add classes to an element if the class array is not empty
	protected function add_classes($classes) {
		$post_classes = null;
		if ($classes) {
			$post_classes = 'class="';
			foreach ($classes as $index => $class) {
				if ($index + 1 < count($classes)) {
					$post_classes .= $class . ' ';
				} else {
					$post_classes .= $class;
				}
			}
			$post_classes .= '"';
		}
		return $post_classes;
	}

}

$registry = Registry\Scheduled_Class_Registry::get_instance();

$registry->schedule = Testeleven_Schedule::get_instance();
