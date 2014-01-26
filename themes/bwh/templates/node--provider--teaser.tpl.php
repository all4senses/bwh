<?php

echo $node->title;
return;

?>

<?php if (!$page): ?>
  <article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
<?php endif; ?>

           
  <div class="main-content" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
    
        <?php if ($page): ?>
    
    
          <?php

//            $url = 'http://bestwebhosting.ca'. url('node/' . $node->nid);
//            echo '<div class="float share">' . bwh_blocks_getSocialiteButtons($url, $node->title) . '</div>';

          ?>
    
    
          <h1<?php //print $title_attributes; 
                echo ' property="v:summary"'; 
                if (!$node->status) {echo ' class="not-published"';}?> ><?php 
                  print $title; 
                ?></h1>
   
   
        <?php else: ?>
          <header>
        
            <h2<?php //print $title_attributes; ?> property="dc:title v:summary">
                <a href="<?php print $node_url; ?>">
                  <?php print $title; ?>
                </a>
            </h2>
            
          </header>
        <?php endif; ?>
    

    

        <div class="content"<?php print $content_attributes; ?>>
          
          
          
           <?php if ($page): ?>
          
          <div style="overflow: hidden;">
              <div class="logo-info">
                
                <?php
                  if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                    echo '<div class="logo">' . bwh_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page', 'alt' => $content['field_p_logo'][0]['#item']['alt'], 'title' => $content['field_p_logo'][0]['#item']['title'], 'attributes' => array('rel' => 'v:photo')))) . '</div>';
                  }
                  else {
                    echo render($title_prefix), '<h2', $title_attributes,'>', $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/, '</h2>', render($title_suffix);
                  }
                  
                ?>
                
                <div class="basic-info" rel="v:itemreviewed">
                  <div typeof="Organization">
                    <div class="caption"><?php echo t('!p Corporate Info:', array('!p' => '<span property="v:itemreviewed">' . $node->field_p_name['und'][0]['value'] /*$content['field_p_name'][0]['#markup']*/ . '</span>')); ?></div>
                    <div><?php echo '<span class="title">Headquarters:</span><span property="v:address">' . $node->p_data['info']['i_heads'] . '</span>'; ?></div>
                    <div><?php echo '<span class="title">Founded In:</span>' . $node->p_data['info']['i_founded']; ?></div>
                    <div><?php echo '<span class="title">Service Availability:</span>' . $node->p_data['info']['i_availability']; ?></div>
                    <div>
                      <?php 
                        if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                          $goto_link_title = (isset($node->p_data['info']['i_web_display']) && $node->p_data['info']['i_web_display']) ? $node->p_data['info']['i_web_display'] : str_replace(array('http://', 'https://'), '', $node->p_data['info']['i_web']);
                          echo '<span class="title">Website:</span>' . bwh_misc_getTrackingUrl($goto_link_title, NULL, NULL, NULL, NULL, array('key' => 'rel', 'value' => 'v:url'));
                        }
                        ?>
                    </div>
                  </div>
                </div>

                
              </div> <!-- <div class="logo share">-->
                
                          
              <div class="image">
                <?php
                  if (isset($content['field_p_image'][0]['#item']['uri'])) {
                    echo '<div>' . bwh_misc_getTrackingUrl(theme('image_style', array( 'path' =>  $content['field_p_image'][0]['#item']['uri'], 'style_name' => 'image_provider_page', 'alt' =>  $content['field_p_image'][0]['#item']['alt'], 'title' =>  $content['field_p_image'][0]['#item']['title']))), '</div>';
                  }
                  
                  if (!$node->p_data['info']['i_web_hide'] && !empty($node->p_data['info']['i_web'])) {
                    echo '<div class="site">' , bwh_misc_getTrackingUrl('Visit ' . $node->field_p_name['und'][0]['value']), '</div>';
                  }
                ?>  
                
              </div>
             </div>
               
              
              <!--<div class="bottom-clear"></div> -->

                  <div class="bwh_votes">
                    <?php
                      if ($node->bwh_voters) {
                        echo '<div class="voters"><div class="title">Total Number of Reviews:</div><div class="count" property="v:count"><a href="#reviews">' . $node->bwh_voters . '</a></div></div>';
                        //echo '<div id="positive">' . $node->bwh_recommends['positive'] . ' Positive reviews</div><div id="negative">' . $node->bwh_recommends['negative'] . ' Negative reviews</div>';
                      }
                      echo '<div class="caption">Overall Consumer Ratings</div>' . render($content['bwh_ratings']); 
                      if ($node->bwh_voters) {
                        echo '<div class="recommend"><div class="title">Would recommend: </div><div class="data">' . $node->bwh_recommend . '% of Users' . '</div></div>';
                      }
                    ?>
                  </div>
                  <div class="overall"> 
                    <div class="star-big">
                      <?php 
                        if ($node->bwh_rating_overall) {
                          echo '<div class="count" content="' . $node->bwh_rating_overall . '" property="v:rating">' . $node->bwh_rating_overall . '</div>' . '<div class="descr">Out of 5 stars</div>'; 
                        }
                        else {
                          echo '<div class="descr be-first">Be the first to review</div>'; 
                        }
                      ?>
                    </div>
                    <div class="text">
                      <div class="title"><?php $node->field_p_name['und'][0]['value']  . ' Overall Rated:'; ?></div>
                      <?php 
                        //echo '<a id="' . ($node->bwh_voters ? 'write-review' : 'write-review-first') . '" href="' . url('node/' . $node->nid, array('fragment' => 'tabs-3')) . '"><img src="/f/img/writeareview.png" /></a>'; 
                        echo '<a id="' . ($node->bwh_voters ? 'write-review' : 'write-review-first') . '" href="' . url('node/add/review', array('query' => array('id' => $node->nid))) . '" rel="nofollow"><img src="/f/img/writeareview.png" /></a>'; 
                      ?>
                    </div>
                    
                  </div>
              
              
              <div class="bottom-clear"></div>
              

              <a name="provider-tabs"></a>         
              <div class="data tabs">
                
                <ul>
                  <?php if ($page && isset($content['reviews_entity_view_1']) && $content['reviews_entity_view_1']): ?>
                    <li><a href="#tabs-0"><?php echo 'Consumer Reviews'; ?></a></li>
                  <?php endif; ?>
                    
                  <li><a href="#tabs-1"><?php echo t('About !p', array('!p' => isset($node->field_p_name['und'][0]['value']) ? $node->field_p_name['und'][0]['value'] : t(' Provider') )); ?></a></li>
                  
                  <?php 
                  
                  if ($user->uid && !empty($node->p_data['provider_options']) && (!isset($node->p_data['provider_options']['enabled']) || !empty($node->p_data['provider_options']['enabled']))) {
                    echo '<li><a href="#tabs-2">Available Options</a></li>';
                  }
                  
                  ?>
                  
                  <?php /* <li><a href="#tabs-3"><?php echo 'Write Review'; ?></a></li> */ ?>
                  
                </ul>
                
                <?php if ($page && isset($content['reviews_entity_view_1']) && $content['reviews_entity_view_1']): ?>
                  <div id="tabs-0">
                    <div class="reviews">
                        <a id="reviews"></a>

                      <?php echo render($content['reviews_entity_view_1']); ?>

                    </div>
                  </div>
                <?php endif; ?>
                
                <div id="tabs-1">
                  <?php echo render($content['body']); ?>
                </div>
                
                
                
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
                
                
                
                <?php /*
                
                <div id="tabs-3">
                  
                  <div id="write-revew-header">
                    
                    <div class="votes_overall">
                      
                      <?php 
                        if (!empty($node->vr_rating_overall)) {
                          $stars_overall = theme('vr_misc_fivestar_static', array('rating' => $node->vr_rating_overall * 20, 'stars' => 5, 'tag' => 'overall', 'widget' => array('name' => 'stars', 'css' => 'stars.css')));
                          echo '<div class="rating_overall"><span class="title">Rating: ' . $node->vr_rating_overall . ' out of 5</span>' . $stars_overall . '</div>';
                          echo '<div class="voters"><div class="title">Number of Reviews:</div><div class="count" property="v:count">' . $node->vr_voters . '</div></div>'; 
                          echo '<div class="recommend"><div class="title">Would recommend: </div><div class="data">' . $node->vr_recommend . '% of Users' . '</div></div>'; 
                        }
                        else {
                          echo '<div class="rating_overall NA"><span class="title">Rating: N/A</span></div>';
                          echo '<div class="voters NA"><div class="title">Number of Reviews: </div><div class="count">N/A</div></div>'; 
                          echo '<div class="recommend NA"><div class="title">Would recommend: </div><div class="data">N/A</div></div>'; 
                        }
                      ?>
                    </div>
                  </div>

                  <?php 
                  
                    echo $node->addProviderReviewForm;
                  
                  ?>
                  
                  <div class="bottom-clear"></div>
                </div>
                
                */ ?>
                
                
               
                <div class="bottom-clear"></div>
                
              </div> <?php // End of <div class="data tabs"> ?>
              
              
              
              
              
              
              
          <?php echo render($content['metatags']); //bwh_misc_renderMetatags_newOrder($content['metatags']);?>
          
          
              
              
              
              
          <?php else: ?> <!-- if ($page): -->
          
                <?php
                  if (isset($content['field_p_logo'][0]['#item']['uri'])) {
                    echo '<div class="logo">' . theme('image_style', array( 'path' =>  $content['field_p_logo'][0]['#item']['uri'], 'style_name' => 'logo_provider_page')) . '</div>';
                  }
                ?>
          
              <?php echo render($content['body']); ?>
          
          
          
          <?php endif; ?>  <!-- if ($page): -->
           
              
          <?php //echo render($content); ?>
          
        </div> <!-- content -->

        
        
      <?php if ($page): ?>
    
        <!--
        <footer>
        </footer>
        -->
        
      <?php endif; ?>
        
      

  </div> <!-- main-content -->
  
    
  
  <?php /*if ($page && isset($content['reviews_entity_view_1']) && $content['reviews_entity_view_1']): ?>
    <div class="reviews">
      <div class="header">
        <a id="reviews"></a>
        <h2 class="button"><?php echo $node->field_p_name['und'][0]['value'], ' ', t('User Reviews'); ?></h2>
        
        <!-- <div class="button"> -->
          <?php 
  
//            if (isset($node->current_user_has_review)) {
//              echo l(t('Your Review'), $node->current_user_has_review, array('attributes' => array('title' => t('You have already submitted a review for this provider: "' . $node->current_user_has_review_title . '"')))); 
//            }
//            else {
//              echo l(t('Submit Your Review'), 'node/add/review'); 
//            }

          ?>
        <!--</div> -->
      </div>

      
      <?php 
        // Hide Sort be Select element.
        //<div class="form-item form-type-select form-item-sort-by">
        ////$content['reviews_entity_view_1'] = preg_replace('/(.*<div.*views-widget-sort-by.*\")(>.*)/', "$1 style=" . '"display: none;"' . "$2", $content['reviews_entity_view_1']);
      
      
//      <div class="views-exposed-widget views-widget-sort-order">
//        <div class="form-item form-type-select form-item-sort-order">
//          <label for="edit-sort-order">Order </label>
//          <select class="form-select" name="sort_order" id="edit-sort-order"><option value="ASC">Asc</option><option selected="selected" value="DESC">Desc</option></select>
//        </div>
//      </div>
    
//        if (strpos($content['reviews_entity_view_1'], '<option selected="selected" value="created">Post date</option>')) {
//          $content['reviews_entity_view_1'] = preg_replace('/(.*<option value="ASC">)(.*)(<.*)/', "$1xxx$3", $content['reviews_entity_view_1']);
//        }
//        else {
//          $content['reviews_entity_view_1'] = preg_replace('/(.*<option value="ASC">)(.*)(<.*)/', "$1yyy$3", $content['reviews_entity_view_1']);
//        }
        echo render($content['reviews_entity_view_1']); 
      ?>
      
    </div>
 <?php endif; */ ?>
  

<?php if (!$page): ?>
  </article> <!-- /.node -->
<?php endif; ?>
