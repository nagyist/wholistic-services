<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
<!--      --><?php //get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
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
    <footer>
<!--      --><?php //wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
	  <?php get_template_part('templates/post-contact-form'); ?>
  </article>
<?php endwhile; ?>
