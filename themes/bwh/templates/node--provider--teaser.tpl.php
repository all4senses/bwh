<?php 

//dpm($node->p_data);
//dpm($content);
//dpm($node);

?>


  <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    
        <div class="content"<?php print $content_attributes; ?>>
          
          
            
                <?php
                
                  if (isset($node->field_p_logo['und'][0]['uri'])) {
                    $logo = '<div class="logo">' . theme('image_style', array( 'path' =>  $node->field_p_logo['und'][0]['uri'], 'style_name' => 'logo_provider_page', 'alt' => $node->field_p_logo['und'][0]['alt'], 'title' => $node->field_p_logo['und'][0]['title'])) . '</div>';
                  }
                  else {
                    $logo = NULL;
                  }
                  echo '<h2>' . bwh_misc_getTrackingUrl($logo . '<div class="title">' . $title . '</div>', NULL, $node->nid) . '</h2>';
                  //echo '<h2><a href="' . $node_url . '">' . bwh_misc_getTrackingUrl($logo . '<div class="title">' . $title . '</div>', NULL, $node->nid) . '</a></h2>';
                  
                  if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                    //echo '<div class="site">' , bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value'], NULL, $node->nid), '</div>';
                    echo '<div class="site">' , bwh_misc_getTrackingUrl('VISIT SITE', NULL, $node->nid), '</div>';
                  }
                  
                  
              echo render($content['body']); 
              
              ?>
          <?php //echo render($content); ?>
          
           
          
        </div> <!-- content -->

        
        
      

  </article> <!-- /.node -->
