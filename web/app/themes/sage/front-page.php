<?php
use Testeleven\Positioned\TemplateTags;
?>

<section class="intro-sideshow">
  <?php get_template_part('templates/carousel'); ?>
</section>

<section class="welcome" id="welcome">
<!--  <div class="full-width-heading">-->
<!--    --><?php //TemplateTags\post_in_position('welcome-to-nbs', 'positioned_title', 2); ?>
<!--  </div>-->
<!--  <div class="front-page-centered intro">-->
<!--    --><?php //TemplateTags\post_in_position('fifteen-second-intro', 'positioned_full', 3); ?>
<!--    --><?php //TemplateTags\post_in_position('fifteen-second-intro-image', 'positioned_image'); ?>
<!--  </div>-->

  <div class="full-width-heading">
    		<?php TemplateTags\post_in_position('what-we-offer', 'positioned_title', 2); ?>
  </div>
  <div class="front-page-centered">
    <?php TemplateTags\post_in_position('our-approach-to-yoga', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('our-approach-to-yoga-image', 'positioned_image'); ?>
  </div>

  <div class="front-page-centered">
    <?php TemplateTags\post_in_position('our-approach-to-energywork', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('our-approach-to-energywork-image', 'positioned_image'); ?>
  </div>

  <div class="front-page-centered">
    <?php TemplateTags\post_in_position('our-approach-to-esthetics', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('our-approach-to-esthetics-image', 'positioned_image'); ?>
  </div>
</section>
<section class="qualifications">
<!--  <div class="full-width-heading">-->
<!--    --><?php //TemplateTags\post_in_position('andrea', 'positioned_title', 2); ?>
<!--  </div>-->
  <div class="front-page-centered">
    <?php TemplateTags\post_in_position('who-we-are', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('andrea-image', 'positioned_image'); ?>
  </div>
</section>
