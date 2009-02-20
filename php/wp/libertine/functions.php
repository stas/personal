<?php
$themename = "Libertine";
$shortname = "lb";
$options = array (

    array(    "name" => "Libertine logo",
            "id" => $shortname."_libertine_logo",
            "std" => "url(img/logo.jpg)",
            "type" => "text"),

    array(    "name" => "Libertine background color",
            "id" => $shortname."_libertine_backgroundcolor",
            "std" => "#FFFFFF",
            "type" => "text"),
            
    array(    "name" => "Libertine page background color",
            "id" => $shortname."_libertine_pagebackgroundcolor",
            "std" => "#FFFFFF",
            "type" => "text"),
            
    array(    "name" => "Libertine background image",
            "id" => $shortname."_libertine_backgroundimage",
            "std" => "url(img/63989.png)",
            "type" => "text"),
    
    array(    "name" => "Libertine font color",
            "id" => $shortname."_libertine_color",
            "std" => "#31312F",
            "type" => "text"),
    
    array(    "name" => "Libertine headings color",
            "id" => $shortname."_libertine_headingscolor",
            "std" => "#5BAF4B",
            "type" => "text"),
    
    array(    "name" => "Libertine links color",
            "id" => $shortname."_libertine_linkscolor",
            "std" => "#1997D1",
            "type" => "text"),

    array(    "name" => "Libertine visited links color",
            "id" => $shortname."_libertine_vlinkscolor",
            "std" => "#6D6A5B",
            "type" => "text"),

    array(    "name" => "Libertine borders color",
            "id" => $shortname."_libertine_borderscolor",
            "std" => "#5BAF4B",
            "type" => "text"),
);

function libertine_add_admin() {
    global $themename, $shortname, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {   
        if ( 'save' == $_REQUEST['action'] ) {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
                header("Location: themes.php?page=functions.php&saved=true");
                die;
        } else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] ); }
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_theme_page($themename." Options", "Libertine Theme Options", 'edit_themes', basename(__FILE__), 'libertine_admin');
}

function libertine_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>


<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<form method="post">
<table class="optiontable">
	<?php foreach ($options as $value) {
		if ($value['type'] == "text") { ?>   
			<tr valign="top"> 
				<th scope="row"><?php echo $value['name']; ?>:</th>
				<td>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
				</td>
			</tr>
	<?php } 
		elseif ($value['type'] == "select") { ?>
			<tr valign="top"> 
				<th scope="row"><?php echo $value['name']; ?>:</th>
				<td>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
						<?php foreach ($value['options'] as $option) { ?>
						<option><?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
	<?php } 
	} ?>
</table>
	<p class="submit">
		<input name="save" type="submit" value="Save changes" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>
<form method="post">
	<p class="submit">
		<input name="reset" type="submit" value="Reset" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<?php
}
function libertine_wp_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php }

//add_action('wp_head', 'libertine_wp_head');
add_action('admin_menu', 'libertine_add_admin'); 

//WIDGETS!!!

if (function_exists('register_sidebar'))
{
register_sidebar(array(
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	'name' => 'Left sidebar'
));

register_sidebar(array(
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	'name' => 'Middle sidebar'
));

register_sidebar(array(
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	'name' => 'Right sidebar'
));
}

?>
