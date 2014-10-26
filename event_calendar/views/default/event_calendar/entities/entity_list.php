<?php
/**
 * View a list of entities
 *
 * @package Elgg
 * @author Curverider Ltd <info@elgg.com>
 * @link http://elgg.com/
 *
 */

$context = $vars['context'];
$offset = $vars['offset'];
$items = $vars['entities'];
$limit = $vars['limit'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];
$context = $vars['context'];
$viewtype = $vars['viewtype'];
$pagination = $vars['pagination'];
$fullview = $vars['fullview'];


if (isset($vars['fullview'])) {
	$vars['full'] = $vars['fullview'];
}

$list_class = 'elgg-list';
$item_class = 'elgg-list-item';

$html = "";
$nav = "";
//var_dump($entities);
if (isset($vars['viewtypetoggle'])) {
	$viewtypetoggle = $vars['viewtypetoggle'];
} else {
	$viewtypetoggle = true;
}

if ($context == "search" && $count > 0 && $viewtypetoggle) {
	$nav .= elgg_view('navigation/viewtype', array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'viewtype' => $viewtype,
	));
}

if ($pagination) {
	$nav .= elgg_view('navigation/pagination',array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
	));
}

$html .= $nav;
if ($viewtype == 'list') {

if (is_array($items) && count($items) > 0) {
	$html .= "<ul class=\"$list_class\">";
	foreach ($items as $item) {
		if (elgg_instanceof($item)) {
			$id = "elgg-{$item->getType()}-{$item->getGUID()}";
		} else {
			$id = "item-{$item->getType()}-{$item->id}";
		}
		$html .= "<li id=\"$id\" class=\"$item_class\">";
		$html .= elgg_view_list_item($item, $vars);
		$html .= '</li>';
	}
	$html .= '</ul>';
}

// 	if (is_array($entities) && sizeof($entities) > 0) {
// 		foreach($entities as $entity) {
// 			$html .= elgg_view_entity($entity, $fullview);
// 		}
// 	}
} else {
	if (is_array($items) && sizeof($items) > 0) {
//		$html .= elgg_view('event_calendar/entities/gallery', array('entities' => $entities));
$num_columns = 4;
?>
<table class="elgg-gallery">
<?php

$col = 0;
foreach ($items as $item) {
	if ($col == 0) {
		echo '<tr>';
	}
	$col++;

	echo '<td>';
	echo elgg_view_list_item($item, $vars);
	echo "</td>";

	if ($col == $num_columns) {
		echo '</tr>';
		$col = 0;
	}
}

if ($col > 0) {
	echo '</tr>';
}

?>

</table>
<?php

	}
}

if ($count) {
	$html .= $nav;
}

echo $html;