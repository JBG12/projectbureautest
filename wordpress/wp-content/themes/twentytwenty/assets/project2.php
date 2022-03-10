<?php

function Projectbureau() {

    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Activiteiten', 'Post Type General Name', 'twentytwenty' ),
            'singular_name'       => _x( 'Activiteit', 'Post Type Singular Name', 'twentytwenty' ),
            'menu_name'           => __( 'Activiteiten', 'twentytwenty' ),
            'parent_item_colon'   => __( 'Parent Activiteit', 'twentytwenty' ),
            'all_items'           => __( 'Alle Activiteiten', 'twentytwenty' ),
            'view_item'           => __( 'Bekijk Activiteit', 'twentytwenty' ),
            'add_new_item'        => __( 'Voeg nieuwe activiteit toe', 'twentytwenty' ),
            'add_new'             => __( 'Nieuw Toevoegen', 'twentytwenty' ),
            'edit_item'           => __( 'Activiteit Toevoegen', 'twentytwenty' ),
            'update_item'         => __( 'Activiteit Updaten', 'twentytwenty' ),
            'search_items'        => __( 'Activiteit Zoeken', 'twentytwenty' ),
            'not_found'           => __( 'Niet Gevonden', 'twentytwenty' ),
            'not_found_in_trash'  => __( 'Niet gevonden in de prullenbak', 'twentytwenty' ),
        );
         
    // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __( 'Activiteiten', 'twentytwenty' ),
            'description'         => __( 'activiteiten', 'twentytwenty' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', /*'revisions', /*'custom-fields',*/ ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'genres' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 3,
            'menu_icon'           => 'dashicons-list-view',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
     
        );
            add_submenu_page(
                'edit.php?post_type=Activiteiten',
                __( 'Books Shortcode Reference', 'textdomain' ),
                __( 'Shortcode Reference', 'textdomain' ),
                'manage_options',
                'books-shortcode-ref',
                'books_ref_page_callback'
            );
        /**
         * Display callback for the submenu page.
         */
        function books_ref_page_callback() { 
            ?>
            <div class="wrap">
                <h1><?php _e( 'Books Shortcode Reference', 'textdomain' ); ?></h1>
                <p><?php _e( 'Helpful stuff here', 'textdomain' ); ?></p>
            </div>
            <?php
        }
        // Registering your Custom Post Type
        register_post_type( 'Activiteiten', $args );
     
    }
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
    add_action( 'init', 'Projectbureau', 0 );

/*========================================================================
  Shortcode for Header
/*=======================================================================*/
function theMainHeader() {
    echo '<div class="theHeader">';
        echo '<div class="imgContainer">';
            echo '<a class="headerIMG" href="'.home_url().'">';
                echo '<img src="http://itsjustlars.cmshost.nl/projectbureautest/projectbureautest/wordpress/wp-content/uploads/2022/03/Plak_Cirkels_RGB-2.png" alt="">';
            echo '</a>';
        echo '</div>';

        $query = new WP_Query();
        $pages = $query->query(array(
            'post_type' => 'page',
            'posts_per_page' => -1,
            //'order'   => 'ASC',
            'orderby', 'meta_value'
        ));

        echo '<ul class="navBar">';
        
        // Here we loop through the different pages which are in an array, from this array we then have each page (this is $value an object with page's information)
        // and from the object we extract the name, link and ID.
        foreach ($pages as $value) {
            $title = $value->post_title;
            $post_id = $value->ID;
            $class_name = "link";

            // If the post ID of one of the pages from the array is the same as the ID of the current page where the user is on, we add another class to highlight
            // the current page.
            if ($post_id == get_the_ID()) {
                $class_name .= " current";
            }

            echo '<li class="menuItem">';
                echo '<a class="'.$class_name.'" href="'.get_permalink($post_id).'">'.$title .'</a>';
            echo '</li>';
        };

        echo '</ul>';
    echo '</div>';
}
add_shortcode('Header', 'theMainHeader');

/*========================================================================
  Shortcode for Footer
/*=======================================================================*/
function theMainFooter() {
    ?>
    <div class="FooterContainer">
        <div class="footerBox1">
            <a href="<?php echo home_url()?>/privacyverklaring">Privacyverklaring</a>
        </div>
        <div class="footerBox2">
            <div class="iconBox">
                <div class="iconContainer">
                <div title="Twitter" class="icon">
                    <i class="fab fa-twitter-square"></i>
                </div>
                </div>
                
                <div class="iconContainer">
                    <div title="Facebook" class="icon">
                        <i class="fab fa-facebook-square"></i>
                    </div>
                </div>
                    
                <div class="iconContainer">
                    <div title="Instragram" class="icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                </div>
                
                <div class="iconContainer">
                    <div title="Mail" class="icon">
                        <i class="fas fa-envelope-square"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="footerBox3">
            <p>Test text</p>
        </div>
    </div>
    <?php
}
add_shortcode('Footer', 'theMainFooter');

/*========================================================================
  Function to List all Activiteiten
/*=======================================================================*/
function activiteit() {
    if ( is_user_logged_in() ) {
        $args = array(
            'post_type' => 'Activiteiten',
            'posts_per_page' => 10
        );
        global $post;
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            for ($x = 1; $x <= 12; $x++) {
                $dateObj   = DateTime::createFromFormat('!m', $x);
                $monthName = $dateObj->format('F');
                echo '<div class="boxx">'.$monthName.'</div>';
                echo '<div class="Activiteiten">';
                    while ( $query->have_posts() ) : $query->the_post();
                    $post_id = get_the_ID();
                    $title = get_the_title();
                    $startDate  = get_field("start_tijd", $post_id);
                    $month = date("m",strtotime($startDate));

                    if ($month == $x) {
                        checks($post_id, $title);
                    }
                    endwhile;
                // Format number to the according month in letters.

                echo '</div>';
            }

        }
    } else {
        echo '<p class="error">Je moet ingelogd zijn om de activiteiten te kunnen bekijken!</p>';
        echo '<p class="error">Klik <a href="'.home_url().'/login-register">hier</a> om in te loggen of een account te registreren.</p>';
    }
}
add_shortcode('test12', 'activiteit');

function checks($post_id, $title) {
    // Get user info
    $user_info  = wp_get_current_user();
    $user_ID    = $user_info->ID;
    $user_name  = $user_info->display_name;
    $user_email = $user_info->user_email;

    $startDate  = get_field("start_tijd", $post_id);
    //$endDate    = get_field("eind_tijd", $post_id);
    // Devide date into 2 to fit into content.
    $pieces = explode(" ", $startDate);
    // Extract month number from the date of the activity.
    $month = date("m",strtotime($startDate));
    // Get second database connection information from functions.php
    global $db2;

    echo '<div id="'.get_the_ID().'" class="Activiteit">';
    echo $month;
    echo $post_id;
        echo '<h4 class="title">';
            echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
        echo '</h4>';
        echo '<p class="dateTime">'.$pieces[0].'<br>'.$pieces[1].'</p>';
        echo '<p class="description">'.get_the_excerpt().'</p>';
        // Create a form to call on a statement when the button is clicked,
        echo '<form class="actForm" method="post">';
        // Add the ID of the input (button) to the name of the button to make it "activiteit" specific.
        if ($already = $db2->get_var("SELECT column_name FROM `$post_id` WHERE ID = $user_ID")) {
            echo '<p>TEST</p>';
        } else {
        echo '<input type="submit" name="ActButton'.$post_id.'" value="Deelnemen" class="ActButton"/>';
        }
        echo '</form>';
    echo '</div>';
    
    // If the "Deelnemen" button is used.
    if(isset($_POST['ActButton'.$post_id.''])) {
        if ($exists = $db2->get_var("SHOW TABLES LIKE '".$post_id."'")) {
            // If the tabel exists, insert the user account values into the tabel from the specific activity.
            $insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");

            $to = 'larsderover@hotmail.com';
            $subject = 'The '.$title;
            $body = ' 
            <html> 
            <head> 
                <title>Welcome to CodexWorld</title> 
            </head> 
            <body> 
                <h1>Thanks you for joining with us!</h1> 
                <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                    <tr> 
                        <th>Name:</th><td>CodexWorld</td> 
                    </tr> 
                    <tr style="background-color: #e0e0e0;"> 
                        <th>Email:</th><td>contact@codexworld.com</td> 
                    </tr> 
                    <tr> 
                        <th>Website:</th><td><a href="http://www.codexworld.com">www.codexworld.com</a></td> 
                    </tr> 
                </table> 
            </body> 
            </html>'; 
            $headers = array('Content-Type: text/html; charset=UTF-8');
             
            wp_mail( $to, $subject, $body, $headers );

        } else {
        // If tabel doesnt exist yet, create table, then insert user info.
            $createTable = $db2->get_var("CREATE TABLE `$post_id` (
                ID INT(6),
                Naam VARCHAR(30) NOT NULL,
                Email VARCHAR(50)
                )");
            $insert = $db2->get_var("INSERT INTO `$post_id` (`ID`, `Naam`, `Email`) VALUES ('$user_ID', '$user_name', '$user_email')");
            // Also send mail to user here.
            wp_mail( $to, $subject, $body, $headers );
        }
    }

}
?>