<?php
/*
 * Template Name: Course Details
 */
get_header();
have_posts();
the_post();
$hours = getCustomField('Hours',false,false);
$max_hours = getCustomField('Max. Hours',false,false);
$max_people = getCustomField('Max. People',false,false);
if(!$max_people):
    $max_people = 5;
endif;
$extraFields = array();
//check for extra custom fields and push to an array if they exist
for ($i = 1; $i <= 10; $i++) {
    $theField_label = getCustomField('_extra_option_'.$i.'_label',false,false);
    $theField_values = getCustomField('_extra_option_'.$i,false,false);
    if(strlen($theField_label)>0 && strlen($theField_values)>0){
        $extraFields[] = array(
            'label' => $theField_label,
            'options' => explode('|',$theField_values),
            'origvalstring' => $theField_values
        );
    }
}
?>
<div class="clear"></div>
<div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : 'pagemain'?>">

    <div id="<?=has_post_thumbnail() ? 'pagebg-static-page' : ''?>">
 
        <div class="pad">
            <?php if(has_post_thumbnail()) { the_post_thumbnail('content-banner-small'); } ?>
            <h1 class="h1_coursedetail"><?php

                    $customh1 = getCustomField('Custom H1',false,false);
                    if($customh1):
                        echo $customh1;
                    else:
                        the_title();
                    endif;

                ?></h1> <div class="clear"></div>
        <div class="pagecol-coursedetail">
               
               
                


                
                <script>
                    jQuery(document).ready(function(){
                        jQuery('#page-gallery a').fancybox();

                    });
                </script>

                <div class="main-content">
                <?php the_content(); ?>
                    <?php if($hours): ?>
                    <h2>Course Duration - <?=$hours?> Hours</h2>
                    <?php endif ?>
                </div>


                


                <?php require('incs/footerlogos.php') ?>
        </div>
            
        </div>
        <?php
        $price = getCustomField('Price',false,false);
        ?>
        <div id="coursedetail-right-col">
            <div class="coursedetail-cta-top"></div>
            <div class="coursedetail-cta-mid" id="booking-form">
                <script>
                    var coursePricePp = <?=(int)$price?>;
                    jQuery(document).ready(function(){
                        $dateField = jQuery("input[name=course_date]");
                        $dateField.datepicker({ dateFormat: 'dd-mm-yy' });
                        jQuery('#triggerDatePicker').click(function(){
                            $dateField.focus();
                        });
                        jQuery('select[name=extra_fields[Number of people]],select[name=extra_fields[Number of hours]]').change(function(){
                            var newPrice = (coursePricePp) * (jQuery('select[name=extra_fields[Number of people]]').val());
                            if(jQuery('select[name=extra_fields[Number of hours]]')){
                                if(jQuery('select[name=extra_fields[Number of hours]]').val()){
                                    newPrice = newPrice * jQuery('select[name=extra_fields[Number of hours]]').val();
                                }
                            }
                            jQuery('.courseprice-field span').html('&pound;'+newPrice);
                            Cufon.refresh();
                        });
                    });
                </script>
                <form action="<?=get_permalink(547);?>" method="get">
                    <img src="<?php bloginfo('stylesheet_directory')  ?>/images/section-book-course.gif" alt="Book Course" />
                    <p>Select your options below:</p>
                    <div class="coursedetail-field-label">Select Date:</div>
                    <div class="coursedetail-field">
                        <input type="text" name="course_date" /> <img src="<?php bloginfo('stylesheet_directory') ?>/images/calendar.gif" alt="Select a date" style="cursor:pointer; margin-bottom: -3px" id="triggerDatePicker" />
                    </div>
                    <div class="coursedetail-field-label">Number of people:</div>
                    <div class="coursedetail-field">
                        <select name="extra_fields[Number of people]">
                            <?php for($i=1; $i<=$max_people; $i++): $peoplevals[] = $i; ?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor ?>
                        </select>
                        <input type="hidden" name="extra_fields_orig[Number of people]" value="<?=implode('|',$peoplevals)?>" />
                    </div>
                    <?php if($max_hours): ?>
                    <div class="coursedetail-field-label">Number of hours:</div>
                    <div class="coursedetail-field">
                        <select name="extra_fields[Number of hours]">
                            <?php for($i=1; $i<=$max_hours; $i++): $hoursvals[] = $i; ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor ?>
                        </select>
                        <input type="hidden" name="extra_fields_orig[Number of hours]" value="<?=implode('|',$hoursvals)?>" />
                    </div>
                    <?php endif;

                        if(count($extraFields)>0):
                            foreach($extraFields as $efield):
                                echo '<div class="coursedetail-field-label">'.$efield['label'].':</div><div class="coursedetail-field">';
                                    echo '<select name="extra_fields['.$efield['label'].']">';
                                        foreach($efield['options'] as $optv):
                                            echo '<option value="'.$optv.'">'.$optv.'</option>';
                                        endforeach;
                                    echo '</select>';
                                    echo '<input type="hidden" name="extra_fields_orig['.$efield['label'].']" value="'.$efield['origvalstring'].'" />';
                                echo '</div>';
                            endforeach;
                        endif;

                    ?>
                    <?php
                            
                            if($price):
                    ?>
                    <div class="coursedetail-field-label">Price:</div>
                    <div class="courseprice-field font1">
                        <span>&pound;<?=$price?></span>
                    </div>
                    <?php endif ?>
                    <input type="hidden" name="course_title" value="<?php the_title() ?>" />
                    <input type="image" class="push-top-small" src="<?php bloginfo('stylesheet_directory') ?>/images/btn-course-book.png" />
                </form>
            </div>
            <div class="coursedetail-cta-bot"></div>

          <?php
            $rellinks = $max_people = getCustomField('related_links',false,false);
            if($rellinks):
            $link_rows = explode(',',$rellinks);
          ?>
          <div class="coursedetail-cta-top push-top"></div>
            <div class="coursedetail-cta-mid content-submnu-generic font4" id="coursedetail-widgetmnu">
                <div class="menu-course-details-page-container">
                    <img src="<?php bloginfo('stylesheet_directory')  ?>/images/section-quick-links.gif" alt="Quick Links" />
                    <ul id="menu-course-details-page" class="menu">
                        <?php foreach($link_rows as $linkrow):
                                $thelink = explode('|',$linkrow);
                        ?>
                        <li class="menu-item menu-item-type-custom menu-item-1283"><a href="<?=$thelink[0]?>"><?=$thelink[1]?></a></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="coursedetail-cta-bot"></div>
            <?php endif ?>

            
            <?php comments_template( '', true ); ?>
            

            <div class="review-col-top push-top"><img src="<?php bloginfo('stylesheet_directory')  ?>/images/section-write-a-review.gif" alt="Write a review" /></div>
            <script type="text/javascript">
                jQuery(document).ready(function(){

                    //jQuery('div.star-rating a').html('');

                    var commentCount = 0;
                    jQuery('#reviewlist .comment').each(function(){
                        commentCount++;
                        if(commentCount>3){
                            jQuery(this).hide();
                            jQuery(this).addClass('allComment');
                        }
                    });

                    jQuery('#review-col-open-all').click(function(){
                        jQuery('.allComment').slideDown();
                        jQuery(this).hide();
                        jQuery('#review-col-close-all').show();
                    });
                    jQuery('#review-col-close-all').click(function(){
                        jQuery('.allComment').slideUp();
                        jQuery(this).hide();
                        jQuery('#review-col-open-all').show();
                    });

                    jQuery('#review-col-form label').each(function(){
                        var obj = jQuery(this);
                        var formElement = jQuery('#' + obj.attr('for'));
                        formElement.val(obj.html());
                        formElement.focus(function(){
                            if(jQuery(this).val()==obj.html()){
                                jQuery(this).val('');
                            } 
                        }).blur(function(){
                            if(jQuery(this).val()==''){
                                jQuery(this).val(obj.html());
                            }
                        });

                    });

                    jQuery('.star-rating-control').append('<div class="clear"></div>');

                    function isValidEmailAddress(emailAddress) {
                        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                        return pattern.test(emailAddress);
                    };


                    jQuery('#commentform').submit(function(){
                        var validationScore = 0;
                        var validationErrors = '';

                        jQuery('.fieldError').removeClass('fieldError');
                        
                        if(jQuery('#author').val()==''||jQuery('#author').val()=='Name'){
                            validationScore++;
                            validationErrors += "Please enter your name.\n";
                            jQuery('#author').addClass('fieldError');
                        }

                        if(jQuery('#email').val()==''||jQuery('#email').val()=='Email'||!isValidEmailAddress(jQuery('#email').val())){
                            validationScore++;
                            validationErrors += "Please enter a valid email address.\n";
                            jQuery('#email').addClass('fieldError');
                        }

                        if(jQuery('#revtitle').val()==''||jQuery('#revtitle').val()=='Title'){
                            validationScore++;
                            validationErrors += "Please enter a title.\n";
                            jQuery('#revtitle').addClass('fieldError');
                        }

                        if(jQuery('input[name=crfp-rating]').val()<=0){
                            validationScore++;
                            validationErrors += "Please select a rating.\n";
                            jQuery('.star-rating-control').addClass('fieldError');
                        }

                        if(jQuery('#comment').val()==''||jQuery('#comment').val()=='Comment'){
                            validationScore++;
                            validationErrors += "Please enter your review.\n";
                            jQuery('#comment').addClass('fieldError');
                        }

                        if(validationScore==0){
                            return true;
                        } else {
                            alert('Please correct these errors:\n'+validationErrors);
                            return false;
                        }

                    });

                    jQuery('#review-col-open').click(function(){
                        jQuery(this).hide();
                        jQuery('#review-col-form').slideDown();
                    });

                    jQuery('.comment').click(function(){
                        jQuery(this).children('.comment-text-snippet').toggle(0);
                        jQuery(this).children('.comment-text-full').toggle(0);
                    });

                    jQuery('#reviewlist .crfp-rating').each(function(){
                        jQuery(this).prependTo(jQuery(this).parents('.comment'));
                    });

                });
            </script>
            <div class="review-col-bot" id="review-col-form"><?php comment_form(array(
                'comment_notes_after' => false,
                'comment_notes_before' => false,
                'title_reply' => ''
            )) ?>
            </div>
            <div class="review-col-bot" id="review-col-open">Click Here</div>


        </div>
        <div class="clear"></div>
    </div>

</div>
    
<?php get_footer(); ?>
