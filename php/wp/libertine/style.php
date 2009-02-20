<?php
require_once( dirname(__FILE__) . '../../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

html, body {
	background-color: <?php echo $lb_libertine_backgroundcolor; ?>;
	background-image: <?php echo $lb_libertine_backgroundimage; ?>;
	color: <?php echo $lb_libertine_color; ?>;
} 

h1, h2, h3, h4, h5, h6 {
	color: <?php echo $lb_libertine_headingscolor; ?>;
}

h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
	color: <?php echo $lb_libertine_headingscolor; ?>;
}

a {
	color: <?php echo $lb_libertine_linkscolor; ?>;
}

a:focus, a:hover, a:visited {
	color: <?php echo $lb_libertine_vlinkscolor; ?>;
}

#page {
	background-color: <?php echo $lb_libertine_pagebackgroundcolor; ?>;
}

#banner {
	background: <?php echo $lb_libertine_logo; ?> no-repeat left;
	padding: 20px;
	background-position: 10%;
	clear:both;
}

#page #banner h1 a {
	color: <?php echo $lb_libertine_headingscolor; ?>;
}

#menu {
	border-top: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
	border-bottom: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}

#menu ul li a:hover {
	border-bottom: 3px solid <?php echo $lb_libertine_borderscolor; ?>;
}

#content .post-content p img, #content .page-content p img {
	border: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}

#content .post-content p a img, #content .page-content p a img {
	border: 1px solid <?php echo $lb_libertine_linkscolor; ?>;
}

#content .post-content p a:hover img, #content .page-content p a:hover img {
	border: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}

#widgets {
	border-top: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
	border-bottom: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}

#commentlist li {
	border-left: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}

.avatar {
	border: 1px solid <?php echo $lb_libertine_borderscolor; ?>;
}
