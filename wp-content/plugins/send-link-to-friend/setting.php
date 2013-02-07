<div class="wrap">
  <h2><?php echo wp_specialchars( 'Send link to friend' ); ?></h2>
  <?php
global $wpdb, $wp_version;

$gSendtofriend_title = get_option('gSendtofriend_title');
$gSendtofriend_title_sm = get_option('gSendtofriend_title_sm');
$gSendtofriend_fromname = get_option('gSendtofriend_fromname');
$gSendtofriend_fromemail = get_option('gSendtofriend_fromemail');
$gSendtofriend_On_Homepage = get_option('gSendtofriend_On_Homepage');
$gSendtofriend_On_Posts = get_option('gSendtofriend_On_Posts');
$gSendtofriend_On_Pages = get_option('gSendtofriend_On_Pages');
$gSendtofriend_On_Search = get_option('gSendtofriend_On_Search');
$gSendtofriend_On_Archives = get_option('gSendtofriend_On_Archives');

if ($_POST['gSendtofriend_submit']) 
{
	$gSendtofriend_title = stripslashes(trim($_POST['gSendtofriend_title']));
	$gSendtofriend_title_sm = stripslashes(trim($_POST['gSendtofriend_title_sm']));
	$gSendtofriend_fromname = stripslashes(trim($_POST['gSendtofriend_fromname']));
	$gSendtofriend_fromemail = stripslashes(trim($_POST['gSendtofriend_fromemail']));
	$gSendtofriend_On_Homepage = stripslashes(trim($_POST['gSendtofriend_On_Homepage']));
	$gSendtofriend_On_Posts = stripslashes(trim($_POST['gSendtofriend_On_Posts']));
	$gSendtofriend_On_Pages = stripslashes(trim($_POST['gSendtofriend_On_Pages']));
	$gSendtofriend_On_Search = stripslashes(trim($_POST['gSendtofriend_On_Search']));
	$gSendtofriend_On_Archives = stripslashes(trim($_POST['gSendtofriend_On_Archives']));
	
	update_option('gSendtofriend_title', $gSendtofriend_title );
	update_option('gSendtofriend_title_sm', $gSendtofriend_title_sm );
	update_option('gSendtofriend_fromname', $gSendtofriend_fromname );
	update_option('gSendtofriend_fromemail', $gSendtofriend_fromemail );
	update_option('gSendtofriend_On_Homepage', $gSendtofriend_On_Homepage );
	update_option('gSendtofriend_On_Posts', $gSendtofriend_On_Posts );
	update_option('gSendtofriend_On_Pages', $gSendtofriend_On_Pages );
	update_option('gSendtofriend_On_Search', $gSendtofriend_On_Search );
	update_option('gSendtofriend_On_Archives', $gSendtofriend_On_Archives );
}

echo '<table width="100%" border="0" cellspacing="5" cellpadding="0">';
echo '<tr>';
echo '<td align="left">';
echo '<form name="form_gSendtofriend" method="post" action="">';
echo '<p>Title:<br><input  style="width: 350px;" type="text" value="';
echo $gSendtofriend_title . '" name="gSendtofriend_title" id="gSendtofriend_title" /></p>';
echo '<p>Small description:<br><input  style="width: 500px;" type="text" value="';
echo $gSendtofriend_title_sm . '" name="gSendtofriend_title_sm" id="gSendtofriend_title_sm" /></p>';
echo '<p>From email name:<br><input  style="width: 350px;" type="text" value="';
echo $gSendtofriend_fromname . '" name="gSendtofriend_fromname" id="gSendtofriend_fromname" /></p>';
echo '<p>From email address:<br><input  style="width: 350px;" type="text" value="';
echo $gSendtofriend_fromemail . '" name="gSendtofriend_fromemail" id="gSendtofriend_fromemail" /></p>';
echo '<p>Display Option:(YES/NO) </p>';
echo '<p>On Homepage:&nbsp;<input  style="width: 100px;" type="text" value="';
echo $gSendtofriend_On_Homepage . '" name="gSendtofriend_On_Homepage" id="gSendtofriend_On_Homepage" />';
echo '&nbsp;On Posts:&nbsp;&nbsp;&nbsp;<input  style="width: 100px;" type="text" value="';
echo $gSendtofriend_On_Posts . '" name="gSendtofriend_On_Posts" id="gSendtofriend_On_Posts" /></p>';
echo '<p>On Pages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 100px;" type="text" value="';
echo $gSendtofriend_On_Pages . '" name="gSendtofriend_On_Pages" id="gSendtofriend_On_Pages" />';
echo '&nbsp;On Search:&nbsp;<input  style="width: 100px;" type="text" value="';
echo $gSendtofriend_On_Search . '" name="gSendtofriend_On_Search" id="gSendtofriend_On_Search" /></p>';
echo '<p>On Archives:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 100px;" type="text" value="';
echo $gSendtofriend_On_Archives . '" name="gSendtofriend_On_Archives" id="gSendtofriend_On_Archives" /></p>';
echo '<input type="submit" id="gSendtofriend_submit" name="gSendtofriend_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />';
echo '</form>';
echo '</td>';
echo '<td align="left">';
echo '</td>';
echo '</tr>';
echo '</table>';

?>
  <h2><?php echo wp_specialchars( 'Paste the below code to your desired template location!' ); ?></h2>
  <div style="padding-top:7px;padding-bottom:7px;"> <code style="padding:7px;"> &lt;?php if (function_exists (gSendtofriend)) gSendtofriend(); ?&gt; </code></div>
  <h2>Special contact</h2>
  <p>If you need any special change/modification in this plug-in, contact:  gopiplus@gmail.com</p>
  <h2><?php echo wp_specialchars( 'About plugin!' ); ?></h2>
  Plug-in created by <a target="_blank" href='http://www.gopiplus.com/work/'>Gopi</a>.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to post suggestion or comments or feedback.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to see plugin live demo.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/'>Click here</a> to see more info.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> To download my other plugins.<br>
  <h2>Donation</h2>
  <p>This plug-in is available under the GPL license, which means  that it's free. If you use it for a commercial web site, if you appreciate my efforts or if you want to encourage me to develop and maintain it, please consider  making a donation using Papal, a secured payment solution. You just need to  click the donate button on the &nbsp;<a href="http://www.gopiplus.com/work/2010/07/18/send-link-to-friend/">plug-in home page</a> and follow the instructions.</p>

</div>
