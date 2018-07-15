<?php

// This is main config files for web application
// CWebApplication properties should be define here
return array(
    // base properties
	'basePath'          =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name'              =>  'Gifm',
    'defaultController' =>  'main',
    'language'          =>  'ru',
    'theme'             =>  'default',
    'charset'           =>  'UTF-8',

	// preload for some components
	'preload'=>array(
        'log',
        // uncomment 'bootstrap' if you want use booster in your web application
        //'bootstrap',
    ),

	// autoload models and components
	'import'=>array(
        // load components/models/modules
		'application.models.*',        
		'application.components.*',
        // load widgets
        'zii.widgets.*',      
        'application.zii.widgets*',
        'application.widgets.*',
        // helpers
        'application.helpers.*',
	),

	// load some modules
	'modules'=>array(
		// enable Gii module (for developers) 
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
		 	// bind to IP for secure
			'ipFilters'=>array('127.0.0.1','79.120.123.159','79.98.214.154','::1'),
            // uncomment next if you want use booster in your web application
            //'generatorPaths' => array(
                //'bootstrap.gii'
            //),
		),        
	),
    
	// components of web applications
	'components'=>array(

        'request'=>array(
            'class' => 'HttpRequest',
            'noCsrfValidationRoutes' => array(
                '^payment',
            ),
            'enableCsrfValidation' => true,
        ),
        
        // script properties
        'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=>'/vk/themes/default/web/js/',
                    'js'=>array('jquery-1.10.2.js'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                'jquery_validate'=>array(
                    'baseUrl'=>'/vk/themes/default/web/js/',
                    'js'=>array('jquery.validate.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                'jquery_ui'=>array(
                    'baseUrl'=>'/vk/themes/default/web/js/',
                    'js'=>array('jquery-ui-1.11.0.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                'jquery_ui_datepicker_ru'=>array(
                    'baseUrl'=>'/vk/themes/default/web/js/',
                    'js'=>array('jquery.ui.datepicker-ru.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                'vk_gifts'=>array(
                    'baseUrl'=>'/vk/themes/default/web/js/',
                    'js'=>array('vk_gifts.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_BEGIN
                )
            ),
        ),
        
		// properties for Url Manager
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'urlSuffix' => '/',
            'useStrictParsing' => false,
            'rules'=>array(
                '' => 'main/index',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
		),
        
		// properties for connect to MySql
        'db' => require(dirname(__FILE__) . '/db.php'),
        
        // properties for Auth Manager
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles' => array('guest'),
        ),
              
        // cache properties
		'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),
        
        // error handler
		'errorHandler'=>array(
            'errorAction'=>'/vk/main/error',
        ),
        
		// log properties
        'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
                    //'class'=>'CWebLogRoute',
					'levels'=>'error, warning', //, trace',
				),
			),
		),
	),

	// user parameters of web application
    // Use: Yii::app()->params['paramName']
    'params' => require dirname(__FILE__) . '/params.php',
);