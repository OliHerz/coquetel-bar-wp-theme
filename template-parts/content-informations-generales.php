<div class="footerHoraires footerGrid">
  <h3 class="footerTitle"> <?php the_field('infos_titre_horaires'); ?> </h3>    
    <div class="footerContent">
    <?php if (have_rows('infos_horaires_groupe')):?>    
      <?php while (have_rows('infos_horaires_groupe')): the_row(); ?>
      <?php $horaires_jours  = get_sub_field('infos_horaires_jours');
            $horaires_heures = get_sub_field('infos_horaires_heures'); ?>
        <div class="footerHeures">
          <p><?php echo $horaires_jours; ?> </p>
          <p><?php echo $horaires_heures; ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>



  <div class="footerAdresse footerGrid">
    <h3 class="footerTitle"> <?php the_field('infos_titre_adresse'); ?> </h3>        
    <div class="footerContent">
      <?php if (have_rows('infos_adresse')):?>
        <?php while(have_rows('infos_adresse')): the_row();
          $adresse = get_sub_field('infos_adresses');?> 
          <p><?php echo $adresse; ?></p>
        <?php endwhile; ?>
    </div>
      <?php endif; ?>
  </div>

  <div class="footerSocialContact">
    <div class="footerSocial footerGrid">
      <h3 class="footerTitle"><?php the_field('infos_titre_reseaux'); ?></h3>        
      <div class="footerContent">
      <?php if (have_rows('infos_social')):?>
        <?php while(have_rows('infos_social')): the_row();
          $icon_rs = get_sub_field('infos_img_reseau_social');
          $url_rs  = get_sub_field('infos_url_reseau_social'); ?>
        <a href="<?php echo $url_rs; ?>" aria-label="Notre page Facebook">
            <img src="<?php echo $icon_rs['url']; ?>" class="iconFooter"></a>
        <?php endwhile; ?>
      </div>
      <?php endif; ?>
    </div>


    <div class="footerContact footerGrid">
      <h3 class="footerTitle"><?php the_field('infos_titre_contact'); ?></h3>  
      <div class="footerContent">
      <?php if (have_rows('infos_contact')):?>
      <?php while(have_rows('infos_contact')): the_row();
        $contactMail = get_sub_field('infos_mail');
        $contactTel  = get_sub_field('infos_tel'); ?>
          <p><?php echo $contactTel; ?></p>
          <p><?php echo $contactMail; ?></p>
      </div>
    <?php endwhile; ?>
    </div>
    <?php endif; ?>
  </div>
