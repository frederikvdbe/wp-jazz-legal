(function ($) {

    var methods = {

        handleMobileMediaQueryChanges: function(mq, $elem, bgs) {

            if (mq.matches) {
                console.log('Matches mobile - min-width: 320px');
                console.log($elem);
                console.log(bgs);

                methods.appendBg($elem, bgs.bgMobile);
            }
        },

        handleTabletMediaQueryChanges: function(mq, $elem, bgs) {

            if (mq.matches) {
                console.log('Matches tablet - min-width: 768px');
                console.log($elem);
                console.log(bgs);

                methods.appendBg($elem, bgs.bgTablet);
            }
        },

        handleDesktopMediaQueryChanges: function(mq, $elem, bgs) {

            if (mq.matches) {
                console.log('Matches desktop - min-width: 1280px');
                console.log($elem);
                console.log(bgs);

                methods.appendBg($elem, bgs.bgDesktop);
            }
        },

        appendBg: function($elem, bg) {
            console.log('append', bg);

            if(!bg) return;

            if($elem.find('.bg--appended').length) $elem.find('.bg--appended').remove();

            $elem.append(bg);

            bg.imagesLoaded({ background: true }, function(imgLoad) {
                bg.addClass('bg--animated');
            });

        }

    }

    $.fn.responsiveBackgroundImages = function () {
        console.log('responsiveBackgroundImages init');

        // TODO: check if is first time loading -> apply fade in, otherwise just replace image

        var $elem = $(this);
        var bgColor = $elem.data('bg-color');

        var mediaQueries = {
            mobile: window.matchMedia('(max-width: 767px)'),
            tablet: window.matchMedia('(max-width: 1279px)'),
            desktop: window.matchMedia('(min-width: 1280px)')
        };

        var bgs = {
            bgMobile : $('<div class="bg--appended" style="background-image: url('+ $(this).data('bg') +');"></div>'),
            bgTablet : $('<div class="bg--appended" style="background-image: url('+ $(this).data('bg-tablet') +');"></div>'),
            bgDesktop : $('<div class="bg--appended" style="background-image: url('+ $(this).data('bg-desktop') +');"></div>')
        };

        // Set background image if provided
        if(bgColor) $elem.css('background-color', bgColor);

        // Add media query event listeners
        mediaQueries.mobile.addEventListener('change', (e) => methods.handleMobileMediaQueryChanges(e, $elem, bgs));
        mediaQueries.tablet.addEventListener('change', (e) => methods.handleTabletMediaQueryChanges(e, $elem, bgs));
        mediaQueries.desktop.addEventListener('change', (e) => methods.handleDesktopMediaQueryChanges(e, $elem, bgs));

        // Trigger media query handlers once manually
        methods.handleMobileMediaQueryChanges(mediaQueries.mobile, $elem, bgs);
        methods.handleTabletMediaQueryChanges(mediaQueries.tablet, $elem, bgs);
        methods.handleDesktopMediaQueryChanges(mediaQueries.desktop, $elem, bgs);

        // Debug
        console.log(bgs);

    };

}(jQuery));