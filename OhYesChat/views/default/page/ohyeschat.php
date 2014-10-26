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
header("Content-type: text/html; charset=UTF-8");
$body = elgg_view('page/elements/body', $vars);
$lang = get_current_language();
$messages = OhYesChat::chatSystemMessages();
elgg_unregister_css('elgg');
elgg_load_css('ohyeschat.admin.css');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
<?php echo elgg_view('page/elements/ohyechead', $vars); ?>
</head>
<body>
<div class="ohyeschat-admin-header">
      <div class="left">
          OhYesChat
      </div>
</div>
<div class="ohyeschat-admin-menu-top">
    <div class="items">
       <?php echo OhYesChat::view_menu('admin', 'admin'); ?>
     </div>
</div>
<div class="ohyeschat-admin-container">
<?php if($messages){ ?> 
  <div class="chat-system-message">
      <?php echo $messages;?>
      <div class="system-message-close">
          <a href="<?php echo elgg_get_site_url();?>ohyeschat/admin">X</a>
      </div>
 </div>
 <?php 
}
 echo $body;?>
 </div>
 <div class="footer">
   <div class="data-inner">&copy; <a href="http://www.informatikon.com">iNFORMATIKON TECHNOLOGIES </a>2014.</div>
 </div>
</body>
</html>