<?php
function initJavascript(){

    add_theme_support( 'nav-menus' );

    //navigation
    register_nav_menu( 'main-menu', 'The main menu shown in the header.' );
    register_nav_menu( 'tuition-menu', 'The tuition menu which is shown below the main menu.' );
    register_nav_menu( 'footer-col-1', 'Footer col 1.' );
    register_nav_menu( 'footer-col-2', 'Footer col 2.' );
    register_nav_menu( 'footer-col-3', 'Footer col 3.' );
    register_nav_menu( 'footer-col-4', 'Footer col 4.' );
    register_nav_menu( 'footer-col-5', 'Footer col 5.' );
    register_nav_menu( 'footer-col-6', 'Footer col 6.' );
    register_nav_menu( 'course-detail-mnu', 'Menu shown under form on course details pages.' );

    if(!is_admin()):
        
    //javascript
    wp_register_script('cufon',get_bloginfo('stylesheet_directory').'/js/cufon.js');
    wp_register_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
    wp_register_script('font-1',get_bloginfo('stylesheet_directory').'/js/captureit.font.js');
    //wp_register_script('font-2',get_bloginfo('stylesheet_directory').'/js/franklingothicdemi.font.js');
    wp_register_script('font-3',get_bloginfo('stylesheet_directory').'/js/myriadpro.font.js');
    //wp_register_script('font-4',get_bloginfo('stylesheet_directory').'/js/franklingothicmedium.font.js');
    wp_register_script('themefunctions',get_bloginfo('stylesheet_directory').'/js/themefunctionality.js');
    wp_register_script('jqueryui',get_bloginfo('stylesheet_directory').'/js/jqueryui/js/jquery-ui-1.8.7.custom.min.js');
    wp_register_script('jqlb',get_bloginfo('stylesheet_directory').'/js/fancybox/jquery.fancybox-1.3.4.pack.js');

    wp_enqueue_script('cufon');
    wp_enqueue_script('jquery');
    wp_enqueue_script('font-1');
    //wp_enqueue_script('font-2');
    wp_enqueue_script('font-3');
    //wp_enqueue_script('font-4');
    wp_enqueue_script('themefunctions');
    wp_enqueue_script('jqueryui');
    wp_enqueue_script('jqlb');

    //styles
    wp_register_style('jsb',get_bloginfo('stylesheet_directory').'/js/jsb/jquery.sb.css');

    wp_enqueue_style('jsb');

    

    endif;

    //custom post type - testimonial
    register_post_type( 'xtrain_testimonial',
        array(
          'labels' => array(
            'name' => __( 'Testimonials' ),
            'singular_name' => __( 'Testimonial' )
          ),
          'public' => true
        )
    );
        
}

add_filter("manage_edit-xtrain_testimonial_columns", "testimonial_columns");
    function testimonial_columns(){
        $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => "Customer / Location"
	    );
	    return $columns;
    }

function getCustomField($theField,$apply_the_content_filter=true,$echo=true) {
	global $post;
	$block = get_post_meta($post->ID, $theField);
	if($block){
		foreach(($block) as $blocks) {
                        if($apply_the_content_filter):
                            $output = apply_filters('the_content',$blocks);
                        else:
                            $output = $blocks;
                        endif;
                        if($echo):
                            echo $output;
                        else:
                            return $output;
                        endif;
		}
	}
}



//setup images
add_theme_support( 'post-thumbnails', array('page') );
add_image_size('homepage-banner',959,267);
add_image_size('content-banner-small',959,136);

add_action('init','initJavascript');

 class Custom_Walker_List_Pages extends Walker_Page {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'page';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this.
	 * @var array
	 */
	var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='children'>\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el(&$output, $page, $depth, $args, $current_page) {

  		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
			$_current_page = get_page( $current_page );
			if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current_page_item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}

		$css_class = implode(' ', apply_filters('page_css_class', $css_class, $page));

                //custom for xtrain
                $hideatag = false;
                if($page->post_parent==11): $hideatag = true; endif;
                //end custom

		$output .= $indent . '<li class="' . $css_class . ($hideatag ? ' submnu-itemheading-nohref' : '') .'">'.($hideatag ? '<span>':'<a href="' . get_page_link($page->ID) . '" title="' . esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) ) . '">' ). $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after .($hideatag ? '</span>':'</a>');

		if ( !empty($show_date) ) {
			if ( 'modified' == $show_date )
				$time = $page->post_modified;
			else
				$time = $page->post_date;

			$output .= " " . mysql2date($date_format, $time);
		}
	}

	/**
	 * @see Walker::end_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output, $page, $depth) {
		$output .= "</li>\n";
	}

}

function get_courses($course_category_page_id = false)
{
        global $wpdb;
	$proba_metavalues = $wpdb->get_results("SELECT post_id,menu_order,post_title FROM $wpdb->postmeta LEFT JOIN wp_posts wpp ON(ID = post_id) WHERE meta_key = '_wp_page_template' AND meta_value = 'page-coursedetail.php' AND post_status='publish' ORDER BY menu_order");
       
       
        foreach($proba_metavalues as $course):
          $row = get_post($course->post_id);
          if($course_category_page_id):
              if($row->post_parent==$course_category_page_id):
                  $courses[] = $row;
              endif;
          else:
              if($row->post_parent):
                  $courses[$row->post_parent]['courses'][] = $row;
                  $courses[$row->post_parent]['course_category'] = get_post($row->post_parent);
              endif;
          endif;
        endforeach;
        return $courses;
}

function output_course_select($default_text = 'Please select...',$isheaderdropdown=false,$classes = false){
    global $wpdb;
    $courses = $wpdb->get_results("SELECT post_id,wp1.menu_order,wp1.post_title,wp1.post_parent FROM wp_posts wp1 LEFT JOIN wp_postmeta ON(wp1.ID = post_id) WHERE meta_key = '_wp_page_template' AND meta_value = 'page-coursedetail.php' AND wp1.post_parent > 0 ORDER BY (SELECT wp2.menu_order FROM wp_posts wp2 WHERE wp1.post_parent = wp2.ID),wp1.post_parent,wp1.menu_order, wp1.post_title");
    
    ?>
    <select name="course" class="selectbox<?=$classes ? ' '.$classes : ''?>" <?=$isheaderdropdown ? 'onChange="if(jQuery(this).val()){ window.location = jQuery(this).val(); }"':''?>>
       <option value=""><?=$default_text?></option>



       <?php
       foreach($courses as $c){
            if($lastparent!=$c->post_parent){
                $parentpost = get_post($c->post_parent);
                if($lastparent>0){
                    echo '</optgroup>';
                }
                echo '<optgroup label="'.$parentpost->post_title.'">';
            }
            $lastparent = $c->post_parent;

            $hidecourse = get_post_meta($c->post_id, 'Hide Course');
            if(!$hidecourse):
                ?><option value="<?=$isheaderdropdown ? get_permalink($c->post_id) : $c->post_title?>" <?=$_GET['course_title']==$c->post_title?'selected="selected"':''?>><?=$c->post_title?></option><?php
            endif;

        }
        echo '</optgroup>';
       ?>








   </select>
    <?php
}

function bookingform(){ ob_start();
    ?>
<script>
    jQuery(document).ready(function(){
        $dateField = jQuery("input[name=date_of_course]");
        $dateField.datepicker({ dateFormat: 'dd-mm-yy' });
        jQuery('#triggerDatePicker').click(function(){
            $dateField.focus();
        });

        jQuery('.xtrainform').submit(function(){
            var formError = 0;
            jQuery('.reqfield').each(function(index,element){
                var rowObj = jQuery(this);
                if(rowObj.val()==''){
                    formError++;
                    rowObj.addClass('fieldError');
                } else {
                    rowObj.removeClass('fieldError');
                }
            });
            if(formError>0){
                return false;
            }
        });

        <?php if($_GET['bookingrequest']): ?>
           alert("Thanks, your booking request has been received. We will be in touch shortly.");
        <?php endif ?>

    });
</script>
<form action="" method="post" class="xtrainform">


    <div class="bookingform-col">
        <div class="bookingform-col-top"></div>
        <div class="bookingform-col-mid">
            <span class="form-req"><span class="required-field">*</span> Required Fields</span>
            <h4>Your Course</h4>

            <div class="booking-form-row">
                <strong>Course: <span class="required-field">*</span></strong>
                <span class="booking-select"><?php output_course_select(false,false,'reqfield') ?></span>
            </div>

            <div class="booking-form-row">
                <strong>Desired Date: <span class="required-field">*</span></strong>
                <input type="text" class="reqfield" name="date_of_course" value="<?=filter_var($_GET['course_date'],FILTER_SANITIZE_STRING)?>" />  <img src="<?php bloginfo('stylesheet_directory') ?>/images/calendar.gif" alt="Select a date" style="cursor:pointer; margin-bottom: -3px" id="triggerDatePicker" />
            </div>

            <?php if(count($_GET['extra_fields'])>0): ?>
            <?php foreach($_GET['extra_fields'] as $field_name => $field_selected_value):
                 echo '<div class="booking-form-row">';
                    echo '<strong>'.urldecode($field_name).':</strong>';
                    echo '<span class="booking-select selectbox"><select name="extras['.$field_name.']">';
                        $menopts = explode('|',$_GET['extra_fields_orig'][$field_name]);
                        foreach($menopts as $mopt):
                            echo '<option value="'.urldecode($mopt).'"'.($field_selected_value==$mopt ? ' selected="selected"' : '').'>'.urldecode($mopt).'</option>';
                        endforeach;
                    echo '</select></span>';
                 echo '</div>';
            endforeach ?>
        <?php endif ?>

        </div>
        <div class="bookingform-col-bot"></div>
    </div>

    <div class="bookingform-col">
        <div class="bookingform-col-top"></div>
        <div class="bookingform-col-mid">
            <span class="form-req"><span class="required-field">*</span> Required Fields</span>
            <h4>About You</h4>
            
            <div class="booking-form-row">
                <strong>Age: <span class="required-field">*</span></strong>
                <input type="text" name="age" class="reqfield" style="width: 100px !important" />
            </div>
            
            <div class="booking-form-row">
                <strong>Title: <span class="required-field">*</span></strong>
                <span class="booking-select"><select name="title" class="selectbox reqfield" style="width: 100px !important">
                   <option value="">Please select...</option>
                   <option value="Mr">Mr</option>
                   <option value="Mrs">Mrs</option>
                   <option value="Ms">Ms</option>
               </select></span>
            </div>

            <div class="booking-form-row">
                <strong>First Name: <span class="required-field">*</span></strong>
                <input type="text" name="first_name" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>Last Name: <span class="required-field">*</span></strong>
                <input type="text" name="last_name" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>Address:</strong>
                <input type="text" name="address_1" /><br />
               <input type="text" name="address_2" /><br />
               <input type="text" name="address_3" />
            </div>

            <div class="booking-form-row">
                <strong>Postcode:</strong>
                <input type="text" name="postcode" />
            </div>
            
            <div class="booking-form-row">
                <strong>Telephone Number: <span class="required-field">*</span></strong>
                <input type="text" name="tel" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>Mobile Number: <span class="required-field">*</span></strong>
                <input type="text" name="mobile" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>Email: <span class="required-field">*</span></strong>
                <input type="text" name="email" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>Confirm Email: <span class="required-field">*</span></strong>
                <input type="text" name="confirm_email" class="reqfield" />
            </div>

            <div class="booking-form-row">
                <strong>How did you hear about us? <span class="required-field">*</span></strong>
                <span class="booking-select"><select name="where_did_you_hear_about_us" class="selectbox reqfield">
                   <option value="">Please select...</option>
                   <option value="Ad (please specify below)">Ad (please specify below)</option>
                   <option value="Been before">Been before</option>
                   <option value="Tourist info">Tourist info</option>
                   <option value="Brochure">Brochure</option>
                   <option value="Other (please specify below)">Other (please specify below)</option>
               </select></span>
            </div>

        </div>
        <div class="bookingform-col-bot"></div>
    </div>

    

    <div class="clear"></div>
                <input type="image" style="float:right; margin: 15px 18px 0px 0px;" value="Go" src="<?php bloginfo('stylesheet_directory') ?>/images/btn-send-booking.png" name="submit" />
                <input type="hidden" name="formgo" value="1" />
                <input type="hidden" name="formsource" value="booking" />
    <div class="clear"></div>
</form>
    <?php $var = ob_get_contents();
ob_clean();
return $var;
}
add_shortcode('bookingform', 'bookingform');

//process booking form
if($_POST['formgo']&&$_POST['formsource']=='booking'){

    foreach($_POST as $name => $unsanitised_value):
        if($name!='extras'):
            $sanitised_post[filter_var($name,FILTER_SANITIZE_STRING)] = filter_var($unsanitised_value,FILTER_SANITIZE_STRING);
        endif;
    endforeach;
    foreach($_POST['extras'] as $ext_label => $ext_val):
            $sanitised_post[filter_var($ext_label,FILTER_SANITIZE_STRING)] = filter_var($ext_val,FILTER_SANITIZE_STRING);
    endforeach;

    $form_labels['course'] = 'Course';
    $form_labels['date_of_course'] = 'Date of course';
    foreach($_POST['extras'] as $ext_label => $ext_val):
        $form_labels[filter_var($ext_label,FILTER_SANITIZE_STRING)] = filter_var(urldecode($ext_label),FILTER_SANITIZE_STRING);
    endforeach;
    $form_labels['age'] = 'Age';
    $form_labels['title'] = 'Title';
    $form_labels['first_name'] = 'First name';
    $form_labels['last_name'] = 'Last name';
    $form_labels['address_1'] = 'Address';
    $form_labels['address_2'] = '';
    $form_labels['address_3'] = '';
    $form_labels['postcode'] = 'Postcode';
    $form_labels['tel'] = 'Tel';
    $form_labels['mobile'] = 'Mobile';
    $form_labels['email'] = 'Email';
    $form_labels['confirm_email'] = 'Confirm Email';
    $form_labels['where_did_you_hear_about_us'] = 'Where did you hear about us?';

    $eml_contents = array();

    foreach($sanitised_post as $name=>$row):
        if(isset($form_labels[$name])):
            $eml_contents[] = $form_labels[$name].($form_labels[$name] ? ': ' : '').$row;
        endif;
    endforeach;

    $email_contents = 'New booking application:'."\n-----------------------------------\n";
    $email_contents .= implode("\n",$eml_contents)."\n-----------------------------------\n";
    $email_contents .= "";

    $addr = get_bloginfo('admin_email');
    $subj = "[X-Train] Booking Request";
    $headers = 'From: '. $sanitised_post['email'];

    ini_set("sendmail_from", $sanitised_post['email']);

    wp_mail($addr,$subj,$email_contents,$headers);

    header('Location: '.$_SERVER['REQUEST_URI'].'?&bookingrequest=done');

    exit;

}

//process newletter form
if($_POST['formgo']&&$_POST['formsource']=='newslettersubscribe'){

    foreach($_POST as $name => $unsanitised_value):
        $sanitised_post[$name] = filter_var($unsanitised_value,FILTER_SANITIZE_STRING);
    endforeach;

    $eml_contents[] = "Name: ".$sanitised_post['sub_n'];
    $eml_contents[] = "Email Address: ".$sanitised_post['sub_e'];

    $email_contents = 'New newletter subscription:'."\n-----------------------------------\n";
    $email_contents .= implode("\n",$eml_contents)."\n-----------------------------------\n";
    $email_contents .= "";

    $addr = get_bloginfo('admin_email');
    $subj = "[X-Train] Newsletter Subscription";
    $headers = 'From: '. $addr;

    ini_set("sendmail_from", $addr);

    wp_mail($addr,$subj,$email_contents,$headers);

    if($sanitised_post['origlocation']):
        header('Location: '.$sanitised_post['origlocation'].'?newslettersubscribe=done');
    else:
        header('Location: '.$_SERVER['REQUEST_URI'].'?newslettersubscribe=done');
    endif;
    
    exit;
}

function get_random_testimonial(){
    $post = get_posts('posts_per_page=1&post_type=xtrain_testimonial&orderby=rand');
    return ($post[0]);
}

function blank_mnu(){
    //fallback function for empty menus so nothing is displayed rather than all pages
}


class Custom_Menu_Walker extends Walker_Nav_Menu
{
	/**
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

                $hidecourse = get_post_meta($item->object_id, 'Hide Course');
                if(!$hidecourse):
                    $class_names = $value = '';

                    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
                    $classes[] = 'menu-item-' . $item->ID;

                    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
                    $class_names = ' class="' . esc_attr( $class_names ) . '"';

                    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
                    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

                    $output .= $indent . '<li' . $id . $value . $class_names .'>';

                    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

                    $item_output = $args->before;
                    $item_output .= '<a'. $attributes .'>';
                    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                    $item_output .= '</a>';
                    $item_output .= $args->after;

                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                endif;
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output, $item, $depth) {
		$output .= "</li>\n";
	}
}

function my_fields($fields) {
    global $crfp;
    $fields['rating'] = '<p>'.$crfp->SaveRating($commentID).'</p>';
    $fields['revtitle'] = '<p class="comment-form-url"><label for="revtitle">' . __( 'Title' ) . '</label>' .
		            '<input id="revtitle" name="revtitle" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';
    $fields['url'] = false;
    return $fields;
}
add_filter('comment_form_default_fields','my_fields');

function comment_submit_btn(){
    echo '<input src="'.get_bloginfo('stylesheet_directory').'/images/btn-submit-review.gif" id="review-submit-btn" type="image" name="submit" />';
}
add_action('comment_form','comment_submit_btn');


function custom_revs($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

     <div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

         <div class="clear"></div>
      <div  class="comment-author vcard">
          <div class="review_title"><?=$comment->extra_revtitle?></div>
         <?php //printf(__('<cite class="fn">%s</cite> <span class="says">wrote:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <div class="review_pending"><?php _e('Your review will be shown once approved.') ?></div>

      <?php endif; ?>

         <div class="comment-text-snippet">
             <p>&ldquo;<?=substr(strip_tags(apply_filters('comment_text', get_comment_text() )),0,100)?>...&rdquo;</p>
         </div>
         <div class="comment-text-full">
            <?=apply_filters('comment_text', '&ldquo;'.get_comment_text().'&rdquo; <a href="javascript:void(0)" style="font-size: 11px">&laquo; Show less</a>' ); ?>
         </div>

     </div>
<?php
}

?>