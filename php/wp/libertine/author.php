<?php get_header(); ?>


<!-- This sets the $curauth variable -->
<?php
if(isset($_GET['author_name'])) :
$curauth = get_userdatabylogin($author_name);
else :
$curauth = get_userdata(intval($author));
endif;
?>

<div class="page">
	<h1><?php echo $curauth->nickname; ?></h1>
	<?php echo get_avatar( $curauth->user_email, '80' );?>
	<h3>About:</h3>
	<p><?php echo $curauth->user_description; ?></p>
	<h3>Webpage:</h3>
	<p><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
	<h3>Contacts:</h3>
	<p><?php if($curauth->yim) echo "Yahoo ID: ".$curauth->yim; ?></p>
	<p><?php if($curauth->aim) echo "AIM: ".$curauth->aim; ?></p>
	<p><?php if($curauth->jabber) echo "Jabber/Gtalk: ".$curauth->jabber; ?></p>
	<h3>Latest posts by <?php echo $curauth->nickname; ?>:</h3>
	<!-- The Loop -->
				<?php if (have_posts()) : ?>
				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php query_posts('showposts=5'); ?>
				<?php while (have_posts()) : the_post(); ?>
				<div class="post">
					<h5><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h5>
				</div>
				<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
