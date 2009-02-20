<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="page">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h5><?php _e("Posted in"); ?> <?php the_category(',') ?>. <?php // the_author() ?>On <?php the_date() ?>, <?php the_time() ?>. <?php the_tags(__('Etichete: '), ', ', ' &#8212; '); ?></h5>
				<div class="page-content">
					<?php the_content(__('Continue reading...')); ?>
					<?php wp_link_pages(); ?>
					<?php edit_post_link(__('Edit')) ?>
					<h5 class="clear"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')) ?></h5>
				</div>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
			
<?php endwhile; else: ?>

			<div class="page">
				<h2>Page not found!</h2>
				<div class="page-content">
					<p><?php _e('Please use the search form from the top of this page.'); ?></p>
				</div>
			</div>
			
<?php endif; ?>
<?php get_footer(); ?>
