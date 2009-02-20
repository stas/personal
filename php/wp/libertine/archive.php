<?php
get_header();

if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle">Archive for &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle">Posts with &#8216;<?php single_tag_title(); ?>&#8217; Tag</h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Archive for <?php the_time('Y'); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Author Archive </h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Blog Archive</h1>
 	  <?php } ?>

			 <?php while (have_posts()) : the_post(); ?>

			<div class="page">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h5><?php _e("Posted in"); ?> <?php the_category(',') ?> by <a href="<?php get_bloginfo('site_url'); ?>?author=<?php the_author_ID(); ?>"><?php the_author(); ?></a>. <?php the_date() ?>, <?php the_time() ?>. <?php the_tags(__('Tags: '), ', ', ' &#8212; '); ?></h5>
				<div class="page-content">
					<h5><?php comments_popup_link(__('No comments'), __('1 Comment'), __('% Comments')) ?></h5>
				</div>
			</div>

<?php endwhile; else: ?>

			<div class="page">
				<h2>Page not found!</h2>
				<div class="page-content">
					<p><?php _e('Please use the search form from the top of this page.'); ?></p>
				</div>
			</div>
			
<?php endif; ?>
		<div id="navigation"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></div>
<?php get_footer(); ?>
