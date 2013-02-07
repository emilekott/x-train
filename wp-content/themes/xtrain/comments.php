<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to twentyten_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
<?php if ( have_comments() ) : ?>
            <div class="review-col-top push-top"><img src="<?php bloginfo('stylesheet_directory')  ?>/images/section-latest-reviews.gif" alt="Latest Reviews" /></div>

            <div class="review-col-bot" id="reviewlist">
                <?php wp_list_comments('callback=custom_revs'); ?>
                <div id="review-col-open-all">View All Reviews</div>
                <div id="review-col-close-all">View Less Reviews</div>
            </div>


            <?php endif ?>