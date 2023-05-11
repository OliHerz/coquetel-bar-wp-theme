<?php


get_header();
?>


<!------------ Colonne gauche de la page   ------------>
  <div class="asideClass">
    <h1 class="coquetelBar"> Bienvenue ! </h1>
  
    <section class="leftSectionContent">
      <div class="content">
        <?php the_excerpt(); ?>
      </div>
    </section>

<!------------ Contenu texte de la page  ------------>

<!------------ FOOTER  ------------>
    <section class="footer">
    <?php $args = array(
          'post_type' => 'information_generale',
          'posts_per_page' => -1,
        );
        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'informations-generales' );
          }
          wp_reset_postdata();
        } else {
          // Afficher un message d'erreur si aucun post n'a été trouvé
          echo 'Aucune  information trouvé';
        }
        ?>
    </section>
  </div>

  <!------------ SECTION DROITE   ------------>
  <section class="rightSection landing-page-section"> 
    <div class="backgroundImage  ">
      <?php $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_image_src( $image_id, 'full' );?>
      <img src="<?php echo $image_url[0]; ?>" class="bgImage" alt="">
    </div>
    <div class="overlay1"></div>
    <div class="overlay2"></div>

    <!------------ CONTAINER PRINCIPALE  ------------>
    <section class="rightSectionContent content-landing-page">

      <!-- <div class="content-accueil"> 
        <p> Des boissons d'exceptions, </p>
        <p> Vos cocktails préférés </p>
        <p> Et ceux que vous ne connaissez pas encore</p>
      </div> -->

      <?php the_content(); ?>

    </section>

  </section>



<?php
get_footer();
?>