<?php
/**
* The blog template file.
*
* @package flatsome
*/

get_header(); ?>
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
                                                    $nom_doc = get_field('nom_doc');
                                                ?>
												<?php if( get_field('lien_pdf') ): ?>
                                                    <a target="_self" name="<?php echo $nom_doc ?>" id="<?php echo $titre_doc ?>"  class="button primary is-smaller popmake-12004" onclick="telechargement(this.name, this.id)" href="">Télécharger</a>
                                                    <script type="text/javascript">
                                                    function telechargement(nom, titre)
                                                    {
                                                        let stateObj = { id: "100" };
                                                        window.history.replaceState(stateObj, "newdoc", "/documents?nom=" + nom);
                                                        document.getElementById('titre_doc').value = titre;                                                       
                                                    }
                                                    </script>
												<?php endif; ?>
												<!-- Visionner document -->
												<?php if( get_field('lien_pdf') ): ?>
													<a target="_self" class="button primary is-smaller" href="<?php the_permalink();?>" ><i class="glyphicon glyphicon-eye-open"></i>Visionner</a>
												<?php endif; ?>
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
<?php else : ?>
	<h1> Pas de documents </1>
	<?php endif; ?>

	<?php get_footer(); ?>
