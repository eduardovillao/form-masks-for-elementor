<?php

namespace FME\Includes;

use \Elementor\Plugin as ElementorPlugin;
use \Elementor\Controls_Manager as ElementorControls;
use \Elementor\Repeater as ElementorRepeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class FME_Elementor_Forms_Mask {

	public $allowed_fields = [
		'text'
	];

	public function __construct() {
		
		add_action( 'elementor/element/form/section_form_fields/before_section_end', [ $this, 'add_mask_control' ], 100, 2 );
		add_filter( 'elementor_pro/forms/render/item', [ $this, 'add_mask_atributes' ], 10, 3 );
	}

	/**
	 * Add mask control
	 * 
	 * @since 1.0
	 * @param $element
	 * @param $args
	 */
	public function add_mask_control( $element, $args ) {
		
		$elementor = ElementorPlugin::instance();
		$control_data = $elementor->controls_manager->get_control_from_stack( $element->get_name(), 'form_fields' );

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$new_control = [
				'label' => __( 'Mask Control', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'sel',
				'options' => [
					'mask' => __( 'Select Mask', 'form-masks-for-elementor' ),
					'ev-tel' => __( 'Phone (8 dig)', 'form-masks-for-elementor' ),
					'ev-tel-ddd' => __( 'Phone (8 dig) + DDD', 'form-masks-for-elementor' ),
					'ev-tel-ddd9' => __( 'Phone (9 dig) + DDD', 'form-masks-for-elementor' ),
					'ev-tel-us' => __( 'Phone USA', 'form-masks-for-elementor' ),
					'ev-cpf' => __( 'CPF', 'form-masks-for-elementor' ),
					'ev-cnpj' => __( 'CNPJ', 'form-masks-for-elementor' ),
					'ev-money' => __( 'Money', 'form-masks-for-elementor' ),
					'ev-ccard' => __( 'Credit Card', 'form-masks-for-elementor' ),
					'ev-ccard-valid' => __( 'Credit Card Date', 'form-masks-for-elementor' ),
					'ev-cep' => __( 'CEP', 'form-masks-for-elementor' ),
					'ev-time' => __( 'Time', 'form-masks-for-elementor' ),
					'ev-date' => __( 'Date', 'form-masks-for-elementor' ),
					'ev-date_time' => __( 'Date and Time', 'form-masks-for-elementor' ),
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
		];

		/**
		 * Filter to pro version change control.
		 * 
		 * @since 1.5
		 */
		$new_control = apply_filters( 'fme_after_mask_control_created', $new_control );
		
		$mask_control = new ElementorRepeater();
		$mask_control->add_control( 'fme_mask_control', $new_control );

		/**
		 * Action to insert more controls.
		 * 
		 * @since 1.5.2
		 */
		do_action( 'fme_after_mask_control_added', $mask_control );

		$pattern_field = $mask_control->get_controls();

		/**
		 * Register control in form advanced tab.
		 * 
		 * @since 1.5.2
		 */
		$this->register_control_in_form_advanced_tab( $element, $control_data, $pattern_field );
		
	}

	/**
	 * Register control in form advanced tab
	 *
	 * @param object $element
	 * @param array $control_data
	 * @param array $pattern_field
	 * @return void
	 * 
	 * @since 1.5.2
	 */
	public function register_control_in_form_advanced_tab( $element, $control_data, $pattern_field ) {

		foreach( $pattern_field as $key => $control ) {
			
			if( $key !== '_id' ) {

				$new_order = [];
				foreach ( $control_data['fields'] as $field_key => $field ) {
					
					if ( 'field_value' === $field['name'] ) {
						$new_order[$key] = $control;
					}
					$new_order[ $field_key ] = $field;
				}

				$control_data['fields'] = $new_order;
			}
		}

		return $element->update_control( 'form_fields', $control_data );
	}

	/**
	 * Render/add new mask atributes on input field.
	 *
	 * @since 1.0
	 * @param array $field
	 * @param string $field_index
	 * @return void
	 */
	public function add_mask_atributes( $field, $field_index, $form_widget ) {
		
		if ( ! empty( $field['fme_mask_control'] ) && in_array( $field['field_type'], $this->allowed_fields ) && $field['fme_mask_control'] != 'sel' ) {

			$form_widget->add_render_attribute( 'input' . $field_index, 'data-fme-mask', $field['fme_mask_control'] );
			$form_widget->add_render_attribute( 'input' . $field_index, 'class', 'fme-mask-input' );
		}

		/**
		 * After mask atribute added
		 * 
		 * Action fired to pro version add custom atributes.
		 * 
		 * @since 1.5.2
		 */
		do_action( 'fme_aftere_mask_atribute_added', $field, $field_index, $form_widget );

		return $field;
	}
}