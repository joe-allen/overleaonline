<?php
/**
 * Intervention
 *
 * @package BoogieDown\Overlea\Functions
 * @version 1.0.0
 */

return [
	'application'                    => [
		'site'       => [
			'timezone'    => 'America/New_York',
			'date-format' => 'F j, Y',
			'time-format' => 'g:i a',
			'week-starts' => 'Sun',
		],
		'taxonomies' => [
			'post-tag' => false,
		],
		'writing'    => [
			'emoji' => false,
		],
	],
	'wp-admin.all'                   => [
		'appearance' => [
			'customize' => 'appearance.menus',
			'theme-editor',
		],
		'comments',
		'common'     => [
			'adminbar'   => [
				'user.howdy' => 'Hello,',
				'comments',
				'wp',
			],
			'footer'     => [
				'credit' => 'Site by <a href="https://joeallen.dev" target="_blank">Joe Allen</a>',
			],
			'pagination' => 40,
			'tabs',
		],
		'media'      => [
			'all' => [
				'list.cols.comments',
			],
		],
		'pages'      => [
			'all' => [
				'list.cols.comments',
			],
		],
		'plugins'    => [
			'plugin-editor',
		],
		'posts'      => [
			'all'   => [
				'title' => 'News',
				'list.cols.comments',
			],
			'title' => 'News',
		],
		'users'      => [
			'profile' => [
				'about',
				'contact',
				'options' => [
					'editor',
					'syntax',
					'schemes',
					'shortcuts',
				],
			],
		],
	],
	'wp-admin.all-not-administrator' => [
		'appearance' => [
			'themes',
		],
		'common'     => [
			'footer.version',
			'footer.credit' => 'Site by <a href="https://joeallen.dev" target="_blank">Joe Allen</a>',
			'updates',
		],
		'dashboard'  => [
			'pages',
			'home.tabs',
			'home.notices',
			'home.activity',
			'home.right-now',
			'home.recent-comments',
			'home.incoming-links',
			'home.plugins',
			'home.quick-draft',
			'home.news',
			'home.site-health',
		],
		'plugins',
		'tools',
	],
];
