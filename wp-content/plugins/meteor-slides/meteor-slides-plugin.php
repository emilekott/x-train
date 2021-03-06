<?php
/*
	Plugin Name: Meteor Slides
	Description: Meteor Slides makes it simple to create slideshows with WordPress by adding a custom post type for slides.
	Plugin URI: http://www.jleuze.com/plugins/meteor-slides
	Author: Josh Leuze
	Author URI: http://www.jleuze.com/
	License: GPL2
	Version: 1.3.1
*/

/*  Copyright 2010 Josh Leuze (email : mail@jleuze.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	// Adds custom post type for Slides
	
	add_action( 'init', 'meteorslides_register_slides' );

	function meteorslides_register_slides() {
	
		$labels = array(
		
			'name'               => __( 'Slides', 'meteor-slides' ),
			'singular_name'      => __( 'Slide', 'meteor-slides' ),
			'add_new'            => __( 'Add New', 'meteor-slides' ),
			'add_new_item'       => __( 'Add New Slide', 'meteor-slides' ),
			'edit_item'          => __( 'Edit Slide', 'meteor-slides' ),
			'edit'               => __( 'Edit', 'meteor-slides' ),
			'new_item'           => __( 'New Slide', 'meteor-slides' ),
			'view_item'          => __( 'View Slide', 'meteor-slides' ),
			'search_items'       => __( 'Search Slides', 'meteor-slides' ),
			'not_found'          => __( 'No slides found', 'meteor-slides' ),
			'not_found_in_trash' => __( 'No slides found in Trash', 'meteor-slides' ), 
			'view'               => __( 'View Slide', 'meteor-slides' ),
			'parent_item_colon'  => ''
			
		);
  
		$args = array(
	
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true, 
			'query_var'          => 'slides',
			'rewrite'            => true,
			'capability_type'    => 'page',
			'hierarchical'       => false,
			'supports'           => array( 'title', 'thumbnail' ),
			'menu_icon'          => ''. plugins_url( '/images/slides-icon-20x20.png', __FILE__ )
		
		);
  
		register_post_type( 'slide', $args );
		
	}
	
	// Adds custom taxonomy for Slideshows
	
	add_action( 'init', 'meteorslides_register_taxonomy' );
	
	function meteorslides_register_taxonomy() {
	
		$labels = array(
				
			'name'              => __( 'Slideshows', 'meteor-slides' ),
			'singular_name'     => __( 'Slideshow', 'meteor-slides' ),
			'search_items'      => __( 'Search Slideshows', 'meteor-slides' ),
			'popular_items'     => __( 'Popular Slideshows', 'meteor-slides' ),
			'all_items'         => __( 'All Slideshows', 'meteor-slides' ),
			'parent_item'       => __( 'Parent Slideshow', 'meteor-slides' ),
			'parent_item_colon' => __( 'Parent Slideshow:', 'meteor-slides' ),
			'edit_item'         => __( 'Edit Slideshow', 'meteor-slides' ),
			'update_item'       => __( 'Update Slideshow', 'meteor-slides' ),
			'add_new_item'      => __( 'Add New Slideshow', 'meteor-slides' ),
			'new_item_name'     => __( 'New Slideshow Name', 'meteor-slides' )
				
		);
		
		$args = array(
	
			'labels'       => $labels,
			'hierarchical' => true,
			'sort'         => true,
			'args'         => array( 'orderby' => 'term_order' ),
			'rewrite'      => array( 'slug' => 'slideshow' )
		
		);
	
		register_taxonomy( 'slideshow', 'slide', $args );
		
	}
	
	// Adds featured image functionality for Slides
	
	add_action( 'after_setup_theme', 'meteorslides_featured_image_array', '9999' );

	function meteorslides_featured_image_array() {
	
		global $_wp_theme_features;

		if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {
		
			$_wp_theme_features['post-thumbnails'] = array( array( 'slide' ) );
			
		}

		elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {
        
			$_wp_theme_features['post-thumbnails'][0][] = 'slide';
			
		}
		
	}
	
	// Adds featured image size for Slides
	
	add_action( 'plugins_loaded', 'meteorslides_featured_image' );
	
	function meteorslides_featured_image() {
		
		$options = get_option( 'meteorslides_options' );
		
		add_image_size( 'featured-slide', $options['slide_width'], $options['slide_height'], true );
		
		add_image_size( 'featured-slide-thumb', 250, 9999 );
	
	}
	
	// Customize and move featured image box to main column
	
	add_action( 'do_meta_boxes', 'meteorslides_image_box' );
	
	function meteorslides_image_box() {
	
		remove_meta_box( 'postimagediv', 'slide', 'side' );
	
		add_meta_box( 'postimagediv', __('Slide Image','meteor-slides'), 'post_thumbnail_meta_box', 'slide', 'normal', 'high' );
	
	}
	
	// Remove permalink metabox
	
	add_action( 'admin_menu', 'meteorslides_remove_permalink_meta_box' );

	function meteorslides_remove_permalink_meta_box() {
	
		remove_meta_box( 'slugdiv', 'slide', 'core' );
	
	}
		
	// Adds meta box for Slide URL
	
	add_action( 'admin_menu', 'meteorslides_create_url_meta_box' );

	$meteorslides_new_meta_box =

		array(
		
			'slide_url' => array(
			
				'name' => 'slide_url',
				'std'  => ''				
			)

		);

	function meteorslides_new_meta_box() {
	
		global $post, $meteorslides_new_meta_box;

		foreach ( $meteorslides_new_meta_box as $meteorslides_meta_box ) {

			$meteorslides_meta_box_value = get_post_meta( $post->ID, $meteorslides_meta_box['name'].'_value', true );  

			if( $meteorslides_meta_box_value == "" ) $meteorslides_meta_box_value = $meteorslides_meta_box['std'];

			echo "<input type='hidden' name='" . $meteorslides_meta_box['name'] . "_noncename' id='" . $meteorslides_meta_box['name'] . " _noncename' value='" . wp_create_nonce( plugin_basename(__FILE__) ) . "' />";

			echo "<input type='text' name='" . $meteorslides_meta_box['name'] . "_value' value='" . $meteorslides_meta_box_value . "' size='55' /><br />";

			echo "<p>" . __('Add the URL this slide should link to.','meteor-slides') . "</p>";

		}

	}

	function meteorslides_create_url_meta_box() {
	
		global $theme_name;

		if ( function_exists('add_meta_box') ) {

			add_meta_box( 'meteorslides-url-box', __('Slide Link','meteor-slides'), 'meteorslides_new_meta_box', 'slide', 'normal', 'low' );

		}

	}
	
	// Save and retrieve the Slide URL data
	
	add_action( 'save_post', 'meteorslides_save_postdata' );

	function meteorslides_save_postdata( $post_id ) {

		global $post, $meteorslides_new_meta_box;

		foreach( $meteorslides_new_meta_box as $meteorslides_meta_box ) {

			if ( !isset( $_POST[$meteorslides_meta_box['name'].'_noncename']  ) || !wp_verify_nonce( $_POST[$meteorslides_meta_box['name'].'_noncename'], plugin_basename(__FILE__) ) ) {

				return $post_id;

			}

			if ( 'page' == $_POST['post_type'] ) {

				if( !current_user_can( 'edit_page', $post_id ) )

				return $post_id;

			}
			
			else {
			
				if( !current_user_can( 'edit_post', $post_id ) )

				return $post_id;

			}

			$data = $_POST[$meteorslides_meta_box['name'].'_value'];

			if ( get_post_meta( $post_id, $meteorslides_meta_box['name'].'_value' ) == "" ) {
			
				add_post_meta( $post_id, $meteorslides_meta_box['name'].'_value', $data, true );
			
			}
			
			elseif ( $data != get_post_meta( $post_id, $meteorslides_meta_box['name'].'_value', true ) ) {

				update_post_meta( $post_id, $meteorslides_meta_box['name'].'_value', $data );
			
			}

			elseif ( $data == "" ) {

				delete_post_meta( $post_id, $meteorslides_meta_box['name'].'_value', get_post_meta( $post_id, $meteorslides_meta_box['name'].'_value', true ) );
			
			}
			
		}

	}
	
	// Adds slide image and link to slides column view
	
	add_filter( 'manage_edit-slide_columns', 'meteorslides_edit_columns' );
 
	function meteorslides_edit_columns( $columns ) {
	
		$columns = array(
		
			'cb'         => '<input type="checkbox" />',
			'slide'      => 'Slide Image',
			'title'      => 'Slide Title',
			'slide-link' => 'Slide Link',
			'date'       => 'Date'

		);
 
		return $columns;
  
	}
	
	add_action( 'manage_posts_custom_column', 'meteorslides_custom_columns' );
	
	function meteorslides_custom_columns( $column ) {
	
		global $post;
 
		switch ( $column ) {
		
			case 'slide' :
			
				echo the_post_thumbnail('featured-slide-thumb');
			
			break;
			
			case 'slide-link' :
			
				if ( get_post_meta($post->ID, "slide_url_value", $single = true) != "" ) {
				
					echo "<a href='" . get_post_meta($post->ID, "slide_url_value", $single = true) . "'>" . get_post_meta($post->ID, "slide_url_value", $single = true) . "</a>";
			
				}  
			
				else {
				
					_e('No Link', 'meteor-slides');
			
				}
			
			break;

		}
		
	}

	// Adds Slideshow settings page
	
	add_action( 'admin_menu', 'meteorslides_menu' );

	function meteorslides_menu() {
		
		add_submenu_page( 'edit.php?post_type=slide', __('Slides Settings', 'meteor-slides'), __( 'Settings', 'meteor-slides' ), 'manage_options', 'slides-settings', 'meteorslides_settings_page' );
		
	}
	
	function meteorslides_settings_page() {
		
		include( 'meteor-slides-settings.php' );
	
	}

	// Adds link to settings page on plugins page
		
	add_filter( 'plugin_action_links', 'meteorslides_settings_link', 10, 2 );
	
	function meteorslides_settings_link( $links, $file ) {
		
		if ( $file == plugin_basename( dirname(__FILE__).'/meteor-slides-plugin.php' ) ) {
		
			$links[] = '<a href="edit.php?post_type=slide&page=slides-settings">'.__( 'Settings', 'meteor-slides' ).'</a>';
	
		}
		
		return $links;
		
	}
	
	// Register options for settings page

	add_action( 'admin_init', 'meteorslides_register_settings' );
	
	function meteorslides_register_settings() {

		register_setting( 'meteorslides_options', 'meteorslides_options' );
		
		add_settings_section( 'meteorslides_slideshow', __( 'Configure Slideshow', 'meteor-slides' ), 'meteorslides_section_text', 'meteorslides' );
		
		add_settings_field( 'slideshow_quantity', __( 'Slideshow Quantity', 'meteor-slides' ), 'slideshow_quantity', 'meteorslides', 'meteorslides_slideshow' );

		add_settings_field( 'slide_height', __( 'Slide Height', 'meteor-slides' ), 'slide_height', 'meteorslides', 'meteorslides_slideshow' );
		
		add_settings_field( 'slide_width', __( 'Slide Width', 'meteor-slides' ), 'slide_width', 'meteorslides', 'meteorslides_slideshow' );

		add_settings_field( 'transition_style', __( 'Transition Style', 'meteor-slides' ), 'transition_style', 'meteorslides', 'meteorslides_slideshow' );

		add_settings_field( 'transition_speed', __( 'Transition Speed', 'meteor-slides' ), 'transition_speed', 'meteorslides', 'meteorslides_slideshow' );

		add_settings_field( 'slide_duration', __( 'Slide Duration', 'meteor-slides' ), 'slide_duration', 'meteorslides', 'meteorslides_slideshow' );
	
		add_settings_field( 'slideshow_navigation', __( 'Slideshow Navigation', 'meteor-slides' ), 'slideshow_navigation', 'meteorslides', 'meteorslides_slideshow' );

	}
	
	// Adds default values for options on settings page
	
	register_activation_hook( __FILE__, 'meteorslides_default_options' );
	
	function meteorslides_default_options() {
	
		$tmp = get_option( 'meteorslides_options' );
		
		if ( ( $tmp['slideshow_quantity']=='' )||( !is_array( $tmp ) ) ) {

			$arr = array(
			
				'slideshow_quantity'   => '5',
				'slide_height'         => '200',
				'slide_width'          => '940',
				'transition_style'     => 'fade',
				'transition_speed'     => '2',
				'slide_duration'       => '5',
				'slideshow_navigation' => 'navnone'
				
			);	
			
			update_option( 'meteorslides_options', $arr );
	
		}

	}
	
	// Validates values for options on settings page
	
	function meteorslides_options_validate( $input ) {

		$options = get_option( 'meteorslides_options' );

		$options['slideshow_quantity'] = trim( $input['slideshow_quantity'] );

		if ( !preg_match( '/^[0-9]{1,3}$/i', $options['slideshow_quantity'] ) ) {

			$options['slideshow_quantity'] = '';

		}
		
		$options['slide_height'] = trim( $input['slide_height'] );

		if ( !preg_match( '/^[0-9]{1,4}$/i', $options['slide_height'] ) ) {

			$options['slide_height'] = '';

		}
		
		$options['slide_width'] = trim( $input['slide_width'] );

		if ( !preg_match( '/^[0-9]{1,5}$/i', $options['slide_width'] ) ) {

			$options['slide_width'] = '';

		}
		
		$options['transition_style'] = trim( $input['transition_style'] );

		if ( !preg_match( '/^[a-z]{4,20}$/i', $options['transition_style'] ) ) {

			$options['transition_style'] = '';

		}
		
		$options['transition_speed'] = trim( $input['transition_speed'] );

		if ( !preg_match( '/^[0-9]{1,3}$/i', $options['transition_speed'] ) ) {

			$options['transition_speed'] = '';

		}
		
		$options['slide_duration'] = trim( $input['slide_duration'] );

		if ( !preg_match( '/^[0-9]{1,3}$/i', $options['slide_duration'] ) ) {

			$options['slide_duration'] = '';

		}
		
		$options['slideshow_navigation'] = trim( $input['slideshow_navigation'] );

		if ( !preg_match( '/^[a-z]{4,20}$/i', $options['slideshow_navigation'] ) ) {

			$options['slideshow_navigation'] = '';

		}

		return $options;
		
	}
	
	// Adds translation support for language files
	
	add_action( 'plugins_loaded', 'meteorslides_localization' );

	function meteorslides_localization() {
		
		load_plugin_textdomain( 'meteor-slides', false, '/meteor-slides/languages/' );
		
	}

	// Adds CSS for the Slides admin pages
	
	add_action( 'admin_enqueue_scripts', 'meteorslides_admin_css' );

	function meteorslides_admin_css() {
		
		global $post_type;
				
		if ( ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'slide' ) || ( isset( $post_type ) && $post_type == 'slide' ) ) {
	
			wp_enqueue_style( 'meteor-slides-admin', plugins_url('/css/meteor-slides-admin.css', __FILE__), array(), '1.0' );
	
		}
		
	}
	
	// Adds CSS for the slideshow
	
	add_action( 'wp_enqueue_scripts', 'meteorslides_css' );

	function meteorslides_css() {
	
		if ( file_exists( get_stylesheet_directory()."/meteor-slides.css" ) ) {
					
			wp_enqueue_style( 'meteor-slides', get_stylesheet_directory_uri() . '/meteor-slides.css', array(), '1.0' );
					
		}
		
		elseif ( file_exists( get_template_directory()."/meteor-slides.css" ) ) {
								
			wp_enqueue_style( 'meteor-slides', get_template_directory_uri() . '/meteor-slides.css', array(), '1.0' );
		
		}
	
		else {
			
			wp_enqueue_style( 'meteor-slides', plugins_url('/css/meteor-slides.css', __FILE__), array(), '1.0' );
		
		}
		
	}
	
	// Adds JavaScript for the slideshow
	
	add_action( 'wp_print_scripts', 'meteorslides_javascript' );
		
	function meteorslides_javascript() {
 		
		$options = get_option( 'meteorslides_options' );
 
		if( !is_admin() ) {
	  
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-cycle', plugins_url( '/js/jquery.cycle.all.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'jquery-metadata', plugins_url( '/js/jquery.metadata.v2.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'meteorslides-script', plugins_url( '/js/slideshow.js', __FILE__ ), array( 'jquery', 'jquery-cycle' ) );
			wp_localize_script( 'meteorslides-script', 'meteorslidessettings',
			
				array(
				
					'meteorslideshowspeed'      => $options['transition_speed'] * 1000,
					'meteorslideshowduration'   => $options['slide_duration'] * 1000,
					'meteorslideshowheight'     => $options['slide_height'],
					'meteorslideshowwidth'      => $options['slide_width'],
					'meteorslideshowtransition' => $options['transition_style']
					
				)
				
			);
			
		}
	
	}
	
	// Adds function to load slideshow in theme
		
	function meteor_slideshow( $slideshow='', $metadata='' ) {
		
		if ( file_exists( get_stylesheet_directory()."/meteor-slideshow.php" ) ) {
					
			include( STYLESHEETPATH . '/meteor-slideshow.php' );
			
		}
		
		elseif ( file_exists( get_template_directory()."/meteor-slideshow.php" ) ) {
								
			include( TEMPLATEPATH . '/meteor-slideshow.php' );
		
		}
	
		else {
			
			include( 'meteor-slideshow.php' );
		
		}
	
	}
		
		/* To load the slideshow, add this line to your theme:
	
			<?php if(function_exists('meteor_slideshow')) { meteor_slideshow(); } ?>
	
		*/
		
	// Adds shortcode to load slideshow in content
	
	function meteor_slideshow_shortcode( $atts ) {
	
		extract( shortcode_atts( array (
		
			'slideshow' => '',
			'metadata'  => '',
			
		), $atts ) );
		
		$slideshow_att = $slideshow;
		
		$metadata_att = $metadata;
	
		ob_start();
		
		meteor_slideshow( $slideshow=$slideshow_att, $metadata=$metadata_att );
		
		$meteor_slideshow_content = ob_get_clean();
		
		return $meteor_slideshow_content;
	
	}
	
	add_shortcode( 'meteor_slideshow', 'meteor_slideshow_shortcode' );
	
		/* To load the slideshow, add this line to your page or post:
	
			[meteor_slideshow]
	
		*/
		
	// Adds widget to load slideshow in sidebar

	add_action( 'widgets_init', 'meteorslides_register_widget' );

	function meteorslides_register_widget() {
	
		register_widget( 'meteorslides_widget' );
	
	}

	class meteorslides_widget extends WP_Widget {

		function meteorslides_widget() {

			$widget_ops = array(
			
				'classname'   => 'meteor-slides-widget',
				'description' => __( 'Add a slideshow widget to a sidebar', 'meteor-slides' )
			
			);

			$control_ops = array( 'id_base' => 'meteor-slides-widget' );

			$this->WP_Widget( 'meteor-slides-widget', __( 'Meteor Slides Widget', 'meteor-slides' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
		
			extract( $args );
						
			$title         = apply_filters( 'widget_title', $instance['title'] );
			$slideshow_arg = $instance['slideshow'];
			$metadata_arg  = $instance['metadata'];

			echo $before_widget;
			
			if ( $title ) {
			
				echo $before_title . $title . $after_title;
				
			}
			
			meteor_slideshow( $slideshow=$slideshow_arg, $metadata=$metadata_arg );

			echo $after_widget;
		
		}

		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			$instance['title']     = strip_tags( $new_instance['title'] );
			$instance['slideshow'] = strip_tags( $new_instance['slideshow'] );
			$instance['metadata']  = strip_tags( $new_instance['metadata'] );

			return $instance;
		
		}
		
		function form( $instance ) {
		
			$defaults = array(
			
				'title'     => '',
				'slideshow' => '',
				'metadata'  => ''
				
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
		
			echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'meteor-slides') . '</label>
			<input type="text" class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" /></p>';

			echo '<p><label for="' . $this->get_field_id( 'slideshow' ) . '">' . __('Slideshow:', 'meteor-slides') . '</label>
			<input type="text" class="widefat" id="' . $this->get_field_id( 'slideshow' ) . '" name="' . $this->get_field_name( 'slideshow' ) . '" value="' . $instance['slideshow'] . '" /></p>';

			echo '<p><label for="' . $this->get_field_id( 'metadata' ) . '">' . __('Metadata:', 'meteor-slides') . '</label>
			<input type="text" class="widefat" id="' . $this->get_field_id( 'metadata' ) . '" name="' . $this->get_field_name( 'metadata' ) . '" value="' . $instance['metadata'] . '" /></p>';
			
		}

	}
	
?>