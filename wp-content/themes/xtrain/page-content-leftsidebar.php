<?php
/*
 * Template Name: Membership (Left Sidebar + Top Banner)
 */
get_header();
have_posts();
the_post();
?>
<div class="clear"></div>
<div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : 'pagemain'?>">

    <div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : ''?>">

        <?php include('incs/sidebars/sidebar2.php') ?>

        <div class="pad">
        <div class="pagecol-rlsb push-left">
                <?php if(has_post_thumbnail()) { the_post_thumbnail('content-banner-small'); } ?>
                <div class="clear"></div>
                <h1><?php

                    $customh1 = getCustomField('Custom H1',false,false);
                    if($customh1):
                        echo $customh1;
                    else:
                        the_title();
                    endif;

                ?></h1>
                
                <div class="main-content">
                <?php the_content(); ?></div>
                <?php require('incs/footerlogos.php') ?>
                
        </div>
        </div>

        <div class="clear"></div>
    </div>

</div>
    
<?php get_footer(); ?>
