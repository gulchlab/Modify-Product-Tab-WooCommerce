
/**
 * Remove default tab
 * Add Custom tab, product page
 * custom repeatable field from product page
 */
add_filter( 'woocommerce_product_tabs', 'tradiestandard_product_tab' );
function tradiestandard_product_tab( $tabs ) {

	unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
	
	// Adds the new tab
	
    $entries = get_post_meta( get_the_ID(), 'repeatable_tab_sections', true );
    $counter = 1;
	foreach ( (array) $entries as $key => $entry ) {
	$counter++;
		$tab_content = $tab_title = '';

		if ( isset( $entry['tab_title'] ) ) {
			$title = esc_html( $entry['tab_title'] );
		}
		if ( isset( $entry['tab_content'] ) ) {
			$desc = wpautop( $entry['tab_content'] );
		}
		if($title) {
			$tabs['tradiestandard_product_tab_'.$counter] = array(
				'title' 	=> __( $title, 'tradiestandard' ),
				'priority' 	=> 50+$counter,
				'tabContent' => $desc,
				'callback' 	=> 'tradiestandard_product_tab_content_'
			);
		}

	}
	return $tabs;

}

function tradiestandard_product_tab_content_( $tab_key, $tab_info ) {
	echo apply_filters( 'tab_content', $tab_info['tabContent'] );
}
