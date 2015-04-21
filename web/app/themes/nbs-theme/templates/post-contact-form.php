<div class="contact-service">
	<header class="contact-header">
		<?php // If the contact is about a 'service' or a 'class', give the correct heading. ?>
		<?php if (has_category('service')) : ?>
			<h2>Schedule an appointment</h2>
		<?php elseif (has_category('class')) : ?>
			<h2>Sign up</h2>
		<?php else : ?>
			<h2>Contact us</h2>
		<?php endif; ?>
	</header>
	<?php gravity_form(1, false, false, false, '', false); ?>
</div>