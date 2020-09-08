<?php get_template_part('template-parts/portfolio/portfolio-title', flatsome_option('portfolio_title')); ?>
<div class="portfolio-top">
<div class="page-wrapper row">


<div id="portfolio-content" class="large-12 col"  role="main">
	<div class="portfolio-inner">
		<?php get_template_part('template-parts/portfolio/portfolio-content'); ?>
	</div><!-- .portfolio-inner -->
</div><!-- #portfolio-content -->

</div><!-- .row -->
</div><!-- .portfolio-top -->

<div class="portfolio-bottom">
	<?php get_template_part('template-parts/portfolio/portfolio-next-prev'); ?>
	<?php get_template_part('template-parts/portfolio/portfolio-related'); ?>
</div>
