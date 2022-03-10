<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// // ** Database settings - You can get this info from your web host ** //
// /** The name of the database for WordPress */
define( 'DB_NAME', 'cmsho_31191404_wordpress' );

// /** Database username */
define( 'DB_USER', 'cmsho_31191404' );

// /** Database password */
define( 'DB_PASSWORD', 'zRNzOLasZ' );

// /** Database hostname */
define( 'DB_HOST', 'sql211.cmshost.nl' );

// /** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

// /** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
// define( 'DB_NAME', 'wordpress' );

// // /** Database username */
// define( 'DB_USER', 'root' );

// // /** Database password */
// define( 'DB_PASSWORD', '' );

// // /** Database hostname */
// define( 'DB_HOST', 'localhost' );

// // /** Database charset to use in creating database tables. */
// define( 'DB_CHARSET', 'utf8mb4' );

// // /** The database collate type. Don't change this if in doubt. */
// define( 'DB_COLLATE', '' );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'spw<ez XN754q?o_d-9(uB5(;EVEe%?h]X|-6yrK:b14$,+78cUMYXJk69rufm}C' );
define( 'SECURE_AUTH_KEY',  'C!V<3Dde^YttYN%8t>]7mtQd1;QLoP.tx/R?[k6}& SVLm<I@2gB#d0A1)5.9;-*' );
define( 'LOGGED_IN_KEY',    'I+mE(mjh,V4<Ne/%Ijd[0EKRM8`EQ}?E6FE)W;H1r[.F:<z[}o6ODvoI>;Q6f*Wf' );
define( 'NONCE_KEY',        ')^7bk[=p@{!l({~-k`jpJ]_;#ZSC;>N9aX2_^c~UXC?;=wnACl4@eoC)SjjKG#I=' );
define( 'AUTH_SALT',        '^bN)AOy,L,-3h~h%/xFSxC;&2nVG}KKu4s#`ob:3q!G3o_<2{*YPx4<R^=|,pDG3' );
define( 'SECURE_AUTH_SALT', 'YEpbZ3o#4o{U.l<7U4T3>]~[|oJtYI^](MZ@/D>0@LUKkbRlD>,F9?^XPy.Y5UJY' );
define( 'LOGGED_IN_SALT',   'zr^{lnz,v$JdvXc<uUHAmbagBazWgou1~jwtl%WMIt}^@mbBDdU1aC#;T>m?T^?a' );
define( 'NONCE_SALT',       'YL|)`FE//wH$]-A[3L~h^?(}DltC*E1$Dl%:x-,2W0}1(/1k|Py@LNs6)NB[TW([' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_ProjectBureau';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


function activiteit() {
    if ( is_user_logged_in() ) {
        $args = array(
            'post_type' => 'Activiteiten',
            'posts_per_page' => 10
        );
        global $post;
        $query = new WP_Query($args);
        if ($query->have_posts()) { 
            echo '<div class="Activiteiten">';
                // Get user info
                $user_info  = wp_get_current_user();
                $user_ID    = $user_info->ID;
                $user_name  = $user_info->display_name;
                $user_email = $user_info->user_email;

                while ( $query->have_posts() ) : $query->the_post();
                // Get the ID of the activity.
                $post_id    = get_the_ID();
                $startDate  = get_field("start_tijd", $post_id);
                //$endDate    = get_field("eind_tijd", $post_id);
                // Devide date into 2 to fit into content.
                $pieces = explode(" ", $startDate);
                // Extract month number from the date of the activity.
                $month = date("m",strtotime($startDate));

                echo '<div id="'.get_the_ID().'" class="Activiteit">';
                echo $month;
                    echo '<h4 class="title">';
                        echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
                    echo '</h4>';
                    echo '<p class="dateTime">'.$pieces[0].'<br>'.$pieces[1].'</p>';
                    echo '<p class="description">'.get_the_excerpt().'</p>';
                    // Create a form to call on a statement when the button is clicked,
                    echo '<form class="actForm" method="post">';
                    // Add the ID of the input (button) to the name of the button to make it "activiteit" specific.
                    echo '<input type="submit" name="ActButton'.$post_id.'" value="Deelnemen" class="ActButton"/>';
                    echo '</form>';
                echo '</div>';
                
                // Get second database connection information from functions.php
                global $db2;
                // If the "Deelnemen" button is used.
                if(isset($_POST['ActButton'.$post_id.''])) {
                    if ($exists = $db2->get_var("SHOW TABLES LIKE '".$post_id."'")) {
                        // If the tabel exists, insert the user account values into the tabel from the specific activity.
                        $insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");
                    } else {
                    // If tabel doesnt exist yet, create table, then insert user info.
                        $createTable = $db2->get_var("CREATE TABLE `$post_id` (
                            ID INT(6),
                            Naam VARCHAR(30) NOT NULL,
                            Email VARCHAR(50)
                            )");
                        $insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");
                    }
                }
                endwhile;
            echo '</div>';

        }
    } else {
        echo '<p class="error">Je moet ingelogd zijn om de activiteiten te kunnen bekijken!</p>';
        echo '<p class="error">Klik <a href="'.home_url().'/login-register">hier</a> om in te loggen of een account te registreren.</p>';
    }
    /* 
    if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		}	}*/

}