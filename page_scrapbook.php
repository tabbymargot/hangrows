<?php /*
Template Name: Scrapbook
*/ ?>

<!--Action below runs the function - I picked genesis_before_loop as the hook, but genesis_before_content seems to work just as well-->
<?php add_action('genesis_after_loop','display_custom_scrapbook_post'); ?>

<!--The following code is adapted from the Treehouse WP theme development course, section on templates - page-portfolio.php. I have added extra code for Genesis -->

<!--Make sure the following line is surrounded by a PHP block, or else won't work-->	
<?php function display_custom_scrapbook_post() { ?>


        <div>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <?php the_content(); ?> 

        <?php endwhile; endif; ?>  

        </div>

     

<?php
//This WP_Query tells the code to pull in posts of the post type 'scrapbook'

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type' => 'scrapbook',
    'posts_per_page'      => 9,
    'paged'          => $paged //this needs to be included to get pagination to work with WP_Query. See https://codex.wordpress.org/Pagination , section: "Adding the "paged" parameter to a query"
  );
  $query = new WP_Query( $args );

?>

<div class="scrapbook-container">

    <section class="group">
    
    <!--This loop pulls in the specified fields as long as there are posts-->
        <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>

            <div class="scrapbook-item-column grid-item">
                <div class="scrapbook-whole-item" style="border-color: <?php the_field('colour'); ?>">
                    <h2 class="scrapbook-header" style="background-color: <?php the_field('colour'); ?>"><?php the_field('title'); ?></h2>

                    <div class="scrapbook_image"><?php the_field('image'); ?></div>

                    <div class="scrapbook-embed"><?php the_field('embed'); ?></div>

                    <div class="scrapbook-main-text"><?php the_field('main_text'); ?></div>
                </div>

            </div>

        <?php endwhile; ?>
    
    </section>
    
    <div class="custom-pagination-positioning"> 
        <section class="archive-pagination pagination">
            <ul>
                <li class="pagination-next"><?php next_posts_link( 'Next page &raquo;', $query->max_num_pages); //does not work without $query->max_num_pages ?></li>
                <li class="pagination-previous"><?php previous_posts_link( '&laquo; Previous page', $query->max_num_pages); ?></li>
            </ul>
        </section>
    </div>
    
</div>
                                                
                                                
<?php endif; wp_reset_postdata(); ?>  

    




        
    
  
    
    

<!--Closing function curly bracket needs to be in PHP block in order to work-->
<?php } ?> 

<?php
genesis();