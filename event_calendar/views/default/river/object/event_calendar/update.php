<?php

	$performed_by = get_entity($vars['item']->subject_guid); 
	$object = get_entity($vars['item']->object_guid);
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("event_calendar:river:updated"),$url) . " ";
	$string .= elgg_echo("event_calendar:river:the_event")." <a href=\"" . $object->getURL() . "\">" . $object->title . "</a>";
    
?>

<?php echo $string; ?>