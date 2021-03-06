<?php
/**
 * OhYesChat
 * @website Link: https://github.com/lianglee/OhYesChat
 * @Package Ohyes
 * @subpackage Chat
 * @author Liang Lee
 * @copyright All right reserved Liang Lee 2014.
 * @ide The Code is Generated by Liang Lee php IDE.
 */ 

global $OhYesChat;
if (!isset($OhYesChat)) {
	$OhYesChat = new stdClass;
}

elgg_register_event_handler('init', 'system', 'OhYesChat');
/**
* Init the OhYesChat
*
* @access system
* @return null;
*/
function OhYesChat(){
   $plugin = elgg_get_plugins_path().'OhYesChat/';
   elgg_register_simplecache_view('css/ohyes/ohyeschat');
   $ohyescss = elgg_get_simplecache_url('css', 'ohyes/ohyeschat');
   elgg_register_css('ohyeschat.css', $ohyescss);
   
   elgg_register_simplecache_view('css/ohyes/ohyeschat.admin');
   $ohyescssadmin = elgg_get_simplecache_url('css', 'ohyes/ohyeschat.admin');
   elgg_register_css('ohyeschat.admin.css', $ohyescssadmin);
      
   elgg_register_simplecache_view('js/ohyes/ohyescha');
   $ohyesjs = elgg_get_simplecache_url('js', 'ohyes/ohyeschat');
   elgg_register_js('ohyeschat.js', $ohyesjs);
   
   if(elgg_is_logged_in()){
   elgg_register_page_handler('ohyeschat', 'ohyeschat_page_handler');
   elgg_register_page_handler('chat', 'ohyeschat_page_handler');
   }
   elgg_register_action('ohyes/chat/deletemssages', "{$plugin}actions/admin/deletemssages.php", 'admin');
   
   elgg_extend_view('page/elements/foot', 'ohyes/chat/bar');
   elgg_extend_view('page/elements/body', 'ohyes/header/chat', 1);
   elgg_extend_view('page/elements/body', 'ohyes/chat/sound');

   OhYesChat::loadCss();
   OhYesChat::loadJs();
   
   run_function_once('ohyeschat_setup');
   
   
   //register menu items
    OhYesChat::RegisterMenus();
	
}
/**
 * OhYesChat Page Setup;
 *  URLs take the form of
 *  Boot:       ohyeschat/boot/ohyeschat.boot.js
 *  Notifications:    ohyeschat/notif
 *  Freinds:   ohyeschat/friends
 *  New tab : ohyeschat/newtab
 *  actions:       {
 *      Send Message:        oyeschat/action/send
 *      Refresh the tab:       ohyeschat/action/refresh
 *      Remove the tab :    ohyeschat/action/removetab/<id of tab>
 *
 * Title is ignored
 *
 *
 * @param array $page
 * @return bool
 */
function ohyeschat_page_handler($page){
	$plugin = elgg_get_plugins_path().'OhYesChat/';
	if(!isset($page[0])){
			if(elgg_is_admin_logged_in()){	
		       $page[0] = 'admin';
			} 
			else {
			 forward();	
			}
			
	}
	$user = elgg_get_logged_in_user_entity();
	if(empty($user->username)){
	   return false;	
	}
	switch ($page[0]) {
        case 'admin':
	if(elgg_is_admin_logged_in()){	
		   if(empty($page[1])){
		 	include_once("{$plugin}pages/admin/dashboard.php");		
		   } 
		   else {
		    if($page[1] == 'track'){
			 include_once("{$plugin}pages/admin/trackuser.php");		
			}
		   if($page[1] == 'getuser'){
			 include_once("{$plugin}pages/admin/getuser.php");		
			}
			   
		   }
	}
		break;
 		
		case 'smilies':
		 	echo elgg_view('ohyes/chat/smiles/similes', array(
															  'tab' => get_input('uid')
															  ));	
		break;
		case 'messages':
		 	$user = $page[1];
			if(!empty($user)){
			 $var['user'] = get_user_by_username($user);
			 $var['owner'] = elgg_get_logged_in_user_entity()->guid;
			 $var['messages'] = array_reverse(OhYesChat::getMessages($var['user']->guid ,$var['owner']));
			 $params['content'] = elgg_view('ohyes/chat/expend', $var);	
			 $body = elgg_view_layout('one_sidebar', $params);
	         echo elgg_view_page($params['title'], $body);
				
			}
		break;
        
		case 'boot':
		if($page[1] == 'ohyeschat.boot.js'){
		    header('Content-Type: text/javascript');
			  echo elgg_view('js/ohyes/chat');
		}
        break;
		case 'notif':
		    header('Content-Type: application/json'); 
			$messages = elgg_view('ohyes/chat/messages');
			if(empty($messages)){
			   $messages = '<p style="padding:10px;">'.elgg_echo('ohyes:chat:no:message').'</p>';				   
		     }
		    echo json_encode(array(
							   'messages' => $messages,
							   'count' => ''
							));
        break;
		case 'friends':
		    header('Content-Type: application/json'); 
		    echo json_encode(array(             
								 'friends' =>  elgg_view('ohyes/chat/friends', array(
													   'entity' => elgg_get_logged_in_user_entity()
													   ))
								 ));
        break;

        case 'newtab':
		header('Content-Type: application/json'); 
		if(empty($page[1])){
		     exit;	
		} 
		else {
	      if(!in_array($page[1], $_SESSION['ohyes_chat'])){ 		
		      $_SESSION['ohyes_chat'][] = $page[1];
		   }
		}
			$login = elgg_get_logged_in_user_entity()->guid;
		    $friend = get_user($page[1]);
			$messages = OhYesChat::getMessages($login, $page[1]);
			foreach(array_reverse($messages) as $umessages){
			  $icon = elgg_view("icon/default", array(
														'entity' => get_user($umessages->sender), 
														'size' => 'small',
									));	
			  $user_msgs[] = elgg_view('ohyes/chat/message-item', array(
																			   'icon' => $icon,
																			   'message' => OhYesChat::replaceIcon($umessages->message),
																			   'sender' => $umessages->sender,
																			   ));	
			}
		    $tab =  elgg_view('ohyes/chat/selectfriend', array(
													   'friend' => $friend,
													   ));
			$messages = implode('', $user_msgs);
			
			echo json_encode(array(
								   'tab' => $tab,
								   'messages' => $messages
								   ));

			global $CONFIG;	
            update_data("UPDATE {$CONFIG->dbprefix}ohyes_chat 
						 SET view='1' WHERE(sender='$page[1]' 
			             AND reciever='{$login}');");
        break;
		
		case 'action':
		if(empty($page[1]) || !in_array($page[1], OhYesChat::actions())){
		     exit;	
		}
		if($page[1] == 'send'){	
			require_once("{$plugin}actions/send.php");
		}
		if($page[1] == 'refresh'){	
           exit; //removed in 1.1 release; $arsalanshah;
	     }
		
		 if($page[1] == 'removetab'){
			        $uid = array_search($page[2],  $_SESSION['ohyes_chat']);
			        unset($_SESSION['ohyes_chat'][$uid]);
			        echo 'removed';
		}
		
        break;	  
		case 'mobile':
		    if (elgg_is_active_plugin('OhYesChat_Mobile') && OhYesChat::FromMobile()) {
               elgg_trigger_plugin_hook('ohyeschat', 'mobile', $page);  
             } 
			 else {
			  forward();	 
			 }
		break;
	   default:
			return false;
	}
	return true;
}
/**
* Setup Chat;
*
* @access system
* @return null;
*/
function ohyeschat_setup(){
   $Setup = new OhYesChat;
   $Setup->Setup();
}