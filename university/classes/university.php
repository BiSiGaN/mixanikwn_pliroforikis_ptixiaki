<?php
/**

 */ 

class university{



/**
* Data Add
*
* @access system
* @return return;
*/

public static function Data($query, $type){
    global $CONFIG;	
	$query = str_replace('prefixes_', $CONFIG->dbprefix, $query);
	if(!empty($query) && $type == 'get'){
	  return get_data($query);	
	}
	if(!empty($query) && $type == 'delete'){
	  return delete_data($query);	
	}
	if(!empty($query) && $type == 'add'){
	  return insert_data($query);	
	}
	if(!empty($query) && $type == 'run'){
	  return run_sql_script($query);	
	}
}

public static function getdata(){
		global $CONFIG;	
	 	$username = elgg_get_logged_in_user_entity()->username;
		
		$get = "SELECT * FROM {$CONFIG->dbprefix}pt_register 
		WHERE(username='{$username}');";
		
		return university::Data($get, 'get');

}



}//class
