<?php get_header(); ?>
<!-- <section class="leftSectionContent"> -->

    <!-- <div class="content">
      <?php 
      // the_content(); 
      ?>
    </div> -->

    <!-- </section> -->

<?php
  if (have_posts()) : 
    while (have_posts() ) : the_post();
    
      echo '<h3>' . get_post_type() . '</h3>';
      get_template_part( 'template-parts/content', get_post_type() );
      // the_title( '<h2 class=nomDePage>', '</h2>');
      // the_content( '<div class="content">', '</div>');

    endwhile;
  endif;
?>

    
  <?php get_footer(); ?>