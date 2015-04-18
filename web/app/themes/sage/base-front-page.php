<php>
  use Testeleven\Positioned\TemplateTags;
</php>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
<!--[if lt IE 9]>
<div class="alert alert-warning">
  <p>
    It seems that you are viewing this site on an older web browser. Our goal is
    to
    create websites that are accessible to everyone. If you are having any
    trouble
    using the site, please contact us to let us know. Thanks :)
  </p>
</div>
<![endif]-->
<section class="splash-wrapper">
  <?php
  do_action('get_header');
  get_template_part('templates/header');
  ?>
  <div class="splash">
    <div class="wrap container" role="document">
      <div class="content row">
        <?php get_template_part('templates/carousel'); ?>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.wrap -->
  </div>
</section>
<!-- end of splash-wrapper -->

<section class="welcome" id="welcome">
  <div class="full-width-heading">
    <?php TemplateTags\post_in_position('welcome-to-nbs', 'positioned_title', 2); ?>
  </div>
  <div class="front-page-centered intro">
    <?php TemplateTags\post_in_position('fifteen-second-intro', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('fifteen-second-intro-image', 'positioned_image'); ?>
  </div>

  <div class="full-width-heading">
    <!--		--><?php //TemplateTags\post_in_position('what-we-offer', 'positioned_title', 2); ?>
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
  <div class="full-width-heading">
    <?php TemplateTags\post_in_position('andrea', 'positioned_title', 2); ?>
  </div>
  <div class="front-page-centered">
    <?php TemplateTags\post_in_position('who-we-are', 'positioned_full', 3); ?>
    <?php TemplateTags\post_in_position('andrea-image', 'positioned_image'); ?>
  </div>
</section>
<?php
get_template_part('templates/footer');
wp_footer();
?>
</body>
</html>