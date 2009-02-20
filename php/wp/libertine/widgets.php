		<div id="widgets">
			<div id="widget-right">
				<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar') ) : ?>
						<h2>Widgets right!!!</h2>
						<p><a href="<?php bloginfo('home'); ?>/wp-admin/widgets.php">Administration...</a></p>
				<?php endif; ?>
			</div>
			
			<div id="widget-middle">
				<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Middle Sidebar') ) : ?>
						<h2>Widgets middle!!!</h2>
						<p><a href="<?php bloginfo('home'); ?>/wp-admin/widgets.php">Administration...</a></p>
				<?php endif; ?>
			</div>
			
			<div id="widget-left">
				<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Sidebar') ) : ?>
						<h2>Widgets left!!!</h2>
						<p><a href="<?php bloginfo('home'); ?>/wp-admin/widgets.php">Administration...</a></p>
				<?php endif; ?>
			</div>
			
			<div class="clear">&nbsp;</div>
		</div>
