# Modify Product Tab - WooCommerce
Remove default tabs and add new tabs using CMB2 metabox - WooCoomerce

** Customize Product Tabs with [CMB2](https://github.com/CMB2/CMB2) Repeater **
>Create repeater field using cmb2.

``` php
// repeatable field for product tab
function register_metabox() {
    $prefix = 'repeatable_tab_';

    $cmb_tab = new_cmb2_box( array(
        'id'            => $prefix . 'metabox',
        'title'         => __( 'Product Tab', 'cmb2' ),
        'object_types'  => array( 'product' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    // Repeatable group
    $group_field = $cmb_tab->add_field( array(
        'id'          => $prefix . 'sections',
        'type'        => 'group',
        'options'     => array(
            'group_title'   => __( 'Tab', 'cmb2' ) . ' {#}', // {#} gets replaced by row number
            'add_button'    => __( 'Add another tab', 'cmb2' ),
            'remove_button' => __( 'Remove tab', 'cmb2' ),
            'sortable'      => true, // beta
        ),
    ) );

    // Tab Title
    $cmb_tab->add_group_field( $group_field, array(
		'name' => 'Tab Title',
		'id'   => 'tab_title',
		'type' => 'text',
	) );

    // Tab editor
    $cmb_tab->add_group_field( $group_field, array(
        'name'    => __( 'Content', 'cmb2' ),
        'id'      => 'tab_content',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 8, ),
    ) );
}

add_action( 'cmb2_init', 'register_metabox' );

> Paste above code in function.php or use example-functions.php as CMB suggest

```
** Now, Below code will unset default tabs and adds new tab field in single product page template **
Paste below code in function.php
```
/**
 * Remove default tab
 * Add Custom tab, single product page - repeatable field CMB2
 */
add_filter( 'woocommerce_product_tabs', 'tradiestandard_product_tab' );
function tradiestandard_product_tab( $tabs ) {
    
    //unset default tabs
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
			$title = esc_html( $entry['tab_title'] ); // tab title value
		}
		if ( isset( $entry['tab_content'] ) ) {
			$desc = wpautop( $entry['tab_content'] ); // tab description content
		}
		if($title) {
      // tab title
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

// function to display tab content
function tradiestandard_product_tab_content_( $tab_key, $tab_info ) {
	echo apply_filters( 'tab_content', $tab_info['tabContent'] );
}
```
# That's All. Thank you.
