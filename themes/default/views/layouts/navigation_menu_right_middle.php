<!-- RightMiddleMenu  -->
<?php
$this->widget('Menu', array(
    'items' => array(
        //array('label' => 'Хостинг', 'itemOptions' => array('class'=>'li-header')),
        //array('label' => 'Хостинг сайтов на Linux', 'url'=>'/reg/hosting/order.php'),
    ),
    'htmlOptions' => array('class' => 'nav bs-sidenav'),
    'activeCssClass' => 'active',
    'itemTemplate' => '{menu}',
));