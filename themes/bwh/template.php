<?php


/**
 * Implements hook_preprocess_user_profile();
 */
/*
function bwh_preprocess_user_profile(&$profile) {
  //dpm($profile);
}
*/


/**
 * Returns HTML for a sort icon.
 *
 * @param $variables
 *   An associative array containing:
 *   - style: Set to either 'asc' or 'desc', this determines which icon to show.
 */
function bwh_tablesort_indicator($variables) {
  
  $path_to_current_theme = drupal_get_path('theme',$GLOBALS['theme']) . '/css/';
    
  if ($variables['style'] == "asc") {
    return '';//theme('image', array('path' => $path_to_current_theme . 'images/arrow-asc.png', 'width' => 13, 'height' => 13, 'alt' => t('sort ascending'), 'title' => t('sort ascending')));
  }
  else {
    return '';//theme('image', array('path' => $path_to_current_theme . 'images/arrow-desc.png', 'width' => 13, 'height' => 13, 'alt' => t('sort descending'), 'title' => t('sort descending')));
  }
}


/**
 * Implements theme_link();
 * 
 * Add rel=nofollow to external links.
 */
function bwh_link($variables) {
  
  if (strpos($variables['path'], '://') && !strpos($variables['path'], 'ttp://bestwebhosting.ca')) {
    
    if (empty($variables['options']['attributes']['rel'])) {
      $variables['options']['attributes']['rel'] = 'nofollow';
    }
    else {
      if(is_array($variables['options']['attributes']['rel'])) {
        $rels = '';
        foreach($variables['options']['attributes']['rel'] as $rel) {
          $rels .= ($rels ? ' ' : '') . $rel;
        }
        $variables['options']['attributes']['rel'] = $rels;
      }

      if (strpos($variables['options']['attributes']['rel'], 'nofollow') === FALSE) {
        $variables['options']['attributes']['rel'] .= ' nofollow';
      }

    }
  }
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}


/**
 * Implements hook_preprocess_user_picture();
 */
function bwh_preprocess_user_picture(&$picture) {
  // Remove a link from a picture.
  if (!isset($picture['account']->picture->uri)) {
    return;
  }
  if (!empty($picture['account']->realname)) {
    $realname = $picture['account']->realname;
  }
  else {
    $userExtendedData = bwh_misc_loadUserExtendedData($picture['account']->uid);
    $realname = $userExtendedData->realname;
  }
  $picture['user_picture'] = theme('image_style', array( 'path' =>  $picture['account']->picture->uri, 'style_name' => 'avatar_profile_page', 'alt' => $realname, 'title' => $realname, 'attributes' => array('rel' => 'v:photo')));
}


/**
 * Returns HTML for the "next page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move forward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function bwh_pager_next($variables) {
  // Add a next rel metatag.
  $out = theme_pager_next($variables);
  if ($out) {
    $out_altered = str_replace('&amp;', '&', $out);
    if(preg_match('|.*href="([^"]*)" .*title="([^"]*)" .*|', $out_altered, $matches) && !empty($matches[1])) {
      
      //dpm('out in next = ' . $out_altered);
      //dpm($matches);

      if ($matches[2] == 'Go to next page') {
        bwh_misc_addMetatag('next', NULL, $href = 'http://bestwebhosting.ca' . $matches[1]);
      }
    }
  }
  return $out;
}


/**
 * Returns HTML for the "previous page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move backward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function bwh_pager_previous($variables) {
  // Add a prev rel metatag.
  $out = theme_pager_previous($variables);
  if ($out) {
    $out_altered = str_replace('&amp;', '&', $out);
    if(preg_match('|.*href="([^"]*)" .*title="([^"]*)" .*|', $out_altered, $matches) && !empty($matches[1])) {

      //dpm('out in prev = ' . $out_altered);
      //dpm($matches);
      
      if ($matches[2] == 'Go to previous page') {
        bwh_misc_addMetatag('prev', NULL, $href = 'http://bestwebhosting.ca' . $matches[1]);
      }
      
    }
  }
  return $out;
}


/**
 * Returns HTML for a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to
 * retrieve a pager control so that users can view other results. Format a list
 * of nearby pages with additional query results.
 *
 * @param $variables
 *   An associative array containing:
 *   - tags: An array of labels for the controls in the pager.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *   - quantity: The number of pages in the list.
 *
 * @ingroup themeable
 */
function bwh_pager($variables) {
  
  // Hide a pager on the home page.
  if($_GET['q'] == 'home') {
    return NULL;
  }
  
  
//  $arg_0 = arg(0);
//  $arg_1 = arg(1);
//  $altered_pager_posts = array('user', 'news', 'blog', 'about-voip-services', 'taxonomy');
//  $altered_pager_reviews = array(98, 429, 434, 581); // 581 - /canada-voip, 434 - /residential-voip-reviews, 429 - /business-voip-reviews, 98 - /providers/reviews
//  
//  if ((in_array($arg_0, $altered_pager_posts) && $arg_1 != 'tags-admin') || @$_SERVER['REDIRECT_URL'] == '/articles') {
//    $newer_link_title = '‹ Newer Posts';
//    $older_link_title = 'Older Posts ›';
//  }
//  elseif ( $arg_0 == 'node' && (in_array($arg_1, $altered_pager_reviews) || bwh_misc_identifyNodeType($arg_1) == 'provider') ) {
//    $newer_link_title = '‹ Newer Reviews';
//    $older_link_title = 'Older Reviews ›';
//  }
//  else {
//    return theme_pager($variables);
//  }
  
    $newer_link_title = '‹ Next Entries';
    $older_link_title = 'Previous Entries ›';

  
  
  
  
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : $newer_link_title), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : $older_link_title), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  
  if ($li_previous) {
    $items[] = array(
      'class' => array('pager-previous'),
      'data' => $li_previous,
    );
    
//    if(preg_match('|.*href="(.*)"\s.*|', $li_previous, $matches) && !empty($matches[1])) {
//      bwh_misc_addMetatag('prev', NULL, $href = 'http://bestwebhosting.ca' . $matches[1]);
//    }
    
  }
  if ($li_next) {
    
    $items[] = array(
      'class' => array('pager-next'),
      'data' => $li_next,
    );
    
//    if(preg_match('|.*href="(.*)"\s.*|', $li_next, $matches) && !empty($matches[1])) {
//      bwh_misc_addMetatag('next', NULL, $href = 'http://bestwebhosting.ca' . $matches[1]);
//    }

  }
    
  
  if (empty($items)) {
    return NULL;
  }
  else {
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' 
          . theme('item_list', array(
            'items' => $items,
            'attributes' => array('class' => array('pager')),
          ));
  }
  
  
  
  
  
  // Original.
  /*
  
  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
  */
}


/**
 * Implements hook_preprocess_searbwh_results().
 */
function bwh_preprocess_searbwh_results(&$variables) {
  
//  // a4s - fix - show lost pager from the results page on some pages.
//  // need prior actions (hack) in function node_searbwh_execute() at node.module
//  // v1
//  //doesn't work correctly - it create bad links like http://bestwebhosting.ca/search/node/sip%20trunking?page=0%2C0%2C0%2C0%2C0%2C0%2C0%2C1
//  $variables['pager'] = theme('pager', array('tags' => NULL, 'element' => 7));

  
  
  // a4s - fix - show lost pager from the results page on some pages.
  // need prior actions (hack) in function node_searbwh_execute() at node.module
  // v2
  global $bwh_num_rows, $bwh_limit_rows;
//  dpm('$bwh_num_rows =' . $bwh_num_rows, '$bwh_limit_rows = ' . $bwh_limit_rows);
//  dpm($_SESSION['bwh_node_searbwh_data']);
//  $page = pager_default_initialize($_SESSION['bwh_node_searbwh_data']['bwh_num_rows'], $_SESSION['bwh_node_searbwh_data']['bwh_limit_rows']);
  $page = pager_default_initialize($bwh_num_rows, $bwh_limit_rows);
  $variables['pager'] = theme('pager', array('tags' => NULL));
 
}


/**
 * Implements hook_html_head_alter().
 * We are overwriting the default meta character type tag with HTML5 version.
 */
function bwh_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
  
  // Set right order for main metatags.
  
  
  $head_elements['system_meta_content_type']['#weight'] = -8;
  
  
  if (isset($head_elements['metatag_description'])) {
    $head_elements['metatag_description']['#weight'] = -15;
  }
  if (isset($head_elements['description'])) {
    $head_elements['description']['#weight'] = -15;
  }
  if (isset($head_elements['metatag_keywords'])) {
    $head_elements['metatag_keywords']['#weight'] = -14;
  }
  if (isset($head_elements['keywords'])) {
    $head_elements['keywords']['#weight'] = -14;
  }
  if (isset($head_elements['news_keywords'])) {
    $head_elements['news_keywords']['#weight'] = -13;
  }

  
//  $c_title = drupal_get_title();
//  dpm($c_title);
  
  //dpm($head_elements);
  
  $current_page = NULL;
  
  // Remove a canonical tag if there next or prev tags are present.
  if (!empty($head_elements['next']) || !empty($head_elements['prev'])) {
    unset($head_elements['metatag_canonical']);
    
    
    // Define the number of a current page.
    if (!empty($head_elements['next'])) {
      $next = explode('?', $head_elements['next']['#attributes']['href']);
      //dpm($next);
      foreach (explode('&', $next[1]) as $param) {
        $param = explode('=', $param);
        if ($param[0] == 'page') {
          $current_page = ($param[1] - 1) + 1;
          break;
        }
      }
    }
    else {
      $prev = explode('?', $head_elements['prev']['#attributes']['href']);
      if (isset($prev[1])) {
        foreach (explode('&', $prev[1]) as $param) {
          $param = explode('=', $param);
          if ($param[0] == 'page') {
            $current_page = ($param[1] + 1) + 1;
            break;
          }
        }
      }
      else {
        $current_page = 2;
      }
      
      
    }

    if ($current_page > 1) {
      
      // Define a current page title
      if (!empty($head_elements['name']['#attributes']['content'])) {
        $current_title = $head_elements['name']['#attributes']['content'];
      }
      else {
        $current_title = drupal_get_title();
      }

      $current_title = str_replace(' | bestwebhosting.ca', '', $current_title);

      //dpm($current_title);

      global $altered_head_title;
      
      $altered_head_title = $current_title . ' - Page ' . $current_page . ' | BestWebHosting.ca';
      
      if (isset($head_elements['metatag_description'])) {
        $head_elements['metatag_description']['#value'] = 'Page ' . $current_page . ' - ' . $head_elements['metatag_description']['#value'];
      }
      if (isset($head_elements['description'])) {
        $head_elements['description']['#attributes']['content'] = 'Page ' . $current_page . ' - ' . $head_elements['description']['#attributes']['content'];
      }
      //dpm('$altered_head_title = ' . $altered_head_title);
//      global $user;
//      if ($user->uid == 1) {
//        bwh_misc_addMetatag('title', $altered_head_title);
//      }
    }
  }
  
  // Add a OG:Description metatag
  if (!empty($head_elements['metatag_description']['#value'])) {
    $head_elements['metatag_og_description'] = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
          'property' => 'og:description',
          'content' => $head_elements['metatag_description']['#value'],
      ),
    );
  }
  
  
  //dpm($head_elements);
  
}


/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function bwh_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h3 class="element-invisible">' . t('Primary tabs') . '</h3>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h3 class="element-invisible">' . t('Secondary tabs') . '</h3>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}


/*
function bwh_preprocess_breadcrumb(&$variables) {
  dpm($variables);
}
*/


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function bwh_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $heading = '<h3 class="element-invisible">' . t('You are here') . '</h3>';
    // Uncomment to add current page to breadcrumb
	// $breadcrumb[] = drupal_get_title();
    return '<nav itemprop="breadcrumb" class="breadcrumb">' . $heading . implode(' » ', $breadcrumb) . '</nav>';
  }
}


/**
 * Override or insert variables into the page template.
 */
function bwh_process_page(&$variables) {
  
  //dpm($_GET);
  //dpm($_SERVER);
  //dpm($variables['node']);
  
  //dpm($variables);
  //$variables['breadcrumb'] = theme('breadcrumb', array('breadcrumb' => drupal_get_breadcrumb()));
  //array(l(t('Home'), NULL), l(t('Blogs'), 'blog'), l(t("!name's blog", array('!name' => format_username($node))), 'blog/' . $node->uid))
  
  if (@$_GET['q'] == 'home') {
    $variables['theme_hook_suggestions'][] = 'page__compare_providers';
  }
  if(isset($variables['node'])) {
    if (arg(2) != 'edit') {
      $variables['theme_hook_suggestions'][] = 'page__' . $variables['node']->type;
    }
    
    if ($variables['node']->type == 'provider' && arg(2) != 'edit') {
      $variables['theme_hook_suggestions'][] = 'page__provider';
    }
    elseif ($variables['node']->type == 'preface') {
      $pages_with_separate_tpl = array('canada', 'shared-hosting', 'vps-hosting', 'wp-hosting', 'website-builder');
      if (in_array(@$variables['node']->field_preface_key['und'][0]['value'], $pages_with_separate_tpl) && arg(2) != 'edit') {
        $variables['theme_hook_suggestions'][] = 'page__compare_providers';
      }
    }
  }
  elseif (arg(0) == 'get' && @arg(1) == 'iframe') {
    module_invoke('admin_menu', 'suppress');
    $variables['theme_hook_suggestions'][] = 'page__url__iframe';
  }
  

  
  // Set breadcrumb
  bwh_misc_setBreadcrumbs($variables);
  
  
  // Set a user referer.
  $module_path_misc = drupal_get_path('module', 'bwh_misc');
  drupal_add_js( $module_path_misc . '/js/bwh_setReferer.js'); 
  
  // Add a BounceX popup window
  //drupal_add_js( $module_path_misc . '/js/bwh_addBounceX.js'); 
  
  
  /* Add Google's fonts */
  //gv_misc_addMetatag('stylesheet', NULL, 'http://fonts.googleapis.com/css?family=Open+Sans', 'NA', 'text/css');
  //gv_misc_addMetatag('stylesheet', NULL, 'http://fonts.googleapis.com/css?family=Open+Sans|Ubuntu:500italic', 'NA', 'text/css');
  // Cufon's, via font-face
  //drupal_add_css(path_to_theme() . '/css/remote-fonts.css', array('group' => CSS_DEFAULT, 'every_page' => TRUE));
  //
  ////bwh_misc_addMetatag('stylesheet', NULL, 'http://fonts.googleapis.com/css?family=Open+Sans|Ubuntu:500', 'NA', 'text/css');
  ///////bwh_misc_addMetatag('stylesheet', NULL, 'http://fonts.googleapis.com/css?family=Open+Sans:normal,bold|Ubuntu:500', 'NA', 'text/css');
  bwh_misc_addMetatag('stylesheet', NULL, 'http://fonts.googleapis.com/css?family=Open+Sans:normal,bold|Ubuntu:500|Roboto:500', 'NA', 'text/css');
  
  // Local fonts, taken from the remote side.  
  // the code places right in the style.css, so is commented out here
  ////drupal_add_css('sites/all/libraries/fonts/google/open-sans-n-ubuntu/fonts.css', array('group' => CSS_THEME/*CSS_DEFAULT*/, 'every_page' => TRUE)); // array('group' => CSS_THEME, 'preprocess' => FALSE)

}


/**
 * Override or insert variables into the node template.
 */
function bwh_preprocess_node(&$variables) {
  
  global $user;
  
  $variables['submitted'] = t('Published by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  if(isset($variables['node'])) {
    
    if($variables['node']->type == 'blog_post' || $variables['node']->type == 'news_post' || $variables['node']->type == 'learn_hosting') {
      $variables['theme_hook_suggestions'][] = 'node__article';
    }
    elseif($variables['node']->type == 'webform') {
      $variables['theme_hook_suggestions'][] = 'node__admin_page';
    }
    
    elseif($variables['node']->type == 'preface') {
      // Speed test page have its own template
      if (@$variables['node']->field_preface_key['und'][0]['value'] == 'voip-speed-test') {
        $variables['theme_hook_suggestions'][] = 'node__preface__voip_speed_test';
      }
      // Custom 404 page.
      elseif(@$variables['node']->field_preface_key['und'][0]['value'] == 'page-not-found') {
        $variables['theme_hook_suggestions'][] = 'node__preface__page404';
      }
      // Types of providers page.
      elseif(@$variables['node']->field_preface_key['und'][0]['value'] == 'providers_types_n_features_n_etc') {
        $variables['theme_hook_suggestions'][] = 'node__preface__types';
      }
    }
    
    elseif($variables['node']->type == 'provider' && arg(2) != 'edit') {
      
      if($variables['view_mode'] == 'teaser') {
        $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__teaser';   
        $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__teaser';
      }
      else {
        $variables['theme_hook_suggestions'][] = 'node__provider_page';
      }
      //$variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];
    }
    
  }
  
}


/**
 * Preprocess variables for region.tpl.php
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function bwh_preprocess_region(&$variables, $hook) {
  // Use a bare template for the content region.
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__bare';
  }
}


/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function bwh_preprocess_block(&$variables, $hook) {
  // Use a bare template for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__bare';
  }

  $variables['title_attributes_array']['class'][] = 'block-title';
}


/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function bwh_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Changes the search form to use the "search" input element of HTML5.
 */
function bwh_preprocess_searbwh_block_form(&$vars) {
  $vars['searbwh_form'] = str_replace('type="text"', 'type="search"', $vars['searbwh_form']);
}

/**
 * Changes the search button label. Here... because it doesn't work via module hook.
 */
function bwh_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'searbwh_block_form') {
    
    // Hide a word on the button "Search"
    ///$form['actions']['submit']['#value'] = '';
    
    // Autohiding hint.
    $default_searbwh_text = t('Search on site');
    $form['searbwh_block_form']['#default_value'] = $default_searbwh_text;
    $form['default_text']['#default_value'] = $default_searbwh_text;
    // Cause a fatal error without it for anonymous.
    $form['default_text']['#type'] = 'hidden';
    
    
    // Example! Does NOT work!!! The above one works!
    //$form['searbwh_block_form']['#value'] = t($default_searbwh_text); // Set a default value for the textfield
    
    // Add extra attributes to the text box
    // Without this a hint autohiding will not work for anonymous.
    $form['searbwh_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = '$default_searbwh_text';}";
    $form['searbwh_block_form']['#attributes']['onfocus'] = "if (this.value == '$default_searbwh_text') {this.value = '';}";
  }
}


function bwh_username($object) {
  return str_replace(' ('. t('not verified') .')', '', theme_username($object));
}


/**
* Default theme function for all RSS rows.
*/
function bwh_preprocess_views_view_rss(&$vars) {
  
  $namespaces = $vars['view']->style_plugin->namespaces;
  
  
//  
//  global $user;
//  
//  
//  if ($user->uid == 1) {
//  
//    dpr($namespaces);
//
//    $disabled_namespaces = array('content', 'dc', 'foaf', 'og', 'rdfs', 'sioc', 'sioct', 'skos', 'xsd', 'addthis');
//    
//    // FIX bad names
//    foreach ($namespaces as $key => $value) {
//      $key_new = str_replace('xmlns:xmlns:', 'xmlns:', $key);
//      if ($key_new != $key) {
//        $namespaces[$key_new] = $value;
//        unset($namespaces[$key]);
//      }
//    }
//    
//    
//    foreach ($disabled_namespaces as $disabled_namespace) {
//      
//      foreach ($namespaces as $key => $value) {
//        if (strpos($key, $disabled_namespace) != FALSE) {
//          unset($namespaces[$key]);
//        }
//      }
//      
//      
//    }
//    
////    foreach ($disabled_namespaces as $disabled_namespace) {
////      if (isset($namespaces[$disabled_namespace])) {
////        unset($namespaces[$disabled_namespace]);
////      }
////    }
//    
//    
//    $vars['namespaces'] = '';
//    foreach ($namespaces as $key => $value) {
//      $vars['namespaces'] .= ' ' . $key . '="' . $value . '"';
//    }
//
//
//    dpr($namespaces);
//    exit;
//
//  }
//  else {
    $disabled_namespaces = array('content', /*'dc',*/ 'foaf', 'og', 'rdfs', 'sioc', 'sioct', 'skos', 'xsd', 'xmlns:xmlns:addthis');
    
        // FIX bad names
    foreach ($namespaces as $key => $value) {
      $key_new = str_replace('xmlns:xmlns:', 'xmlns:', $key);
      if ($key_new != $key) {
        $namespaces[$key_new] = $value;
        unset($namespaces[$key]);
      }
    }

     foreach ($disabled_namespaces as $disabled_namespace) {
      
      foreach ($namespaces as $key => $value) {
        if (strpos($key, $disabled_namespace) != FALSE) {
          unset($namespaces[$key]);
        }
      }
      
      
    }
    
    
    $vars['namespaces'] = '';
    foreach ($namespaces as $key => $value) {
      $vars['namespaces'] .= ' ' . $key . '="' . $value . '"';
    }
    

  
}


/**
* Default theme function for all Archive.
*/
function bwh_preprocess_views_view_archive(&$vars) {
  dpr('xxxxzzzz');
  exit;
  //dpm($vars['view']);
}


/**
* Default theme function for all RSS rows.
*/
function bwh_preprocess_views_view_row(&$vars) {
  dpm('xxxxxx');
  exit;  
}

/**
* Default theme function for all RSS rows.
*/
function bwh_preprocess_views_view_row_rss(&$vars) {
  
  $node = $vars['view']->style_plugin->row_plugin->nodes[$vars['row']->nid];
  //$vars['description'] = check_plain(htmlspecialchars_decode($node->field_a_teaser['und'][0]['value']));
  if (isset($node->body['und'][0]['value'])) {
    $rss_teaser = bwh_misc_getArticleTeaserData('all', $node->body['und'][0]['value'], $vars['row']->nid, 400, TRUE);
    // Clear attribute typeof="foaf:Image" from the img tag (which iss added by the core rdf module via hook_preprocess_image).
    $rss_teaser = preg_replace('|typeof="foaf:Image" |', '', $rss_teaser);
    // Convert relative links to absolute.
    $rss_teaser = preg_replace('|href="/|', 'href="http://bestwebhosting.ca/', $rss_teaser);
    // Restore a normal state of a YouTube url from a token.
    // [video: http://www.youtube.com/watch?v=SoMS77zE7iE]
    $rss_teaser =   preg_replace('|\[video:.*(http.*)\]|', '<a href="$1"> [Watch a video] </a>', $rss_teaser);
    $vars['description'] = check_plain(htmlspecialchars_decode($rss_teaser));
  }
  
  // Replace username with real user name for <dc:creator>
  $extra_data = unserialize(@$node->field_extra_data['und'][0]['value']);
  if (!empty($extra_data['guest_author'])) {
    $vars['item_elements'] = preg_replace('|<dc:creator>.*</dc:creator>|', '<dc:creator>' . $extra_data['guest_author'] . '</dc:creator>', $vars['item_elements']);
    $vars['item_elements'] = preg_replace('|<dc:creator />|', '<dc:creator>' . $extra_data['guest_author'] . '</dc:creator>', $vars['item_elements']);
  }
  else {
    $vars['item_elements'] = preg_replace('|<dc:creator>.*</dc:creator>|', '<dc:creator>' . bwh_misc_getUserRealName($node->uid) . '</dc:creator>', $vars['item_elements']);
  }
  
}


/**
 * Display the simple view of rows one after another
 */

function bwh_preprocess_views_view_unformatted(&$vars) {
//  dpr('yyy');
//exit;
  
  /*
  if( ($vars['view']->name == 'blog' || $vars['view']->name == 'news') && $vars['view']->current_display == 'page') {
    $vars['theme_hook_suggestions'][] = 'views-view-unformatted__blog__page';
    $vars['theme_hook_suggestion'] = 'views-view-unformatted__blog__page';
    dpm($vars);
  }
  */
  
}



/**
 * Theme function for a CAPTCHA element.
 * 
 * a4s rename CAPTCHA to Captcha
 *
 * Render it in a fieldset if a description of the CAPTCHA
 * is available. Render it as is otherwise.
 */
/*
function bwh_captcha($variables) {
  $element = $variables['element'];
  if (!empty($element['#description']) && isset($element['captcha_widgets'])) {
    $fieldset = array(
      '#type' => 'fieldset',
      '#title' => t('Captcha'),
      '#description' => $element['#description'],
      '#children' => drupal_render_children($element),
      '#attributes' => array('class' => array('captcha')),
    );
    return theme('fieldset', array('element' => $fieldset));
  }
  else {
    return '<div class="captcha">' . drupal_render_children($element) . '</div>';
  }
}
*/


/**
 * Preprocess the primary theme implementation for a view.
 */

function bwh_preprocess_views_view(&$vars) {
  //dpm($vars);
  //$vars['view']->rows = 'xxx';
  //$vars['rows'] = 'xxx';
  
  //$vars['rows'] = 'yyy ' . $vars['view']->render();
  
  if ($vars['view']->current_display == 'block_blog_summary') {
    $out = '';
    foreach ($vars['view']->result as $item) {
      $url = preg_replace('/^(.*)(....)(..)$/', '$1$2/$3', $item->url);
      //$url = str_replace('bestwebhosting.ca', 'test.bestwebhosting.ca', $url);
      //$out .= '<li>' . l($item->link, $url) . '</li>';
      $out .= '<li><a href="/' . $url . '">' . $item->link . '</a></li>';
    }
    $out = '<div class="item-list"><ul class="views-summary">' . $out . '</ul></div>';
    $vars['rows'] = $out;
  }

  /*
  // I set title for preface (at bwh_misc_views_pre_render(&$view)) instead of a view itself.
//  if ($vars['view']->current_display == 'page_by_tag') {
//    if (!$vars['title']) {
//      $vars['title'] = '<h1>' . $vars['view']->get_title() . '</h1>'; //str_replace('%1', $vars['view']->build_info['substitutions']['%1'], $vars['view']->build_info['title']); 
//    }  
//  }

  // hasn't worked out to make use one temlate for different views unformatted
  
  if (isset($vars['view']->name) && ($vars['view']->name == 'blog' || $vars['view']->name == 'news') ) {
    $function = 'bwh_preprocess_views_view_unformatted'; 
    if (function_exists($function)) {
     $function($vars);
    }
  }
*/  
}



/**
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 2. Uncomment the required function to use.
 * 3. Read carefully, especially within bwh_preprocess_html(), there
 *    are extra goodies you might want to leverage such as a very simple way of adding
 *    stylesheets for Internet Explorer and a browser detection script to add body classes.
 */
function bwh_preprocess_html(&$vars) {
  // Load the media queries styles
  // Remember to rename these files to match the names used here - they are
  // in the CSS directory of your subtheme.
//  $media_queries_css = array(
//    'bwh.responsive.style.css',
//    'bwh.responsive.gpanels.css'
//  );
//  load_subtheme_media_queries($media_queries_css, 'bwh');


//  * Load IE Stylesheets
//  *
//  * AT automates adding IE stylesheets, simply add to the array using
//  * the conditional comment as the key and the stylesheet name as the value.
//  *
//  * See our online help: http://adaptivethemes.com/documentation/working-with-internet-explorer
//  *
//  * For example to add a stylesheet for IE8 only use:
//  *
//  *  'IE 8' => 'ie-8.css',
//  *
//  * Your IE CSS file must be in the /css/ directory in your subtheme.
  
//  Uncomment to add a conditional stylesheet for IE 7 or less.
//  $ie_files = array(
//    'lte IE 7' => 'ie-lte-7.css',
//  );
//  load_subtheme_ie_styles($ie_files, 'bwh');

  
  /*
  //dpm($variables);
  //global $user;
  //if ($user->uid == 1) {
    foreach ($variables['page']['content']['system_main']['nodes'] as $key => $html) {
      //dpr($html['body']['#object']->rdf_mapping);
      if (isset($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping['comment_count']['datatype'])) {
        unset($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping['comment_count']['datatype']);
      }
      //dpr($variables['page']['content']['system_main']['nodes'][$key]['body']['#object']->rdf_mapping);
    }
    //die;
  //}
  */
  
  
  
  // Add class for the active theme name
  // Uncomment to add a class for the active theme name.
  //$vars['classes_array'][] = drupal_html_class($theme_key);
  
  // Works!
  global $user;
  if ($user->uid == 1 || ($user->uid && in_array('administrator', $user->roles)) ) {
    $vars['classes_array'][] = 'admin';
  }
  elseif ($user->uid && in_array('writer', $user->roles) ) {
    $vars['classes_array'][] = 'writer';
  }
  else {
    $vars['classes_array'][] = 'not-admin';
  }
  
  global $body_classes_add;
  if (!empty($body_classes_add)) {
    $vars['classes_array'] += $body_classes_add;
  }

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  //Uncomment to add a classes for the browser and platform.
  //$vars['classes_array'][] = css_browser_selector();

}


/**
 * Process variables for comment.tpl.php.
 *
 * @see comment.tpl.php
 */
function bwh_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  /*
  $node = $variables['elements']['#node'];
  $variables['comment']   = $comment;
  $variables['node']      = $node;
  */
  $variables['author']    = $comment->name; //theme('username', array('account' => $comment));
  $variables['created']   = date('m.d.Y \a\t g:ia', $comment->created);//format_date($comment->created);
  $variables['changed']   = date('m.d.Y \a\t g:ia', $comment->changed); //format_date($comment->changed);
/*
  $variables['new']       = !empty($comment->new) ? t('new') : '';
  $variables['picture']   = theme_get_setting('toggle_comment_user_picture') ? theme('user_picture', array('account' => $comment)) : '';
  $variables['signature'] = $comment->signature;

  $uri = entity_uri('comment', $comment);
  $uri['options'] += array('attributes' => array('class' => 'permalink', 'rel' => 'bookmark'));

  $variables['title']     = l($comment->subject, $uri['path'], $uri['options']);
  $variables['permalink'] = l(t('Permalink'), $uri['path'], $uri['options']);
  $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['author'], '!datetime' => $variables['created']));

  // Preprocess fields.
  field_attabwh_preprocess('comment', $comment, $variables['elements'], $variables);

  // Helpful $content variable for templates.
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Set status to a string representation of comment->status.
  if (isset($comment->in_preview)) {
    $variables['status'] = 'comment-preview';
  }
  else {
    $variables['status'] = ($comment->status == COMMENT_NOT_PUBLISHED) ? 'comment-unpublished' : 'comment-published';
  }

  // Gather comment classes.
  // 'comment-published' class is not needed, it is either 'comment-preview' or
  // 'comment-unpublished'.
  if ($variables['status'] != 'comment-published') {
    $variables['classes_array'][] = $variables['status'];
  }
  if ($variables['new']) {
    $variables['classes_array'][] = 'comment-new';
  }
  if (!$comment->uid) {
    $variables['classes_array'][] = 'comment-by-anonymous';
  }
  else {
    if ($comment->uid == $variables['node']->uid) {
      $variables['classes_array'][] = 'comment-by-node-author';
    }
    if ($comment->uid == $variables['user']->uid) {
      $variables['classes_array'][] = 'comment-by-viewer';
    }
  }
 */
}

