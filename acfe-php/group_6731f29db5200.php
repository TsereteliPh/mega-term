<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_6731f29db5200',
	'title' => 'Вопрос - ответ',
	'fields' => array(
		array(
			'key' => 'field_6731f29d4949f',
			'label' => 'Ответ',
			'name' => 'answer',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'acfe_textarea_code' => 0,
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'rows' => '',
			'placeholder' => '',
			'new_lines' => 'br',
			'acfe_field_group_condition' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'faq',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'acfe_autosync' => array(
		0 => 'php',
	),
	'acfe_form' => 0,
	'acfe_display_title' => '',
	'acfe_meta' => '',
	'acfe_note' => '',
	'modified' => 1731326858,
));

endif;