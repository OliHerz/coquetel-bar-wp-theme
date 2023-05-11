<!-- Contenu de la page Boissons -->



<!--  Affiche les boutons pour chaque catégorie de boisson -->
<section class="affichageBoissons">

  <?php $cat_boissons = get_terms( array( 
    // get_terms permet de récupérer toutes les sous-catégories de la catégorie de boissons sélectionnée
    'taxonomy' => 'cat_boissons', // recherche les éléments crées à partir de ma taxonomie 'cat_boissons' qui m'a permis de créer des catégories de boissons
    'hide_empty' => false,
    'parent' => 0, // sélectionne uniquement les catégories parentes, et non les sous catégories
    'orderby' => 'term_id', // trie par ordre de cration des catégories
  ) );

  // Si ma variable n'est pas vide, et si elle ne contient pas d'erreurs
  if ( ! empty( $cat_boissons ) && ! is_wp_error( $cat_boissons ) ) {
    foreach ( $cat_boissons as $categories ) { ?>
      <button class="buttonToggle">
          <p class="textLogoBoissons"> <?php echo $categories->name; ?> </p>
      </button>
    <?php } 
  }?>

</section>


<!-- Début de la section qui va  contenir les articles voulus -->
<section class="boissonsContent">

<!-- Pour chaque catégories de Boissons faire de la taxonomie 'cat_boissons' -->
  <?php foreach ( $cat_boissons as $categories ) {
    // Récupération de l'image de a catégorie
    $image = get_field( 'categorie_img', $categories ); ?>

    <!-- Pour chaque catégorie de boissons, on va créer un article-->
    <!-- Création et début de l'article -->
      <article class="articleContent">

        <!-- On affiche l'image de la catégorie dans l'article -->
        <div class="containerImg">
          <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'];?>" class="imgArticle">
        </div>


        <!-- Partie de l'article qui affiche le contenu des catégories (sous catégories et posts) -->
        <div class="contenuCarteBoisson">

          
          <!-- Récupération des sous-catégories de la catégorie voulue -->
        <?php  $sous_cat = get_terms( array(
            // get_terms permet de récupérer toutes les sous-catégories de la catégorie de boissons sélectionnée
            'taxonomy' => 'cat_boissons',
            'hide_empty' => false,
            'parent' => $categories->term_id,
          ) );

          // Vérification si la catégorie à des sous-catégories
          if (count($sous_cat) > 0) {
            // Boucle sur chaque sous-catégorie
            foreach ($sous_cat as $sous_categorie) {
              // Récupération des posts de la sous-catégorie
              $postSousCat = get_posts(array(
                'post_type' => 'carte_boisson',
                'tax_query' => array(
                  array(
                    'taxonomy' => 'cat_boissons',
                    'field' => 'term_id',
                    'terms' => $sous_categorie->term_id,
                  ),
                ),
              ));
              if (count($postSousCat) > 0) { ?>
                <table class="listeBoisson">
                  <thead>
                    <tr>
                      <th class="tableNom"><?php echo $sous_categorie->name; ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($postSousCat as $post) { ?>
                      <tr>
                        <td class="tableText"><?php echo $post->post_title; ?></td>
                        <td class="tablePrix"><?php the_field('article_item_prix', $post->ID); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php }}

          // Si la catégorie n'a pas de sous catégorie
          } else {
            // Si la catégorie n'a pas de sous-catégories, on affiche les publications de la catégorie
            $args = array(
              'post_type' => 'carte_boisson',
              'tax_query' => array(
                array(
                  'taxonomy' => 'cat_boissons',
                  'field'    => 'term_id',
                  'terms'    => $categories->term_id,
                ),
              ),
            );
            // J'affiche le tableau de ma catégorie si je n'ai pas de sous catégorie 
            $afficheBoisson = new WP_Query( $args );
            if ( $afficheBoisson->have_posts() ) {
              while ( $afficheBoisson->have_posts() ) {
                $afficheBoisson->the_post(); ?>
                <table class="listeBoisson">
                  <thead>
                    <tr>
                      <th class="tableNom"> <?php the_title(); ?>  </th>
                      <th class="tablePrix"> <?php the_field('article_item_prix'); ?> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tableText">  <?php the_content(); ?> </td>
                    </tr>
                  </tbody>
                </table>
              <?php }

              wp_reset_postdata();
            }
          } ?>
        </div>
      </article>
    <?php } ?>
</section>

