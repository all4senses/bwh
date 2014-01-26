<div id="c-top">

    <header id="header" role="banner" class="clearfix">

    <div id="logo-block">
      <a href="<?php print $front_page; ?>" title="<?php print 'bestwebhosting.ca'; ?>" id="logo">
        <img src="<?php echo '/sites/all/themes/bwh/css/images/bwh-logo-main-top.png'; ?>" alt="bestwebhosting.ca" title="<?php print 'bestwebhosting.ca Home'; ?>" />
      </a>

    </div>
      
    <nav id="navigation" role="navigation" class="clearfix">
      <!--<div id="header-menu-back"></div>-->
      
      <?php 

//        if ($user->uid == 1) {
          echo /*'<a id="itexpo" href="http://bestwebhosting.ca/blog/tags/itexpo-2012"></a>',*/ render($page['header']); 
          
          echo bwh_blocks_getBlockThemed(array('module' => 'om_maximenu', 'delta' => 'om-maximenu-1', 'no_subject' => TRUE, 'class' => 'block-om-maximenu', 'shadow' => FALSE), TRUE, '+31 day', ($user->uid ? '_logged' : NULL));
          
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
  
  <div id="all-content-wrapper">
  <div id="all-content" class="clearfix">
      
      
      <?php if ($page['highlighted']): ?>
          <?php 
//            $url = 'http://bestwebhosting.ca';
//            $share_title = bwh_misc_metatag_getFrontTitle();
//            echo '<div class="float share">' . bwh_blocks_getSocialiteButtons($url, $share_title) . '</div>';
          ?>
          <section id="highlighted" class="clearfix">
            <?php print render($page['highlighted']); ?>
          </section>
      <?php endif; ?>
      
    
      <section id="main" role="main" class="clearfix">

          <?php 
            /*
            if ($breadcrumb): 
              print $breadcrumb;
            endif;
            */
            
            // Hide breadcrumbs temporarily, but reserve the room for it.
            //echo $breadcrumb; 
          ?>
          <div id="breadcrumbs-dummy"></div>
        
          <?php 
          
          //dpm($_SESSION['messages']);
          //dpm($messages);
          

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
          
          <?php /* if (!$is_front && $title): ?>
            <?php print render($title_prefix); ?>
            <h1 class="title" id="page-title"><?php print $title; ?></h1>
            <?php print render($title_suffix); ?>
          <?php endif; */ ?>
          
          <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          
          <?php print render($page['above_content']); ?>
          <?php print render($page['content']); ?>
          
          
      </section> <!-- /#main -->


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

        
  </div> <!-- /#all-content -->
</div>
  

  
  <footer id="footer" role="contentinfo" class="clearfix">
    <div id="footer-inside">

      <!--<div id="in-touch"></div> -->
      
      
      
      <?php 
        
        echo render($page['footer']);
        
        //echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'send_msg_n_subscribe', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        ////echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'social_links', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        //echo bwh_blocks_getBlockThemed(array('module' => 'bwh_blocks', 'delta' => 'footer_menu', 'no_subject' => TRUE/*, 'class' => 'block-om-maximenu'*/, 'shadow' => FALSE)/*, TRUE, '+31 day'*/ /*, ($user->uid ? '_logged' : NULL)*/);
        
        echo bwh_blocks_get_footerLinks() . '<div class="c">© 2014 BestWebHosting.ca | All Rights Reserved</div>';
        
                
        //echo '<div id="block-bwh-blocks-follow-links"><div class="follow-us">Follow Us</div>', bwh_blocks_get_headerLinks(), '</div>';
      ?>
      
      
    </div>
  </footer> <!-- /#footer -->
  <?php /* 
  <div id="under-footer">
    <div class="c">Copyright © 2014 BestWebHosting.ca | All rights reserved.</div>
  </div>
  */ ?>