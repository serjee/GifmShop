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
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        // load widgets
        'zii.widgets.*',      
        'application.zii.widgets*',
        'application.widgets.*',
        // load YiiMailer extension
        'ext.YiiMailer.YiiMailer',
        // helpers
        'application.helpers.*',
        // Расширение для работы с Qiwi по протоколу REST
        'ext.qiwi.QiwiClass',
	),

	// load some modules
	'modules'=>array(
        // enable "user" module for working with users
        'user'=>array(
            'defaultController' => 'account',
        ),
        // enable "order" module for working with orders
        'order'=>array(
            'defaultController' => 'index',
        ),
        // enable "admin" module for working with Admin Panel
        'admin'=>array(
            'defaultController' => 'main',
        ),
        'payment'=>array(
            'defaultController' => 'order',
            'modules' => array(
                'webmoney'=>array(
                    'defaultController' => 'pay',
                ),
                'qiwi'=>array(
                    'defaultController' => 'pay',
                ),
                'yam'=>array(
                    'defaultController' => 'pay',
                ),
                'rb'=>array(
                    'defaultController' => 'pay',
                ),
                'paypal'=>array(
                    'defaultController' => 'pay',
                    'components'=>array(
                        'Paypal' => array(
                            'class'=>'payment.paypal.components.Paypal',
                            'apiUsername' => 'YOUR_API_USERNAME',
                            'apiPassword' => 'YOUR_API_PASSWORD',
                            'apiSignature' => 'YOUR_API_SIGNATURE',
                            'apiLive' => false,

                            'returnUrl' => '/payment/paypal/pay/confirm/', //regardless of url management component
                            'cancelUrl' => '/payment/paypal/pay//cancel/', //regardless of url management component
                        ),
                    ),
                ),
            ),
        ),
		// enable Gii module (for developers) 
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
		 	// bind to IP for secure
			'ipFilters'=>array('127.0.0.1','::1'),
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
                '^payment/webmoney/pay/result',
                '^payment/webmoney/pay/success',
                '^payment/webmoney/pay/fail',
                '^payment/qiwi/pay/notify',
                '^payment/qiwi/pay/success',
                '^payment/qiwi/pay/fail',
                '^payment/yam/pay/result',
                '^payment/yam/pay/success',
                '^payment/yam/pay/fail',
                '^payment/paypal/ipn$',
                '^payment/paypal/return$',
            ),
            'enableCsrfValidation' => true,
        ),
    
        // properties for user component
		'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'loginUrl'=>array('/user/account'),
            'class' => 'application.modules.user.components.WebUser',
		),
        
        // script properties
        'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1.8.3/',
                    'js'=>array('jquery.min.js'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                /*
                'jquery-migrate'=>array(
                    'baseUrl'=>'//code.jquery.com/',
                    'js'=>array('jquery-migrate-1.2.1.min.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_HEAD
                ),
                */
                'jquery.ui'=>array(
                    'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/',
                    'js'=>array('jquery-ui.min.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_BEGIN
                ),
                'bootstrap'=>array(
                    'baseUrl'=>'/themes/default/web/js/',
                    'js'=>array('bootstrap.min.js'),
                    'depends'=>array('jquery'),
                    'coreScriptPosition'=>CClientScript::POS_BEGIN
                ),
                'elastislide'=>array(
                    'baseUrl'=>'/themes/default/web/',
                    'css'=>array('css/elastislide.css'),
                    'js'=>array('js/modernizr.custom.17475.js','js/jquerypp.custom.js','js/jquery.elastislide.js'),
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
        
        // properties for booster
        'bootstrap' => array(
    	    'class' => 'ext.bootstrap.components.Bootstrap',
    	    'responsiveCss' => true,
    	),
        
        'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // enable GD
            'driver'=>'GD',
        ),
              
        // cache properties
		'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),
        
        // error handler
		'errorHandler'=>array(
            'errorAction'=>'main/error',
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