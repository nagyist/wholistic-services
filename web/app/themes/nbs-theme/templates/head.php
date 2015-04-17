<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> Feed" href="<?= esc_url(get_feed_link()); ?>">
	  <script src="//use.typekit.net/vzs8osg.js"></script>
	  <script>try{Typekit.load();}catch(e){}</script>
    <?php wp_head(); ?>
	  <script>
	  jQuery.browser = {};
		  (function () {
			  jQuery.browser.msie = false;
			  jQuery.browser.version = 0;
			  if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
				  jQuery.browser.msie = true;
				  jQuery.browser.version = RegExp.$1;
			  }
		  })();
  	  </script>
  </head>
