<?php
/*
 * Template Name: Home
 */
get_header();
have_posts();
the_post();
?>
<div id="pagebg">
    <div class="pad" id="slides-home">
        <a href="<?php echo get_permalink(11) ?>" id="join-overlay"></a>
        <?php if ( function_exists( 'meteor_slideshow' ) ) { meteor_slideshow(); } ?>
    </div>
</div>
    <div class="clear"></div>
<div id="pagemain">
    <div class="pad">
        <div id="page-heading-bar"><?php the_content(); ?></div>
        <div class="clear"></div>
    <div class="pagecol-rlsb push-right">
            
            <div class="featureboxes">
                <?php for($i=1; $i<=6; $i++): ?>
                <div class="featurebox <?=$i==3|$i==6 ? 'ie-last-row-child n3' : ''?>">
                    <div class="featurebox-top"></div>
                    <div class="featurebox-mid">
                        <a href="<?php getCustomField('Feature '.$i.' URL',false) ?>" class="font2 featurebox-title">
                            <?php getCustomField('Feature '.$i.' Title',false) ?>
                        </a>
                        <a href="<?php getCustomField('Feature '.$i.' URL',false) ?>">
                            <img src="<?php echo wp_get_attachment_url(getCustomField('Feature '.$i.' Image',false,false)) ?>" alt="<?php getCustomField('Feature '.$i.' Title',false) ?>" />
                        </a>
                    </div>
                    <div class="featurebox-bot"></div>
                </div>
                <?php endfor; ?>
                <div class="clear"></div>
            </div>
            <?php getCustomField('Page Text') ?>
            <?php require('incs/footerlogos.php') ?>
    </div>
    </div>
    <?php include('incs/sidebars/sidebar1.php') ?>
    <div class="clear"></div>
</div>
    
<?php get_footer(); ?>
