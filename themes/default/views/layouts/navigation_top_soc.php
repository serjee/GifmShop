<!-- SocMenu  -->
<?php
$this->widget('Menu', array(
    'items' => array(
        array('label' => Yii::t('user','We in social: '),'itemOptions'=>array('style'=>'padding:3px 5px 3px 0;font-size: 16px;')),
        array('label' => '', 'url'=>'http://vk.com/itlikeru','linkOptions'=>array('class'=>'soc-group vk','target'=>'_blank')),
        array('label' => '', 'url'=>'https://twitter.com/itlikeru','linkOptions'=>array('class'=>'soc-group tw','target'=>'_blank')),
        array('label' => '', 'url'=>'https://www.facebook.com/itlikeru','linkOptions'=>array('class'=>'soc-group fb','target'=>'_blank')),
    ),
    'htmlOptions' => array('class' => 'nav-soc'),
    'activeCssClass' => 'active',
    'itemTemplate' => '{menu}',
));