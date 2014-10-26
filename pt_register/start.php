<?php


global $ptregister;
if (!isset($ptregister)) {
	$ptregister = new stdClass;
}

elgg_register_event_handler('init', 'system', 'pt_register_init');

/**
* Init the pt_register
*
* @access system
* @return null;
*/
function pt_register_init() {
	//put the terms agreement at the very end
	elgg_extend_view('register/extend', 'pt_register/register', 1000);

	//block user registration if they don't check the box
	elgg_register_plugin_hook_handler('action', 'register', 'pt_register_hook');
	
	run_function_once('pt_register_setup');
}


function pt_register_hook() {

	if (get_input('agreetoterms', false) != 'true') {
		register_error(elgg_echo('registrationterms:required'));
		forward(REFERER);
	}



	//get dropdown 
	$num_links = get_input('num_links');
	
	$username = get_input('username');
	
	
	$pt_user = get_input('pt_user');
	if ($pt_user == null)
	{
		register_error(elgg_echo('register:input:username'));
		forward(REFERER);
	}
	
	$pt_pass = get_input('pt_pass');
	if ($pt_pass == null)
	{
		register_error(elgg_echo('register:input:password'));
		forward(REFERER);
	}
	
	$pt_pass2 = get_input('pt_pass2');
	if ($pt_pass2 == null)
	{
		register_error(elgg_echo('register:input:password2'));
		forward(REFERER);
	}
	/*/======================================================================
		$student = new ElggObject();
		$student->title = $num_links;
		$student->subtype = $username;
		$student->description = $num_links;
		
		$student->save();
	//=====================================================================*/
	
	
	if($pt_pass != $pt_pass2)
	{
		register_error(elgg_echo('registration:verification:pass'));
		forward(REFERER);
	}
	
	$char_contains = array('!', '@',' #', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '?');
	foreach($char_contains  as $char_contain)
	{
		if(strpos($pt_pass, $char_contain) == true )
		{
			register_error(elgg_echo('registration:required:pass'));
			forward(REFERER);
		}
	}
	
	if($num_links != null && $num_links != "Select University"){
	
		ptregister::setdata($num_links, $pt_user, $pt_pass, $username);
		
	}
	
}

function pt_register_setup(){
   $Setup = new ptregister;
   $Setup->Setup();
}
