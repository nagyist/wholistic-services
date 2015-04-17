<?php
namespace Testeleven\WholisticServices\Welcome;
use Testeleven\Positioned\TemplateTags;

?>
<section class="welcome">
	<div class="fifteen-second-intro">
		<div class="full-width-heading">
			<?php TemplateTags\post_in_position('welcome-to-nbs', 'positioned_title', 2); ?>
		</div>
		<?php TemplateTags\post_in_position('fifteen-second-intro', 'positioned_full', 3); ?>
		<?php TemplateTags\post_in_position('fifteen-second-intro-image', 'positioned_image'); ?>
	</div>
	<div class="still-reading">
		<div class="full-width-heading">
			<?php TemplateTags\post_in_position('still-reading', 'positioned_title', 2); ?>
		</div>
		<div class="full-width-heading">
			<?php TemplateTags\post_in_position('what-we-offer', 'positioned_title', 3); ?>
		</div>
		<?php TemplateTags\post_in_position('our-approach-to-yoga', 'positioned_full', 4); ?>
		<?php TemplateTags\post_in_position('our-approach-to-yoga-image', 'positioned_image'); ?>
		<?php TemplateTags\post_in_position('our-approach-to-energywork', 'positioned_full', 4); ?>
		<?php TemplateTags\post_in_position('our-approach-to-energywork-image', 'positioned_image'); ?>
		<?php TemplateTags\post_in_position('our-approach-to-esthetics', 'positioned_full', 4); ?>
		<?php TemplateTags\post_in_position('our-approach-to-esthetics-image', 'positioned_image'); ?>
		<div class="full-width-heading">
			<?php TemplateTags\post_in_position('why-we-are-so-good', 'positioned_title', 3); ?>
		</div>
		<?php TemplateTags\post_in_position('because-of-who-we-are', 'positioned_full', 4); ?>
		<?php TemplateTags\post_in_position('because-of-our-qualifications', 'positioned_full', 4); ?>
	</div>
</section>
