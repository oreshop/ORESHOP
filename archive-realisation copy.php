<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<!-- DNS prefetching -->
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<!-- Website info -->
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
	<!-- Google Fonts -->

	<!-- WP Head -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/**
* The blog template file.
*
* @package flatsome
*/

get_header(); ?>

<div class="page-title-inner flex-row  medium-flex-wrap container">
    <div class="flex-col flex-grow medium-text-center">
        <div class="is-medium">
            <div class="product-breadcrumb-container is-smaller">
                <nav id="breadcrumbs" class="yoast-breadcrumb breadcrumbs uppercase">
                    <?php
                        if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<h4 id="breadcrumbs">','</h4>');}
                    ?>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="content-area page-wrapper">
	<div class="row">
		<div class="col small-12 large-12">
			<div class="col-inner">
				<h2>Réalisations</h2>
				<p>Vous trouverez sur cette page une liste non exhaustive de nos références chantiers, à savoir quelques exemples où nos produits ont été utilisés dans des conditions réelles d'application. </p>
			</div>
		</div>
		<div class="col small-12 large-3">

		<?php get_template_part('partials/home/sidebar'); ?>

		</div>
<div class="large-9  small-12  col page-realisations" data-js-filter="target">
			<div class="col-inner">
					<div class="bg section-bg fill bg-fill bg-loaded">
					</div>
					<div class="section-content relative">
						<div class="row large-columns-5 medium-columns-4 small-columns-2">
						<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
     'post_type' => 'realisation',
     'posts_per_page' => 20,
     'paged' => $paged
);

$loop = new WP_Query( $args );	?>
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
						<div class="col gallery-col ">
								<div class="col-inner">
									<div class="row row-small">
											<div class="col-inner">
												<div class="box has-hover has-hover box-shade dark box-text-middle">
														<div class="box-image image-cover">
															<?php the_post_thumbnail('small'); ?>
														</div>
														<a style="display:block" href="<?php the_permalink();?>">
														<div class="box-text show-on-hover hover-fade-out text-center hover-real" style="background-color: rgba(46, 45, 45, 0.43);height:100%">
															<div class="box-text-inner">
																<h4 class="show-on-hover hover-zoom-in hover-zoom text-center"><?php the_title() ?></h4>
															</div>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
									<?php endwhile ?>
<?php wp_reset_postdata(); ?>
							</div>
							<?php the_posts_pagination( array(
								'mid_size' => 2,
								'prev_text' => __( 'Précédent', 'textdomain' ),
								'next_text' => __( 'Suivant', 'textdomain' ),
							) ); ?>
					</div>
			</div>
		</div>
	<div>
</div>
	


<?php else : ?>
	<h1> Pas de réalisations </h1>
	<?php endif; ?>


	<?php get_footer(); ?>

</body>