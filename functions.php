<?php

  // Intégration du fichier avec les appels add_action().
  require_once get_template_directory() . '/inc/actions.php';

  // Intégration du fichier avec les fonctions de template.
  require_once get_template_directory() . '/inc/template-functions.php';

  // Intégration du fichier avec les appels add_filter().
  require_once get_template_directory() . '/inc/filters.php';

  // Intégration du fichier avec les fonctions de filtrage.
  require_once get_template_directory() . '/inc/filter-functions.php';

  // Walker Nav Menu
  require_once get_template_directory() . '/classes/class-coquetel-nav-menu.php';

  // Plugin ACF
  require_once get_template_directory() . '/inc/plugins/acf.php';


  // Affiche ou cache la bar d'admin menu Wordpress
  add_filter('show_admin_bar', '__return_false');