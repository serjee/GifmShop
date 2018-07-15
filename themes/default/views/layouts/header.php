<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <meta charset="utf-8">
    <meta name='yandex-verification' content='4a6dd013d3f5d814' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?php echo $this->keywords; ?>">
    <meta name="description" content="<?php echo $this->description; ?>">
    <meta name="author" content="">

    <meta property="og:image" content="<?php echo Yii::app()->theme->baseUrl; ?>/web/img/logo.png" />
    <meta property="og:title" content="<?php echo Yii::t('user','Project name'); ?>" />
    <meta property="og:description" content="<?php echo Yii::t('user','Project description'); ?>" />

    <!-- Le styles -->
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/web/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/favicon.ico"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/web/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/web/js/respond.min.js"></script>
    <![endif]-->

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-41381900-4', 'gifm.ru');
        ga('send', 'pageview');

    </script>
</head>

<body>

<div id="wrap" class="container">

    <div class="row">
        <div class="col-lg-6">
            <?php
            $this->beginClip('navigation_top_soc');
            $this->renderPartial('//layouts/navigation_top_soc');
            $this->endClip();
            $this->renderClip('navigation_top_soc');
            ?>
        </div>
        <div class="col-lg-6 head-contacts text-right">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/clock.png', '', array('class' => '')).' '.Yii::t('user','Time Work');?> &nbsp;&nbsp;&nbsp;<?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/mobile.png', '', array('class' => '')).' '.Yii::t('user','Contact Phone');?>
        </div>
    </div>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-fixed">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/logo.png', '', array('class' => ''));?></a>
        </div>
        <div class="navbar-collapse collapse">
            <?php
            $this->beginClip('navigation_top_left');
            $this->renderPartial('//layouts/navigation_top_left');
            $this->endClip();
            $this->renderClip('navigation_top_left');
            ?>
            <?php
            $this->beginClip('navigation_top_right');
            $this->renderPartial('//layouts/navigation_top_right');
            $this->endClip();
            $this->renderClip('navigation_top_right');
            ?>
        </div><!--/.nav-collapse -->
    </div>