<!--  Génère les boutons pour chaque catégories crées par type de posts  -->
<?php
    $terms = get_terms( array(
        'taxonomy' => 'cat_boissons',
        'hide_empty' => true,
    ) );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        ?>
        <button class="buttonToggle">
            <p class="textLogoBoissons"> <?php echo $term->name; ?> </p>
        </button>
        <?php
    }
}
?>