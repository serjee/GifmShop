<!-- RightTopMenu  -->
<?php
$this->widget('Menu', array(
    'items' => array(
        //array('label' => 'Домены', 'itemOptions' => array('class'=>'li-header'),),
        //array('label' => 'Проверка и регистрация домена', 'url'=>array('/main/domaincheck')),
    ),
    'htmlOptions' => array('class' => 'nav bs-sidenav'),
    'activeCssClass' => 'active',
    'itemTemplate' => '{menu}',
));