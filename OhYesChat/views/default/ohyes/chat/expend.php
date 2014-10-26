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
 ?>
<h2> Chat History Between You and <?php echo $vars['user']->name;?></h2>
<?php
if(empty($vars['messages'])){
	$vars['messages'] = array();
}
?>
<br />
<div class="ohyes-chat-expand" id="ohyes-chat-data-messages-expand">

<?php
foreach($vars['messages'] as $message){
   $sender = $message->sender;
   $icon = elgg_view("icon/default", array(
									'entity' => get_user($sender), 
								    'size' => 'small',
	));
  ?>
  <div class="message-item-expand">
        <div class="icon">
        <?php echo $icon;?>
        </div>
        <div class="message">
        <?php echo OhYesChat::replaceIcon($message->message);?>
        </div>
  </div>
  <?php
}

?>
</div>