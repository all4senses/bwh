(function ($) {

  Drupal.behaviors.bwh_review_stars = {
    attach: function (context, settings) {

        $('.form-item-rating-features').stars({
          inputType: "select",
          captionEl: $('#edit-rating-features-choice'),
          cancelShow: false
        });
        $('.form-item-rating-control').stars({
          inputType: "select",
          captionEl: $('#edit-rating-control-choice'),
          cancelShow: false
        });
        $('.form-item-rating-rely').stars({
          inputType: "select",
          captionEl: $('#edit-rating-rely-choice'),
          cancelShow: false
        });
        $('.form-item-rating-money').stars({
          inputType: "select",
          captionEl: $('#edit-rating-money-choice'),
          cancelShow: false
        });
        $('.form-item-rating-service').stars({
          inputType: "select",
          captionEl: $('#edit-rating-service-choice'),
          cancelShow: false
        });
    
    }
  };

}(jQuery));