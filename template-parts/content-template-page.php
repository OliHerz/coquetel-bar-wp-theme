<?php
/*
Template Name: Template Coquetel
*/

get_header(); ?>

  <div class="asideClass">
    <h1 class="coquetelBar"> <?php echo the_title() ?> </h1>

    <section class="leftSectionContent">

      <div class="content">
        <?php the_excerpt(); ?>
      </div>
    </section>

    
    
<!------------ 'FOOTER' coté gauche, partie Aside  ------------>
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
          echo 'Aucune  information trouvé';
        }
        ?>
    </section>
  </div>

<!------------ SECTION DROITE   ------------>
  <section class="rightSection"> 
  <div class="backgroundImage">
    <?php $image_id = get_post_thumbnail_id();
          $image_url = wp_get_attachment_image_src( $image_id, 'full' );?>
    <img src="<?php echo $image_url[0]; ?>" class="bgImage" alt="Image en background de la page">
  </div>
  <!-- <div class="overlay1"></div> -->
  <div class="overlay2"></div>

<!------------ CONTAINER PRINCIPALE  ------------>
    <section class="rightSectionContent">

      <!-- Page d'évènements -->
        <?php if( is_page(13) ): ?>
        <?php get_template_part('template-parts/content', 'page-events'); ?>
        <?php endif; ?>

      <!-- Page Boissons -->
        <?php if( is_page(11) ): ?>
        <?php get_template_part('template-parts/content', 'page-boissons'); ?>
        <?php endif; ?>

      <!--  Page Menu -->
        <?php if( is_page(9) ): ?>
        <?php get_template_part('template-parts/content', 'page-menus'); ?>
        <?php endif; ?>

      <!-- Page Contact -->
        <?php if( is_page(15) ): ?>
          <?php get_template_part('template-parts/content', 'page-contact'); ?>
        <?php endif; ?>

      </section>

  </section> 


<?php get_footer(); ?>