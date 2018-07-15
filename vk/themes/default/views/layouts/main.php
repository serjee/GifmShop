<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="Content-Language" content="en-US" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="description" content="Приложение Реальные Подарки Друзьям: создано для Вас, Ваших друзей и родных людей! Скидывайтесь на реальные подарки друзьям или попросите их сделать подарок Вам." />
    <meta property="vk:title" content="Собирайте деньги" />
    <meta property="vk:type" content="website" />
    <meta property="vk:url" content="https://vk.com/app4057896" />
    <meta property="vk:app_id" content="4057896" />
    <meta property="vk:image" content="https://gifm.ru/themes/default/web/img/logo.png" />
    <meta property="vk:description" content="Приложение Реальные Подарки Друзьям: создано для Вас, Ваших друзей и родных людей! Скидывайтесь на реальные подарки друзьям или попросите их сделать подарок Вам." />

    <!-- Le styles -->
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/jquery-ui-1.11.0.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/style_vk.css" type="text/css" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/web/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/web/js/respond.min.js"></script>
    <![endif]-->
    <script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<script>
    /* ABOUT MONEY */
    var bal = 0;
    var action_id = '0';
    var action_pid = '';
    var page_id = 0;
    var uid = '54655';
    var current_user = {"Userurl":"http:\/\/vk.com\/serbsh","Username":"Ser \u00a9 Bashkov","Firstname":"Ser","Lastname":"Bashkov"};
    //var previousUrl = 'https://moneyvkapp.yandex.ru' + '/actions/index';
    var curbal = 0;
</script>

<div class="wrapper">

    <div class="header">
        <a  href="https://vk.com/app4057896" target="_top" class="logo"></a>
        <div class="header_links">
            <div id="vk_like"></div>
            <script type="text/javascript">
                VK.Widgets.Like("vk_like", {type: "button",
                    pageUrl: 'https://vk.com/app4057896',
                    pageDescription: 'Приложение Реальные Подарки Друзьям: создано для Вас, Ваших друзей и родных людей! Скидывайтесь на реальные подарки друзьям или попросите их сделать подарок Вам.',
                    pageTitle: 'Скиньтесь другу/подруге на реальный подарок',
                    text: 'Приложение Реальные Подарки Друзьям: создано для Вас, Ваших друзей и родных людей! Скидывайтесь на реальные подарки друзьям или попросите их сделать подарок Вам.',
                    verb: 1});
            </script>
        </div>
    </div>

    <div class="tabs">
        <?php
        echo CHtml::link('<span class="tl"><span class="tr">О Магазине</span></span>',array('controller/action'),array('class'=>'create_act'));
        $this->widget('zii.widgets.CMenu', array(
            'encodeLabel'=>false,
            'items'=>array(
                array('label'=>'<span class="tl"><span class="tr">Как это работает?</span></span>', 'url'=>array('main/index')),
                array('label'=>'<span class="tl"><span class="tr">Подарки</span></span>', 'url'=>array('main/gifts')),
                array('label'=>'<span class="tl"><span class="tr">Скинуться на подарок</span></span>', 'url'=>array('main/give')),
                array('label'=>'<span class="tl"><span class="tr">Попросить подарок</span></span>', 'url'=>array('main/get')),
            ),
            'htmlOptions' => array(
                'class'=>'nav',
            ),
        ));
        ?>
    </div>

    <?php echo $content; ?>

</div>
</body>
</html>