<?php

namespace Basico;

return array(    
    'router' => array(        
        'routes' => array(
            //Rota: home 
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Basico\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
			//Rota: basico-index
            'basico' => array(
                'type' 		=> 'Segment',
                'options' 	=> array(
                    'route'    => '/basico/index[/:action]',
                    'defaults' => array(
                        'controller' => 'Basico\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            //Rota: cadastro-categoria
            'cadastro-categoria' => array(
                'type' 		=> 'Segment',
                'options' 	=> array(
                    'route'    => '/cadastro/categoria[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Basico\Controller\Categoria',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+',
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Zend\Mvc\Router\Http\Wildcard',
                        'options' => array(
                            'key_value_delimiter' => '/',
                            'param_delimiter' => '/',
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ), //end of router
    //--------------------------------------------------------------------------------

    'controllers' => array(
        'invokables' => array(
            'Basico\Controller\Index'       => 'Basico\Controller\IndexController',
            'Basico\Controller\Categoria'   => 'Basico\Controller\CategoriaController',
        ),
    ), //end of controllers
    //--------------------------------------------------------------------------------

	'controller_plugins' => array(
    	'invokables' => array(
        	'ParamCores' 	=> 'Basico\Controller\Plugin\ParamCores',
		)
	), //end of controller_plugins
    //--------------------------------------------------------------------------------
    
    'service_manager' => array(
        'factories' => array(
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ), //end of service_manager
    //--------------------------------------------------------------------------------

    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ), //end of translator
    //--------------------------------------------------------------------------------
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index'   => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ), //en of view_manager
    //--------------------------------------------------------------------------------

	'doctrine' => array(
    	'driver' => array(
        	__NAMESPACE__ . '_driver' => array(
            	'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
            'orm_default' => array(
            	'drivers' => array(
                	__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				),
			),
		),
        'configuration' => array(
        	'orm_default' => array(
            	'types' => array(
                	'SqlServerDatetime' 		=> 'Basico\Doctrine\Types\SqlServerDatetime',
                    'SqlServerSmalldatetime' 	=> 'Basico\Doctrine\Types\SqlServerSmalldatetime',
				),
			),
		),
	), //end of doctrine
    //--------------------------------------------------------------------------------
        
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
