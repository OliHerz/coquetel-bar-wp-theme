
<?php

// ajoute les actions. en fonction de ('quelle actions est effectuée' -> 'quelle fonction cela lance')

add_action('after_setup_theme', 'themeCoquetel_supports');

// permet d'activer l'utilisation des scritp enregistrés dans la fonction 'themeCoquetel_register_assets'
add_action('wp_enqueue_scripts', 'themeCoquetel_register_assets');

// Register the menu locations.
add_action( 'after_setup_theme', 'themeCoquetel_register_menus' );

// add_action( 'after_setup_theme', 'themeCoquetel_menu_class' );
// add_action( 'after_setup_theme', 'themeCoquetel_menu_link_class' );




remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function() {
  while ( @ob_end_flush() );
} );

// Ajouter le filtre de taxonomie à la page d'administration des boissons 
add_action( 'restrict_manage_posts', 'filter_carte_boissons_by_categorie' );
// Modifie la requête de la liste des boissons pour inclure le filtre de taxonomie
add_action( 'pre_get_posts', 'filter_carte_boissons_by_categorie_query' );



// Ajouter le filtre de taxonomie à la page d'administration des menus
add_action( 'restrict_manage_posts', 'filter_carte_menu_by_categorie' );
// Modifie la requête de la liste des menus pour inclure le filtre de taxonomie
add_action( 'pre_get_posts', 'filter_carte_menu_by_categorie_query' );
