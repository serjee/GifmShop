<!-- TopRightMenu  -->
<?php
$this->widget('Menu', array(
    'items' => array(
        array('label' => Yii::t('user','Management'), 'url'=>array('/admin/'), 'visible'=>Yii::app()->user->checkAccess('ADMIN')),
        array('label' => Yii::t('user','My profile'), 'url'=>array('/user/profile'), 'visible'=>!Yii::app()->user->isGuest),
        array('label' => Yii::t('user','Login'), 'url'=>array('/user/account'), 'visible'=>Yii::app()->user->isGuest),
        array('label' => Yii::t('user','Logout'), 'url'=>array('/user/account/logout'), 'visible'=>!Yii::app()->user->isGuest),
    ),
    'htmlOptions' => array('class' => 'nav navbar-nav navbar-right'),
    'activeCssClass' => 'active',
    'itemTemplate' => '{menu}',
));