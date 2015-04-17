<ul class="secondary-menu">

<!--	--><?php //if (current_user_can('manage_options')) : ?>
<!--		<li><a href="--><?php //echo esc_url(get_site_url()); ?><!--">Admin Area</a></li>-->
<!--	--><?php //endif; ?>

<!--	--><?php //if (is_user_logged_in()) : ?>
<!--		--><?php //$home_url = get_home_url(); ?>
<!--		<li><a href="--><?php //echo esc_url(wp_logout_url($home_url)); ?><!--">Logout</a></li>-->
<!--	--><?php //else : ?>
<!--		<li><a href="#">Login</a></li>-->
<!--	--><?php //endif; ?>

	<?php if (!is_front_page()) : ?>
		<li><a href="<?php echo esc_url(get_home_url()); ?>">Home</a></li>
	<?php endif; ?>

	<li>
		<a href="#">Contact Us</a>
	</li>

</ul>