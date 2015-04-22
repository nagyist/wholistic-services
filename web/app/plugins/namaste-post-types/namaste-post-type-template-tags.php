<?php

namespace Testeleven\NamastePostTypes\TemplateTags;

function display_workshops($limit = 1, $heading_level = 2) {
	$args = array(
		'post_type' => 'nbs_workshop',
		'posts_per_page' => $limit,
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<div class="workshops">
<!--			<header class="section-header">-->
<!--				--><?php //$top_heading_level = $heading_level - 1; ?>
<!--				--><?php //wrap_section_with_heading_level('Workshops at Namaste Bodywork Studio', $top_heading_level); ?>
<!--			</header>-->
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<article <?php post_class(array('editable', 'highlight-box')); ?>>

					<?php if (has_post_thumbnail()) : ?>
						<div class="featured-image">
							<?php the_post_thumbnail(); ?>
						</div>
					<?php endif; ?>
					<header>
						<?php $title = get_the_title(); ?>
						<a href="<?php echo esc_url(the_permalink()); ?>">
							<?php wrap_entry_with_heading_level($title, $heading_level); ?>
						</a>
						<?php $date = get_field('workshop_date'); ?>
						<?php $time = get_field('workshop_time'); ?>
						<?php if ($date && $time) {
							$datetime = "$date, $time";
						} elseif ($date || $time) {
							$datetime = "$date $time";
						} else {
							$datetime = null;
						}
						?>
						<?php if ($datetime) : ?>
							<div class="datetime">
								<?php echo $datetime; ?>
							</div>
				    <?php endif; ?>
					</header>
          <div class="excerpt">
	          <?php the_excerpt(); ?>
          </div>
				</article>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
<?php
	wp_reset_postdata();
}

// Display Notification
function display_notifications($heading_level = 2) {
	$args = array(
		'post_type' => 'nbs_notice',
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<div class="site-notice alert alert-warning highlight-box">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<header>
					<?php $title = get_the_title(); ?>
					<?php wrap_entry_with_heading_level($title, $heading_level); ?>
				</header>
			<?php endwhile; ?>
			<article <?php post_class('site-notice'); ?>>
				<?php the_content(); ?>
			</article>
		</div>
	<?php endif; ?>
<?php
	wp_reset_postdata();
}

function display_videos($heading_level = 3, $limit = 3) {
	$args = array(
		'post_type' => 'nbs_video',
		'posts_per_page' => $limit,
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<div class="videos">
<!--			<header>-->
<!--				--><?php //wrap_section_with_heading_level('Andrea\'s videos', $heading_level - 1); ?>
<!--			</header>-->
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php $video_id = get_field('video_id'); ?>
				<?php $video_url = "http://www.youtube.com/embed/{$video_id}/?enablejsapi=1"; ?>
				<?php $post_id = 'video-' . get_the_ID(); ?>
				<?php $label_id = $post_id . '-label'; ?>
				<?php $title = get_the_title(); ?>

				<!-- List videos -->
        <div class="highlight-box">
				<a class="modal-video" data-toggle="modal" data-target="#<?php echo $post_id; ?>"
				   data-src="<?php echo $video_url; ?>" href="#">
					<?php wrap_entry_with_heading_level($title, $heading_level); ?>
					<img src="http://img.youtube.com/vi/<?php echo $video_id; ?>/mqdefault.jpg" alt="<?php echo $title; ?>"/>
				</a>
        </div>

				<!-- The modal -->
				<div class="modal fade" tabindex="-1" role="dialog" id="<?php echo $post_id; ?>"
				      aria-labelledby="<?php echo $label_id; ?>" aria-hidden="true"
					    data-player-id="<?php echo $video_id; ?>">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" type="button" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="<?php echo $label_id; ?>"><?php echo $title; ?></h4>
							</div>
							<!-- The player -->
							<div class="modal-body">
								<div class="embed-responsive embed-responsive-16by9">
									<iframe id="<?php echo $video_id; ?>" class="testeleven-video embed-responsive-item"
									        src="<?php echo $video_url; ?>"></iframe>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
<?php
	wp_reset_postdata();
}

function display_testimonials($limit = 3) {
	$args = array(
		'post_type' => 'nbs_testimonial',
	);
	$query = new \WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<div class="testimonials">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<article <?php post_class(array('editable', 'highlight-box')); ?>>
				  <?php the_content(); ?>
					<footer>
						<?php $post_date = get_the_date(); ?>
						Submitted by: <?php the_title(); ?><br/>
						On: <?php echo $post_date; ?>
					</footer>
				</article>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
<?php
	wp_reset_postdata();
}

function display_posts($heading_level = 3, $limit = 3) {
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => $limit,
  );
  $query = new \WP_Query($args);
  ?>
  <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <article <?php post_class(array('editable', 'highlight-box')); ?> >
        <header>
         <?php $title = get_the_title(); ?>
         <?php wrap_entry_with_heading_level($title, $heading_level); ?>
        </header>
        <?php if (has_post_thumbnail()) : ?>
          <div class="featured-image">
            <?php the_post_thumbnail(); ?>
          </div>
        <?php endif; ?>
        <div class="entry-content">
          <?php the_excerpt(); ?>
        </div>
      </article>
    <?php endwhile?>
  <?php endif; ?>
<?php
  wp_reset_postdata();
}

// Wrap a string in a chosen heading level
function wrap_entry_with_heading_level($str, $level = 2) {
	$format = '<h%2$d class="entry-title">%1$s</h%2$d>';
	echo sprintf($format, $str, $level);
}

function wrap_section_with_heading_level($str, $level) {
	$format = '<h%2$d class="section-title">%1$s</h%2$d>';
	echo sprintf($format, $str, $level);
}

