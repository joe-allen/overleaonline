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
			->setInstructions('Do not enter manually. Pick Date/Time then click \'Done\'.<br>Events in the past will not be shown.<br>Format: dd/mm/yyyy')
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
			->addTrueFalse(
			'event_show_dates',
			[
				'label' => 'Show dates on site?',
				'ui' => 1,
				'default_value' => 1,
			])
			->addTrueFalse(
			'event_subject_to_change',
			[
				'label' => 'Dates are subject to change?',
				'ui' => 1,
			]);

return $c_date_picker;
