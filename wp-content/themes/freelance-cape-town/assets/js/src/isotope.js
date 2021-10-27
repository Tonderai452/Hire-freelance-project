 jQuery(window).bind("load", function ($) {

        setTimeout(loadisotope(), 1000);
        var $container = jQuery('#container');
        jQuery(window).smartresize(function () {
            $container.isotope({
                // update columnWidth to a percentage of container width
                masonry: { columnWidth: $container.width() / 3 }
            });
        });
    });



    function loadisotope() {

        var $container = jQuery('#container');
        // initialize Isotope

        $container.isotope({
            // options...
            resizable: false, // disable normal resizing
            // set columnWidth to a percentage of container width
            masonry: { columnWidth: $container.width() / 3 }
        });

        // update columnWidth on window resize
        jQuery(window).smartresize(function () {
            $container.isotope({
                // update columnWidth to a percentage of container width
                masonry: { columnWidth: $container.width() / 3 }
            });
        });
    }
