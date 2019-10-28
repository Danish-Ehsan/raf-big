<?php

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
                    if ( have_posts() ) : ?>
                    
                    <h1 class="page-title screen-reader-text">Projects Archive</h1>
                    
                <?php

                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();
                ?>
                    
                    <div class="project-cont">
                        <div class="project__copy-cont">
                            <span class="project__copy-year"><?php echo ( the_field( 'year_completed' ) ) ? get_the_field( 'year-completed' ) : '&nbsp;'; ?></span>
                            <a href="<?php echo get_post_permalink(); ?>"><h3 class="project__copy-title"><?php the_title(); ?></h3></a>
                            <p class="project__copy-description"><?php echo ( the_field( 'description' ) ) ? get_the_field( 'description' ) : '&nbsp;'; ?></p>
                            <a href="<?php echo get_post_permalink(); ?>" class="project__copy-icon" style="background-image: url('<?php echo get_template_directory_uri() . '/images/icon_arrows-sprite.png' ?>') "></a>
                        </div>
                        <a href="<?php echo get_post_permalink(); ?>" class="project__image-cont" style="background-image: url('<?php the_post_thumbnail_url( 'wide-medium' ); ?>')"></a>
                    </div>
                    
                <?php
                    endwhile;

                        the_posts_navigation();

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;
            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
