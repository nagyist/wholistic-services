<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;
use Testeleven\NamastePostTypes\TemplateTags;

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
</div>
<div class="wrap container">
  <div class="content row">
    <div id="highlights">
      <?php TemplateTags\display_notifications(3); ?>
      <?php TemplateTags\display_workshops(3, 3); ?>
      <?php TemplateTags\display_videos(); ?>
      <?php TemplateTags\display_posts(); ?>
      <?php TemplateTags\display_testimonials(); ?>
    </div>
  </div>
</div>
<?php
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>
