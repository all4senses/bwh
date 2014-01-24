      
  <div class="main-content" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
    
    
      <?php

//            $url = 'http://bestwebhosting.ca'. url('node/' . $node->nid);
//            echo '<div class="float share">' . bwh_blocks_getSocialiteButtons($url, $node->title) . '</div>';

      ?>





    <div class="content"<?php print $content_attributes; ?>>

          
          
          <div id="left-col" style="overflow: hidden;">
            
                      <div class="image">
                      <?php
                        if (isset($content['field_p_image'][0]['#item']['uri'])) {
                          echo '<div>' . bwh_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_image'][0]['#item']['uri'], 'style_name' => 'image_provider_page', 'alt' =>  $content['field_p_image'][0]['#item']['alt'], 'title' =>  $content['field_p_image'][0]['#item']['title']))), '</div>';
                        }
                      ?>

                      </div>


                      <?php
                        if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                          $visit_site_url = '<div class="site">' . bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value']) . '</div>';
                          echo $visit_site_url;
                        }
                      ?>   


                      
                      
                      <div id="ratings">
              
                            <div class="bwh_votes">
                              <?php
                                
                                echo '<div class="caption"><span property="v:itemreviewed">', $node->field_p_name['und'][0]['value'], '</span> Ratings</div>';
                                if ($node->bwh_voters) {
                                  echo '<div class="voters"><div class="title">Total Number of Reviews:</div><div class="count" property="v:count">' . $node->bwh_voters . '</div></div>';
                                  echo '<div class="recommend"><div class="title">Would recommend: </div><div class="data">' . $node->bwh_recommend . '% of Users' . '</div></div>';
                                  echo render($content['bwh_ratings']); 
                                  echo '<div class="overall">Overall Score: <span class="count" content="' . $node->bwh_rating_overall . '" property="v:rating">' . $node->bwh_rating_overall . '</span> out of 5</div>'; 
                                }
                                else {
                                  echo l('Be the first to review!', 'node/add/review', array('query' => array('id' => $node->nid), 'attributes' => array('class' => array('be-first'), 'rel' => array('nofollow'))));
                                  //echo '<a href="' . url() . '" class="descr be-first">Be the first to review</a>'; 
                                }
                              ?>
                            </div>
                        
                      </div> <!-- <div id="ratings">-->
                      
                      
                      <?php 
                      
                        $block_data = array('module' => 'views', 'delta' => 'providers-block_topwhost_small', 'shadow' => FALSE);
                        echo bwh_blocks_getBlockThemed($block_data);
                      
                      ?>
                          
            </div>
               
              
              
              
      
      
            <div class="data tabs">
              
                
                <div id="top-line">
                    
                    <h1<?php //print $title_attributes; 
                    echo ' property="v:summary"'; 
                    if (!$node->status) {echo ' class="not-published"';}?> ><?php 
                      print $title; 
                    ?></h1>

                    <ul>
                      
                      <li><a href="#tabs-1">Editor's Overview</a></li>

                      <?php if (!empty($content['reviews_entity_view_1'])): ?>
                        <li><a href="#tabs-0"><?php echo 'Customer Reviews'; ?></a></li>
                      <?php endif; ?>


                      <?php 

                      if ($user->uid && !empty($node->p_data['provider_options']) && (!isset($node->p_data['provider_options']['enabled']) || !empty($node->p_data['provider_options']['enabled']))) {
                        echo '<li><a href="#tabs-2">Available Options</a></li>';
                      }

//                      if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
//                        echo '<li>', bwh_misc_getTrackingUrl('Visit Website', NULL, NULL, NULL, 'visit-site'), '</li>';
//                      }
                      ?>

                    </ul>
                  
                    <?php
                      if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                        //echo '<div id="visit-site-tab">', bwh_misc_getTrackingUrl('Visit Website'), '</div>';
                        echo '<div class="visit-site" style="display: none;">' . bwh_misc_getTrackingUrl('Visit Website') . '</div>';
                      }
                    ?>
                </div>
                
              
              
              
              
              
                
                <div id="tabs-1">
                  <?php 
                  
                      echo render($content['body']), (!empty($visit_site_url) ? $visit_site_url : ''); 
                      
                  ?>
                  
                </div>
                
                
                <?php if (!empty($content['reviews_entity_view_1'])): ?>
                  <div id="tabs-0">
                    <div class="reviews">
                        <a id="reviews"></a>

                      <?php echo render($content['reviews_entity_view_1']); ?>

                    </div>
                  </div>
                <?php endif; ?>
                
                
                
                <?php 
                  if ($user->uid && !empty($node->p_data['provider_options']) && (!isset($node->p_data['provider_options']['enabled']) || !empty($node->p_data['provider_options']['enabled']))) {
                    
                  
                    echo '<div id="tabs-2">';

                      $provider_options = '';

                      unset($node->p_data['provider_options']['enabled']);

                      foreach ($node->p_data['provider_options'] as $options_set => $options_data) {

                        $provider_options .= '<tr></tr><tr class="caption"><td colspan="2">' . $options_set . '</td></tr>';

                        $odd = TRUE;

                        foreach ($options_data as $option_title => $option_value) {
                          if (strpos($option_title, '-text-')) {
                            continue;
                          }
                          $option_title = str_replace('Num ', '# ', $option_title);
                          $option_value = (is_int($option_value) ? ($option_value ? 'Yes' : 'No') : ($option_value ? $option_value : 'N/A'));
                          if ($odd) {
                            $odd = FALSE;
                            $row_class = 'even';
                          }
                          else {
                            $odd = TRUE;
                            $row_class = 'odd';
                          }

                          if ($option_value == 'Yes' && !empty($options_data[$option_title . ' -text-'])) {
                            $additional_text = ' <span>' . $options_data[$option_title . ' -text-'] . '</span>';
                          }
                          else {
                            $additional_text = '';
                          }
                          if (is_array($option_value)) {
                            $option_value = $option_value['value'];
                          }
                          $provider_options .= '<tr class="' . $row_class . '"><td class="title">' . $option_title . '</td><td class="value' . ($option_value == 'Yes' ? ' yes' : ($option_value == 'No' ? ' no' : '')) . '"><div class="check">' . $option_value . '</div><span>' . $additional_text . '</span></td></tr>';
                        }
                      }
                      echo '<table class="specs"><tbody>' . $provider_options . '</tbody></table>';

                    echo '</div>';
                  }
                  ?>
                
                
               
                <div class="bottom-clear"></div>
                
              </div> <?php // End of <div class="data tabs"> ?>
              
              
              
              
              
              
              
          <?php echo render($content['metatags']); //bwh_misc_renderMetatags_newOrder($content['metatags']);?>
          
          
              
              
              
          
    </div> <!-- content -->

      

</div> <!-- main-content -->
  
