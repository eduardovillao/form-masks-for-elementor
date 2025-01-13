<?php

namespace FME\Includes;

use \Elementor\Plugin as ElementorPlugin;
use \Elementor\Controls_Manager as ElementorControls;
use \Elementor\Repeater as ElementorRepeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FME_Elementor_Forms_Mask {

	public $allowed_fields = [
		'text',
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
		$pro_tag = ' <a class="fme-pro-feature" href="https://codecanyon.net/item/form-masks-for-elementor/25872641" target="_blank">' . esc_html__( 'PRO', 'form-masks-for-elementor' ) . '</a>';

		if ( is_wp_error( $control_data ) ) {
			return;
		}

		$controls_to_register = [
			'fme_mask_control' => [
				'label' => esc_html__( 'Mask Control', 'form-masks-for-elementor' ),
				'type' => ElementorControls::SELECT,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'default' => 'sel',
				'options' => [
					'mask' => esc_html__( 'Select Mask', 'form-masks-for-elementor' ),
					'ev-tel' => esc_html__( 'Phone (8 dig)', 'form-masks-for-elementor' ),
					'ev-tel-ddd' => esc_html__( 'Phone (8 dig) + DDD', 'form-masks-for-elementor' ),
					'ev-tel-ddd9' => esc_html__( 'Phone (9 dig) + DDD', 'form-masks-for-elementor' ),
					'ev-tel-us' => esc_html__( 'Phone USA', 'form-masks-for-elementor' ),
					'ev-cpf' => esc_html__( 'CPF', 'form-masks-for-elementor' ),
					'ev-cnpj' => esc_html__( 'CNPJ', 'form-masks-for-elementor' ),
					'ev-money' => esc_html__( 'Money', 'form-masks-for-elementor' ),
					'ev-ccard' => esc_html__( 'Credit Card', 'form-masks-for-elementor' ),
					'ev-ccard-valid' => esc_html__( 'Credit Card Date', 'form-masks-for-elementor' ),
					'ev-cep' => esc_html__( 'CEP', 'form-masks-for-elementor' ),
					'ev-time' => esc_html__( 'Time', 'form-masks-for-elementor' ),
					'ev-date' => esc_html__( 'Date', 'form-masks-for-elementor' ),
					'ev-date_time' => esc_html__( 'Date and Time', 'form-masks-for-elementor' ),
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
			],
			'fme_mask_alert_pro_version' => [
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'info',
				'content' => esc_html__( '🚀 Unlock features with the PRO version.', 'form-masks-for-elementor' ) . ' <a href="https://codecanyon.net/item/form-masks-for-elementor/25872641" target="_blank">' . esc_html__( 'Upgrade Now', 'form-masks-for-elementor' ) . '</a>',
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => $this->allowed_fields,
						],
					],
				],
			],
			'fme_mask_prefix_control' => [
				'label' => esc_html__( 'Mask Prefix', 'form-masks-for-elementor' ) . $pro_tag,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text' ],
						],
					],
				],
			],
			'fme_mask_suffix_control' => [
				'label' => esc_html__( 'Mask Suffix', 'form-masks-for-elementor' ) . $pro_tag,
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text' ],
						],
					],
				],
			],
			'fme_mask_reverse_control' => [
				'label' => esc_html__( 'Mask Reverse?', 'form-masks-for-elementor' ) . $pro_tag,
				'description' => esc_html__( 'Reverse mode is to format values dynamically as the user types, starting from the right (e.g., 0.01, 1.23, 12.34). Is commonly used for currency masks where the value grows from the decimal point.', 'form-masks-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'form-masks-for-elementor' ),
				'label_on' => esc_html__( 'On', 'form-masks-for-elementor' ),
				'return_value' => 'true',
				'default' => '',
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text' ],
						],
					],
				],
			],
			'fme_mask_inputmode_control' => [
				'label' => esc_html__( 'Mask Input Mode', 'form-masks-for-elementor' ) . $pro_tag,
				'description' => esc_html__( 'Input Mode determines the type of on-screen keyboard shown to users on mobile devices.', 'form-masks-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'select',
				'options' => [
					'select' => esc_html__( 'Select', 'form-masks-for-elementor' ),
					'text' => esc_html__( 'Text', 'form-masks-for-elementor' ),
					'decimal' => esc_html__( 'Decimal', 'form-masks-for-elementor' ),
					'numeric' => esc_html__( 'Numeric', 'form-masks-for-elementor' ),
					'tel' => esc_html__( 'Telephone', 'form-masks-for-elementor' ),
					'search' => esc_html__( 'Search', 'form-masks-for-elementor' ),
					'email' => esc_html__( 'Email', 'form-masks-for-elementor' ),
					'url' => esc_html__( 'Url', 'form-masks-for-elementor' ),
				],
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text' ],
						],
					],
				],
			],
			'fme_mask_divider_control' => [
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'tab' => 'content',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'form_fields_advanced_tab',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text' ],
						],
					],
				],
			],
		];

		/**
		 * Filter to pro version change control.
		 *
		 * @since 1.5
		 */
		$controls_to_register = apply_filters( 'fme_after_mask_control_created', $controls_to_register );

		$controls_repeater = new ElementorRepeater();
		foreach ( $controls_to_register as $key => $control ) {
			$controls_repeater->add_control( $key, $control );
		}

		$pattern_field = $controls_repeater->get_controls();

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
		if ( ! empty( $field['fme_mask_control'] ) && in_array( $field['field_type'], $this->allowed_fields ) && $field['fme_mask_control'] !== 'mask' ) {
			$form_widget->add_render_attribute( 'input' . $field_index, 'data-mask', $field['fme_mask_control'] );
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
