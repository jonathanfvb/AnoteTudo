<?php
return array(
    'modules' => array(
		//Doctrine
    	'DoctrineModule',
    	'DoctrineORMModule',
            
		//Lib própria
    	'Jlib',
            
    	//Módulos do TexCash
        'Basico',    	
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),    
);