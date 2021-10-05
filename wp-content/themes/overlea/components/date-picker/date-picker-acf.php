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
				'label' => 'Start Date / Time',
				'wrapper' => [
					'width' => '50',
				],
			])
			->addDateTimePicker(
				'event_end_date',
				[
					'label' => 'End Date / Time',
					'wrapper' => [
						'width' => '50',
					],
				]
			);

return $c_date_picker;
