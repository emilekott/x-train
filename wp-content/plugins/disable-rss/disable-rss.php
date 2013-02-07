<?php
/*
Plugin Name: Disable RSS
Plugin URI: http://clifgriffin.com/2008/12/02/disable-rss-plugin-for-wordpress
Description:  Disables RSS feeds for a Wordpress installation. Hack suggested by Smashing Magaqzine. (http://www.smashingmagazine.com/2008/12/02/10-useful-rss-hacks-for-wordpress/)
Version: 1.0 
Author: Clifton H. Griffin II
Author URI: http://clifgriffin.com
*/

add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);

function fb_disable_feed() {
	wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

?>
