(function ($) {

    var config = {
        breakpoint: 1024,
        fadeDelay: 200
    };

    var methods = {

        toggle: function($current, $next) {
            var $nav = $('.tabs-nav'),
                nextIsCurrent = $current.is($next);

            // Remove initial class
            // Initial class is for closed tabs on mobile
            $current.removeClass('--initial');

            if($(window).innerWidth() < config.breakpoint){

                $current.find('.pane-body').slideUp();

                if(!nextIsCurrent) $next.find('.pane-body').slideDown();

            } else {

                if(nextIsCurrent) return;

                $current.find('.pane-body').hide();

                if(!nextIsCurrent) $next.find('.pane-body').show();

            }

            if(nextIsCurrent){
                $current.removeClass('--active');
                $nav.find('a[href="#'+$current.attr('id')+'"]').parent().removeClass('--active');
                return;
            }

            $current.removeClass('--active');
            $nav.find('a[href="#'+$current.attr('id')+'"]').parent().removeClass('--active');

            $next.addClass('--active');
            $nav.find('a[href="#'+$next.attr('id')+'"]').parent().addClass('--active');

            // $next.find('button[type="submit"]').attr('disabled', true);
        }
    }

    // TODO: check for hash in window location

    $.fn.tabs = function () {

        var $container = $(this),
            $nav = $(this).find('.tabs-nav'),
            $content = $(this).find('.tabs-content');

        // Desktop nav
        $nav.find('a').click(function(e) {

            var target = $(this).attr('href'),
                $next = $(target),
                $tab = $(this).parent(),
                $current = $content.find('.tab-pane.--active'),
                isActive = $next.hasClass('--active');

            // if(isActive) return;

            methods.toggle($current, $next);

        });

        // Mobile nav
        $content.find('.pane-header').click(function(e) {

			return;
            var $next = $(this).parent('.tab-pane'),
				$initial = $content.find('.tab-pane --initial')
                $header = $(this),
                $current = $content.find('.tab-pane.--active'),
                isActive = $next.hasClass('--active'),
				nextIsCurrent = $current.is($next);

            // if(isActive) return;
			if($(window).innerWidth() < config.breakpoint){
				if ($next.hasClass('--initial')) {

					$next.find('.pane-body').slideDown();
					$current.removeClass('--initial');
				} else {
					methods.toggle($current, $next);
				}
			} else {
				methods.toggle($current, $next);
			}

        });

		$("form.form--calculator").find('button[type="submit"]').click(function(e) {
			// console.log('test');
		})
    };


}(jQuery));
