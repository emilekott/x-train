<?php
/*
 * Template Name: Courses (With Left Sidebar + Sub-Page Links)
 */
get_header();
have_posts();
the_post();
?>
<div class="clear"></div>
<div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : 'pagemain'?>">

    <div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : ''?>">

        <?php include('incs/sidebars/sidebar_courses.php') ?>

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
                
                <?php
                $courses = get_courses(get_the_ID() );
                    if($courses):
                ?>
                 <div class="featureboxes" id="courselist">
                <?php
                    $c=0;
                    foreach($courses as $course): $c++;
                        if($c==3){
                            $c=0;
                            $boxClass="n3";
                        } else {
                            $boxClass="";
                        }
                        $thumbid = get_post_meta($course->ID, 'Thumbnail');
                        $thumbid = $thumbid[0];
                        
                        $price = get_post_meta($course->ID, 'Price');
                        $price = $price[0];
                        $hours = get_post_meta($course->ID, 'Hours');
                        $hours = $hours[0];
                        $hidecourse = get_post_meta($course->ID, 'Hide Course');
                        if(!$hidecourse):
                            ?>
                                <div class="featurebox <?=$boxClass?>">
                                    <div class="featurebox-top"></div>
                                    <div class="featurebox-mid">
                                        <a href="<?=get_permalink($course->ID)?>" class="font2 featurebox-title">
                                           <?=$course->post_title?>
                                        </a>
                                        
                                        <a href="<?=get_permalink($course->ID)?>">
                                            <?php if ($thumbid) { ?>
                                            <img src="<?php echo wp_get_attachment_url($thumbid) ?>" alt="" />
                                            <?php } else { ?>
                                            <img src="<?php bloginfo('stylesheet_directory') ?>/images/image-coming-soon.jpg" alt="" />
                                            <?php } ?>
                                        </a>
                                        <div class="course-listing-price-row">
                                            <div class="course-listing-price font1"><?=$hours ? $hours.' Hours - ' : ''?><?=$price ? '&pound;'.$price : ''?></div>
                                            <div class="course-listing-btn"><a href="<?=get_permalink($course->ID)?>" class="moreinfo-btn"></a></div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="featurebox-bot"></div>
                                </div>
                            <?php
                    endif;
                    endforeach;
                ?>
                <div class="clear"></div>
                </div>
                <?php endif ?>
                <div class="main-content">
                <?php the_content(); ?>
                </div>
                <?php require('incs/footerlogos.php') ?>
        </div>
        </div>

        <div class="clear"></div>
    </div>

</div>
    
<?php get_footer(); ?>
