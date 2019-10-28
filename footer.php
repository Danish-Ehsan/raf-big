<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rafbig
 */
    $query = new WP_Query( array(
        'pagename' => 'contact'
    ) );
    $query->the_post();

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
            <div class="footer__logo-cont">
                <?php //$logo_url declared in functions.php ?>
                <img src="<?php echo esc_url( $GLOBALS['logo_url'][0] ) ?>" alt="<?php echo get_bloginfo( 'name' ) ?>">
            </div>
            <table class="footer__info-table">
            <?php
                $telephone = get_field( 'telephone' );
                if ( !empty($telephone) ) : 
            ?>
                <tr>
                    <td>Telephone</td>
                    <td><?php echo $telephone; ?></td>
                </tr>
            <?php 
                endif; 
                $fax = get_field( 'fax' );
                if ( !empty($fax) ) :
            ?>
                <tr>
                    <td>Fax</td>
                    <td><?php echo $fax; ?></td>
                </tr>
            <?php
                endif;
                $email = get_field( 'email' );
                if ( !empty($email) ) :
            ?>
                <tr>
                    <td>Email</td>
                    <td><?php echo $email; ?></td>
                </tr>
            <?php 
                endif;
                $address = get_field( 'address' );
                if ( !empty($address) ) :
            ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $address; ?></td>
                </tr>
            <?php endif; ?>
            </table>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
