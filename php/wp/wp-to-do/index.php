<?php
/*
    Plugin Name: To Do
    Plugin URI: http://wordpress.org/extend/plugins/wp-to-do/
    Description: A full featured module for creating and management a "to do" list.
    Version: 3.0
    Author: Stas Sushkov and Levente Varga
    Author URI: http://stas.nerd.ro/
*/
?>
<?php
/*  Copyright 2008  Stas Sushkov, Levente Varga (email: stas@nerd.ro, levi@ramblingbyte.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

/*
 * Some initialisations
 */
$wptodo_domain = "wptodo";

/**
 * Creating database tables and the rest of needed stuff
 */
function wptodo_install() {
	global $wpdb;
	// where and what we will store - db structure
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wptodo_comments_table = $wpdb->prefix . "wptodo_comments";
	
	$wptodo_structure = "
	CREATE TABLE IF NOT EXISTS $wptodo_table (
		`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
		`date` DATE NOT NULL ,
		`title` TEXT NOT NULL ,
		`desc` TEXT NOT NULL ,
		`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
		`for` BIGINT( 20 ) UNSIGNED NOT NULL DEFAULT '0',
		`until` DATE NOT NULL ,
		`status` TINYINT( 1 ) NOT NULL DEFAULT '0',
		`priority` TINYINT( 1 ) NOT NULL DEFAULT '0',
		`notify` BINARY NOT NULL DEFAULT '0',
		PRIMARY KEY ( `id` )
	) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	
	$wptodo_comments_structure = "
	CREATE TABLE IF NOT EXISTS $wptodo_comments_table (
		`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
		`date` DATE NOT NULL ,
		`task` BIGINT( 20 ) UNSIGNED NOT NULL ,
		`body` TEXT NOT NULL ,
		`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
		PRIMARY KEY ( `id` )
	) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	
	// Sending all this to mysql queries
	$wpdb->query($wptodo_structure);
	$wpdb->query($wptodo_comments_structure);
	$today_date = gmdate('Y-m-d');
	// Popullating newly created table with 1st task
	$wpdb->query("INSERT INTO $wptodo_table(`id`, `date`, `title`, `desc`, `from`, `for`, `until`, `status`, `priority`, `notify`)
				VALUES(NULL, '$today_date', 'Your first task!', 'Send some feedback to authors.', 1, 0, '0000-00-00', 0, 0, 0)");
	$wpdb->query("INSERT INTO $wptodo_comments_table(`id`, `date`, `task`, `body`, `from`)
				VALUES(NULL, '$today_date', '1', 'This comment can be deleted as the task it belongs to.', '1')");
}

/**
 * Table drop if removing wptodo
 */
function wptodo_deinstall() {
	global $wpdb;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wpdb->query("DROP TABLE IF EXISTS `$wptodo_table`");
}

/**
 * Users id -> nicename
 */
function wptodo_from($raw_from) {
	if(is_int($raw_from) && ($raw_from != '0')) {
		$from = get_userdata($raw_from);
		return $from->display_name;
	}
	else if (is_string($raw_from)) {
		$from = get_userdata($raw_from);
		return $from->ID;
	}
	else return "Nobody";
}

/**
 * Displaying a nicer date
 */
function wptodo_date($raw_date) {
	if($raw_date != "0000-00-00") {
		return mysql2date(get_option('date_format'), $raw_date); //Let's use wordpress prefered date settings
	}
	else return "Not set";
}

/**
 * Displaying a nicer status
 */
function wptodo_status($raw_status) {
	switch ($raw_status) {
	default: return "New";
	case 1: return "Open";
	case 2: return "Buggy";
	case 3: return "Solved";
	case 4: return "Closed";
	}
}

/**
 * Displaying a nicer priority
 */
function wptodo_priority($raw_priority) {
	switch ($raw_priority) {
	default: return "Normal";
	case 0: return "Low";
	case 2: return "High";
	case 3: return "Important";
	}
}

/**
 * Displaying a nicer notice
 */
function wptodo_notice($raw_notice) {
	switch ($raw_notice) {
	default: return "No";
	case 1: return "Yes";
	}
}

/**
 * Add a task to db
 */
function wptodo_addtask($newdata) {
	global $wpdb;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$today_date = gmdate('Y-m-d');
	$wptodo_query = "INSERT INTO `".$wptodo_table."` (`id`, `date`, `title`, `desc`, `from`, `for`, `until`,`status`,`priority`,`notify`)
					VALUES (NULL , '$today_date', '".$newdata['wptodo_title']."','".$newdata['wptodo_description']."','".$newdata['wptodo_from']."','0','".$newdata['wptodo_deadline']."','".$newdata['wptodo_status']."','".$newdata['wptodo_priority']."','".$newdata['wptodo_notify']."')";
	$wpdb->query($wptodo_query);
}

/**
 * Update a task
 */
function wptodo_updatetask($newdata) {
	global $wpdb;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wptodo_query = "UPDATE `".$wptodo_table."` SET `title`='".$newdata['wptodo_title']."', `desc`='".$newdata['wptodo_description']."', `for`='".$newdata['wptodo_for']."', `until`='".$newdata['wptodo_deadline']."', `status`='".$newdata['wptodo_status']."', `priority`='".$newdata['wptodo_priority']."', `notify`='".$newdata['wptodo_notify']."' WHERE `id`='".$newdata['wptodo_taskid']."'";
	$wpdb->query($wptodo_query);
}

/**
 * Delete a task
 */
function wptodo_deletetask($id) {
	global $wpdb;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wptodo_comments_table = $wpdb->prefix . "wptodo_comments";
	$wpdb->query("DELETE FROM `".$wptodo_table."` WHERE `id`=$id");
	$wpdb->query("DELETE FROM `".$wptodo_comments_table."` WHERE `task`=$id");
	wptodo_manage_main("");
}

/**
 * Add a comment
 */
function wptodo_addcomment($newdata) {
	global $wpdb;
	$wptodo_comments_table = $wpdb->prefix . "wptodo_comments";
	$today_date = gmdate('Y-m-d');
	$wpdb->query("INSERT INTO $wptodo_comments_table(`id`, `date`, `task`, `body`, `from`)
				VALUES(NULL, '$today_date', '".$newdata['wptodo_comment_task']."', '".$newdata['wptodo_comment_body']."', '".$newdata['wptodo_comment_author']."')");
}

/**
 * Edit a task
 */
function wptodo_edit($id) {
	global $wpdb;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wptodo_edit_item = $wpdb->get_results("SELECT * FROM `$wptodo_table` WHERE `id`=$id");
	if(!$wptodo_edit_item) {
		echo'<div class="wrap"><h2>There is no such task to edit. Please add one first.</h2></div>';
	}
	else {
?>
	<div class="wrap">
		<h2><?php _e("Edit task #$id", 'wptodo'); ?></h2>
		<div class="narrow">
		<form name="updatetask" id="updatetask" action="" method="post">
			<input name="wptodo_updatetask" id="wptodo_updatetask" value="true" type="hidden" />
			<input name="wptodo_taskid" id="wptodo_taskid" value="<?php echo $id; ?>" type="hidden" />
			<table>
			<tbody><tr>
				<th width="33%"><label for="wptodo_title">Title:</label></th>
				<td width="67%"><input name="wptodo_title" id="wptodo_title" value="<?php echo $wptodo_edit_item['0']->title; ?>" size="40" type="text" /></td>
			</tr>
			<tr>
				<th><label for="wptodo_description">Description:</label></th>
				<td><textarea name="wptodo_description" id="wptodo_description" rows="5" cols="40"><?php echo $wptodo_edit_item['0']->desc; ?></textarea></td>
			</tr>
			<tr>
				<th width="33%"><label for="wptodo_date">Since:</label></th>
				<td width="67%"><?php echo $wptodo_edit_item['0']->date; ?> (<?php echo wptodo_date($wptodo_edit_item['0']->date); ?>)</td>
			</tr>
			<tr>
				<th width="33%"><label for="wptodo_deadline">Deadline:</label></th>
				<td width="67%"><input name="wptodo_deadline" id="wptodo_deadline" value="<?php echo $wptodo_edit_item['0']->until; ?>" type="text" /><a href="#cal" id="wptodo_cal">Show calendar</a></td>
			</tr>
			<tr>
				<th width="33%"><label for="wptodo_for">Assigned to:</label></th>
				<td width="67%">
					<?php $for=$wptodo_edit_item['0']->for; wp_dropdown_users("name=wptodo_for&selected=$for"); ?>
				</select>
				</td>
			</tr>
			<tr>
			<th><label for="wptodo_status">Status:</label></th>
				<td>
	  			<select name="wptodo_status" id="wptodo_status" class="postform">
				<option value="0" <?php if ($wptodo_edit_item['0']->status == 0) echo "selected=\"selected\""; ?> >New</option>
				<option value="1" <?php if ($wptodo_edit_item['0']->status == 1) echo "selected=\"selected\""; ?> >Open</option>
				<option value="2" <?php if ($wptodo_edit_item['0']->status == 2) echo "selected=\"selected\""; ?> >Buggy</option>
				<option value="3" <?php if ($wptodo_edit_item['0']->status == 3) echo "selected=\"selected\""; ?> >Solved</option>
				<option value="4" <?php if ($wptodo_edit_item['0']->status == 4) echo "selected=\"selected\""; ?> >Closed</option>
				</select>
	  			</td>
			</tr>
			<th><label for="wptodo_priority">Priority:</label></th>
				<td>
	  			<select name="wptodo_priority" id="wptodo_priority" class="postform">
				<option value="0" <?php if ($wptodo_edit_item['0']->priority == 0) echo "selected=\"selected\""; ?> >Low</option>
				<option value="1" <?php if ($wptodo_edit_item['0']->priority == 1) echo "selected=\"selected\""; ?> >Normal</option>
				<option value="2" <?php if ($wptodo_edit_item['0']->priority == 2) echo "selected=\"selected\""; ?> >High</option>
				<option value="3" <?php if ($wptodo_edit_item['0']->priority == 3) echo "selected=\"selected\""; ?> >Important</option>
				</select>
	  			</td>
			</tr>
			<tr>
			<th><label for="wptodo_notify">Send alerts through email?</label></th>
				<td>
					<input name="wptodo_notify" id="wptodo_notify" value="1" <?php if ($wptodo_edit_item['0']->notify == 1) echo "checked=\"checked\""; ?> type="checkbox" />
				</td>
			</tr>
			</tbody></table>
			<p class="submit">
				<input name="wptodo_deletetask" value="Delete Task" type="submit" />
				<input name="Submit" value="Update Task" type="submit" />
			</p>
		</form>
		</div>
	</div>
<? }
}

/**
 * View a task
 */
function wptodo_view($id) {
	global $wpdb, $user_ID;
	$wptodo_table = $wpdb->prefix . "wptodo";
	$wptodo_comments_table = $wpdb->prefix . "wptodo_comments";
	$wptodo_view_item = $wpdb->get_results("SELECT * FROM `$wptodo_table` WHERE `id`=$id");
	$wptodo_view_item_comments = $wpdb->get_results("SELECT * FROM `$wptodo_comments_table` WHERE `task`=$id");
	if(!$wptodo_view_item) {
		echo'<div class="wrap"><h2>There is no such task to edit. Please add one first.</h2></div>';
	}
	else {
?>
	<div class="wrap">
		<h2><?php _e("View task #$id", 'wptodo'); ?></h2>
		<div class="narrow">
			<p><h3><?php echo $wptodo_view_item['0']->title; ?></h3></p>
			<p class="alternate"><?php echo $wptodo_view_item['0']->desc; ?></p>
			<p><small>By <strong><?php echo wptodo_from((int)$wptodo_view_item['0']->from); ?></strong> on <em><?php echo wptodo_date($wptodo_view_item['0']->date); ?></em> until <em><?php echo wptodo_date($wptodo_view_item['0']->until); ?></em>, currently assigned to <em><strong><?php echo wptodo_from((int)$wptodo_view_item['0']->for); ?></strong></em></small></p>
			<?php if($wptodo_view_item_comments) { 
					echo "<h3>Comments</h3>"; 
					$wptodo_counted = count($wptodo_view_item_comments);
					$c = 0;
					echo '<p><ol>';
					while ($c != $wptodo_counted) {
						echo '<li><p>'.$wptodo_view_item_comments["$c"]->body.'</p>
						<small>On '.wptodo_date($wptodo_view_item_comments["$c"]->date).' by '.wptodo_from((int)$wptodo_view_item_comments["$c"]->from).'</small></li>';
						$c++;
					}
					echo '</ol></p>';
			}?>
			<h3>Submit a comment</h3>
			<form action="" id="wptodo_addnewcomment" method="post">
				<input name="wptodo_comment_author" type="hidden" value="<?php echo $user_ID; ?>" />
				<input name="wptodo_comment_task" type="hidden" value="<?php echo $wptodo_view_item['0']->id; ?>" />
				<p><textarea cols="40" rows="5" name="wptodo_comment_body" id="wptodo_comment_body"></textarea></p>
				<p class="submit"><input name="wptodo_comment_submit" id="wptodo_comment_submit" value="Add Comment" type="submit"></p>
			</form>
		</div>
	</div>
<? }
}

/**
 * Main admin page
 */
function wptodo_manage_main($wptodo_filter_status) {
	global $wpdb, $user_ID;
	$wptodo_table = $wpdb->prefix . "wptodo";
?>
	<div class="wrap">
		<h2><?php _e("To Do Management", 'wptodo'); ?></h2>
		<h3><?php printf(__('Analyze tasks or <a href="%1$s">add a new one</a>', 'wptodo'),"#addnewtodo"); ?></h3>
		<form name="wptodo_filter_status" id="wptodo_filter_status" action="" method="post">
			<p>Task Status:
				<select name="wptodo_filter_status">
					<option <?php if($wptodo_filter_status == "") echo 'selected="selected"'; ?> value="">Any</option>
					<option <?php if($wptodo_filter_status == "0") echo 'selected="selected"'; ?> value="0">New</option>
					<option <?php if($wptodo_filter_status == "1") echo 'selected="selected"'; ?> value="1">Open</option>
					<option <?php if($wptodo_filter_status == "2") echo 'selected="selected"'; ?> value="2">Buggy</option>
					<option <?php if($wptodo_filter_status == "3") echo 'selected="selected"'; ?> value="3">Solved</option>
					<option <?php if($wptodo_filter_status == "4") echo 'selected="selected"'; ?> value="4">Closed</option>
				</select>
			<input id="wptodo_filter_status_submit" value="Filter »" class="button" type="submit" />
			</p>
		</form>
		<br style="clear: both;">
		<table class="widefat">
		  <thead>
		  <tr>
		    <th scope="col">ID</th>
		    <th scope="col">Title</th>
		    <th scope="col">Submitter</th>
			<th scope="col">Asigned to</th>
			<th scope="col">Added on</th>
			<th scope="col">Deadline</th>
			<th scope="col">Status</th>
			<th scope="col">Priority</th>
			<th scope="col">Notify</th>
		  </tr>
		  </thead>
		  <?php
		  		if($wptodo_filter_status == "") $wptodo_manage_items = $wpdb->get_results("SELECT * FROM $wptodo_table ORDER BY `priority` DESC");
				else $wptodo_manage_items = $wpdb->get_results("SELECT * FROM $wptodo_table WHERE `status`=$wptodo_filter_status ORDER BY `priority` DESC");
		  		$wptodo_counted = count($wptodo_manage_items);
		  		$num = 0;
		  		while($num != $wptodo_counted) {
		  			echo "<tbody><tr>";
		  			echo "<td>".$wptodo_manage_items[$num]->id."</td>";
		  			echo "<td><span style=\"float:right; display: inline;\">(<a href=\"?page=wptodo&edit=".$wptodo_manage_items[$num]->id."\">Edit</a>)</span><a href=\"?page=wptodo&view=".$wptodo_manage_items[$num]->id."\">".$wptodo_manage_items[$num]->title."</a></td>";
		  			echo "<td>".wptodo_from((int)$wptodo_manage_items[$num]->from)."</td>"; //we have to send int not strings
		  			echo "<td>".wptodo_from((int)$wptodo_manage_items[$num]->for)."</td>";
					echo "<td>".wptodo_date($wptodo_manage_items[$num]->date)."</td>";
		  			echo "<td>".wptodo_date($wptodo_manage_items[$num]->until)."</td>";
		  			echo "<td>".wptodo_status($wptodo_manage_items[$num]->status)."</td>";
		  			echo "<td>".wptodo_priority($wptodo_manage_items[$num]->priority)."</td>";
		  			echo "<td>".wptodo_notice($wptodo_manage_items[$num]->notify)."</td>";
		  			echo "</tr></tbody>";
		  			echo "";
		  			$num++;
		  		}
		  ?>
		</table>
		<h3 id="addnewtodo"><?php _e("Add a new To Do", 'wptodo'); ?></h3>
		<div class="narrow">
		<form name="addnewtask" id="addnewtask" action="" method="post">
			<input name="wptodo_addtask" id="wptodo_addtask" value="true" type="hidden" />
			<input name="wptodo_from" id="wptodo_from" value="<?php echo $user_ID; ?>" type="hidden" />
			<table>
			<tbody><tr>
				<th width="33%"><label for="wptodo_title">Title:</label></th>
				<td width="67%"><input name="wptodo_title" id="wptodo_title" value="" size="40" type="text" /></td>
			</tr>
			<tr>
				<th><label for="wptodo_description">Description:</label></th>
				<td><textarea name="wptodo_description" id="wptodo_description" rows="5" cols="40"></textarea></td>
			</tr>
			<tr>
				<th width="33%"><label for="wptodo_deadline">Deadline:</label></th>
				<td width="67%"><input name="wptodo_deadline" id="wptodo_deadline" value="0000-00-00" type="text" /><a href="#cal" id="wptodo_cal">Show calendar</a></td>
			</tr>
			<tr>
			<th><label for="wptodo_status">Status:</label></th>
				<td>
	  			<select name="wptodo_status" id="wptodo_status" class="postform">
				<option value="0">New</option>
				<option value="1">Open</option>
				<option value="2">Buggy</option>
				<option value="3">Solved</option>
				<option value="4">Closed</option>
				</select>
	  			</td>
			</tr>
			<th><label for="wptodo_priority">Priority:</label></th>
				<td>
	  			<select name="wptodo_priority" id="wptodo_priority" class="postform">
				<option value="0">Low</option>
				<option value="1">Normal</option>
				<option value="2">High</option>
				<option value="3">Important</option>
				</select>
	  			</td>
			</tr>
			<tr>
			<th><label for="wptodo_notify">Send alerts through email?</label></th>
				<td>
					<input name="wptodo_notify" id="wptodo_notify" value="1" type="checkbox" />
				</td>
			</tr>
			</tbody></table>
			<p class="submit"><input name="Submit" value="Add Task" type="submit"></p>
		</form>
		</div>
	</div>
<?php }

/**
 * Admin CP manage page
 */
function wptodo_manage() {
	global $wpdb, $user_ID;
	$wptodo_table = $wpdb->prefix . "wptodo";
	if($_POST['wptodo_addtask'] && $_POST['wptodo_title']) wptodo_addtask($_POST); //If we have a new task let's add it
	if($_POST['wptodo_updatetask']) wptodo_updatetask($_POST); //Update my task
	if($_POST['wptodo_comment_task']) wptodo_addcomment($_POST); //Add comments to tasks
	if($_POST['wptodo_filter_status'] != NULL) wptodo_manage_main($_POST['wptodo_filter_status']); 
	if($_POST['wptodo_deletetask']) wptodo_deletetask($_POST['wptodo_taskid']); //Update my task
	if($_GET['view']) wptodo_view($_GET['view']);
	else if($_GET['edit']) wptodo_edit($_GET['edit']);
	else wptodo_manage_main("");
 }

/**
 * Admin CP options page
 */
function wptodo_options() {
?>
	<div class="wrap">
		<h2><?php _e("To Do Options", 'wptodo'); ?></h2>
	</div>
<?php }

/**
 * Admin CP pages
 */
function wptodo_options_page() {
	add_options_page(__('To Do', 'wptodo'), __('To Do', 'wptodo'), 1, 'wptodo', 'wptodo_options');
}
function wptodo_manage_page() {
	add_management_page(__('To Do', 'wptodo'), __('To Do', 'wptodo'), 1, 'wptodo', 'wptodo_manage');
}


/**
 *  Internationalization (i18n)
 */
load_plugin_textdomain($wptodo_domain, $wptodo_domainPath . '/i18n' );

/**
 *	Hooks
 */
register_activation_hook(__FILE__,'wptodo_install');
add_action('admin_menu', 'wptodo_options_page');
add_action('admin_menu', 'wptodo_manage_page');
?>