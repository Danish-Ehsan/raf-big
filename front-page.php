<?php


get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="hero">
            <?php
                $projects = get_field( 'featured_projects_main' );
                $projectKeys = array();
                foreach ($projects as $key => $project) {
                    //$project['projectIndex'] = $key;
                    //create a separate array that holds the project keys to be referenced for image sources
                    $projectKeys[] = $key;
                }
                //print_r($projects);
                //The animation needs at least 7 items to function properly
                //If there are less than 7 items then duplicate list
                
                //get middle list item key
                $active_key = ceil( (count( $projects ) / 2) - 1 );
                
                foreach ($projects as $key => $project) :
					$project_images = get_field('project_images', $project->ID);
					
                    if ( $key == $active_key ) :
                    //Only load the background image of the active project
                    //Save the rest of the featured list image URLs as data attributes to be used with javascript for lazy loading
            ?>
                <div class="hero__image js--hero-list-image hero__image--active" data-key="<?php echo $key ?>" style="background-image: url('<?php echo $project_images['featured_image']; ?> ');"></div>
            <?php else : ?>
                <div class="hero__image js--hero-list-image" data-key="<?php echo $key ?>" data-image-source="<?php echo $project_images['featured_image']; ?>"></div>
            <?php
                endif;
                endforeach;
                //The cycleList() animation needs at least 7 items to function properly
                //If there are less than 7 items then duplicate list
                //Duplication of full list is required because the list loops forwards and backwards
                if ( count($projects) < 7 ) {
                    //$projects = array_values($projects);
                    $projectsLength = count($projects);
                    $projectsToPrepend = array();
                    $projectKeysToPrepend = array();
                    for ( $i = 0; $i < $projectsLength; $i++ ) {
                        if ( $i < ( ceil($projectsLength / 2) ) ) {
                            $projects[] = $projects[$i];
                            $projectKeys[] = $projectKeys[$i];
                        } else {
                            $projectsToPrepend[] = $projects[$i];
                            $projectKeysToPrepend[] = $projectKeys[$i];
                            //array_unshift($projects, $projects[$i]);
                            //array_unshift($projectKeys, $projectKeys[$i]);
                        }
                    }
                    
                    $projects = array_merge($projectsToPrepend ,$projects);
                    $projectKeys = array_merge($projectKeysToPrepend, $projectKeys);
                    $active_key = ceil( (count( $projects ) / 2) - 1 );
                    
                    /*
                    foreach ($projects as $project) {
                        $projects[] = $project;
                    }
                    foreach ($projectKeys as $projectKey) {
                        $projectKeys[] = $projectKey;
                    }*/
                }
            ?>
                    
                <div class="hero__list-cont js--hero-list-cont">
                    <ol class="hero__list js--hero-list <?php if (!(count($projects) % 2)) { echo 'hero__list--even'; } ?>">
                        
                    <?php
                        
                        
                        foreach ($projects as $key => $project) :
                        
                        //assign classes to middle and outer list items
                        $style_class = '';
                        if ( $key == $active_key ) { 
                            $style_class = 'hero__list-item--active';
                        } else if ( $key == $active_key - 1 || $key == $active_key + 1 ) {
                            $style_class = 'hero__list-item--white';
                        } else if ( $key == $active_key - 2 || $key == $active_key + 2 ) {
                            $style_class = 'hero__list-item--faded';
                        }
                        
                    ?>
                    <li class="hero__list-item <?php echo $style_class ?> js--hero-list-item" data-key="<?php echo $projectKeys[$key]; ?>">
                        <a href="<?php echo get_post_permalink( $project->ID ); ?>" class="hero__list-link">
                            <span class="hero__list-title"><?php echo $project->post_title ?></span><br>
                            <span class="hero__list-address"><?php echo ( the_field( 'address', $project->ID ) ) ? the_field( 'address', $project->ID ) : '&nbsp;';  ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>     
                    
                    </ol>
                </div><!--.hero__list-cont-->
                <div class="hero__logo">
                    <?php //$logo_url declared in functions.php ?>
                    <img src="<?php echo esc_url( $logo_url[0] ) ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
                </div>
            </div> <!-- .hero -->
        <?php
        if ( have_posts() ) :

            /* Start the Loop */
            while ( have_posts() ) :
                the_post();
            ?>
            <article class="copy-cont" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <img class="copy__icon" src="<?php echo get_template_directory_uri() . '/images/icon_line_plus.png'; ?>" alt="branding-icon">
                <div class="copy__content"><?php the_content(); ?></div>
                <div class="copy__signature-cont">
                    <img class="copy__signature" src="<?php echo get_template_directory_uri() . '/images/R+B_signature.png'; ?>" alt="Raf+Big Signature">
                </div>
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php endwhile;

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif; ?>
            
        <?php 
            $projects_secondary = get_field( 'featured_projects_secondary' );
            if ( !empty($projects_secondary) ) :
        ?>
            <div class="featured-secondary" style="background-image: url('<?php echo get_template_directory_uri() . '/images/floor_plan_small_faded.jpg'; ?>')">
                <div class="featured-secondary__items-cont">
                <?php 
					foreach ($projects_secondary as $key => $project) : 
					$project_images = get_field('project_images', $project->ID);
				?>
                    <div class="featured-secondary__item item-<?php echo $key + 1 ?>">
						<a href="<?php echo get_post_permalink( $project->ID ); ?>" class="featured-secondary__item__image-cont" style="background-image: url('<?php if ($project_images['featured_secondary']) { echo $project_images['featured_secondary']; } else { the_post_thumbnail_url( $size = 'tall-thumbnail', $post = $project->ID ); } ?>')"></a>
                        <div class="featured-secondary__item-copy-cont item-<?php echo $key + 1 ?>">
                            <h3 class="featured-secondary__item__title item-<?php echo $key + 1 ?>"><a href="<?php echo get_post_permalink( $project->ID ); ?>"><?php echo $project->post_title ?></a></h3>
                            <span class="featured-secondary__item__address item-<?php echo $key + 1 ?>"><?php echo ( the_field( 'address', $project->ID ) ) ? the_field( 'address', $project->ID ) : '&nbsp;' ; ?></span>
                            <span class="featured-secondary__item__year item-<?php echo $key + 1 ?>"><?php echo  ( the_field( 'year_completed', $project->ID ) ) ? the_field( 'year_completed', $project->ID ) : '&nbsp;'; ?></span>
                            <span class="featured-secondary__item__client item-<?php echo $key + 1 ?>"><?php echo ( the_field( 'client', $project->ID ) ) ? the_field( 'client', $project->ID ) : '&nbsp;'; ?></span>
                            <span class="featured-secondary__item__square-footage item-<?php echo $key + 1 ?>"><?php echo  ( the_field( 'square_footage', $project->ID ) ) ? the_field( 'square_footage', $project->ID ) : '&nbsp;'; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="featured-secondary__items__see-more">
                    <a href="<?php echo get_post_type_archive_link( 'projects' ); ?>">See more</a>
                    <img src="<?php echo get_template_directory_uri() .  '/images/icon_see-more.png'; ?>" alt="see-more-icon">
                </div>
            </div><!-- .featured-secondary -->
        <?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
