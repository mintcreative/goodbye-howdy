<?php
/*
Plugin Name: Goodbye, Howdy
Plugin URI: 
Description: Change the Howdy message in the WordPress admin toolbar to anything you like. Use the Goodbye Howdy Settings to change your message.
Author: Jim Richards
Author URI: http://mintcreative.github.io
Version: 1.0
*/



// function to create / register a settings page for the wp admin menu

function howdy_plugin_settings() {

    add_menu_page('Goodbye Howdy Settings', 'Goodbye Howdy Settings', 'administrator', 'goodbye_howdy_settings', 'howdy_display_settings');

}




// define the content of the settings page
function howdy_display_settings() {


	// put the message setting into a variable
	// if nothing there, set a default value
    $mymsg = (get_option('howdy_msg') != '') ? get_option('howdy_msg') : 'Welcome back';

    // define html for the form, to be rendered on the plugin options page

    $html = '<div class="wrap">
<form action="options.php" method="post" name="options">
<h2>Enter your message text</h2>
<h4>...you don&#39;t need to add a comma at the end.</h4>
' . wp_nonce_field('update-options') . '
<table class="form-table" width="100%" cellpadding="10">
<tbody>
<tr>
<td scope="row" align="left">
 <label>Message:</label><input type="text" name="howdy_msg" value="' . $mymsg . '" /></td>
</tr>
</tbody>
</table>
 <input type="hidden" name="action" value="update" />

 <input type="hidden" name="page_options" value="howdy_msg" />

 <input type="submit" name="Submit" value="Update" />
 </form>
 <p><small>The text you enter here will be displayed in the top right-hand corner of the admin pages.</small></p>
 </div>
';

    echo $html;

}



// add settings page to admin menu using admin_menu action hook
add_action('admin_menu', 'howdy_plugin_settings');




// main function for plugin, get_option the message and then print it in wp_admin_bar
// credit to wpbeginner.com for the original wp_admin_bar code
// http://bit.ly/1sowAa2

function wp_admin_bar_custom_howdy( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$printwhat = get_option('howdy_msg');
$howdy = $printwhat;
$howdy .= ", ";
$howdy .= $current_user->display_name;
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}

// add our custom message to admin_bar_menu hook
add_action( 'admin_bar_menu', 'wp_admin_bar_custom_howdy', 11 );