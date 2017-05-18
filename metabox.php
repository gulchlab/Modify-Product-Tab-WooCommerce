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
