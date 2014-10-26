<?php
/**
 * university navigation
 */

 
$tabs = array(
	'announce' => array(
		'title' => elgg_echo('university:label:announce'),
		'url' => "university/announce",
		'selected' => $vars['selected'] == 'announce',
	),
	'egram' => array(
		'title' => elgg_echo('university:label:egram'),
		'url' => "university/egram",
		'selected' => $vars['selected'] == 'egram',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
