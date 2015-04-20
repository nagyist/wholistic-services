<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;
use Testeleven\Positioned\TemplateTags;

?>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
<!--[if lt IE 9]>
<div class="alert alert-warning">
  <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
  browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->
<?php
do_action('get_header');
get_template_part('templates/header');
?>
<div class="wrap container intro-slideshow">
  <div class="content row">
    <?php get_template_part('templates/carousel'); ?>
  </div>
  <!-- /.content -->
</div>
<!-- /.wrap -->
<div class="welcome">
  <div class="wrap container">
    <div class="content row">
      <div class="full-width-heading">
        <?php TemplateTags\post_in_position('what-we-offer', 'positioned_title', 2); ?>
      </div>
      <div class="front-page-centered">
        <?php TemplateTags\post_in_position('fifteen-second-intro', 'positioned_full', 3);?>
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
    </div>
  </div>
</div>
<div class="wrap container qualifications">
  <div class="content row">
    <div class="front-page-centered">
      <?php TemplateTags\post_in_position('who-we-are', 'positioned_full', 3); ?>
      <?php TemplateTags\post_in_position('andrea-image', 'positioned_image'); ?>
    </div>
  </div>
</div>
<?php
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>
