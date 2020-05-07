<?php


get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
        <?php
            while ( have_posts() ) :
                the_post();
				$project_images = get_field('project_images');
				$gallery_images = $project_images['project_gallery'];
        ?>
            <div class="project-single__carousel owl-carousel owl-theme">
                <div class="project-single__carousel-image" style="background-image: url('<?php echo $project_images['featured_image']; ?>');"></div>
                <?php if( have_rows('project_images') ):
                    while ( have_rows('project_images') ) : 
                        the_row();
						if ( have_rows('project_gallery') ) :
							while ( have_rows('project_gallery') ) :
							the_row();
                ?>
                <div class="project-single__carousel-image owl-lazy" data-src="<?php the_sub_field( 'gallery_image' ) ?>"></div>
                <?php
					endwhile; endif; endwhile; endif; ?>
            </div>
            
            <div class="project-single__copy-cont">
                <div class="project-single__copy-title-cont">
                    <h2 class="project-single__copy-title"><?php the_title(); ?><img class="project-single__copy-icon" src="<?php echo get_template_directory_uri() . '/images/icon_cross-lg.png'; ?>" alt="branding-icon"></h2>
                </div>
                <div class="project-single__copy-left-column">
                <?php
                    $address = get_field( 'address' );
                    if ( !empty($address) ) :
                ?>
                    <span class="project-single__copy-label">Location</span>
                    <span class="project-single__copy-address"><?php echo $address; ?></span>
                <?php 
                    endif; 
                    $client = get_field( 'client' );
                    if ( !empty($client) ) :
                ?>
                    <span class="project-single__copy-label">Client</span>
                    <span class="project-single__copy-client"><?php echo $client; ?></span>
                <?php 
                    endif; 
                    $year = get_field( 'year_completed' );
                    if ( !empty($year) ) :
                ?>
                    <span class="project-single__copy-label">Year</span>
                    <span class="project-single__copy-year"><?php echo $year; ?></span>
                <?php 
                    endif;
                    //$square_footage = get_field( 'square_footage' );
                    //if ( !empty($year) ) :
                ?>
					<!--
                    <span class="project-single__copy-label">Square Footage</span>
                    <span class="project-single__copy-year"><?php //echo $square_footage; ?></span>
					-->
                <?php //endif; ?>
                </div>
                <div class="project-single__copy-right-column">
                    <span class="project-single__copy-label"><?php the_title(); ?></span>
                <?php
                    $description = get_field( 'description' );
                    if ( !empty($description) ) :
                ?>
                    <span class="project-single__copy-description"><?php the_field( 'description' ); ?></span>
                <?php endif; ?>
                </div>
            </div>
            
        <?php  endwhile; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();