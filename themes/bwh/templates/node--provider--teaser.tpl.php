<?php 

//dpm($node->p_data);
//dpm($content);
//dpm($node);

?>


  <article id="node-<?php print $node->nid; ?>" class="p-teaser <?php echo ($node->field_p_listposition_sh['und'][0]['value'] == 1 ? 'first ' : ''), $classes; ?> clearfix"<?php print $attributes; ?>>
    
        <div class="content"<?php print $content_attributes; ?>>
          
          
            
                <?php
                
                  echo '<div class="listpos"><div><span>', $node->field_p_listposition_sh['und'][0]['value'], '</span></div></div>';
                  if (isset($node->field_p_logo['und'][0]['uri'])) {
                    if ($_SERVER['REQUEST_URI'] != '/' || !$image = bwh_misc_getProviderLogoFromSprite($node->nid, 'home_top_providers_teasers')) {
                      $image = theme('image_style', array( 'path' =>  $node->field_p_logo['und'][0]['uri'], 'style_name' => 'logo_provider_teaser', 'alt' => $node->field_p_logo['und'][0]['alt']/*, 'title' => $node->field_p_logo['und'][0]['title']*/));
                    }

                    //$logo = '<div class="logo"><div>' . theme('image_style', array( 'path' =>  $node->field_p_logo['und'][0]['uri'], 'style_name' => 'logo_provider_teaser', 'alt' => $node->field_p_logo['und'][0]['alt'], 'title' => $node->field_p_logo['und'][0]['title'])) . '</div></div>';
                    $logo = '<div class="logo"><div>' . $image . '</div></div>';

                    $h2_class = ' class="with-logo"';
                  }
                  else {
                    $logo = NULL;
                  }
                  echo '<h2', $h2_class, '>', bwh_misc_getTrackingUrl('<span class="title">' . $title . '</span>' . $logo, NULL, $node->nid), bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value'], NULL, $node->nid, NULL, 'site'), '</h2>';
                  
                  //echo '<div class="about">', $content['body'][0]['#markup'], l('(Read Full Review)', 'node/' . $node->nid), '</div>'; 
                  
                  $out = '<div class="plan">' . $node->p_data['s']['sh']['pti'] . '</div>';
                  $features = $node->p_data['s']['sh']['weights_sh_features'];
                  //dpm($features);

                  if (!empty($features)) {
                    $featires_count = 0;
                    foreach($features as $tid => $term) {
                      $out .= '<div class="feature">' . $term['name'] . '</div>';
                      if (++$featires_count >2) {
                        break;
                      }
                    }
                  }
                  echo '<div class="features">', $out, l('Read Reviews', 'node/' . $node->nid), '</div>';

                  //dpm($node->p_data['provider_options']);
                  echo '<div class="table">';
                    echo '<div class="mbg">MONEY BACK<div>', $node->p_data['info']['i_mbg'], '</div></div>';
                    echo '<div class="sp">SPACE<div>', $node->p_data['s']['sh']['sp'], '</div></div>';
                    //echo '<div class="domain">DOMAIN NAME<div>', $node->p_data['provider_options']['Services & Performance']['Domains Allowed -text-'], '</div></div>';
                    echo '<div class="domain">DOMAIN NAME<div>', @$node->p_data['provider_options']['Services & Performance']['Domain Name'], '</div></div>';
                    echo '<div class="bw">BANDWIDTH<div>', $node->p_data['s']['sh']['bw'], '</div></div>';
                  echo '</div>';
                  
                  echo '<div class="right">';
                    echo '<div class="price"><span>$', $node->p_data['s']['sh']['fees']['mon'], '</span>/mo</div>';
                    //echo '<div class="overall">Overall Score: <span class="count" content="' . $node->bwh_rating_overall . '" property="v:rating">' . $node->bwh_rating_overall . '</span> out of 5</div>'; 
                    echo '<div class="rating"><span class="overall">', $node->bwh_rating_overall, '<span>/5</span></span>', theme('bwh_misc_fivestar_static', array('rating' => $node->bwh_rating_overall*20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css'))), '</div>';
                    
                    if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                      //echo '<div class="site">' , bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value'], NULL, $node->nid), '</div>';
                      echo bwh_misc_getTrackingUrl('Let\'s go!', NULL, $node->nid, NULL, 'site');
                    }
                  echo '</div>';
                  
                  
                  
                  
              
              
              ?>
          <?php //echo render($content); ?>
          
           
          
        </div> <!-- content -->

        
        
      

  </article> <!-- /.node -->
