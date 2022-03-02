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
            echo '<a href="'.home_url().'">';
                echo '<img src="http://localhost/projectbureautest/projectbureautest/wordpress/wp-content/uploads/2022/02/Plak_Cirkels_RGB.png" class="headerIMG" alt="">';
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
    $args = array(
        'post_type' => 'Activiteiten',
        'posts_per_page' => 10
    );
    global $post;
    $query = new WP_Query($args);
    if ($query->have_posts()) { 
        echo '<div class="Activiteiten">';
            while ( $query->have_posts() ) : $query->the_post();
            $post_id = get_the_ID();
            // call here on function and give information to check if information is valid:
            // aFunctionHere($post);
            //call_user_func(array($this, 'testF')); 
            echo '<div id="'.get_the_ID().'" class="Activiteit">';
                echo '<h4 class="title">';
                    echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
                echo '</h4>';
                echo '<p class="description">'.get_the_excerpt().'</p>';
            echo '</div>';//
            endwhile;
        echo '</div>';
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
add_shortcode('test12', 'activiteit');
?>