<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
		@import url( <?php bloginfo('template_url'); ?>/style.php );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>

<body>
	<div id="page">
		<div id="banner">
			<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
					<input type="text" name="s" id="s" size="15" value="<?php the_search_query(); ?> " /> <input type="submit" value="<?php _e('Search'); ?>" />
			</form>
			<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
			<h4><?php bloginfo('description'); ?></h4>
		</div>
		<div id="menu">
			<ul>
				<?php wp_list_pages('sort_column=menu_order&title_li='); ?> 
			</ul>
			<ul>
				<?php wp_list_categories('orderby=name&show_count=0&title_li='); ?> 
			</ul>
		</div>
		<div id="content">
