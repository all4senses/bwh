<?php 

//static $all_data_quick;
//
//if (!$all_data_quick) {
//  $all_data_quick = bwh_misc_getProvidersDataQuick();
//}
// 
//dpm($all_data_quick[$node->nid]);
//dpm($node->p_data);
dpm($content);
//dpm($node);

?>


  <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
           
  <div class="main-content" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
    
          <header>
        
            <h2<?php //print $title_attributes; ?> property="dc:title v:summary">
                <a href="<?php print $node_url; ?>">
                  <?php print $title; ?>
                </a>
            </h2>
            
          </header>
    
    

        <div class="content"<?php print $content_attributes; ?>>
          
          
          
          <div style="overflow: hidden;">
              <div class="logo-info">
                
                <?php
                
                  if (isset($node->field_p_logo['und'][0]['uri'])) {
                  //if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                    //echo '<div class="logo">' . bwh_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page', 'alt' => $content['field_p_logo'][0]['#item']['alt'], 'title' => $content['field_p_logo'][0]['#item']['title'], 'attributes' => array('rel' => 'v:photo'))), NULL, $node->nid) . '</div>';
                    echo '<div class="logo">' . bwh_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $node->field_p_logo['und'][0]['uri'], 'style_name' => 'logo_provider_page', 'alt' => $node->field_p_logo['und'][0]['alt'], 'title' => $node->field_p_logo['und'][0]['title'], 'attributes' => array('rel' => 'v:photo'))), NULL, $node->nid) . '</div>';
                  }
                  else {
                    echo render($title_prefix), '<h2', $title_attributes,'>', $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/, '</h2>', render($title_suffix);
                  }
                  
                ?>
                
                <div class="basic-info" rel="v:itemreviewed">
                  <div typeof="Organization">
                    <div>
                      <?php

                        if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                          echo '<div class="site">' , bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value'], NULL, $node->nid), '</div>';
                        }
                      ?>  

                    </div>
                  </div>
                </div>

                
              </div> <!-- <div class="logo share">-->
                
                          
                
             </div>
              
              
              
              
              
              
              
              
          
              <?php echo render($content['body']); ?>
          
           
          
        </div> <!-- content -->

        
        
      

  </div> <!-- main-content -->
  

  </article> <!-- /.node -->
