<?php
/**
 * university plugin intialization
 */

global $university;
if (!isset($university)) {
	$university = new stdClass;
}


elgg_register_event_handler('init', 'system', 'university_init');

/**
 * Initialize page handler and site menu item
 */
function university_init() {
	elgg_register_page_handler('university', 'university_page_handler');

	$item = new ElggMenuItem('university', elgg_echo('university'), 'university');
	elgg_register_menu_item('site', $item);
	
	/**
	 * JS, CSS and Views
	 */
	// CSS
	elgg_extend_view('css/elgg', 'css/table');
}

/**
 * university page handler
 *
 * @param array $page url segments
 * @return bool
 */
function university_page_handler($page) {
	$base = elgg_get_plugins_path() . 'university/pages/university';

	if (!isset($page[0])) {
		$page[0] = 'announce';
	}

	$vars = array();
	$vars['page'] = $page[0];

	
		require_once "$base/index.php";
	
	return true;
}
