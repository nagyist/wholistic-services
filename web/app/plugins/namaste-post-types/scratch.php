<?php
function display_videos_bak($heading_level = 3, $limit = 3) {
$args = array(
'post_type' => 'nbs_video',
'posts_per_page' => $limit,
);
$query = new \WP_Query($args);
?>
<?php if ($query->have_posts()) : ?>
	<div class="videos">
		<header>
			<?php wrap_section_with_heading_level('Current videos', $heading_level - 1); ?>
		</header>
		<?php while ($query->have_posts()) : $query->the_post(); ?>
			<?php $video_id = get_field('video_id'); ?>
			<?php $video_url = "https://www.youtube.com/embed/{$video_id}?enablejsapi=1"; ?>
			<?php $post_id = 'video-' . get_the_ID(); ?>
			<?php $label_id = $post_id . '-label'; ?>
			<?php $title = get_the_title(); ?>

			<!-- Button -->
			<a class="modal-video" data-toggle="modal" data-target="#<?php echo $post_id; ?>"
			   data-src="<?php echo $video_url; ?>" href="#">
				<?php wrap_entry_with_heading_level($title, $heading_level); ?>
				<img src="http://img.youtube.com/vi/<?php echo $video_id; ?>/1.jpg" alt=""/>
			</a>

			<!-- Modal -->
			<div class="modal fade" id="<?php echo $post_id; ?>" tabindex="-1" role="dialog"
			     aria-labelledby="<?php echo $label_id; ?>" aria-hidden="true"
			     data-player-id="<?php echo $video_id; ?>">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="<?php echo $label_id; ?>"><?php the_title(); ?></h4>
						</div>
						<div class="modal-body">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe id="<?php echo $video_id; ?>" class="testeleven-video embed-responsive-item" allowfullscreen></iframe>
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
