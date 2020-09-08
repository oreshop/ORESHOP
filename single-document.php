<?php
/**
 * The blog template file.
 *
 * @package flatsome
 */

get_header();

?>

<?php if ( have_posts() ) : ?>

<?php /* Start the Loop */ ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-title-inner flex-row  medium-flex-wrap container">
    <div class="flex-col flex-grow medium-text-center">
        <div class="is-medium">
            <div class="product-breadcrumb-container is-smaller">
                <nav id="breadcrumbs" class="yoast-breadcrumb breadcrumbs uppercase">
                    <?php
                        if ( function_exists('yoast_breadcrumb') ) {yoast_breadcrumb('<p id="breadcrumbs">','</p>');}
                    ?>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col small-12 large-12">
		<div class="col-inner">
			<h2><?php get_template_part( 'template-parts/posts/partials/entry', 'title'); ?></h2>
			<?php if( get_field('lien_pdf') ): ?>
    			<a target="_self" class="button primary" href="" >Télécharger le document</a>
			<?php endif; ?>
			<div class="embed-container">
			<div style="text-align:center;"><div style="margin:8px 0px 4px;"></div><iframe src="<?php the_field('iframe_liseuse'); ?>" width="1200" height="800" frameborder="0" scrolling="no" allowtransparency allowfullscreen style="margin:0 auto;"></iframe><div style="margin:4px 0px 8px;"></div></div>
			</div>
		</div>
	</div>
</div>

<?php get_template_part( 'template-parts/posts/content', 'single' ); ?>

<?php endwhile; ?>
<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

<?php get_footer();


