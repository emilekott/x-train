<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<script>var siteBaseUrl = '<?php bloginfo('url') ?>';</script>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory') ?>/js/jqueryui/css/ui-lightness/jquery-ui-1.8.7.custom.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory') ?>/js/fancybox/jquery.fancybox-1.3.4.css" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<script>
   // Cufon.replace('.font1, .mainmenus .sub-menu,h1,h2,h3,blockquote,h4', { fontFamily: 'Franklin Gothic Demi' });
    Cufon.replace('.font2,#menu-tuition-menu > li > a', { fontFamily: 'Capture it', hover:'true' });
    Cufon.replace('.font3', { fontFamily: 'Myriad Pro'});
    //Cufon.replace('.content-submnu > ul > li > ul > li > a,.font4',{ fontFamily: 'Franklin Gothic Medium'});
    <?php if($_GET['newslettersubscribe']): ?>
        alert('Thanks For Signing Up To Our Newsletter.');
    <?php endif ?>
</script>


<!--[if lte IE 6]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/ie6.css" />
<![endif]-->
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/ie7.css" />
<![endif]-->

<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/ie.css" />
<![endif]-->
</head>

<body <?php body_class(); ?>>

    <?php edit_post_link('Edit', '<span style="position: fixed; left: 5px; top 5px; background-color: #000000; color: #FFFFFF; display: block; padding: 5px;">', '</span>' ); ?>

<div id="layout">
	<div id="header">

            <div id="header-banner">
                

                <div class="header-section">
                   <a href="<?php bloginfo('url') ?>">
                    <img src="<?php bloginfo('stylesheet_directory') ?>/images/header-logo.jpg" alt="<?php bloginfo('title') ?>" />
                   </a>
                </div>
                <div class="header-section">
                    <?php if(function_exists( 'wp_bannerize' ))
                        wp_bannerize('group=header'); ?>
                </div>
                <div class="header-section">
                   <a href="<?php echo get_permalink(19) ?>">
                    <img src="<?php bloginfo('stylesheet_directory') ?>/images/header-contact.jpg" alt="<?php bloginfo('title') ?>" />
                   </a>
                </div>

                <div class="clear"></div>
            </div>
            <div id="mnu-top" class="font1 mainmenus">
                <div id="search">
                <form action="<?php bloginfo('url') ?>" method="get">
                    <input type="text" name="s" value="<?=$_GET['s']?>" />
                </form>
            </div>
                <?php wp_nav_menu(array('menu'=>'main-menu','walker' => new Custom_Menu_Walker)) ?>
            </div>
            <div id="mnu" class="mainmenus">
                <?php wp_nav_menu(array('menu'=>'tuition-menu','walker' => new Custom_Menu_Walker)) ?>
            </div>
	</div><!-- #header -->
        <div class="clear"></div>
        <div class="breadcrumbs">
                <?php
                if(is_front_page()){
                    echo 'Xtrain & West Wittering Windsurf Club';
                } else {
                    if(function_exists('bcn_display'))
                    {
                        bcn_display();
                    }
                }
                ?>
                </div>

        <div id="selects">

            

            <?php
            /*
                    $courseslist = get_pages(array(
                        'child_of' => 21
                    ));
                    $courselist_parents = array();
                    foreach($courseslist as $courselist_check):
                        if($courselist_check->post_parent==21):
                             $courselist_parents[] = $courselist_check;
                        endif;
                    endforeach;
                    unset($courseslist);
                    
                    foreach($courselist_parents as $list_course):
                        echo $list_course->post_title;
                    endforeach;
             *
             */
            ///$walker_pages = new Walker_Page_Menudrop;
            //wp_list_pages(array('walker' => $walker_pages, 'title_li' => '', 'menu' => 'course-header-dropdown'));
                ?>

            <?php output_course_select('Book a course',true) ?>
                <select name="location" class="selectbox" onChange="if(jQuery(this).val()){ window.location = jQuery(this).val(); }">
                    <?php
                        $items = get_pages(array('child_of'=>2,'sort_column'=>'menu_order'));
                    ?>
                    <option value="">WWWC Information</option>
                    <?php foreach($items as $item): ?>
                    <option value="<?=get_permalink($item->ID)?>"><?=$item->post_title?></option>
                    <?php endforeach ?>
                </select>
     
                <a href="http://www.2xs.co.uk/" target="_blank" title="Shop at www.2xs.co.uk"><img src="<?php bloginfo('stylesheet_directory') ?>/images/2xs.gif" style="margin: 0px 0px -1px;" alt="Shop at 2xs.co.uk" /></a>
         
        </div> <div class="clear"></div>
	<div id="main">
