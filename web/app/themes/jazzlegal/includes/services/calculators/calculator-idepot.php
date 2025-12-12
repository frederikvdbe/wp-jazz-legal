<?php

/**
 * @var array $args
 * @var WP_Post $child
 * @var array $data
 * @var bool $calculated
 * @var array $totals
 */
extract($args);
//var_dump($_POST);
?>

<section class="block_form form-calculator<?= $calculated ? ' form--calculated' : ''; ?>">

	<div class="block-form">

		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

					<form method="POST" action="<?php the_permalink(); ?>?calculated=true" class="form--calculator" data-type="idepot">
						<input type="hidden" name="calculator_service" value="<?= $child->post_title; ?>">

						<div class="form-header">
							<div class="form-title">
								<span><?= get_field('form_title', $child->ID) ? get_field('form_title', $child->ID) : 'Bereken de kost van jouw ' . $child->post_name; ?></span>
							</div>
						</div>

						<div class="form-description">
							<?php _e('Op basis van volgende informatie kunnen wij jou een gerichte prijs bezorgen:', 'jazzlegal'); ?>
						</div>

						<div class="form-body">

							<div class="form-row input--radio">
								<label for="option_year_<?= $child->ID; ?>" class="row-label">
									<?php _e('Voor hoeveel jaar wil u een I-depot indienen?', 'jazzlegal'); ?>
								</label>

								<div class="row-input">
									<?php foreach ($data['idepot_options'] as $option_key => $option) : ?>
										<div class="radio-input">
											<input type="radio" name="option_year_<?= $child->ID; ?>" value="<?= $option_key; ?>" <?= !isset($_POST['option_year_' . $child->ID]) && $option_key == 0 || isset($_POST['option_year_' . $child->ID]) && $option_key == $_POST['option_year_' . $child->ID] ? ' checked' : ''; ?>>
											<label for=""><?= $option['idepot_name']; ?></label>
										</div>
									<?php endforeach; ?>
								</div>
							</div>

							<div class="form-row row-submit">
								<div class="row-input">
									<button class="btn-rounded" type="submit" name="calculate" value="<?= $child->ID; ?>">
										<?= get_field('form_button', $child->ID) ? get_field('form_button', $child->ID) : 'Bereken jouw ' . $child->post_name; ?>
									</button>
								</div>
								<div class="row-label">
									<?php _e('Vragen of twijfels?', 'jazzlegal'); ?> <a href="<?php the_permalink(27); ?>"><?php _e('Neem contact met ons op', 'jazzlegal'); ?></a>.
								</div>
							</div>

						</div>

					</form>

				</div>
			</div>

		</div>

		<?php get_template_part('partials/vectors/mask6.svg'); ?>

	</div>

	<?php if ($calculated && count($totals)) : ?>

		<div class="block-footer" id="result">

			<div class="container container-results">
				<div class="row">
					<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

						<div class="result-header">
							<h2 class="footer-title"><?php _e('Resultaat', 'jazzlegal'); ?></h2>
						</div>

						<div class="result-body">

							<?php
							foreach ($totals['summary'] as $result) : ?>

								<div class="result-item">
									<div class="item-title"><?= $result['title']; ?></div>
									<div class="item-price"><?= $result['price']; ?>&euro;</div>
								</div>

							<?php endforeach; ?>

							<div class="result-item item-total">
								<div class="item-title">
									<strong><?php _e('Totaal', 'jazzlegal'); ?></strong> <span>(<?php _e('Prijzen exclusief btw. Op BBIE- en EUIPO-taksen is geen btw verschuldigd', 'jazzlegal'); ?><br>Onze <a href="#"><?php _e('algemene voorwaarden', 'jazzlegal'); ?></a> <?php _e('zijn van toepassing', 'jazzlegal'); ?>.</span>
								</div>
								<div class="item-price"><?= $totals['total']['price']; ?>&euro;</div>
							</div>

						</div>

					</div>
				</div>
			</div>

		</div>

	<?php endif; ?>

</section>
