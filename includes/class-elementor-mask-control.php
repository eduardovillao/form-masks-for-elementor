<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Evcode_Elementor_Forms_Mask {

	public $allowed_fields = [
		'text',
		'tel',
	];

	public function __construct() {
		// Add class attribute to form field render
		add_filter( 'elementor_pro/forms/render/item', [ $this, 'evcode_add_mask_class' ], 10, 3 );

		add_action( 'elementor/element/form/section_form_fields/before_section_end', [ $this, 'evcode_add_mask_control' ], 100, 2 );
	}

	/**
	 * add_css_class_field_control
	 * @param $element
	 * @param $args
	 */
	public function evcode_add_mask_control ( $element, $args ) {
		$elementor = \Elementor\Plugin::instance();
		$control_data = $elementor->controls_manager->get_control_from_stack( $element->get_name(), 'form_fields' );

		if ( is_wp_error( $control_data ) ) {
			return;
		}
		// create a new css class control as a repeater field
		$tmp = new Elementor\Repeater();
		$tmp->add_control(
			'evcode_mask_control',
			[
				'label' => __( 'Mask Control', 'elementor-pro' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'sel',
				'options' => [
					'mask' => __( 'Select Mask', 'elementor-pro' ),
					'ev-tel' => __( 'Phone', 'elementor-pro' ),
					'ev-tel-ddd' => __( 'Phone + DDD', 'elementor-pro' ),
					'ev-tel-us' => __( 'Phone USA', 'elementor-pro' ),
					'ev-cpf' => __( 'CPF', 'elementor-pro' ),
					'ev-cnpj' => __( 'CNPJ', 'elementor-pro' ),
					'ev-money' => __( 'Money', 'elementor-pro' ),
					'ev-cep' => __( 'CEP', 'elementor-pro' ),
					'ev-time' => __( 'Time', 'elementor-pro' ),
					'ev-date' => __( 'Date', 'elementor-pro' ),
					'ev-date_time' => __( 'Date and Time', 'elementor-pro' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			]
		);

		$pattern_field = $tmp->get_controls();
		$pattern_field = $pattern_field['evcode_mask_control'];

		// insert new class field in advanced tab before field ID control
		$new_order = [];
		foreach ( $control_data['fields'] as $field_key => $field ) {
			if ( 'field_value' === $field['name'] ) {
				$new_order['evcode_mask_control'] = $pattern_field;
			}
			$new_order[ $field_key ] = $field;
		}
		$control_data['fields'] = $new_order;

		$element->update_control( 'form_fields', $control_data );
	}

	public function evcode_add_mask_class ( $field, $field_index, $form_widget ) {
		if ( ! empty( $field['evcode_mask_control'] ) && in_array( $field['field_type'], $this->allowed_fields ) ) {

			$form_widget->add_render_attribute( 'input' . $field_index, 'class', $field['evcode_mask_control'] );
		}
		return $field;
	}
}
new Evcode_Elementor_Forms_Mask();
