<div id="c-top">

  <header id="header" role="banner" class="clearfix">
      
    <div id="logo-block">
      <a href="<?php print $front_page; ?>" title="<?php print 'bestwebhosting.ca'; ?>" id="logo">
        <img src="<?php echo '/sites/all/themes/bwh/css/images/bwh-logo-main-top.png'; ?>" alt="bestwebhosting.ca" title="<?php print 'bestwebhosting.ca Home'; ?>" />
      </a>

    </div>
      
    <!--<div class="intro">COMPARE OUR TOP WEB HOSTING PICKS<div>UPDATED JANUARY 2014</div></div>  -->
      
    <nav id="navigation" role="navigation" class="clearfix">
      <!--<div id="header-menu-back"></div>-->
      
      
      <?php 
          //global $user;

//        if ($user->uid == 1) {
          echo /*'<a id="itexpo" href="http://bestwebhosting.ca/blog/tags/itexpo-2012"></a>',*/ render($page['header']); 
          
//          if ($user->uid == 1) {
//            echo bwh_blocks_getBlockThemed(array('module' => 'om_maximenu', 'delta' => 'om-maximenu-1', 'no_subject' => TRUE, 'class' => 'block-om-maximenu', 'shadow' => FALSE), TRUE, '+31 day', ($user->uid ? '_logged' : NULL));
//          }
          
//        }
//        else {
//          echo '<div id="block-bwh-blocks-header-links"><div class="follow-us">Follow Us</div>', bwh_blocks_get_headerLinks(), '</div>', render($page['header']); 
//        }
      ?>
    </nav> <!-- /#navigation -->

    <?php ////if ($breadcrumb): print $breadcrumb; endif;?>
  </header> <!-- /#header -->

</div>




    
  <?php
  /*
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div>
  */
  ?>

  

  
  <?php /* if ($page['highlighted']): ?>
    <div id="highlighted-wrapper">
      <section id="highlighted" class="clearfix">
        <?php print render($page['highlighted']); ?>
      </section>
    </div>
  <?php endif; */?>
  
<div id="all-content-wrapper" class="page-compare-providers">
  
  <div id="all-content" class="clearfix">
      
    
      <section id="main" role="main" class="clearfix">

          <?php 
            /*
            if ($breadcrumb): 
              print $breadcrumb;
            endif;
            */
            
            // Hide breadcrumbs temporarily, but reserve the room for it.
            //echo $breadcrumb; 
            echo '<div id="breadcrumbs-dummy"></div>';
          ?>
        
          <?php 
          
            print $messages; 
            // we aren't getting messages, get them manually
//            if (isset($_SESSION['messages'])) {
//                echo '<div class="messages">';
//                foreach($_SESSION['messages'] as $type=>$messages) {
//                    echo "<p class=\"$type\">".implode("</p><p class=\"$type\">", $messages)."</p>";
//                }
//                echo '</div>';
//                unset($_SESSION['messages']);
//            }

            
          ?>
          <a id="main-content"></a>
          
           
          <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          
          <?php print render($page['above_content']); ?>
          
          
          <?php print render($page['content']); ?>
          
          <div id="below">
            
            <?php if ($page['below_content']): ?>
                <div id="below_content">
                  <?php print render($page['below_content']); ?>
                </div>
            <?php endif; ?>

            <?php if ($page['sidebar_second']): ?>
              <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
                <?php print render($page['sidebar_second']); ?>
              </aside>  <!-- /#sidebar-second -->
            <?php endif; ?>

          </div>
          
          <?php 
            /*
          $pages_with_timestamp = array(
            '/compare-business-voip-providers', 
            '/business-voip-reviews', 
            '/compare-residential-voip-providers', 
            '/best-voip-service-providers',
            '/residential-voip-reviews', 
            '/sip-trunking-providers',
            '/internet-fax-service-providers',
            '/providers/reviews', 
            '/about-voip-services', 
            '/blog', 
            '/news', 
            '/voip-provider-submit-user-review',
            '/about-us',
            '/contact-us',
            '/advertise',
            '/press',
            '/privacy-policy',
            '/terms-of-use',
            '/our-team',
          );
          //if ($user->uid == 1) {
          if($is_front || in_array($_SERVER['REDIRECT_URL'], $pages_with_timestamp))
            echo bwh_misc_lastUpdatedStamp();
              
          //}
          */
          ?>
          
      </section> <!-- /#main -->

      
      <?php /*
      
      <?php if ($page['sidebar_first']): ?>
        <aside id="sidebar-first" role="complementary" class="sidebar clearfix">
          <?php print render($page['sidebar_first']); ?>
        </aside>  <!-- /#sidebar-first -->
      <?php endif; ?>

      <?php if ($page['sidebar_second']): ?>
        <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
          <?php print render($page['sidebar_second']); ?>
        </aside>  <!-- /#sidebar-second -->
      <?php endif; ?>
        
      */ ?>

        
  </div> <!-- /#all-content -->
</div>
  

  
  <footer id="footer" role="contentinfo" class="clearfix">
    <div id="footer-inside">

      <!--<div id="in-touch"></div> -->
      
      <div id="logo-footer"></div>
        
      <?php 
        
        echo render($page['footer']);
        
        //echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'send_msg_n_subscribe', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        ////echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'social_links', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        //echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'footer_menu', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        
        echo bwh_blocks_get_footerLinks();
        
                
        //echo '<div id="block-bwh-blocks-follow-links"><div class="follow-us">Follow Us</div>', bwh_blocks_get_headerLinks(), '</div>';
      ?>
      
      
      <div id="disclamer">Disclamer: BestWebHosting.ca is an independent provider comparison and shoppers guide, offering unbiased consumer reviews. We monetize from advertisers and affiliates. This does not influence the rankings and reviews on our website</div>
      <div class="c">© 2014 BestWebHosting.ca | All Rights Reserved</div>

    </div>
  </footer> <!-- /#footer -->
  <?php /* 
  <div id="under-footer">
    <div class="c">Copyright © 2014 Cloud Hosting HQ | All rights reserved.</div>
  </div>
  */ ?>