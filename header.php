<!DOCTYPE html>
<html>
  <head  <?php language_attributes(); ?>>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?> class="noscroll">
  <?php wp_body_open(); ?>

  <header class='topLeftSection'>
    
    <div class="containerLogo">
      <?php 
        if (has_custom_logo() ):
        $logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) );?>
          <img src="<?php echo $logo[0]; ?>"  class="logoCoquetel" 
          href="<?php echo esc_url( home_url('/') ); ?>" 
          aria-label="Logo du Coquetel Bar">
        <?php endif; ?>
    </div>

    <nav class="nav">
      <?php
          wp_nav_menu( array (
            'theme_location' => 'Menu dynamique',
            'container'      => false,
            'menu_class'     => 'navList',
            'depth'          => 1,
            'walker'         => new Custom_Walker_Nav_Menu()
          ) );
      ?>
    </nav>

    <button class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </header>

<main class="main">
<!------------ Header Part (navbar + logo + bugerMenu section) -------------->
