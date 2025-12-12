<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page' );
}

add_filter('single_template', 'service_single_template');
function service_single_template($template) {
    global $post;

    if ( $post->post_type == 'service' )
        if ( file_exists( get_template_directory() . '/includes/services/single.php' ) )
            return get_template_directory() . '/includes/services/single.php';

    return $template;
}

function calculate_region_calculator_totals($child, $data, $discount = 0) {

    if(isset($_POST['calculate']) && $_POST['calculate'] == $child->ID){

        $service = isset($_POST['calculator_service']) ? $_POST['calculator_service'] : null;
        $postedRegion = isset($_POST['region_' . $_POST['calculate']]) ? $_POST['region_' . $_POST['calculate']] : null;
        $postedOption = isset($postedRegion) && isset($_POST['option_' . $_POST['calculate'] . '_' . $postedRegion]) ? $_POST['option_' . $_POST['calculate'] . '_' . $postedRegion] : null;
        $extras = isset($_POST['extra_' . $_POST['calculate'] . '_' . $_POST['region_' . $_POST['calculate']]]) ? $_POST['extra_' . $_POST['calculate'] . '_' . $_POST['region_' . $child->ID]] : null;

        $results = [];
        $region_options = isset($data[$postedRegion.'_options']) ? $data[$postedRegion.'_options'] : null;
        $region_extras = isset($data[$postedRegion.'_extras']) ? $data[$postedRegion.'_extras'] : null;
        $price = 0;
        $rate = 0;
        $price_extra = 0;
        $rate_extra = 0;
        $extra_total = 0;
        $result_extras = [];

        if(!$region_options) return $results;

        // Get region
        foreach($region_options as $option_key => $region_option) {
            $price += $region_option['option_price'];
            $rate += $region_option['option_rate'];

            if (urlencode($region_option['option_name']) == $postedOption) {
                $selectedOption = $region_option;
                $selectedOptionKey = $option_key;
                break;
            }
        }

        // Get extras
        foreach($region_extras as $extra_key => $extra) {
            if(isset($extras[$extra_key]) && $extras[$extra_key] == 1){
                $result_extras[] = $extra;
            }
        }

        $results['region'] = $postedRegion;
        $results['option'] = $postedOption;

	    $results['summary'] = array();

        $results['summary'][] = array(
            'title' => $postedRegion == 'benelux' ? __('Recht Benelux-Bureau voor de Intellectuele Eigendom', 'jazzlegal-front')  : __('Recht EU-Bureau voor de Intellectuele Eigendom', 'jazzlegal-front'),
            'price' => $price
        );

		if($discount === 'AMDISCOUNT') {
			$results['summary'][] = array(
				'title' => __('Tarief Jazz.Legal', 'jazzlegal-front'),
				'price' => $rate
			);
			$results['summary'][] = array(
				'type' => 'discount',
				'title' => __('-50% on Jazz.legal fee (Discount code: AMDISCOUNT)', 'jazzlegal-front'),
				'price' => ($rate / 2 * -1),
			);
		} else {
			$results['summary'][] = array(
				'title' => __('Tarief Jazz.Legal', 'jazzlegal-front'),
				'price' => $rate
			);
		}

        if($result_extras) {

            $results['extras'] = [];

            /* SHAME / TODO: check for multilang */
            if($service == 'Modelregistratie' || $service == 'Design registration') {

                if(isset($region_extras[$selectedOptionKey])){
                    $extra = $region_extras[$selectedOptionKey];
                    $extra_total = $extra['extra_price'] + $extra['extra_rate'];

                    $results['summary'][] = array(
                        'title' => $extra['extra_name'],
                        'price' => $extra['extra_price'] + $extra['extra_rate']
                    );

                    $results['extras'][] = $extra['extra_name'];
                }

            } else {

                foreach($result_extras as $extra) {
                    $extra_total += $extra['extra_price'] + $extra['extra_rate'];

                    $results['summary'][] = array(
                        'title' => $extra['extra_name'],
                        'price' => $extra['extra_price'] + $extra['extra_rate']
                    );

                    $results['extras'][] = $extra['extra_name'];

                }

            }

        }

		if($discount && $discount == 'AMSINGAPORE') {
			$results['total'] = array(
				'price' => $price + ($rate / 2) + $extra_total
			);
		} else {
			$results['total'] = array(
				'price' => $price + $rate + $extra_total
			);
		}



        return $results;

    }

    return [];

}

function calculate_idepot_calculator_totals($child, $data) {

    if(isset($_POST['calculate']) && $_POST['calculate'] == $child->ID){

        $service = isset($_POST['calculator_service']) ? $_POST['calculator_service'] : null;
        $option = isset($_POST['option_year_' . $child->ID]) ? $_POST['option_year_' . $child->ID] : null;

        $results = [];
        $idepot_options = isset($data['idepot_options']) ? $data['idepot_options'] : null;
        $price = 0;
        $rate = 0;

        if(!$idepot_options) return $results;

        // Get region
        foreach($idepot_options as $idepot_option_key => $idepot_option) {

            if ($idepot_option_key == $option) {

                $results['option'] = $idepot_option['idepot_name'];

                $results['summary'][] = array(
                    'title' => __('Recht Benelux-Bureau voor de Intellectuele Eigendom', 'jazzlegal-front'),
                    'price' => $idepot_option['idepot_price']
                );

                $results['summary'][] = array(
                    'title' => __('Tarief Jazz.Legal', 'jazzlegal-front'),
                    'price' => $idepot_option['idepot_rate']
                );

                $results['total'] = array(
                    'price' => $idepot_option['idepot_price'] + $idepot_option['idepot_rate']
                );

                return $results;

                break;
            }
        }

    }

    return [];

}
