<?php
/*
Plugin Name: Fluency Admin
Plugin URI: http://deanjrobinson.com/projects/fluency-admin/
Description: Give your WordPress admin the Fluency look, Fluency 2.3.2 is the latest update and is compatible with WP 3.0.x. You can customize Fluency using the options found under 'Fluency Options' in the 'Settings' menu.
Version: 2.3.2
Author: Dean Robinson
Author URI: http://deanjrobinson.com/
Text Domain: fluency-admin
*/ 

define("FLUENCY_VERSION","2.3.2");

/*
 * iPad Detection for custom styles
 */
if(preg_match('/iPad/',$_SERVER['HTTP_USER_AGENT'])) {
	define("FLUENCY_IPAD",true);
} else {
	define("FLUENCY_IPAD",false);
}

/*
 * Setup Fluency Options when plugin is activated
 */
function wp_fluency_init() {
	if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['plugin']) && $_GET['plugin'] == 'wp-fluency-2/wp-fluency-2.php') {
		$key_s = get_option('fluency_login_style');
		$key_l = get_option('fluency_login_logo');
		$key_ll = get_option('fluency_login_link');
		$key_ml = get_option('fluency_menu_logo');
		$key_mw = get_option('fluency_menu_width');
		$key_mp = get_option('fluency_menu_position');
		$key_mi = get_option('fluency_menu_icons');
		$key_cm = get_option('fluency_click_menus');
		$key_hk = get_option('fluency_hot_keys');
		empty($key_s) ? update_option('fluency_login_style', 'true') : null;
		empty($key_l) ? update_option('fluency_login_logo', '') : null;
		empty($key_ll) ? update_option('fluency_login_link', '') : null;
		empty($key_ml) ? update_option('fluency_menu_logo', '') : null;
		empty($key_mw) ? update_option('fluency_menu_width', '') : null;
		empty($key_mp) ? update_option('fluency_menu_position', 'true') : null;
		empty($key_mi) ? update_option('fluency_menu_icons', 'true') : null;
		empty($key_cm) ? update_option('fluency_click_menus', 'false') : null;
		empty($key_hk) ? update_option('fluency_hot_keys', 'true') : null;
	}
}
add_action('init','wp_fluency_init');

/*
 * Add Fluency Stylesheet to admin head
 */
function wp_admin_fluency_css() {
	global $userdata;
	wp_enqueue_style('fluency',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/wp-admin.css', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' );
	$userdata->admin_color == 'classic' ? wp_enqueue_style('fluency-classic-colors',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/classic-colors.css', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' ) : null;
	if($userdata->admin_color == 'coffee') {
		wp_deregister_style('colors');
		wp_enqueue_style('colors-fresh');
		wp_enqueue_style('fluency-coffee-colors',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/coffee-colors.css', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' );
	}
}
add_action('admin_print_styles','wp_admin_fluency_css');

/*
 * Add Style overrides for custom menu width/positioning
 */
function wp_admin_fluency_menu_size() {
	$width = get_option('fluency_menu_width');
	if(!FLUENCY_IPAD && !empty($width) && $width>=140){
		?>
		<style>
			#wpwrap,#footer {border-left-width:<?php echo $width; ?>px;}
			#wpwrap #footer {margin-left:-<?php echo $width; ?>px;}
			#adminmenu,#adminmenu li.wp-has-submenu {width:<?php echo $width; ?>px;}
			#adminmenu a.menu-top {min-width:<?php echo $width-30; ?>px;}
			#adminmenu li.wp-has-submenu.hover {width:<?php echo $width+8; ?>px;}
			#adminmenu li div.wp-submenu {left:<?php echo $width+8; ?>px;}
			#adminmenu .menu-top-last a.menu-top,#adminmenu li a.wp-has-submenu,#adminmenu li.menu-top-first a.wp-has-submenu,#adminmenu li a.menu-top,#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,#adminmenu li.menu-top > a.current,#adminmenu li.wp-first-item.current,#adminmenu li.wp-has-current-submenu,#adminmenu li.menu-top:hover, #adminmenu li.menu-top.hover {background-position:<?php echo $width-280; // $width-140; ?>px bottom;}
			#adminmenu li.menu-top-last a, #adminmenu li.menu-top-last a:hover, #adminmenu li.menu-top .current, #adminmenu li.menu-top .current:hover {background-position:<?php echo $width-14; ?>px -112px;}
			#admin-bar-logo {margin-left:<?php echo $width+10; ?>px;}
		</style>
		<?php
	}
	$pos = get_option('fluency_menu_position');
	if($pos=='false'){ ?><style>#adminmenu{position:absolute;}</style><?php }
	$icons = get_option('fluency_menu_icons');
	if($icons=='false'){ ?><style>#adminmenu li div.wp-menu-image{display:none;}.hiddenMenu #adminmenu li div.wp-menu-image{display:block;}#adminmenu > li > a > #awaiting-mod{right:25px;left:auto;}#adminmenu > li.hover > a > #awaiting-mod{right:33px;left:auto;}</style><?php }
}
add_action('admin_head','wp_admin_fluency_menu_size');

/*
 * Add Styles for click-to-open menus
 */
function wp_admin_fluency_clickmenus() {
	global $userdata;
	wp_enqueue_style('fluency-clickmenus',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/click-menus.css.php'.($userdata->admin_color == 'classic' ? '?classic=true' : ''), $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' );
}
(get_option('fluency_click_menus')=='true' || FLUENCY_IPAD) ? add_action('admin_print_styles','wp_admin_fluency_clickmenus') : null;

/*
 * Add Styles for iPad 'optimised' menus
 */
function wp_admin_fluency_ipadmenus() {
	wp_enqueue_style('fluency-ipadmenus',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/ipad-menus.css', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' );
}
FLUENCY_IPAD ? add_action('admin_print_styles','wp_admin_fluency_ipadmenus') : null;

/*
 * Default script init for Fluency Menus
 */
function wp_admin_default_init() {
	?><script>(function($){$(document).ready(function(){adminMenu={init:function(){}};<?php if(get_option('fluency_click_menus')=='true' || FLUENCY_IPAD) { ?>fluencyClickMenu.init();<?php } else { ?>fluencyHoverMenu.init();<?php if(get_option('fluency_hot_keys')=='true') { ?>fluencyKeys.init();<?php } } ?>});})(jQuery);</script><?php
}
add_action('admin_head','wp_admin_default_init');

/*
 * Add Fluency Javascript to admin footer
 */
function wp_admin_fluency_js() {
	wp_enqueue_script('fluency',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/fluency.js', $deps = array('jquery'), $ver = FLUENCY_VERSION, $in_footer = true );
	get_option('fluency_menu_logo')!='' ? add_action('admin_print_footer_scripts', 'wp_admin_fluency_footer_js') : null;
}
add_action('admin_print_scripts','wp_admin_fluency_js');

/*
 * Prints Script to override WordPress logo above admin menu
 */
function wp_admin_fluency_footer_js(){
	echo '<script>try{document.getElementById("adminmenu").style.backgroundImage = "url(\'' . get_option('fluency_menu_logo') . '\')";}catch(e){}</script>';
}

/*
 * Add Fluency Login Stylesheet to login head
 */
function wp_login_fluency_css() {
	get_option('fluency_login_style')=='true' ? wp_admin_fluency_enqueue_style('fluency-login',WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/wp-login.css', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all' ) : null;
}
add_action('login_head','wp_login_fluency_css');

/*
 * Add Custom Logo to Login page to override WordPress logo
 */
function wp_login_fluency_custom_logo() {
	echo get_option('fluency_login_logo')!='' ? '<style type="text/css">#login h1 a { background-image:url('.get_option('fluency_login_logo').') !important; }</style>' : null;
}
add_action('login_head','wp_login_fluency_custom_logo');

/*
 * Add Custom Link to Logo on Login page
 */
function wp_login_fluency_custom_link($link) {
	return get_option('fluency_login_link')!='' ? get_option('fluency_login_link') : $link;
}
add_filter('login_headerurl','wp_login_fluency_custom_link');

/*
 * Function that mimics the core wp_enqueue_style function which doesn't appear to work on the login page
 */
function wp_admin_fluency_enqueue_style($handle='',$file='', $deps = array(), $ver = FLUENCY_VERSION, $media = 'all') {
	echo '<link rel="stylesheet" id="' . $handle . '-css" href="' . $file . '?version=' . $ver .'" type="text/css" media="' . $media . '" />'."\n";
}

/*
 * Adds Fluency information to wp-admin footer
 */
function wp_fluency_footer(){
	echo '<span id="fluency-footer"><a href="http://deanjrobinson.com/projects/fluency-admin/">Fluency Admin '.FLUENCY_VERSION.'</a> '.__('is a plugin by', 'fluency-admin').' <a href="http://deanjrobinson.com">Dean Robinson</a> - <a href="http://deanjrobinson.com/donate/">'.__('Donate', 'fluency-admin').'</a></span><br/>';
}
add_action('in_admin_footer','wp_fluency_footer',1000);

/*
 * Adds Akismet Link to the Comments menu in addtion to the item under Dashboard
 */
function wp_fluencycomments_akismet_stats_page() {
	( function_exists('add_submenu_page') && function_exists('akismet_init') ) ? add_submenu_page('edit-comments.php', __('Akismet Stats', 'fluency-admin'), __('Akismet Stats', 'fluency-admin'), 'manage_options', 'akismet-stats-display', 'akismet_stats_display') : null;
}
add_action('admin_menu','wp_fluencycomments_akismet_stats_page');

/*
 * Fluency Admin Options Save
 */
function wp_fluency_options_save() {
	if(wp_verify_nonce($_REQUEST['_wp_fluency_nonce'],'fluency-admin')) {
		if ( isset($_POST['submit']) ) {
			( function_exists('current_user_can') && !current_user_can('manage_options') ) ? die(__('Cheatin&#8217; uh?', 'fluency-admin')) : null;
			isset($_POST['fluency_login_style']) ? update_option('fluency_login_style', 'true') : update_option('fluency_login_style', 'false');
			isset($_POST['fluency_login_logo']) ? update_option('fluency_login_logo', strip_tags($_POST['fluency_login_logo'])) : update_option('fluency_login_logo', '');
			isset($_POST['fluency_login_link']) ? update_option('fluency_login_link', strip_tags($_POST['fluency_login_link'])) : update_option('fluency_login_link', '');
			isset($_POST['fluency_menu_logo']) ? update_option('fluency_menu_logo', strip_tags($_POST['fluency_menu_logo'])) : update_option('fluency_menu_logo', '');
			isset($_POST['fluency_menu_width']) ? update_option('fluency_menu_width', strip_tags($_POST['fluency_menu_width'])) : update_option('fluency_menu_width', '');
			isset($_POST['fluency_menu_position']) ? update_option('fluency_menu_position', 'true') : update_option('fluency_menu_position', 'false');
			isset($_POST['fluency_menu_icons']) ? update_option('fluency_menu_icons', 'true') : update_option('fluency_menu_icons', 'false');
			isset($_POST['fluency_click_menus']) ? update_option('fluency_click_menus', 'false') : update_option('fluency_click_menus', 'true');
			isset($_POST['fluency_hot_keys']) ? update_option('fluency_hot_keys', 'true') : update_option('fluency_hot_keys', 'false');
		}
	}
}
isset($_REQUEST['_wp_fluency_nonce']) ? add_action('admin_init','wp_fluency_options_save') : null;

/*
 * Fluency Admin Options Page
 */
function wp_fluency_options_page() {
	if ( !empty($_POST) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'fluency-admin') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php _e('Fluency Admin Options', 'fluency-admin'); ?></h2>
	<form action="" method="post" id="fluency-options">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php _e('Fluency Login Style', 'fluency-admin'); ?></th>
					<td><label><input name="fluency_login_style" id="fluency_login_style" value="true" type="checkbox" <?php if ( get_option('fluency_login_style') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Style the WordPress login to match the rest of the Fluency Admin theme.', 'fluency-admin'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><label for="fluency_login_logo"><?php _e('Login screen custom logo', 'fluency-admin'); ?></label></th>
					<td>
						<input type="text" class="regular-text" value="<?php if ( get_option('fluency_login_logo') != '' ) echo get_option('fluency_login_logo'); ?>" id="fluency_login_logo" name="fluency_login_logo"/>
						<div class="description"><?php _e('Specify the full URL for your chosen image, for best results use an image that is <strong>250px wide</strong>, and <strong>50px high</strong>.', 'fluency-admin'); ?></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fluency_login_link"><?php _e('Login screen custom link', 'fluency-admin'); ?></label></th>
					<td>
						<input type="text" class="regular-text" value="<?php if ( get_option('fluency_login_link') != '' ) echo get_option('fluency_login_link'); ?>" id="fluency_login_link" name="fluency_login_link"/>
						<div class="description"><?php _e('Specify the URL that your custom logo will link through to.', 'fluency-admin'); ?></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fluency_menu_logo"><?php _e('Custom logo (top of menu)', 'fluency-admin'); ?></label></th>
					<td>
						<input type="text" class="regular-text" value="<?php if ( get_option('fluency_menu_logo') != '' ) echo get_option('fluency_menu_logo'); ?>" id="fluency_menu_logo" name="fluency_menu_logo"/>
						<?php $c_width = ( get_option('fluency_menu_width') != '' ) ? get_option('fluency_menu_width') : '140'; ?>
						<div class="description"><?php _e("Specify the full URL for your chosen image, for best results use an image that is <strong>{$c_width}px wide</strong>, and <strong>50px high</strong>.", 'fluency-admin'); ?></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fluency_menu_width"><?php _e('Custom menu width', 'fluency-admin'); ?></label></th>
					<td>
						<input type="text" class="small-text" maxlength="3" value="<?php if ( get_option('fluency_menu_width') != '' ) echo get_option('fluency_menu_width'); ?>" id="fluency_menu_width" name="fluency_menu_width"/> px
						<div class="description"><?php _e('If you find that some menu items are wrapping across multiple lines you can increase the width of the menu.<br/>Default is 140px. <strong>Leave empty to reset.</strong>', 'fluency-admin'); ?></div>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Fixed position menu', 'fluency-admin'); ?></th>
					<td><label><input name="fluency_menu_position" id="fluency_menu_position" value="true" type="checkbox" <?php if ( get_option('fluency_menu_position') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable if you have lots of plugins that add menu items, or a small screen.', 'fluency-admin'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Menu item icons', 'fluency-admin'); ?></th>
					<td><label><input name="fluency_menu_icons" id="fluency_menu_icons" value="true" type="checkbox" <?php if ( get_option('fluency_menu_icons') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable to hide icons from expanded menu.', 'fluency-admin'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Hover menus', 'fluency-admin'); ?></th>
					<td><label><input name="fluency_click_menus" id="fluency_click_menus" value="true" type="checkbox" <?php if ( get_option('fluency_click_menus') != 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Disable to switch back to the click-to-open style menus while retaining the Fluency look.', 'fluency-admin'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('Menu Hot Keys', 'fluency-admin'); ?></th>
					<td><label><input name="fluency_hot_keys" id="fluency_hot_keys" value="true" type="checkbox" <?php if ( get_option('fluency_hot_keys') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable if you encounter a conflict with another plugin, or if you just need them.', 'fluency-admin'); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php _e('iPad \'friendly\' menus', 'fluency-admin'); ?></th>
					<td><?php _e('Tada! No setting needed for this, just visit your wp-admin on your iPad and you\'ll get the \'finger-friendly\' menus instantly.<br/>Note: Hover menus are auto-disabled on the iPad... because you can\'t, um, hover.', 'fluency-admin'); ?></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<?php wp_nonce_field('fluency-admin','_wp_fluency_nonce'); ?>
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Save Changes', 'fluency-admin'); ?>" />
		</p>
	</form>
</div>
<?php
}

/*
 * Add Fluency Admin Options Page to Settings menu
 */
function wp_fluency_options_menu() {
	function_exists('add_submenu_page') ? add_options_page(__('Fluency Options', 'fluency-admin'), __('Fluency Options', 'fluency-admin'), 'manage_options', 'fluency-options', 'wp_fluency_options_page') : null;
}
add_action('admin_menu','wp_fluency_options_menu');

/*
 * Add Contextual Help to Fluency Admin Options Page
 */
function wp_fluency_options_help() {
	add_contextual_help('settings_page_fluency-options',
	'<p>' . __('If you find any bugs, or any conflicts with other plugins please report them via one of the links below.', 'fluency-admin') . '</p>' .
	'<p>' . __('If you have any feature requests, please send them via one of the support links below.', 'fluency-admin') . '</p>' .
	'<p><strong>' . __('For support:', 'fluency-admin') . '</strong></p>' .
	'<p>' . __('<a href="http://wordpress.org/tags/fluency-admin?forum_id=10" target="_blank">Fluency support on the WordPress.org support forums</a>', 'fluency-admin') . '</p>' .
	'<p>' . __('<a href="http://help.deanjrobinson.com/groups/fluency-admin/" target="_blank">Fluency support on help.deanjrobinson.com</a>', 'fluency-admin') . '</p>' .
	'<p><strong>' . __('For more information:', 'fluency-admin') . '</strong></p>' .
	'<p>' . __('<a href="http://wordpress.org/extend/plugins/fluency-admin/" target="_blank">Fluency Admin on WordPress.org</a>', 'fluency-admin') . '</p>' .
	'<p>' . __('<a href="http://deanjrobinson.com/projects/fluency-admin/" target="_blank">Homepage for Fluency Admin</a>', 'fluency-admin') . '</p>'
	);
}
add_action('admin_init','wp_fluency_options_help');

/*
 * Registers Additional Fluency Admin color schemes
 */
function wp_fluency_register_admin_color_schemes() {
	wp_admin_css_color('coffee', __('Coffee', 'fluency-admin'), WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/coffee-colors.css', array('#301E0F', '#907E6F', '#FCEADB', '#ECDACB'));
	// wp_admin_css_color('light', __('Light', 'fluency-admin'), WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/resources/light-colors.css', array('#C6C6C6', '#D3D3D3', '#F1F1F1', '#DFDFDF'));
	// Light scheme coming soon...
}
add_action('admin_init','wp_fluency_register_admin_color_schemes',100);

/*
 * Load TextDomain for translations
 */
function wp_fluency_textdomain() { // l10n
	load_plugin_textdomain( 'fluency-admin', 'wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/languages', '' . plugin_basename(dirname(__FILE__)) . '/languages' );
}
add_action('admin_init','wp_fluency_textdomain');

?>