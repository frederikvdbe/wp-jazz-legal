<?php

/**
 * @var WP_Post $post
 * @var array $args
 * @var bool $logo_inverse
 * @var bool $nav_inverse
 */
extract($args);

$nav_inverse = $nav_inverse ?? false;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<title><?php wp_title(); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if (getenv('WP_ENV')  == 'production') :  ?>
		<!-- Google Tag Manager -->
		<script type="plain/text" data-cookiecategory="analytics">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-598XG5X');</script>
		<!-- End Google Tag Manager -->
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php if (getenv('WP_ENV')  == 'production') :  ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript data-cookiecategory="analytics"><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-598XG5X"
					  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php endif; ?>

	<?php if (getenv('WP_ENV') == 'development') : ?>
		<div class="debug_grid">
			<div class="container">
				<div class="row">
					<?php foreach (range(1, 12) as $column) : ?>
						<div class="col-xs-1">
							<div class="box"></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<section class="nav-site">
		<div class="nav-inner">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">
						<?php wp_nav_menu(array(
							'container' => false,
							'menu_class' => 'menu site-menu',
							'theme_location' => 'site-nav'
						)); ?>

						<div class="nav-legal">
							<?php wp_nav_menu(array(
								'container' => false,
								'menu_class' => 'menu legal-menu',
								'theme_location' => 'footer-nav'
							)); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

	<header class="site-header">
		<div class="container">
			<div class="row middle-xs between-xs">

				<div class="col-logo col-xs-4 col-sm-3 col-lg-2">
					<div class="header-logo<?= isset($logo_inverse) && $logo_inverse ? ' logo--inverse' : ''; ?>">
						<a href="<?php echo home_url(); ?>"><?php get_template_part('partials/vectors/logo.svg'); ?></a>
					</div>
				</div>

				<div class="col-xs-8 col-sm-9 col-lg-10">
					<div class="header-nav<?php if($nav_inverse) echo ' nav--inverse'; ?>">
						<div class="nav-buttons">
							<?php wp_nav_menu(array(
								'container' => false,
								'menu_class' => 'menu site-menu',
								'theme_location' => 'site-nav',
								'walker' => new WPSE_78121_Sublevel_Walker,
							)); ?>
						</div>
						<div class="nav-cta">
							<a href="https://calendly.com/thierryvanransbeeck" target="_blank" rel="noopener" class="btn-rounded btn--small btn--backdrop"><?php _e('Vraag een meeting aan', 'jazzlegal-front'); ?></a>
						</div>

						<div class="nav-lang">
							<?php echo languages_nav(); ?>
						</div>

					</div>
				</div>

				<div class="nav-toggle<?php if($nav_inverse) echo ' toggle--inverse'; ?>">
					<button class="hamburger hamburger--squeeze" type="button" data-open="<?php _e('Menu', 'jazzlegal-front'); ?>" data-close="<?php _e('Sluiten', 'jazzlegal-front'); ?>">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
					<div class="button-label">
						<?php get_template_part('partials/vectors/menu.svg'); ?>
					</div>
				</div>

			</div>
		</div>
	</header>

	<main class="site-main">
