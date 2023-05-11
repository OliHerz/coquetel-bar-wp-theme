<?php
// defer le script js pour qu'il soit hargé en fin de page 
add_filter( 'script_loader_tag', 'add_defer_attribute', 10, 2 );

?>

