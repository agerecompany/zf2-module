<?php
namespace Agere\Module;

return [

	'controller_plugins' => [
		'factories' => [
			'module' => Controller\Plugin\Factory\ModulePluginFactory::class,
			'entity' => Controller\Plugin\Factory\EntityPluginFactory::class,
		]
	],

	'view_helpers' => [
		'aliases' => [
			'module' => 'entity',
		],
		'factories' => [
			'entity' => View\Helper\Factory\ModuleFactory::class,
		],
	],

	'service_manager' => [
		'aliases' => [
			'ModuleService' => Service\ModuleService::class,
			'Module' => Model\Module::class,
		],
		'factories' => [
			Service\ModuleService::class => Service\Factory\ModuleServiceFactory::class,
		],
	],

	// Doctrine config
	'doctrine' => [
		'driver' => [
			'orm_default' => [
				'drivers' => [
					__NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver',
				],
			],
			__NAMESPACE__ . '_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
				'cache' => 'array',
				'extension' => '.dcm.yml',
				'paths' => [__DIR__ . '/yaml'],
			],
		],
	],

	/*'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Model']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ],
        ],
    ],*/
];
