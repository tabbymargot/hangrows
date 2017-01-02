<?php
?>

<!--Action below runs the function - I picked genesis_before_loop as the hook, but genesis_before_content seems to work just as well-->
<?php add_action('genesis_before_loop','display_custom_scrapbook_post'); ?>

<!--The following code is adapted from the Treehouse WP theme development course, section on custom post types - single-portfolio.php -->

<!--Make sure the following line is surrounded by a PHP block, or else won't work-->	
<?php function display_custom_scrapbook_post() { ?> 

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
	     <div class="scrapbook-item-column grid-item">
                <div class="scrapbook-whole-item" style="border-color: <?php the_field('colour'); ?>">
                    <h2 class="scrapbook-header" style="background-color: <?php the_field('colour'); ?>"><?php the_field('title'); ?></h2>

                    <div class="scrapbook_image"><?php the_field('image'); ?></div>

                    <div class="scrapbook-embed"><?php the_field('embed'); ?></div>

                    <div class="scrapbook-main-text"><?php the_field('main_text'); ?></div>
                </div>

            </div>
		
	<?php endwhile; endif; ?>


<!--Closing function curly bracket needs to be in PHP block in order to work-->
<?php } ?> 

<?php
genesis();