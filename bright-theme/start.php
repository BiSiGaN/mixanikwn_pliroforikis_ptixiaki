<?php
elgg_register_event_handler('init', 'system', 'bright_theme_init');

function bright_theme_init() {
  elgg_unregister_menu_item('topbar', 'elgg_logo');
  // Replace the default index page
    register_plugin_hook('index','system','new_index');
	$username = elgg_get_logged_in_user_entity();
	
	elgg_register_menu_item('topbar', array(
			'name' => 'username',
			'href' => "profile/{$username->username}",
			'text' =>  "$username->username",
			'style' => 'font-size:18px;',
			'priority' => 1,
   ));
	
}

 function new_index() {
    if (!include_once(dirname(dirname(__FILE__)) . "/bright-theme/index.php"))
        return false;
 
    return true;
}


?>
