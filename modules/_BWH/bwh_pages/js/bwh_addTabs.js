(function ($) {

  Drupal.behaviors.bwh_addTabs = {
    attach: function (context, settings) {

        //console.log('Tabs!');
        $( ".data.tabs" ).tabs();
        
        //console.log($(".data.tabs .visit-site"));
        //console.log($(".data.tabs .visit-site-link-manually-added"));
        
        // With this condition we prevent creating extra visit-site links on ajax changing sorting options.
        if (!$(".visit-site-link-manually-added").length) {
          $( ".data.tabs #top-line ul" ).append('<li class="ui-state-default ui-corner-top visit-site-link-manually-added">' + $(".data.tabs .visit-site")[0].innerHTML + '</li>');     
        }
        // Buttun to go to the tab to Write review right on the provider page
        /*
        $( "a#write-review-first" ).click(function(){
          $( ".data.tabs" ).tabs( { selected: 2 } );
          var aTag = $("a[name='provider-tabs']");
          $('html,body').animate({scrollTop: aTag.offset().top},'slow');
          return false;
        });
        
        $( "a#write-review" ).click(function(){
          $( ".data.tabs" ).tabs( { selected: 3 } );
          var aTag = $("a[name='provider-tabs']");
          $('html,body').animate({scrollTop: aTag.offset().top},'slow');
          return false;
        });
        */
    }
  };

}(jQuery));