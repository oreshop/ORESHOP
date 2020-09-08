<?php
// Add custom Theme Functions here
/* Afficher "À partir de" pour les produits variables */
add_filter( 'woocommerce_variable_sale_price_html', 'wpm_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wpm_variation_price_format', 10, 2 );

function wpm_variation_price_format( $price, $product ) {
	//On récupère le prix min et max du produit variable
	$min_price = $product->get_variation_price( 'min', true );
	$max_price = $product->get_variation_price( 'max', true );

	// Si les prix sont différents on affiche "À partir de ..."
	if ($min_price != $max_price){
		$price = sprintf( __( 'A partir de %1$s', 'woocommerce' ), wc_price( $min_price ) );
		return $price;
	// Sinon on affiche juste le prix
	} else {
		$price = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) );
		return $price;
	}
}


/*
 * On ajoute un nouveau statut de post &quot;en cours de livraison&quot; dans WordPress
 */
function msk_create_being_delivered_status_in_wc() {
	register_post_status(
		'wc-being-delivered',
		array(
			'label' => __('Livraison en cours ', 'uno'),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('Livraison en cours <span class="count">(%s)</span>', 'Livraison en cours <span class="count">(%s)</span>', 'uno')
		)
	);
}
add_action( 'init', 'msk_create_being_delivered_status_in_wc' );


/*
 * On insère ce nouveau statut dans la liste des statuts utilisés par WooCommerce
 */
function msk_add_being_delivered_status_to_wc($order_statuses) {
	$new_statuses_array = array();

	foreach ($order_statuses as $key => $status) {
		$new_statuses_array[$key] = $status;
		if ('wc-processing' === $key) $new_statuses_array['wc-being-delivered'] = __('Livraison en cours', 'uno');
	}

	return $new_statuses_array;
}
add_filter('wc_order_statuses', 'msk_add_being_delivered_status_to_wc');

/*******************
PREFIXE ORDER ID
****************/
add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number' );
function change_woocommerce_order_number( $order_id ) {
    $prefix = '10F';
    $new_order_id = $prefix . $order_id;
		//A noter que l'$order_id est celui de la bdd, pas celui renuméroté par le plugin 'Custom Order Numbers Options'
		$order_id = $new_order_id;
    return $new_order_id;
}

/**********************
VARIATION DANS CART
***********************/
add_filter ( 'wc_add_to_cart_message_html', 'filter_wc_add_to_cart_message_html', 10, 2 );
function filter_wc_add_to_cart_message_html( $message, $products ) {

    $product_id = key($products);
    $count = 0;

    $variation_id = isset( $_REQUEST[ 'variation_id' ] ) ? $_REQUEST[ 'variation_id' ] : null;

    // si on ne récupère pas de variations, alors on retourne simplement le message
    if ($variation_id == null) {
         return $message;
    }

    $var_product = wc_get_product( $variation_id );
    $variations = $var_product->get_variation_attributes();
    $attributes = $var_product->get_attributes();

    $variations_str = '';

    // on récupère toutes les variations
    if ( is_array( $variations ) ) {

        foreach( $variations as $key => $value ) {

            $key = str_replace( 'attribute_', '', $key );

            $attribute = $attributes[$key];

            $variations_str .= ', ' . $attribute;

        }

    }

    // on récupère la quantité
    foreach ( $products as $product_id => $qty ) {
		$titles[] = ( $qty > 1 ? absint( $qty ) . ' × ' : '' ) . sprintf( _x( '“%s”', 'Item name in quotes', 'woocommerce' ), strip_tags( get_the_title( $product_id ) ) );
		$count += $qty;
    }


    $product_title = '' . get_the_title( $product_id ) . ''; // Get the main product title
    $product_url = get_permalink( $product_id );
    $product_title .= $variations_str;

    //$product_title .= substr($variations_str, 0, -1);

    $added_text = sprintf( '%s X %s ajouté au panier !' , $count, $product_url, $product_title );

    $message = sprintf( '%S %s', wc_get_page_permalink( 'cart' ), __( 'View Cart', 'woocommerce' ), $added_text );

    return $message;
}


/***************************
 * Nom devis pdf
 */
if( function_exists('YITH_Request_Quote_Premium') ){
  add_filter('ywraq_pdf_file_name','ywraq_pdf_file_name', 10, 2);
  function ywraq_pdf_file_name( $filename, $order_id ){
      return 'DEVIS_ORÉ_SHOP_'.$order_id.'.pdf';
  }
}

/**
 * @snippet       Add First & Last Name to My Account Register Form - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WC 3.9
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
///////////////////////////////
// 1. ADD FIELDS
  
add_action( 'woocommerce_register_form_start', 'bbloomer_add_name_woo_account_registration' );
  
function bbloomer_add_name_woo_account_registration() {
    ?>
     <div class="name-content-register">
    <p class="form-row form-row-first name-register">
    <!-- <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label> -->
    <input placeholder="Prénom*"  type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
    </p>
  
    <p class="form-row form-row-last surname-register">
    <!-- <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label> -->
    <input placeholder="Nom*"  type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
      </div>
    <div class="clear"></div>
  
    <?php
}
  
///////////////////////////////
// 2. VALIDATE FIELDS
  
add_filter( 'woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3 );
  
function bbloomer_validate_name_fields( $errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
    }
    return $errors;
}
  
///////////////////////////////
// 3. SAVE FIELDS
  
add_action( 'woocommerce_created_customer', 'bbloomer_save_name_fields' );
  
function bbloomer_save_name_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
    }
  
}







// Add the code below to your theme's functions.php file to add a confirm password field on the register form under My Accounts.
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Les mots de passes ne correspondent pas', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide password-register-2">
		<!-- <label for="reg_password2"><?php _e( 'Confirmation de mot de passe', 'woocommerce' ); ?> <span class="required">*</span></label> -->
		<input placeholder="Confirmation du mot de passe*"  type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}

/**
 * Change min password strength.
 *
 * @author James Kemp (Iconic)
 * @link http://iconicwp.com/decrease-strength-required-woocommerce-passwords/
 * @param int $strength
 * @return int
 */
function iconic_min_password_strength( $strength ) {
  return 2;
}

add_filter( 'woocommerce_min_password_strength', 'iconic_min_password_strength', 10, 1 );

//Enlever quotes sur dashboard

// remove_action( 'woocommerce_before_my_account', array( YITH_YWRAQ_Order_Request(), 'my_account_my_quotes' ) );



//DEFER ALL JS SCRIPTS
function defer_parsing_of_js( $url ) {
  if ( is_user_logged_in() ) return $url; //don't break WP Admin
  if ( FALSE === strpos( $url, '.js' ) ) return $url;
  if ( strpos( $url, 'jquery.js' ) ) return $url;
  return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );




// // /*
// // /*  DOCUMENTS
// // /*
/*
* On utilise une fonction pour créer notre custom post type 'documents'
*/

function wpm_custom_post_type() {

	// On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
	$labels = array(
		// Le nom au pluriel
		'name'                => _x( 'Documents', 'Post Type General Name'),
		// Le nom au singulier
		'singular_name'       => _x( 'Document', 'Post Type Singular Name'),
		// Le libellé affiché dans le menu
		'menu_name'           => __( 'Documents'),
		// Les différents libellés de l'administration
		'all_items'           => __( 'Tous les documents'),
		'view_item'           => __( 'Voir les documents'),
		'add_new_item'        => __( 'Ajouter un nouveau document'),
		'add_new'             => __( 'Ajouter'),
		'edit_item'           => __( 'Editer le document'),
		'update_item'         => __( 'Modifier le document'),
		'search_items'        => __( 'Rechercher un document'),
		'not_found'           => __( 'Non trouvée'),
		'not_found_in_trash'  => __( 'Non trouvée dans la corbeille'),
	);
	
	// On peut définir ici d'autres options pour notre custom post type
	
	$args = array(
		'label'               => __( 'Documents'),
		'description'         => __( 'Tous sur les documents'),
		'labels'              => $labels,
		'menu_icon'           => 'dashicons-media-document',
		// On définit les options disponibles dans l'éditeur de notre custom post type ( un titre, un auteur...) 
		// Les autres champs liseuses et liens pdf sont crées avec ACF
		'supports'            => array( 'title', 'thumbnail', 'revisions', 'page-attributes','editor'),
		/* 
		* Différentes options supplémentaires
		*/	
		'show_in_rest' => true,
		'menu_position'       => 4,
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			  => array( 'slug' => 'documents', 'with_front' => false ),

	);
	
	// On enregistre notre custom post type qu'on nomme ici "serietv" et ses arguments
	register_post_type( 'document', $args );

}

add_action( 'init', 'wpm_custom_post_type', 0 );
add_action( 'init', 'wpm_add_taxonomies', 0 );

//On créer 1 taxonomie personnalisée: Catégories de document.

function wpm_add_taxonomies() {
	
	// Catégorie de document

	$labels_cat_serie = array(
		'name'                       => _x( 'Catégories', 'taxonomy general name'),
		'singular_name'              => _x( 'Catégories', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une catégorie'),
		'popular_items'              => __( 'Catégories populaires'),
		'all_items'                  => __( 'Toutes les catégories'),
		'edit_item'                  => __( 'Editer une catégorie'),
		'update_item'                => __( 'Mettre à jour une catégorie'),
		'add_new_item'               => __( 'Ajouter une nouvelle catégorie'),
		'new_item_name'              => __( 'Nom de la nouvelle catégorie'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une catégorie'),
		'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées'),
		'not_found'                  => __( 'Pas de catégories trouvées'),
		'menu_name'                  => __( 'Catégories'),
		'slug'                  => __( 'Slug'),
	);

	$args_cat_serie = array(
	// Si 'hierarchical' est défini à true, notre taxonomie se comportera comme une catégorie standard
		'hierarchical'          => true,
		'labels'                => $labels_cat_serie,
		'show_ui'               => true,
		'show_in_rest'			=> true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'has_archive'         => true,
		'rewrite'               => array( 'slug' => 'categories-documents' ),
	);

  register_taxonomy( 'categoriesdocuments', 'document', $args_cat_serie );
  
}
// Display prix HT/TTC
add_filter( 'woocommerce_show_variation_price', '__return_true' );


// // /*  RÉALISATIONS

/* On utilise une fonction pour créer notre custom post type 'réalisation'*/

function wpc_cpt_realisations() {

	/* Réalisation */
	$labels_real = array(
		'name'                => _x('Réalisations', 'Post Type General Name'),
		'singular_name'       => _x('Réalisation', 'Post Type Singular Name'),
		'menu_name'           => __('Réalisations'),
		'name_admin_bar'      => __('Réalisations'),
		'all_items'           => __('Toutes les réalisations'),
		'add_new_item'        => __('Ajouter une nouvelle réalisation'),
		'add_new'             => __('Ajouter'),
		'edit_item'           => __('Modifier une réalisation'),
		'update_item'         => __('Modifier une réalisation'),
		'view_item'           => __('Voir la réalisation'),
		'search_items'        => __('Rechercher une réalisation'),
		'not_found'           => __('Non trouvée'),
		'not_found_in_trash'  => __('Non trouvée dans la corbeille'),
	);

	$args_real = array(
		'label'               => __('Réalisation'),
		'description'         => __('Réalisations'),
		'labels'              => $labels_real,
		'supports'            => array('title', 'thumbnail'),
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-lightbulb',
		'show_in_rest' 		  => true,
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			  => array( 'slug' => 'realisations', 'with_front' => false),
	);
	register_post_type('realisation', $args_real);	
}

add_action('init', 'wpc_cpt_realisations', 0);
add_action( 'init', 'wpm_add_taxonomies_cat', 0 );

//On créer 1 taxonomie personnalisée: Catégories de réalisation.

function wpm_add_taxonomies_cat() {
	
	// Catégorie de réalisation.

	$labels_cat_realisation = array(
		'name'                       => _x( 'Catégories', 'taxonomy general name'),
		'singular_name'              => _x( 'Catégories', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une catégorie'),
		'popular_items'              => __( 'Catégories populaires'),
		'all_items'                  => __( 'Toutes les catégories'),
		'edit_item'                  => __( 'Editer une catégorie'),
		'update_item'                => __( 'Mettre à jour une catégorie'),
		'add_new_item'               => __( 'Ajouter une nouvelle catégorie'),
		'new_item_name'              => __( 'Nom de la nouvelle catégorie'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une catégorie'),
		'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées'),
		'not_found'                  => __( 'Pas de catégories trouvées'),
		'menu_name'                  => __( 'Catégories'),
		'slug'                  => __( 'Slug'),
	);

	$args_cat_realisation = array(
	// Si 'hierarchical' est défini à true, notre taxonomie se comportera comme une catégorie standard
		'hierarchical'          => true,
		'labels'                => $labels_cat_realisation,
		'show_ui'               => true,
		'show_in_rest'			=> true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'has_archive'         => true,
		'rewrite'               => array( 'slug' => 'categories-realisations' ),
	);

  register_taxonomy( 'categoriesrealisations', 'realisation', $args_cat_realisation );

}


add_action('init', function(){
  add_theme_support('post-thumbnails'); 
});

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('main', get_stylesheet_uri());
  wp_enqueue_script('main', get_stylesheet_directory_uri() . '/sorting.js', '', '', true);
});


// VIDÉO

/* On utilise une fonction pour créer notre custom post type 'vidéo'*/

function wpc_cpt_video() {

	/* Réalisation */
	$labels_video = array(
		'name'                => _x('Vidéo', 'Post Type General Name'),
		'singular_name'       => _x('Vidéo', 'Post Type Singular Name'),
		'menu_name'           => __('Vidéos'),
		'name_admin_bar'      => __('Vidéos'),
		'all_items'           => __('Toutes les vidéos'),
		'add_new_item'        => __('Ajouter une nouvelle vidéo'),
		'add_new'             => __('Ajouter'),
		'edit_item'           => __('Modifier une vidéo'),
		'update_item'         => __('Modifier une vidéo'),
		'view_item'           => __('Voir la vidéo'),
		'search_items'        => __('Rechercher une vidéo'),
		'not_found'           => __('Non trouvée'),
		'not_found_in_trash'  => __('Non trouvée dans la corbeille'),
	);

	$args_video = array(
		'label'               => __('Vidéo'),
		'description'         => __('Vidéos'),
		'labels'              => $labels_video,
		'supports'            => array('title', 'thumbnail'),
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-video-alt3',
		'show_in_rest' 		  => true,
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			  => array( 'slug' => 'videos', 'with_front' => false),
		'capabilities' => array(
			'edit_post'          => 'update_core',
			'read_post'          => 'update_core',
			'delete_post'        => 'update_core',
			'edit_posts'         => 'update_core',
			'edit_others_posts'  => 'update_core',
			'delete_posts'       => 'update_core',
			'publish_posts'      => 'update_core',
			'read_private_posts' => 'update_core'
		),
	);
	register_post_type('video', $args_video);	
}

add_action('init', 'wpc_cpt_video', 0);
add_action( 'init', 'wpm_add_taxonomies_video', 0 );

//On créer 1 taxonomie personnalisée: Catégories de réalisation.

function wpm_add_taxonomies_video() {
	
	// Catégorie de vidéos.

	$labels_cat_video = array(
		'name'                       => _x( 'Catégories', 'taxonomy general name'),
		'singular_name'              => _x( 'Catégories', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une catégorie'),
		'popular_items'              => __( 'Catégories populaires'),
		'all_items'                  => __( 'Toutes les catégories'),
		'edit_item'                  => __( 'Editer une catégorie'),
		'update_item'                => __( 'Mettre à jour une catégorie'),
		'add_new_item'               => __( 'Ajouter une nouvelle catégorie'),
		'new_item_name'              => __( 'Nom de la nouvelle catégorie'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une catégorie'),
		'choose_from_most_used'      => __( 'Choisir parmi les catégories les plus utilisées'),
		'not_found'                  => __( 'Pas de catégories trouvées'),
		'menu_name'                  => __( 'Catégories'),
		'slug'                  => __( 'Slug'),
	);

	$args_cat_video = array(
	// Si 'hierarchical' est défini à true, notre taxonomie se comportera comme une catégorie standard
		'hierarchical'          => true,
		'labels'                => $labels_cat_video,
		'show_ui'               => true,
		'show_in_rest'			=> true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'has_archive'         => true,
		'rewrite'               => array( 'slug' => 'categories-videos' ),
	);

  register_taxonomy( 'categoriesvideos', 'video', $args_cat_video );

}
require_once('inc/scripts.php');
require_once('inc/styles.php');
require_once('inc/ajax/filter.php');


require_once('inc/post-types/_post-type-includes.php');
require_once('inc/taxonomies/_taxonomies-includes.php');

// include option tree
require_once('inc/options/_option-includes.php');

require_once('inc/general-functions.php');


add_filter('acf/settings/remove_wp_meta_box', '__return_false');
