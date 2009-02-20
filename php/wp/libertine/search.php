<?php
get_header();
?>

<h1>S-a făcut căutare după "<?php the_search_query(); ?></h1>

<?
if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="page">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h5><?php _e("Posted in"); ?> <?php the_category(',') ?> by <a href="<?php get_bloginfo('site_url'); ?>?author=<?php the_author_ID(); ?>"><?php the_author(); ?></a>. <?php the_date() ?>, <?php the_time() ?>. <?php the_tags(__('Tags: '), ', ', ' &#8212; '); ?></h5>
				<div class="page-content">
					<h5 class="clear"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')) ?></h5>
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
