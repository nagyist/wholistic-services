<?php
namespace Testeleven\WholisticService\Carousel;
use Testeleven\ImagePanel;
?>

<div id="front-page-carousel" class="testeleven-carousel carousel slide hidden-xs"
     data-ride="carousel" data-interval="false">
	<?php // select all image panels
	$args = array(
		'post_type' => 'image_panel',
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<?php $post_count = 0; ?>

		<ol class="carousel-indicators">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<li data-target="front-page-carousel" data-slide-to="<?php echo $post_count ?>"
					class="indicator <?php echo add_active_class($post_count); ?>"></li>
				<?php $post_count += 1; ?>
			<?php endwhile; ?>
		</ol>
		<?php rewind_posts(); ?>
	  <?php $post_count = 0; ?>

		<div class="carousel-inner" role="listbox">
			<?php while($query->have_posts()) : $query->the_post(); ?>
				<div class="item <?php echo add_active_class($post_count); ?>">
					<div class="image-panel">
						<div class="text">
              <div class="wrap">
                <header><h3><?php the_title(); ?></h3></header>
                <?php the_content(); ?>
              </div>
						</div>
						<div class="image">
							<?php $image = get_field('imagepanel'); ?>
							<?php if (!empty($image)) : ?>
								<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
					    <?php endif; ?>
						</div>
					</div>
				</div>
				<?php $post_count += 1; ?>
		  <?php endwhile; ?>
		</div>
		<a class="left carousel-control" role="button" data-slide="prev"
		   href="#front-page-carousel">
      <span class="control-text-left btn btn-primary">&#8592;</span>
<!--			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" role="button" data-slide="next"
		   href="#front-page-carousel">
      <span class="control-text-right btn btn-primary">&#8594;</span>
<!--			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
			<span class="sr-only">Next</span>
		</a>

	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>

<div class="visible-xs testeleven-static-carousel">
	<?php ImagePanel\display_image_panel(); ?>
</div>



<?php
function add_active_class($post_count, $target=0) {
	if ($post_count == $target) {
		return 'active';
	}
}