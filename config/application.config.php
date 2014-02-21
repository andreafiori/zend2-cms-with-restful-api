<?php
return array(

    'modules' => array(
        'Application',
    	'EdpModuleLayouts', 'ServiceLocatorFactory',
    	'DoctrineModule', 'DoctrineORMModule',
    	//'ZendDeveloperTools',
    	'ZfcBase','ZfcUser','BjyProfiler',
    	'Backend','Categories','Config','Contacts','Languages','Posts','Setup','Users','Gallery','Timeline'
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