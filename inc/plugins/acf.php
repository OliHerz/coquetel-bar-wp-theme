<?php 
  if( function_exists('acf_add_options_page') ) {
      
    acf_add_options_page(array(
      'page_title'    => 'Infos générales',
      'menu_title'    => 'Options',
      'menu_slug'     => 'infos-site',
      'capability'    => 'edit_posts',
      'position'     => 3,
      'redirect'      => false,
      'post_id'      => 'infos',
      'update_button' => 'Mettre à jour'
    ));
  }