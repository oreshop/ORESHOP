<?php
  $args = array(
    'post_type' => 'realisation',
    'posts_per_page' => -1,
    'order' => 'ASC'
  );
  $query = new WP_Query($args);

  if($query->have_posts()) : 
    
    $counter = 0;
    
    while($query->have_posts()) : $counter++; $query->the_post();

    $realisation_id = get_the_ID();
  
    $url = get_the_permalink();
    $title = get_the_title();
    $thumb = get_the_post_thumbnail_url();

    $taxonomy = 'realisation';
 
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
						<div class="col gallery-col" data-css-card="realisation-card">
								<div class="col-inner">
									<div class="row row-small">
											<div class="col-inner">
												<div class="box has-hover has-hover box-shade dark box-text-middle" data-css-card="realisation-summary">
														<div class="box-image image-cover " data-css-card="realisation-thumbnail">
															<?php the_post_thumbnail('small'); ?>
														</div>
														<a style="display:block" href="<?php the_permalink();?>">
														<div class="box-text show-on-hover hover-fade-out text-center hover-real" style="background-color: rgba(46, 45, 45, 0.43);height:100%">
															<div class="box-text-inner">
																<h4 class="show-on-hover hover-zoom-in hover-zoom text-center title"><?php the_title() ?></h4>
															</div>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
                </div>
            <?php endwhile;
          endif; wp_reset_postdata();