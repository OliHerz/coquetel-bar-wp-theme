<?php
// Spécifie toutes les actions que le thème peut supporter 

function themeCoquetel_supports() {
  // permet de donner à la page son titre dans le nagivateur
    add_theme_support('title-tag');
  
  // permet d'ajouter les menus personnalisés
    add_theme_support( 'menus' );
  
  // permet d'intégrer un logo personnalisé dans la page (header, footer, ...)
    add_theme_support('custom-logo');
    add_theme_support('custom_logo', array(
      'height'      => 150,
      'width'       => 150,
      'flex-height' => true,
      'flex-width'  => true,
    ));

  // Ajout de l'image mise en avant 
    add_theme_support( 'post-thumbnails' );
  
  // Permet du thème de supporter des modèles templates de pages personnalisées 
    add_theme_support('post-templates');

    add_post_type_support('page', 'excerpt');

    add_theme_support(
      'html5',
      array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
      )
    );

    add_theme_support( 'disable-custom-font-sizes' );

    add_theme_support( 'disable-custom-colors' );

    add_theme_support( 'editor-color-palette' );
    
    remove_action('wp_head', '_admin_bar_bump_cb');

  }

// permet de créer des menus personalisables
function themeCoquetel_register_menus(){
  register_nav_menus( array(
    'Menu dynamique' => ( 'walker')
  ));
}

// permet de cibler la class Wordpress attribuée aux liens <li> dans la navlist, et changer cette class
// function themeCoquetel_menu_class($classes){
//   $classes[] = 'navItem';
//   return $classes; 
// }

// // permet de cibler la class Wordpress attribuée aux liens <a> dans la navlist, et changer cette class
// function themeCoquetel_menu_link_class($attrs){
//   $attrs['class'] = 'navLink';
//   return $attrs; 
// }

function tribe_past_reverse_chronological_v2( $template_vars ) {
  if ( ! empty( $template_vars['is_past'] ) ) {
    $template_vars['events'] = array_reverse( $template_vars['events'] );
  }
  return $template_vars;
}


function themeCoquetel_register_assets(){
  // Import des font Google
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Lobster&family=Lobster+Two&family=Montserrat:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap');

  // Import des icons font Awesome
  wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

  // Import de la feuille de style.css
  wp_enqueue_style('style', get_stylesheet_uri(). './../dist/styles.css');

  // // Import du script JS  & Chargement
  wp_enqueue_script('script', get_theme_file_uri('dist/script.js'), array(), '1.0', true); 
}


function add_defer_attribute ($tag, $handle){
  $scripts_to_defer = array ('script');
  foreach( $scripts_to_defer as $defer_script) {
    if ($defer_script === $handle){
      return str_replace (' src', ' defer="defer" src', $tag);
    }
  } return $tag;
}



// ---------- Fonctions qui permettent d'afficher les catégories et sous catégories du type de posts Boissons ---------- 
// 'restrict_manage_posts' = hook qui permet d'ajouter des filtres aux pages d'adminisration de contenu
// ajoute un formulaire de sélection pour filtrer les résultats de la liste de publications en fonction 
// des termes de taxonomie (catégories) associés à ces publications personnalisées.
function filter_carte_boissons_by_categorie() {
  global $typenow;

  // On affiche le filtre de taxonomie uniquement pour le type de post "carte_boissons"
  if ( $typenow == 'carte_boisson' ) {
    $taxonomy = 'cat_boissons';
    $current_taxonomy = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';

    // Obtenir toutes les catégories de boissons avec ou sans sous-catégories
    $categories = get_terms( array(
      'taxonomy' => $taxonomy,
      'hide_empty' => false,
    ) );

    // On doit créer un tableau pour stocker les catégories parentes et leurs enfants
    $category_tree = array();
    foreach ( $categories as $category ) {
      if ( $category->parent == 0 ) {
        $category_tree[ $category->slug ] = array(
          'name' => $category->name,
          'children' => array(),
        );
      } else {
        $category_tree[ $category->parent ]['children'][ $category->slug ] = $category->name;
      }
    }

    // Créer un tableau pour stocker les catégories parentes et leurs enfants
    $category_tree = array();
    foreach ( $categories as $category ) {
      if ( $category->parent == 0 ) {
        $category_tree[ $category->term_id ] = array(
          'name' => $category->name,
          'children' => array(),
        );
      } else {
        $category_tree[ $category->parent ]['children'][ $category->term_id ] = $category->name;
      }
    }

    // Afficher le filtre de taxonomie
    if ( count( $category_tree ) > 0 ) {
      echo '<select name="' . $taxonomy . '" id="' . $taxonomy . '">';
      echo '<option value="">Toutes les catégories</option>';

      // Tri des catégories par ordre de parenté et affichage hiérarchique
      $top_level_categories = array_filter( $category_tree, function( $category ) {
        return empty( $category['parent'] );
      } );
      foreach ( $top_level_categories as $category_id => $category ) {
        echo '<optgroup label="' . $category['name'] . '">';
        if ( ! empty( $category_tree[ $category_id ]['children'] ) ) {
          foreach ( $category_tree[ $category_id ]['children'] as $child_id => $child_name ) {
            echo '<option value="' . get_term( $child_id )->slug . '"';
            if ( get_term( $child_id )->slug == $current_taxonomy ) {
              echo ' selected="selected"';
            }
            echo '>' . $child_name . '</option>';
          }
        }
        echo '</optgroup>';
      }
      echo '</select>';
    }

  }
}

// Modifie la requête de la liste des boissons pour inclure le filtre de taxonomie
function filter_carte_boissons_by_categorie_query( $query ) {
  global $pagenow, $typenow;

  // Applique le filtre de taxonomie uniquement pour le type de post "carte_boissons"
  if ( $typenow == 'carte_boisson' && $pagenow == 'edit.php' && isset( $_GET['cat_boissons'] ) && $_GET['cat_boissons'] != '' ) {
    $query->query_vars['tax_query'] = array(
      array(
        'taxonomy' => 'cat_boissons',
        'field' => 'slug',
        'terms' => $_GET['cat_boissons'],
        'include_children' => true,
      ),
    );
  }
}


// Ajouter le filtre de taxonomie à la page d'administration des menus
// 'restrict_manage_posts' = hook qui permet d'ajouter des filtres aux pages d'adminisration de contenu
// ajoute un formulaire de sélection pour filtrer les résultats de la liste de publications en fonction 
// des termes de taxonomie (catégories) associés à ces publications personnalisées.
function filter_carte_menu_by_categorie() { 
  // global $typenow est un vairable qui contient le type de contenu affiché par l'administration WP
  // On utilise cette vairable pour afficher le filtre de taxonomie pour ce type de contenu 'carte_boissons'
  global $typenow;

  // Afficher le filtre de taxonomie uniquement pour le type de post "carte_menu"
  if ( $typenow == 'carte_menu' ) {
    $taxonomy = 'cat_menus';
    $current_taxonomy = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';

    // Obtenir toutes les catégories de menus avec leurs sous-catégories
    $categories = get_terms( array(
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
      'parent' => 0,
    ) );

    // Afficher le filtre de taxonomie
    if ( count( $categories ) > 0 ) {
      echo '<select name="' . $taxonomy . '" id="' . $taxonomy . '">';
      echo '<option value="">Toutes les catégories</option>';

      foreach ( $categories as $category ) {
        echo '<option value="' . $category->slug . '"';
        if ( $category->slug == $current_taxonomy ) {
          echo ' selected="selected"';
        }
        echo '>' . $category->name . '</option>';

        // Si la catégorie a des sous-catégories, les afficher dans le filtre
        $subcategories = get_terms( array(
          'taxonomy' => $taxonomy,
          'hide_empty' => true,
          'parent' => $category->term_id,
        ) );

        if ( count( $subcategories ) > 0 ) {
          foreach ( $subcategories as $subcategory ) {
            echo '<option value="' . $subcategory->slug . '"';
            if ( $subcategory->slug == $current_taxonomy ) {
              echo ' selected="selected"';
            }
            echo '>&nbsp;&nbsp;&nbsp;' . $subcategory->name . '</option>';
          }
        }
      }

      echo '</select>';
    }
  }
}

// Modifie la requête de la liste des menus pour inclure le filtre de taxonomie
function filter_carte_menu_by_categorie_query( $query ) {
  global $pagenow, $typenow;

  // Applique le filtre de taxonomie uniquement pour le type de post "carte_menu"
  if ( $typenow == 'carte_menu' && $pagenow == 'edit.php' && isset( $_GET['cat_menus'] ) && $_GET['cat_menus'] != '' ) {
    $query->query_vars['tax_query'] = array(
      array(
        'taxonomy' => 'cat_menus',
        'field' => 'slug',
        'terms' => $_GET['cat_menus'],
      ),
    );
  }
}


