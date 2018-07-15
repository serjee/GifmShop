<!-- TopLeftMenu  -->
<?php
$this->widget('Menu', array(
    'items' => array(
        array('label' => Yii::t('user','Order gift'), 'url'=>array('/order/create/step1')),
        array('label' => Yii::t('user','Delivery and pay'), 'url'=>array('/main/delivery')),
        //array('label' => Yii::t('user','Reviews'), 'url'=>array('/main/reviews')),
        array('label' => Yii::t('user','Contacts'), 'url'=>array('/main/contacts')),
    ),
    'htmlOptions' => array('class' => 'nav navbar-nav'),
    'activeCssClass' => 'active',
    'itemTemplate' => '{menu}',
));