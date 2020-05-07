<?php
/**
* Template Name: About Us
*
* @package WordPress
* @subpackage ragbig
*/

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="about__copy-cont" style="background-image: url('<?php echo get_template_directory_uri() . '/images/floor_plan_small_faded.jpg'; ?>')">
            <?php 
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                
                        echo '<img class="about__copy-icon" src="' . get_template_directory_uri() . '/images/icon_line_plus.png" alt="branding-icon">';
                        the_content();
                    endwhile;
                endif;
            ?>
            </div>
			
<!--            <div class="about__team-cont">
                <?php 
//                    if( have_rows('team_member_details') ) : 
//                        $section_title = get_field( 'section_title' );
//                        if ( !empty($section_title) ) :
                ?>
                <h2 class="about__team-section-title"><?php echo $section_title ?></h2>
                <?php // endif; ?>
                <div class="about__team-members-cont owl-carousel owl-theme">    
                <?php // while ( have_rows('team_member_details') ) :
                    the_row();
                ?>
                    <div class="about__team-member__cont">
                        <div class="about__team-member__photo" style="background-image: url('<?php // the_sub_field( 'photo' ); ?>')"></div>
                        <div class="about__team-member__copy-cont">
                            <h3 class="about__team-member__name"><?php // the_sub_field( 'name' ); ?></h3>
                            <div class="about__team-member__job-title"><?php // the_sub_field( 'job_title' ); ?></div>
                        </div>
                    </div>
                <?php // endwhile; ?>
                </div>
                <img src="<?php // echo get_template_directory_uri() . '/images/icon_line_plus.png'; ?>" class="about__team-icon" alt="branding-icon">
                <?php // endif; ?>
            </div>-->
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();