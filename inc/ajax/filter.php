<?php

add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );
add_action( 'wp_ajax_filter', 'filter_ajax' );

function filter_ajax() {

    print_r($_POST);

    $realisation_title = $_POST['realisation-title'];
    $realisation_genre = $_POST['realisation-genre'];
    $realisation_keywords = $_POST['realisation-keywords'];
    $realisation_order = $_POST['realisation-order'];

    $args = array(
        'post_type' => 'realisation',
        'posts_per_page' => -1,
        'order' => 'ASC',
       );

    // For the search bar
    if(!empty($realisation_title)) {
        $args['s'] = $realisation_title;
    }

    //genres dropdown
    if(!empty($realisation_genre)){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'genre',
                'field'    => 'term_id',
                'terms'    => array($realisation_genre) 
            )
        );
    }

    //keyword
    if(!empty($realisation_keywords)){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'keyword',
                'field'    => 'term_id',
                'terms'    => $realisation_keywords
            )
        );
    }
        
    //order by Alphabetique / Populaire
    if(!empty($realisation_order)){

        $order_param = '';
        $meta_query = array();

        if($realisation_order == 'Alphabetical') {
            $order_param = 'title';
        } elseif($realisation_order == 'Popularity') {
            $order_param = 'meta_value_num';
            $args['meta_key'] = 'score';
            $args['order'] = 'DESC'; 
        }  
        else {
            $order_param = 'date';
        }

        $args['orderby'] = $order_param;
    }





      $query = new WP_Query($args);
    
      if($query->have_posts()) : 
        
        $counter = 0;
        
        while($query->have_posts()) : $counter++; $query->the_post();
    
        $realisation_id = get_the_ID();
      
        $url = get_the_permalink();
        $title = get_the_title();
        $thumb = get_the_post_thumbnail_url();
        $excerpt = get_the_excerpt();
        $year = get_post_meta($realisation_id,'year',true);
        $rating = get_post_meta($realisation_id,'rating',true);
        $runtime = get_post_meta($realisation_id,'runtime',true);
        $score = get_post_meta($realisation_id,'score',true);
    
        $taxonomy = 'category';
     
        // Get the term IDs assigned to post.
        $post_terms = wp_get_object_terms( $realisation_id, $taxonomy, array( 'fields' => 'ids' ) );
        
        // Separator between links.
        $separator = ', ';
        
        if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
        
            $term_ids = implode( ',' , $post_terms );
        
            $terms = wp_list_categories( array(
                'title_li' => '',
                'style'    => 'none',
                'echo'     => false,
                'taxonomy' => $taxonomy,
                'include'  => $term_ids
            ) );
        
            $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
        }
    
    ?>
    <article data-css-card="realisation-card">
      <div data-css-card="realisation-wrapper">
        <div data-css-card="realisation-thumbnail">
          <img src="<?= $thumb; ?>" alt="Avengers: Infinity War" />
        </div>
        <div data-css-card="realisation-summary">
          <h2 class="title"><span class="number"><?= $counter; ?>. </span><a href="<?= $url;?>"><?= $title; ?></a> <span class="date">(<?= $year; ?>)</span></h2>
          <div data-css-card="realisation-meta">
            <span class="rating"><?= $rating; ?></span> 
            <span class="runtime"><?= $runtime; ?></span> 
            <div class="categories">
              <?= $terms; ?>
            </div>
          </div>
          <p data-css-card="realisation-score"><span class="score"><?= $score; ?></span></p>
          <?= $excerpt; ?>
        </div>
      </div>
    </article>
    <?php endwhile;
    else : ?>
    <article data-css-card="realisation-card" >
        <p>Pas de film</p>
    </article>
  <?php endif; 
    wp_reset_postdata(); 
        
    die();

}
