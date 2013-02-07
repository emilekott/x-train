<?php

/*
Plugin Name: Send link to friend
Description: If the user thought the page link is useful to their friend, he can send the page link via this plug-in.. 
Author: Gopi.R
Version: 5.0
Plugin URI: http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/
Author URI: http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/
Donate link: http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/
*/

function gSendtofriend()
{
	if(is_home() && get_option('gSendtofriend_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('gSendtofriend_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('gSendtofriend_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('gSendtofriend_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('gSendtofriend_On_Search') == 'YES') {	$display = "show";	}
	
	if($display == "show")
	{
		$sendlinks = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
		$_sm = get_option('gSendtofriend_title_sm');
		?>
        <link rel='stylesheet' href='<?php echo get_option('siteurl'); ?>/wp-content/plugins/send-link-to-friend/style.css' type='text/css' />
		<form action="#" name="sendtofriendform" id="sendtofriendform">
		<?php
		if($_sm <> "")
		{
			echo "<div style='padding-top:4px;'>";
			echo $_sm;    
			echo "</div>";
		}
		?>
		<div style='padding-top:4px;'><span id="send-link-to-friend-result"></span></div>
		<div class="gtitle" style='padding-top:4px;'>Recipient's Email</div>
		<div><input name="txt_friendemail" class="gtextbox" type="text" id="txt_friendemail" maxlength="120"></div>
		<div class="gtitle" style='padding-top:4px;'>Enter your message</div>
		<div><textarea name="txt_friendmessage" class="gtextarea" rows="3" id="txt_friendmessage"></textarea></div>
		<div class="gtitle" style='padding-top:4px;'>Enter security code shown below</div>
		<div>
			<input name="txt_captcha" class="gtextbox" type="text" id="txt_captcha" maxlength="6">
		</div>
		<div style='padding-top:4px;'>
		  	<img src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/send-link-to-friend/captcha.php?width=100&height=30&characters=5" />
		</div>
		<div style="padding-top:4px;" ><input type="button" name="button" value="Send Link" onclick="javascript:get(this.parentNode,'<?php echo get_option('siteurl'); ?>/wp-content/plugins/send-link-to-friend/');"></div>
		<input type="hidden" name="sendlink" id="sendlink" value="<?php echo $sendlinks; ?>"  />
		</form>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/send-link-to-friend/send-link-to-friend.js"></script>
		<?php
	}
}

function gSendtofriend_install() 
{

	add_option('gSendtofriend_title', "Send link to Friend");
	add_option('gSendtofriend_title_sm', "If you thought this page is useful to your friend, use this form to send.");
	add_option('gSendtofriend_fromname', "Admin");
	add_option('gSendtofriend_fromemail', "admin@sendtofriend.com");
	add_option('gSendtofriend_On_Homepage', "YES");
	add_option('gSendtofriend_On_Posts', "YES");
	add_option('gSendtofriend_On_Pages', "YES");
	add_option('gSendtofriend_On_Archives', "NO");
	add_option('gSendtofriend_On_Search', "NO");
}

function gSendtofriend_widget($args) 
{
	if(is_home() && get_option('gSendtofriend_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('gSendtofriend_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('gSendtofriend_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('gSendtofriend_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('gSendtofriend_On_Search') == 'YES') {	$display = "show";	}
	
	if($display == "show")
	{
		extract($args);
		echo $before_widget . $before_title;
		echo get_option('gSendtofriend_title');
		echo $after_title;
		gSendtofriend();
		echo $after_widget;
	}
}
	
function gSendtofriend_control() 
{
	echo '<p>Send link to friend.<br> To change the setting go to Send link to friend link under SETTING TAB.';
	echo '<br><a href="options-general.php?page=send-link-to-friend/setting.php">';
	echo 'click here</a>.</p>';
	?>
	<h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>
	Plug-in created by <a target="_blank" href='http://www.gopiplus.com/'>Gopi</a>. <br> 
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to post suggestion or comments or feedback. <br> 
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to see live demo. <br> 
	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to see more info.<br>
	<a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> to download my other plugins. <br> 
	<?php
}

function gSendtofriend_widget_init()
{
  	register_sidebar_widget(__('Send link to friend'), 'gSendtofriend_widget');   
	
	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Send link to friend', 'gSendtofriend_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Send link to friend', 'widgets'), 'gSendtofriend_control', 400, 400);
	} 
}

function gSendtofriend_deactivation() 
{
	//  delete_option('gSendtofriend_title');
	//	delete_option('gSendtofriend_title_sm');
	//  delete_option('gSendtofriend_fromname');
	//	delete_option('gSendtofriend_fromemail');
	//	delete_option('gSendtofriend_On_Homepage');
	//	delete_option('gSendtofriend_On_Posts');
	//	delete_option('gSendtofriend_On_Pages');
	//	delete_option('gSendtofriend_On_Archives');
	//	delete_option('gSendtofriend_On_Search');
}

function gSendtofriend_add_to_menu() 
{
	add_options_page('Send link to friend', 'Send link to friend', 7, "send-link-to-friend/setting.php",'' );
}

add_action('admin_menu', 'gSendtofriend_add_to_menu');
add_action("plugins_loaded", "gSendtofriend_widget_init");
register_activation_hook(__FILE__, 'gSendtofriend_install');
register_deactivation_hook(__FILE__, 'gSendtofriend_deactivation');
add_action('init', 'gSendtofriend_widget_init');
?>