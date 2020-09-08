<?php

/**
 * Template Name: Home Page
 *
 */

get_header();?>
 <div data-css-flex="container">
            <div data-css-flex="row-col">
			<div class="content-area page-wrapper">
				<div class="row">
					<div class="col small-12 large-12">
						<div class="col-inner">
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
							<h2>Réalisations</h2>
							<p>Vous trouverez sur cette page une liste non exhaustive de nos références chantiers, à savoir quelques exemples où nos produits ont été utilisés dans des conditions réelles d'application. </p>
						</div>
					</div>
					<div class="col small-12 large-3">
						<?php  get_template_part('partials/home/sidebar'); ?>
					</div>		
			<div class="col small-12 large-9 page-realisations">	
            <div class="col-inner">
                <div class="bg section-bg fill bg-fill bg-loaded">
            </div>
                 <div class="section-content relative " data-css-content="main">
                     <div class="row large-columns-5 medium-columns-4 small-columns-2" data-js-filter="target">
			        	<?php  get_template_part('partials/home/content')  ?>
		        	</div>
                </div>
            </div>
        </div>
  </div>
    <?php 
get_footer();
