<?php
/**
 * Plugin Name: Testeleven Image Panel
 * Text Domain: t11-image-panel
 */

namespace Testeleven\ImagePanel;

class Testeleven_Image_Panel {
	protected static $instance = null;

	public static function get_instance() {
		self::$instance === null && self::$instance = new self;

		return self::$instance;
	}

	protected function __construct() {
		add_action('init', array($this, 'image_panel_post_type'));
		$this->register_image_panel_field_groups();
	}

	public function image_panel_post_type() {
		$labels = array(
			'name' => __('Image Panels', 't11-image-panel'),
			'singular_name' => __('Image Panel', 't11-image-panel'),
			'add_new_item' => __('Add New Image Panel', 't11-image-panel'),
			'not_found' => __('No image panels found', 't11-image-panel'),
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'supports' => array('title', 'editor', 'revisions'),
		);
		register_post_type('image_panel', $args);
	}

	public function register_image_panel_field_groups(){
		if( function_exists('register_field_group') ):

			register_field_group(array (
				'key' => 'group_5508a5937bdb6',
				'title' => 'Image Panel Fields',
				'fields' => array (
					array (
						'key' => 'field_5508a5b6c4835',
						'label' => 'Image',
						'name' => 'imagepanel',
						'prefix' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'image_panel',
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

$image_panel = Testeleven_Image_Panel::get_instance();

// Display the panel

function display_image_panel($posts_per_page = 1) {
	$args = array(
		'post_type' => 'image_panel',
		'posts_per_page' => $posts_per_page,
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<?php while ($query->have_posts()) : $query->the_post(); ?>
			<div class="editable image-panel">
				<div class="text">
					<header>
						<h3><?php the_title(); ?></h3>
					</header>
					<?php the_content(); ?>
				</div>
				<div class="image">
					<?php $image = get_field('imagepanel') ?>
					<?php if (!empty($image)) : ?>
						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
				  <?php endif; ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
<?php
	wp_reset_postdata();
	rewind_posts();
}