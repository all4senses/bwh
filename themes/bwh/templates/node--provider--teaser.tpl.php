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
                    $logo = '<div class="logo"><div>' . theme('image_style', array( 'path' =>  $node->field_p_logo['und'][0]['uri'], 'style_name' => 'logo_provider_page', 'alt' => $node->field_p_logo['und'][0]['alt'], 'title' => $node->field_p_logo['und'][0]['title'])) . '</div></div>';
                    $h2_class = ' class="with-logo"';
                  }
                  else {
                    $logo = NULL;
                  }
                  echo '<h2', $h2_class, '>', bwh_misc_getTrackingUrl('<span class="title">' . $title . '</span>' . $logo, NULL, $node->nid), '</h2>';
                  //echo '<h2><a href="' . $node_url . '">' . bwh_misc_getTrackingUrl($logo . '<div class="title">' . $title . '</div>', NULL, $node->nid) . '</a></h2>';
                  //dpm($content);
                  //echo '<div class="about">', render($content['body']), l('(Read Full Review)', 'node/' . $node->nid), '</div>'; 
                  echo '<div class="about">', $content['body'][0]['#markup'], l('(Read Full Review)', 'node/' . $node->nid), '</div>'; 
                  
                  
                  echo '<div class="table">';
                    echo '<div class="mbg">REFUND POLICY<div>', $node->p_data['info']['i_mbg'], '</div></div>';
                    echo '<div class="space">STORAGE<div>', $node->p_data['s']['sh']['sp'], '</div></div>';
                    //echo '<div class="domain">DOMAIN NAME<div>', $node->p_data['provider_options']['Services & Performance']['Domains Allowed -text-'], '</div></div>';
                    echo '<div class="domain">DOMAIN NAME<div>', $node->p_data['provider_options']['Services & Performance']['Domains Allowed'], '</div></div>';
                    echo '<div class="traffic">TRAFFIC<div>', $node->p_data['s']['sh']['bw'], '</div></div>';
                  echo '</div>';
                  
                  echo '<div class="right">';
                    echo '<div class="price"><div>$', $node->p_data['s']['sh']['fees']['mon'], '</div>STARTING PRICE</div>';
                    //echo '<div class="overall">Overall Score: <span class="count" content="' . $node->bwh_rating_overall . '" property="v:rating">' . $node->bwh_rating_overall . '</span> out of 5</div>'; 
                    echo '<div class="rating"><span class="overall">', $node->bwh_rating_overall, '/5</span>', theme('bwh_misc_fivestar_static', array('rating' => $node->bwh_rating_overall*20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css'))), '</div>';
                    
                    if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                      //echo '<div class="site">' , bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value'], NULL, $node->nid), '</div>';
                      echo bwh_misc_getTrackingUrl('VISIT SITE', NULL, $node->nid, NULL, 'site');
                    }
                  echo '</div>';
                  
                  
                  
                  
              
              
              ?>
          <?php //echo render($content); ?>
          
           
          
        </div> <!-- content -->

        
        
      

  </article> <!-- /.node -->
