<?php

namespace Basico;

return array(
	    'router' => array(
	        'routes' => array(
	            //home 
	            'home' => array(
	                'type' => 'Zend\Mvc\Router\Http\Literal',
	                'options' => array(
	                    'route'    => '/',
	                    'defaults' => array(
	                        'controller' => 'basico-index',
	                        'action'     => 'index',
	                    ),
	                ),
	            ),
				//basico
                'basico' => array(
                        'type' 		=> 'Segment',
                        'options' 	=> array(
                                'route'    => '/basico[/:controller[/:action]][/:id][/:child_id]',
                                'defaults' => array(
                                        'module'	 => 'basico',
                                        'controller' => 'basico-index',
                                        'action'     => 'index',
                                ),
                                'constraints'	=> array(
                                        'id' 		=> '[0-9]+',
                                        'child_id' 	=> '[a-zA-Z0-9_-]+',
                                )
                        ),
                ),
	                
				/*'basico' => array(
	                'type'    => 'Literal',
	                'options' => array(
	                    'route'    => '/application',
	                    'defaults' => array(
	                        '__NAMESPACE__' => 'Application\Controller',
	                        'controller'    => 'Index',
	                        'action'        => 'index',
	                    ),
	                ),
	                'may_terminate' => true,
	                'child_routes' => array(
	                    'default' => array(
	                        'type'    => 'Segment',
	                        'options' => array(
	                            'route'    => '/[:controller[/:action]]',
	                            'constraints' => array(
	                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
	                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
	                            ),
	                            'defaults' => array(
	                            ),
	                        ),
	                    ),
	                ),
	            ),*/
	                
	        ),
	    ), //end of router
	    //--------------------------------------------------------------------------------
    
	    'controllers' => array(
	        'invokables' => array(
	                'basico-index'	=> 'Basico\Controller\IndexController',
	                'index'			=> 'Basico\Controller\IndexController',
	                'teste'			=> 'Basico\Controller\TesteController',
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
                        #'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
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
	            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
	            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
	            'error/404'               => __DIR__ . '/../view/error/404.phtml',
	            'error/index'             => __DIR__ . '/../view/error/index.phtml',
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
