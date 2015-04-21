<ul class="secondary-menu">
	<?php if (!is_front_page()) : ?>
		<li><a href="<?php echo esc_url(get_home_url()); ?>">Home</a></li>
	<?php endif; ?>

	<li>
		<a href="/contact" class="btn btn-default">Contact Us</a>
	</li>
</ul>