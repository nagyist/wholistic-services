<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class('row'); ?>>
    <header>
      <h1 class="entry-title <?php if (get_field('workshop_date')) {echo 'has-date';} ?>"><?php the_title(); ?></h1>
      <?php if (get_field('workshop_date')) : ?>
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
      <?php endif;?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
      <div class="featured-image">
        <?php the_post_thumbnail(); ?>
      </div>
      <?php if(has_category('class')) : ?>
        <p>Have a look at our <a href="/schedule">schedule</a> to see if there is
          a class that works for you.</p>
      <?php endif; ?>
    </div>

    <?php if (get_field('item_and_price')) : ?>
      <h2>Price</h2>
      <table class="table table-striped">
        <?php while (has_sub_field('item_and_price')) : ?>
          <?php $item = get_sub_field('item'); ?>
          <?php $price = get_sub_field('price'); ?>
          <tr><td><?php echo $item; ?></td><td><?php echo $price; ?></td></tr>
        <?php endwhile; ?>
      </table>
    <?php endif; ?>
    <?php get_template_part('templates/post-contact-form'); ?>
  </article>
<?php endwhile; ?>