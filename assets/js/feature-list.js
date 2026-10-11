(function ($) {
    "use strict";
    
    function updateFeatureIndexing() {
        $('.listing-feature-wrap').find('.listing-feature-item').each(function (i, item) {
            $('input, textarea', item).each(function () {
                // Rename first array value from name to group index
                var _feature_input = $(this);
                _feature_input.attr('name', _feature_input.attr('name').replace(/listing_feature_list\[[^\]]*\]/, 'listing_feature_list[' + i + ']'));
            });
        });
    }

    $(document).on('click', '.listing-feature-wrapper .add-feature', function (e) {
        e.preventDefault();

        var _self = $(this),
            feature = '<div class="listing-feature-item">' +
                '<span class="rt-remove"><i class="fa fa-times" aria-hidden="true"></i></span>' +
                '<div class="listing-feature-title"><input type="text" name="listing_feature_list[][faqtitle]" class="form-control" placeholder="Group Title"></div>' +
                '<div class="listing-feature-title"><textarea name="listing_feature_list[][faqdesc]" class="form-control" placeholder="Description"></textarea></div>' +
                '</div>';
        _self.closest('.listing-feature-wrapper').find('.listing-feature-wrap').append(feature);
        updateFeatureIndexing();

    });
    $(document).on('click', '.listing-feature-item > .rt-remove', function (e) {
        e.preventDefault();
        var _self = $(this);
        if (_self.closest('.listing-feature-wrapper').find('.listing-feature-item').length >= 0) {
            _self.closest('.listing-feature-item').slideUp('slow', function () {
                $(this).remove();
                updateFeatureIndexing();
            });
        } else {
            alert('You are not permited to remove all feature');
        }
    });

})(jQuery);