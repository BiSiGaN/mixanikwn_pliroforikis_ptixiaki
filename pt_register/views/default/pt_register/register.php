<?php
/**
 *
 */

$label = elgg_echo('registrationterms:agree', array(elgg_normalize_url('/terms')));

$input = elgg_view('input/checkbox', array(
	'name' => 'agreetoterms',
	'value' => 'true',
	'required' => TRUE,
	'default' => false,
));
//univercity username
$label_username = elgg_echo("lebel:Select_username");
$input_username = elgg_view('input/text', array(
	'name' => 'pt_user',
	
));

//univercity password
$lebel_password = elgg_echo("lebel:Select_password");
$input_password = elgg_view('input/password', array(
	'name' => 'pt_pass',
	
));

//univercity password again
$lebel_password2 = elgg_echo("lebel:Select_password2");
$input_password2 = elgg_view('input/password', array(
	'name' => 'pt_pass2',
	
));

//univercity dropdown
$label_dropdown = elgg_echo("lebel:Select_University");
$plugin = $vars["entity"];
$input_dropdown = elgg_view('input/dropdown', array(
						
						'name' => 'num_links',
						'value' => $plugin->num_links,
						'options_values' => array(
													"Select University" => elgg_echo("option:Select_University"),
													"tei lamias" => elgg_echo("option:tei_lamias"),
													"tei xalkidas" => elgg_echo("option:tei_xalkidas"),
													"tei patras" => elgg_echo("option:tei_patras"),
													"tei athinas" => elgg_echo("option:tei_athinas"),
													"tei spartis" => elgg_echo("option:tei_spartis")
												)
				));
			
							



?>

<div>
	<label><?php echo "$label_username $input_username"; ?></label>
</div>
<div>
	<label><?php echo "$lebel_password $input_password"; ?></label>
</div>
<div>
	<label><?php echo "$lebel_password2 $input_password2"; ?></label>
</div>
<div>
	<label><?php echo "$label_dropdown $input_dropdown"; ?></label>
</div>

<div>
	<label><?php echo "$input $label"; ?></label>
</div>

