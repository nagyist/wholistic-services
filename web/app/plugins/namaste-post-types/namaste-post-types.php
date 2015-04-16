<?php
/**
 * Plugin Name: Namaste Post Types
 */

namespace Testeleven\NamastePostTypes;

class Namaste_Post_Types {
	protected static $instance = null;

	public static function get_instance() {
		self::$instance === null && self::$instance = new self;

		return self::$instance;
	}

	protected function __construct() {
		add_action('init', array($this, 'register_namaste_post_types'));
		$this->register_nbs_post_type_field_groups();
	}

	public function register_namaste_post_types() {
		$this->nbs_workshop();
		$this->nbs_notice();
    $this->nbs_testimonial();
		$this->nbs_video();
	}

	protected function nbs_workshop() {
		$labels = array(
			'name'          => 'Workshops',
			'singular_name' => 'Workshop',
			'add_new_item'  => 'Add New Workshop',
		);
		$args   = array(
			'labels'   => $labels,
			'public'   => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
		);
		register_post_type('nbs_workshop', $args);
	}

	protected function nbs_notice() {
		$labels = array(
			'name'          => 'Notifications',
			'singular_name' => 'Notification',
			'add_new_item'  => 'Add New Notification',
		);
		$args   = array(
			'labels'   => $labels,
			'public'   => true,
			'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
		);
		register_post_type('nbs_notice', $args);
	}

	protected function nbs_testimonial() {
		$labels = array(
			'name'          => 'Testimonials',
			'singular_name' => 'Testimonial',
		);
		$args   = array(
			'labels'   => $labels,
			'public'   => true,
			'supports' => array('title', 'editor'),
		);
		register_post_type('nbs_testimonial', $args);
	}

	protected function nbs_video() {
		$labels = array(
			'name'          => 'Videos',
			'singular_name' => 'Video',
			'add_new_item' => 'Add New Video',
		);
		$args   = array(
			'labels'   => $labels,
			'public'   => true,
			'supports' => array('title', 'editor', 'revisions'),
		);
		register_post_type('nbs_video', $args);
	}

	public function register_nbs_post_type_field_groups() {
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_551310df97802',
				'title' => 'Testimonial details',
				'fields' => array (
					array (
						'key' => 'field_5513110d9cc39',
						'label' => 'Testimonial author email',
						'name' => 'testimonial_email',
						'prefix' => '',
						'type' => 'email',
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
					),
					array (
						'key' => 'field_5513113e9cc3a',
						'label' => 'Allowed to post',
						'name' => 'testimonial_allowed',
						'prefix' => '',
						'type' => 'checkbox',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array (
							'' => '',
						),
						'default_value' => array (
							'' => '',
						),
						'layout' => 'vertical',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'nbs_testimonial',
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

			register_field_group(array (
				'key' => 'group_5511af7cd5ecf',
				'title' => 'Video details',
				'fields' => array (
					array (
						'key' => 'field_5512d94017e5b',
						'label' => 'Video ID',
						'name' => 'video_id',
						'prefix' => '',
						'type' => 'text',
						'instructions' => 'Copy the ID of the YouTube video',
						'required' => 1,
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
							'value' => 'nbs_video',
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

			register_field_group(array (
				'key' => 'group_5511aec853069',
				'title' => 'Workshop Details',
				'fields' => array (
					array (
						'key' => 'field_5511aedc7e23d',
						'label' => 'Workshop location',
						'name' => 'workshop_location',
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
					array (
						'key' => 'field_5511af0d7e23e',
						'label' => 'Workshop date',
						'name' => 'workshop_date',
						'prefix' => '',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'd/m/Y',
						'return_format' => 'd/m/Y',
						'first_day' => 1,
					),
					array (
						'key' => 'field_5511af3b7e23f',
						'label' => 'Workshop time',
						'name' => 'workshop_time',
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
					array (
						'key' => 'field_5511af4b7e240',
						'label' => 'Workshop cost',
						'name' => 'workshop_cost',
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
							'value' => 'nbs_workshop',
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
}

Namaste_Post_Types::get_instance();

require_once(__DIR__ . '/namaste-post-type-template-tags.php');