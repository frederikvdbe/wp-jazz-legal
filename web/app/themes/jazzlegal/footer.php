<?php

/**
 * @var array $args
 * @var string $style
 */
?>

</main>

<footer class="site-footer<?= isset($args['style']) ? ' footer--' . $args['style'] : ''; ?>">
	<div class="container">
		<div class="footer-legal">
			© Jazz.legal BV 2019-<?= date('Y'); ?> • KBO 0739.729.918
		</div>
		<div class="footer-nav">
			<?php wp_nav_menu(array(
				'container' => false,
				'theme_location' => 'footer-nav'
			)); ?>
		</div>
		<div class="footer-credits">
			<li class="credits-socials">
				<a href="https://www.facebook.com/jazz.legal/" target="_blank"><i class="fab fa-brands fa-facebook"></i></a>
				<a href="https://twitter.com/JazzLegal" target="_blank"><i class="fab fa-brands fa-twitter"></i></a>
				<a href="http://www.linkedin.com/company/jazz-legal" target="_blank"><i class="fab fa-brands fa-linkedin-in"></i></a>
				<a href="https://www.instagram.com/jazz.legal/" target="_blank"><i class="fab fa-brands fa-instagram"></i></a>
			</li>
			<a href="https://weareantenna.be" target="_blank"><?php get_template_part('partials/vectors/logo-antenna.svg'); ?></a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
