<?php
/**
* The blog template file.
* @package flatsome
*/

get_header(); ?>

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

<div class="content-area page-wrapper">
	<div class="row">
		<div class="col small-12 large-12">
			<div class="col-inner">
				<h2>Nos documentations</h2>
				<p>Vous trouverez dans cette rubrique l’ensemble de nos documentations au format PDF, notamment notre catalogue/tarif annuel ainsi que les brochures commerciales.</br>Pour télécharger les fiches techniques ou les fiches de sécurité des produits, rendez-vous directement sur la page du produit en tapant son nom dans la barre de recherche située en haut à droite.</p>
			</div>
		</div>
	</div>
	<div class="row row-main">
		<div class="large-12 col">
			<div class="col-inner">
				<?php if ( have_posts() ) : ?>
					<div class="row">
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="col medium-4 small-12 large-3">
								<div class="col-inner">
									<div class="box has-hover   has-hover box-text-bottom">
										<div class="box-image" style="width: 70%;">
											<a href="<?php the_permalink();?>">
												<?php the_post_thumbnail('small'); ?>
											</a>
										</div>
										<div class="box-text text-center">
											<div class="box-text-inner">
												<?php
                                                    //Titre documentation
                                                    echo '<p>' . get_the_title() . '</p>';
                                                    $titre_doc = get_the_title();
                                                    $lien_pdf_php = get_field('lien_pdf');
                                                ?>
												<?php if( get_field('lien_pdf') ):
                                                    if( get_field('formulaire_obligatoire') == 'obligatoire' ) { ?>
                                                        <a target="_self" name="<?php echo $titre_doc ?>" class="button primary is-smaller popmake-12004" onclick="telechargement(this.name)" href="">Télécharger</a>
                                                        <?php }
                                                    else { ?>
                                                        <a target="_blank" class="button primary is-smaller" href="<?php echo $lien_pdf_php; ?>">Télécharger</a>
                                                    <?php }
                                                    endif;
												//Visionner document
												if( get_field('lien_pdf') ): ?>
													<a target="_self" class="button primary is-smaller" href="<?php the_permalink();?>" ><i class="glyphicon glyphicon-eye-open"></i>Visionner</a>
												<?php endif ?>
											</div>
										</div>
									</div>
								</div>
							</div>
				    <?php endwhile ?>
					</div>
				</div>
			</div>
		</div>
    </div>
    <script type="text/javascript">
    function telechargement(titre)
    {
        //let stateObj = { id: "100" };
        //window.history.replaceState(stateObj, "newdoc", "/documents?nom=" + nom);
        switch (titre) {
            case 'Guide des produits de marquage routier 3S': var pdf = "Guide des produits de marquage routier 3S 2020 web - Oré Peinture.pdf";break;
            case 'Tarif Routier 2020': var pdf = "Tarif routier 2020 Oré Peinture.pdf" ; break;
            case 'Tarif Bâtiment 2020-2021': var pdf = "Tarif batiment 2020-2021 Oré Peinture.pdf" ; break;
            case 'Tarif T SIGN 2020 – Marquage thermocollé': var pdf = "Tarif 2020 - Signalisation préfabriquée thermocollée T SIGN - Oré Peinture.pdf" ; break;
            case 'Tarif ADVIA 2020 – Marquage adhésif': var pdf = "Tarif 2020 - Marquage adhésif préfabriqué ADVIA - Oré Peinture.pdf" ; break;
            case 'ForQuali – Formation professionnelle': var pdf = "forquali/Depliant-ForQuali-web.pdf" ; break;
            case 'Les solutions d’accessibilité MOBILE' : var pdf = "Les-solutions-accessibilite-MOBILE-ore-peinture.pdf" ; break;
            case "Guide sur l'aménagement urbain Viadécor" : var pdf = "Guide%20aménagement%20urbain%20VIADECOR%20web.pdf" ; break;
            case 'Plaquette T LUDO : jeux au sol thermocollés': var pdf = "Gamme%20aire%20de%20jeux%20thermocolles%20T%20LUDO%202019%20-%20doc%20web.pdf" ; break;
        }
        document.getElementById('titre_doc').value = titre;
        document.getElementById('pdf_doc').value = pdf;  
    }
    </script>
<?php else : ?>
	<h1> Pas de documents </1>
	<?php endif; ?>

	<?php get_footer(); ?>
