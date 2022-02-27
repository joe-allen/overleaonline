<?php
/**
 * Date Picker ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_date_picker = new FieldsBuilder( 'date_picker' );

$c_date_picker
	->addTab('date_time', [ 'label' => 'Date / Time' ])
		->addDateTimePicker(
			'event_start_date',
			[
				'label'          => 'Start Date / Time',
				'required' => 1,
				'wrapper' => [
					'width' => '50',
				],
			])
			->setInstructions('Events in the past will not be shown. Format: dd/mm/yyyy')
			->addDateTimePicker(
				'event_end_date',
				[
					'label'          => 'End Date / Time',
					'wrapper' => [
						'width' => '50',
					],
				]
			)
			->setInstructions('Format: dd/mm/yyyy')
			->addCheckbox(
			'event_subject_to_change',
			[
				'label' => '',
				'choices' => [
					1 => 'Dates are subject to change?',
				],
			]);

return $c_date_picker;
