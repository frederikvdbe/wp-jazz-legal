<?php
/**
 * @var array $args
 * @var WP_Post $child
 * @var array $data
 * @var bool $calculated
 * @var array $totals
 */
extract( $args );
?>

<section class="block_form form-calculator<?= $calculated ? ' form--calculated' : ''; ?>">

	<div class="block-form">

		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

					<form method="POST" action="<?php the_permalink(); ?>?calculated=true" class="form--calculator" data-type="regions">
						<input type="hidden" name="calculator_service" value="<?= $child->post_title; ?>">
						<?php if ( isset( $discount ) ) : ?>
							<input type="hidden" name="calculator_discount" value="<?= $discount; ?>">
						<?php endif; ?>

						<div class="form-header">
							<div class="form-title">
								<span><?= get_field( 'form_title', $child->ID ) ? get_field( 'form_title', $child->ID ) : 'Bereken de kost van jouw ' . $child->post_name; ?></span>
							</div>
						</div>

						<div class="form-description">
							<?php _e( 'Op basis van volgende informatie kunnen wij jou een gerichte prijs bezorgen', 'jazzlegal' ); ?>:
						</div>

						<div class="form-body">

							<div class="form-row">
								<label for="<?= 'region_' . $child->ID; ?>" class="row-label">
									<?= $data['calculator_region_question']; ?>
								</label>
								<div class="row-input">
									<select class="js_select_region" id="<?= $child->ID . '_region_select'; ?>" name="<?= 'region_' . $child->ID; ?>" data-type="region" data-id="<?= $child->ID; ?>">
										<option value="0"<?= isset( $_POST[ 'region_' . $child->ID ] ) && $_POST[ 'region_' . $child->ID ] == 0 ? ' selected' : ''; ?>><?php _e( 'Maak uw keuze', 'jazzlegal-front' ); ?></option>

										<?php foreach ( $data['calculator_regions'] as $region ) : ?>

											<?php // REWORK THIS PLS ?>

											<?php if ( apply_filters( 'wpml_current_language', NULL ) == 'en' && $region['label'] == 'Overige' ) : ?>
												<option value="<?= $region['value']; ?>"<?= isset( $_POST[ 'region_' . $child->ID ] ) && $_POST[ 'region_' . $child->ID ] == $region['value'] ? ' selected' : ''; ?>>Other</option>
										<?php elseif ( apply_filters( 'wpml_current_language', NULL ) == 'en' && $region['label'] == 'Europese Unie' ) : ?>
										<option value="<?= $region['value']; ?>"<?= isset( $_POST[ 'region_' . $child->ID ] ) && $_POST[ 'region_' . $child->ID ] == $region['value'] ? ' selected' : ''; ?>>European Union</option>
											<?php else : ?>
												<option value="<?= $region['value']; ?>"<?= isset( $_POST[ 'region_' . $child->ID ] ) && $_POST[ 'region_' . $child->ID ] == $region['value'] ? ' selected' : ''; ?>><?= $region['label']; ?></option>

											<?php endif; ?>
										<?php endforeach; ?>

									</select>
								</div>
							</div>

							<?php foreach ( $data['calculator_regions'] as $region_key => $region ) : ?>
								<?php if ( $region['value'] == 'misc' ) {
									continue;
								} ?>

								<div class="js_region-section" id="section_<?= $child->ID; ?>_<?= $region['value']; ?>"<?= ! isset( $_POST[ 'region_' . $child->ID ] ) && $region_key != 0 || isset( $_POST[ 'region_' . $child->ID ] ) && $_POST[ 'region_' . $child->ID ] != $region['value'] ? ' style="display: none;"' : ''; ?>>

									<?php if ( isset( $data[ $region['value'] . '_options' ] ) ) : ?>
										<?php $count_options = count( $data[ $region['value'] . '_options' ] ); ?>
										<div class="form-row">
											<label for="<?= 'option_' . $child->ID . '_' . $region['value']; ?>" class="row-label">
												<?= $data[ $region['value'] . '_options_question' ] ?>

												<?php if ( isset( $data[ $region['value'] . '_options_question_info' ] ) && $data[ $region['value'] . '_options_question_info' ] != '' ) : ?>
													<i class="fas fa-info-circle tooltip" title="<?= $data[ $region['value'] . '_options_question_info' ]; ?>"></i>
												<?php endif; ?>

											</label>
											<div class="row-input">
												<select class="js_select_option" id="<?= $child->ID . '_' . $region['value'] . '_option_select'; ?>" name="<?= 'option_' . $child->ID . '_' . $region['value']; ?>" data-type="region" data-id="<?= $child->ID; ?>">
													<option value="0"<?= isset( $_POST[ 'option_' . $child->ID . '_' . $region['value'] ] ) && $_POST[ 'option_' . $child->ID . '_' . $region['value'] ] == 0 ? ' selected' : ''; ?>>
														<?php if ( $child->ID == apply_filters( 'wpml_object_id', 83, 'serivce', true ) ) : ?>
															<?php _e( 'Aantal modellen', 'jazzlegal-front' ); ?>
														<?php else : ?>
															<?php _e( 'Aantal Nice-klassen', 'jazzlegal-front' ); ?>
														<?php endif; ?>
													</option>
													<?php foreach ( $data[ $region['value'] . '_options' ] as $option ) : ?>
														<option value="<?= urlencode( $option['option_name'] ); ?>"<?= isset( $_POST[ 'option_' . $child->ID . '_' . $region['value'] ] ) && $_POST[ 'option_' . $child->ID . '_' . $region['value'] ] == urlencode( $option['option_name'] ) ? ' selected' : ''; ?>><?= $option['option_name']; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									<?php endif; ?>

									<?php if ( isset( $data[ $region['value'] . '_extras' ] ) && is_array( $data[ $region['value'] . '_extras' ] ) ) : ?>

										<?php // Check for Registratieprocedures - modelregistratie ?>

										<?php foreach ( $data[ $region['value'] . '_extras' ] as $extra_key => $extra ) : ?>

											<div class="form-row row-extra input--radio<?= $region_key != 0 ? ' row---hidden' : ''; ?>" data-region="<?= $region['value']; ?>">
												<label for="<?= 'extra_' . $child->ID . '[' . $extra_key . ']'; ?>" class="row-label">
													<?= $extra['extra_name']; ?>
													<span>(<?php _e( 'optioneel', 'jazzlegal-front' ); ?>)</span>
												</label>

												<div class="row-input">
													<div class="radio-input">
														<input type="radio" name="<?= 'extra_' . $child->ID . '_' . $region['value'] . '[' . $extra_key . ']'; ?>" value="0"<?= ! isset( $_POST[ 'extra_' . $child->ID . '_' . $region['value'] ][ $extra_key ] ) || isset( $_POST[ 'extra_' . $child->ID . '_' . $region['value'] ][ $extra_key ] ) && $_POST[ 'extra_' . $child->ID . '_' . $region['value'] ][ $extra_key ] == '0' ? ' checked' : ''; ?>>
														<label for=""><?php _e( 'Nee', 'jazzlegal' ); ?></label>
													</div>
													<div class="radio-input">
														<input type="radio" name="<?= 'extra_' . $child->ID . '_' . $region['value'] . '[' . $extra_key . ']'; ?>" value="1"<?= isset( $_POST[ 'extra_' . $child->ID . '_' . $region['value'] ][ $extra_key ] ) && $_POST[ 'extra_' . $child->ID . '_' . $region['value'] ][ $extra_key ] == '1' ? ' checked' : ''; ?>>
														<label for=""><?php _e( 'Ja', 'jazzlegal' ); ?></label>
													</div>
												</div>
											</div>

											<?php if ( $child->ID == apply_filters( 'wpml_object_id', 83, 'service' ) ) {
												break;
											} ?>

										<?php endforeach; ?>

									<?php endif; ?>

								</div>

							<?php endforeach; ?>

							<div class="form-row row-submit">
								<div class="row-input">
									<button class="btn-rounded" type="submit" name="calculate" value="<?= $child->ID; ?>"<?= ! isset( $_POST['calculate'] ) ? ' disabled' : ''; ?>>
										<?= get_field( 'form_button', $child->ID ) ? get_field( 'form_button', $child->ID ) : 'Bereken jouw ' . $child->post_name; ?>
									</button>
								</div>
								<div class="row-label">
									<?php _e( 'Vragen of twijfels?', 'jazzlegal' ); ?> <a href="<?php the_permalink( 27 ); ?>"><?php _e( 'Neem contact met ons op', 'jazzlegal' ); ?></a>.
								</div>
							</div>

						</div>

					</form>

				</div>
			</div>

		</div>

		<?php get_template_part( 'partials/vectors/mask6.svg' ); ?>

	</div>

	<?php if ( $calculated ) : ?>

		<div class="block-footer" id="result">

			<div class="container container-results">
				<div class="row">
					<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

						<div class="result-header">
							<h2 class="footer-title"><?php _e( 'Resultaat', 'jazzlegal' ); ?></h2>
						</div>

						<div class="result-body">

							<?php if ( count( $totals ) ) : ?>

								<?php foreach ( $totals['summary'] as $result ) : ?>

									<div class="result-item">
										<div class="item-title"><?= $result['title']; ?></div>
										<div class="item-price"><?= $result['price']; ?>&euro;</div>
									</div>

								<?php endforeach; ?>

								<?php // TODO: check for totals -> discount ?>

								<div class="result-item item-total">
									<div class="item-title">
										<strong><?php _e( 'Totaal', 'jazzlegal' ); ?></strong> <span>(<?php _e( 'Prijzen exclusief btw. Op BBIE- en EUIPO-taksen is geen btw verschuldigd', 'jazzlegal' ); ?>)<br>
                                            <?php printf( __( 'Onze %s algemene voorwaarden %s zijn van toepassing', 'jazzlegal' ), '<a href="' . get_permalink( apply_filters( 'wpml_object_id', 306, 'page' ) ) . '" target="_blank">', '</a>' ); ?>.</span>
									</div>
									<div class="item-price"><?= $totals['total']['price']; ?>&euro;</div>
								</div>

							<?php else : ?>

								<?php _e( 'Deze vraag moeten wij op maat voor jou bekijken. Gelieve onderstaand contactformulier in te vullen en we komen snel op jouw vraag terug.', 'jazzlegal' ); ?>

							<?php endif; ?>

						</div>

					</div>
				</div>
			</div>

			<?php if ( $data['result_includes'] ) : ?>
				<div class="container container-includes">
					<div class="row">
						<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

							<div class="result-includes">

								<div class="result-header">
									<h2 class="footer-title"><?php printf( __( 'Deze %s houd in', 'jazzlegal' ), $child->post_name ); ?></h2>
								</div>

								<div class="result-body">

									<ul class="list-checks">
										<?php foreach ( $data['result_includes'] as $include ) : ?>
											<li><?= $include['include_name']; ?></li>
										<?php endforeach; ?>
									</ul>

								</div>

							</div>

						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>

	<?php endif; ?>

</section>
