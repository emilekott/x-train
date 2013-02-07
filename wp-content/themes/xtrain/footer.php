<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div id="footer" class="font3">
            <?php 
                wp_nav_menu(array('menu'=>'footer-col-1','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
                wp_nav_menu(array('menu'=>'footer-col-2','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
                wp_nav_menu(array('menu'=>'footer-col-3','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
                wp_nav_menu(array('menu'=>'footer-col-4','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
                wp_nav_menu(array('menu'=>'footer-col-5','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
                wp_nav_menu(array('menu'=>'footer-col-6','fallback_cb' => 'blank_mnu','walker' => new Custom_Menu_Walker));
            ?>
            <div class="clear"></div>
	</div><!-- #footer -->
        <div id="footer-bar">
            Copyright <?=date('Y')?> X-Train<span style="width:10px;display:inline-block"> </span>|<span style="width:10px;display:inline-block"> </span><a href="http://www.design51.co.uk/" title="Web Design Chichester">Web Design Chichester - Design 51</a>
        </div>

</div><!-- #wrapper -->
<script type="text/javascript"> Cufon.now(); </script>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

</body>
</html>
