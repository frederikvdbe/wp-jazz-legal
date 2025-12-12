const App = {
	// ---------------- Properties ----------------
	mediaQueries: {
		mobile: window.matchMedia("(min-width: 320px) and (max-width: 767px)"),
		tablet: window.matchMedia("(min-width: 768px) and (max-width: 1279px)"),
		tabletUp: window.matchMedia("(min-width: 768px)"),
		desktop: window.matchMedia(
			"(min-width: 1280px) and (max-width: 1499px)"
		),
		desktopLarge: window.matchMedia("(min-width: 1500px)"),
	},
	navOpen: false,

	init: function () {
		// Extend jQuery
		this.extendjQuery();

		// Toggle nav click handler
		$(".nav-toggle .hamburger").click(function (e) {
			App.toggleNav($(e.currentTarget));
		});

		// Backdrop click event
		$(document).on("click", ".nav-backdrop", function () {
			App.toggleNav($(".nav-toggle"));
		});

		// Logic for service calculators
		this.priceCalculators();

		// Swiper init
		App.initLogosSlider($(".block_references"));
		App.initGallerySlider($(".block_gallery"));

		// Tooltipster init
		$(".tooltip").tooltipster({
			trigger: "click",
			maxWidth: "420",
			functionBefore: function (origin, continueTooltip) {
				$(continueTooltip.origin).addClass("tooltip--active");
			},
			functionAfter: function (origin) {
				$(origin._$origin).removeClass("tooltip--active");
			},
		});

		// Responsive background images
		// $('.js_responsive_bg').responsiveBackgroundImages();

		// Service tabs init
		$(".js_tabs-container").tabs();

		// Select 2 init
		$(".form--calculator select").each(function (index, elem) {
			$(elem).select2({
				theme: "light",
				minimumResultsForSearch: -1,
			});
		});

		// ScrollTo init
		$(".js_scrollto").click((e) => this.scrollTo(e));

		if ($.urlParam("calculated") === "true") {
			$.scrollTo($("#result"), {
				duration: 800,
				easing: "easeInOutExpo",
			});

			if($(window).innerWidth() < 1024){

				$('.tab-pane').each(function() {

					$body = $(this).find('.pane-body');

					if ($body.find('.form--calculated').length > 0) {
						$(this).addClass('--active');
						$(this).removeClass('--initial');
						$(this).find('.pane-body').show();
					}
				});

				$.scrollTo($("#result"), {
					duration: 800,
					easing: "easeInOutExpo",
				});
			}
		}
	},

	initLogosSlider: function ($elems) {

		if(!$elems.length) return;

		$elems.each(function(key, elem) {
			var swiper = $(elem).find(".swiper");

			if(swiper)
				new Swiper(swiper.get(0), {
					slidesPerView: "auto",

					pagination: {
						el: ".swiper-pagination",
						clickable: true,
					},
				});
		});

	},

	initGallerySlider: function ($elems) {

		if(!$elems.length) return;

		$elems.each(function(index, elem) {

			new Swiper('.swiper', {
				slidesPerView: 1,

				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},

			});
		});
	},

	toggleNav: function ($toggle) {
		var $body = $('body'),
			$nav = $(".nav-site"),
			$header = $(".site-header"),
			$backdrop = $('<div class="nav-backdrop"></div>').hide(),
			closeDuration = 400;

		if (!App.navOpen) {
			App.lockScroll($(".site-header, .nav-site"));

			$body.addClass('nav--open');

			if ($header.find(".header-nav").hasClass("nav--inverse")) {
				$header.find(".header-nav").attr('id', 'inverse');
			}

			$header.find(".header-nav").addClass("nav--inverse");
			$header.find(".logo").addClass("logo--white");
			$nav.addClass("--open");
			$toggle.addClass("is-active");
			$toggle.parent().addClass("toggle--inverse");

			anime
				.timeline()
				.add({
					targets: $nav.get(),
					translateY: ["-100%", 0],
					duration: 600,
					easing: "easeOutQuint",
				})
				.add(
					{
						targets: $nav.find(".menu.site-menu > li").get(),
						translateY: [-120, 0],
						opacity: [0, 1],
						easing: "easeOutQuart",
						duration: 400,
						delay: anime.stagger(120),
						begin: function () {
							$header.addClass("--nav-open");
						},
					},
					"-120"
				)
				.add(
					{
						targets: $nav.find(".menu.legal-menu").get(),
						translateY: [-120, 0],
						opacity: [0, 1],
						easing: "easeOutQuart",
						duration: 400,
						begin: function () {
							$header.addClass("--nav-open");

							$("body").append($backdrop);
							$backdrop.fadeIn();
						},
					},
					"200"
				);
		} else {
			App.unlockScroll($(".site-header, .nav-site"));

			anime({
				targets: $nav.get(),
				translateY: [0, "-100%"],
				duration: closeDuration,
				easing: "easeInOutCirc",
			});

			$header.removeClass("--nav-open");

			setTimeout(function () {

				if ($header.find(".header-nav").attr('id') != 'inverse') {
					$header.find(".header-nav").removeClass("nav--inverse");
					$header.removeClass("header--inverse");
					$toggle.parent().removeClass("toggle--inverse");
				}

				$body.removeClass('nav--open');

				$header.find(".logo").removeClass("logo--white");
				$nav.removeClass("--open");
				$toggle.removeClass("is-active");
				$(".nav-backdrop").fadeOut(function () {
					$(".nav-backdrop").remove();
				});

			}, closeDuration * 0.8);
		}
		// Toggle navOpen property
		App.navOpen = !App.navOpen;
	},

	priceCalculators: function () {
		var $form = $("form.form--calculator");

		$form.each(function (e, form) {
			var $form = $(form),
				type = $form.data("type"),
				$submit = $(form).find('button[type="submit"]');

			if (type === "regions") {
				// Load in appropriate subfields
				$form
					.find(".js_select_region")
					.on("select2:select", function (e) {
						var $select = $(e.target),
							id = $select.data("id"),
							region = $select.val(),
							$section = $("#section_" + id + "_" + region),
							$select_option = $section.find(".js_select_option");

						$form.find(".js_region-section").hide();
						$section.show();

						if (
							$select.val() !== "0" &&
							$select_option.val() !== "0"
						) {
							$submit.attr("disabled", false);
						} else {
							$submit.attr("disabled", true);
						}
					});

				$form
					.find(".js_select_option")
					.on("select2:select", function (e) {
						var $select = $(e.target);

						if ($select.val() !== "0") {
							$submit.attr("disabled", false);
						} else {
							$submit.attr("disabled", true);
						}
					});
			} else {
				// $radioButtons = $form.find('input[type="radio"]').change(function() {
				//     console.log('changed');
				// })
			}
		});
	},

	scrollTo: function (e) {
		var $button = $(e.currentTarget),
			$target = $($button.data("scroll-target")),
			type = $button.data("scroll-type");

		// Scroll to target
		if ($target.length) {
			console.log("Scroll to element", $target);
			$.scrollTo($target, {
				duration: 800,
				easing: "easeInOutExpo",
			});
		}

		// Skip viewport height
		// for heros
		if (type && type === "skip") {
			console.log("Scroll to skip");

			$.scrollTo($(window).outerHeight(), {
				duration: 800,
				easing: "easeInOutExpo",
			});
		}
	},

	lockScroll: function ($elems = null) {
		console.log("Lock scroll");

		$html = $("html");
		$body = $("body");
		var initWidth = $body.outerWidth();
		var initHeight = $body.outerHeight();

		var scrollPosition = [
			self.pageXOffset ||
				document.documentElement.scrollLeft ||
				document.body.scrollLeft,
			self.pageYOffset ||
				document.documentElement.scrollTop ||
				document.body.scrollTop,
		];
		$html.data("scroll-position", scrollPosition);
		$html.data("previous-overflow", $html.css("overflow"));
		$html.css("overflow", "hidden");
		window.scrollTo(scrollPosition[0], scrollPosition[1]);

		var marginR = $body.outerWidth() - initWidth;
		var marginB = $body.outerHeight() - initHeight;
		$body.css({ "margin-right": marginR, "margin-bottom": marginB });

		if ($elems.length) {
			$elems.each(function (i, elem) {
				$(elem).css({
					"margin-right": marginR,
					"margin-bottom": marginB,
				});
			});
		}
	},

	unlockScroll: function ($elems = null) {
		console.log("Unlock scroll");

		$html = $("html");
		$body = $("body");
		$html.css("overflow", $html.data("previous-overflow"));
		var scrollPosition = $html.data("scroll-position");
		window.scrollTo(scrollPosition[0], scrollPosition[1]);

		$body.css({ "margin-right": 0, "margin-bottom": 0 });

		if ($elems.length) {
			$elems.each(function (i, elem) {
				$(elem).css({ "margin-right": 0, "margin-bottom": 0 });
			});
		}
	},

	extendjQuery: function () {
		// easeInOutExpo easing
		$.easing = Object.assign({}, $.easing, {
			easeInOutExpo: function (x, t, b, c, d) {
				if (t == 0) return b;
				if (t == d) return b + c;
				if ((t /= d / 2) < 1)
					return (c / 2) * Math.pow(2, 10 * (t - 1)) + b;
				return (c / 2) * (-Math.pow(2, -10 * --t) + 2) + b;
			},
		});

		// Get query parameters
		$.urlParam = function (name) {
			var results = new RegExp("[?&]" + name + "=([^&#]*)").exec(
				window.location.search
			);

			return results !== null ? results[1] || 0 : false;
		};
	},
};

$(document).ready(function () {
	App.init();
});
