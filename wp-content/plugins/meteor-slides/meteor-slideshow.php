<?php
/*  Loop template for the Meteor Slides slideshow
	
	Copy "meteor-slideshow.php" from "/meteor-slides/" to your theme's directory to replace
	the plugin's default slideshow loop.
	
	Learn more about customizing the slideshow template for Meteor Slides: 
	http://www.jleuze.com/plugins/meteor-slides/customizing-the-slideshow-template/
*/

	// Settings for slideshow loop

	global $post;
	
	$options = get_option( 'meteorslides_options' );
	
	$meteornav = $options['slideshow_navigation'];
	
	$i = 1;
	
	$loop = new WP_Query( array(
	
		'post_type'      => 'slide',
		'slideshow'      => $slideshow,
		'posts_per_page' => $options['slideshow_quantity']
		
	) ); ?>
	
	<div id="meteor-slideshow" class="meteor-slides <?php echo $meteornav . ' ' . $slideshow; ?>">
		
		<?php // Adds Previous/Next and Paged navigation
		
		if ( $meteornav == "navboth" ) : ?>
	
			<ul class="meteor-nav">
		
				<li class="prev" id="meteor-prev<?php echo $slideshow; ?>"><a href="#"><?php _e( 'Previous', 'meteor-slides' ) ?></a></li>
			
				<li class="next" id="meteor-next<?php echo $slideshow; ?>"><a href="#"><?php _e( 'Next', 'meteor-slides' ) ?></a></li>
			
			</ul><!-- .meteor-nav -->
		
			<div class="meteor-buttons" id="meteor-buttons<?php echo $slideshow; ?>"></div>
		
		<?php // Adds Previous/Next navigation
		
		elseif ( $meteornav == "navprevnext" ) : ?>
	
			<ul class="meteor-nav">
		
				<li class="prev" id="meteor-prev<?php echo $slideshow; ?>"><a href="#"><?php _e( 'Previous', 'meteor-slides' ) ?></a></li>
			
				<li class="next" id="meteor-next<?php echo $slideshow; ?>"><a href="#"><?php _e( 'Next', 'meteor-slides' ) ?></a></li>
			
			</ul><!-- .meteor-nav -->
		
		<?php // Adds Paged navigation
		
		elseif ( $meteornav == "navpaged" ): ?>
	
			<div class="meteor-buttons" id="meteor-buttons<?php echo $slideshow; ?>"></div>
			
		<?php endif; ?>
		
		<div class="slides { <?php
		
			// Adds metadata to slideshow
		
			if ( !empty( $slideshow ) ) {
			
				echo "next: '#meteor-next" . $slideshow . "', prev: '#meteor-prev" . $slideshow . "', pager: '#meteor-buttons" . $slideshow . "'";
				
			}
				
			if ( !empty( $metadata ) && !empty( $slideshow ) ) {
			
				echo ', ';
				
			}
			
			echo $metadata;
			
		?> }">
	
			<?php // Loop which loads the slideshow
			
			while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<div id="slide-<?php echo $i; ?>" class="slide">
				
					<?php // Adds slide image with Slide URL link
					
					if ( get_post_meta( $post->ID, "slide_url_value", $single = true ) != "" ): ?>
						
						<a href="<?php echo get_post_meta( $post->ID, "slide_url_value", $single = true ); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'featured-slide' ); ?></a>
			
					<?php // Adds slide image
					
					else: ?>
					
						<?php the_post_thumbnail( 'featured-slide' ); ?>
					
					<?php endif; ?>
			
				</div><!-- .slide -->
			
				<?php $i++; ?>
			
			<?php endwhile; ?>
		
		</div><!-- .slides -->
		
		<?php wp_reset_query(); ?>
			
	</div><!-- #meteor-slideshow -->