(function ($) {

  Drupal.behaviors.bwh_SendMsgNnewsletterSubscr_fieldHints = {
    attach: function (context, settings) {
      
      //$('#block-bwh_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-email"], #block-bwh_blocks-send_msg_n_subscribe textarea[id="edit-message"]').each(function(){
      $('#block-bwh-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-email"], #block-bwh-blocks-send-msg-n-subscribe textarea[id="edit-message"]').each(function(){
        if ($(this).val() == '') {
          $(this).val($(this).attr('title'));
          $(this).addClass('blur');
        }
        else if ($(this).val() == $(this).attr('title')) {
          $(this).addClass('blur');
        }
      });
      
      //$('#block-bwh_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-email"], #block-bwh_blocks-send_msg_n_subscribe textarea[id="edit-message"]').focus(function(){
      $('#block-bwh-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-email"], #block-bwh-blocks-send-msg-n-subscribe textarea[id="edit-message"]').focus(function(){        
        if ($(this).val() == $(this).attr('title')) {
          $(this).val('');
          $(this).removeClass('blur');
        }
        
      });
      
      //$('#block-bwh_blocks-send_msg_n_subscribe input[id="edit-fname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-lname"], #block-bwh_blocks-send_msg_n_subscribe input[id="edit-email"], #block-bwh_blocks-send_msg_n_subscribe textarea[id="edit-message"]').blur(function(){
      $('#block-bwh-blocks-send-msg-n-subscribe input[id="edit-fname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-lname"], #block-bwh-blocks-send-msg-n-subscribe input[id="edit-email"], #block-bwh-blocks-send-msg-n-subscribe textarea[id="edit-message"]').blur(function(){
        
        if ($(this).val() == '') {
          $(this).val($(this).attr('title'));
          $(this).addClass('blur');
        }
        
      });
      
    }
  };

}(jQuery));