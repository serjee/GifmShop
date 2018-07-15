<ul class="nav navbar-nav">
    <li>
        <?php echo CHtml::link(Yii::t('admin', 'Orders'),
            array('/admin/main','token'=>Yii::app()->getRequest()->getCsrfToken()),
            array(
                'title' => Yii::t('admin', 'Orders'),
                'csrf' => true,
            )
        );
        ?>
    </li>
    <li>
        <?php echo CHtml::link(Yii::t('admin', 'Transaction'),
            array('/admin/transaction','token'=>Yii::app()->getRequest()->getCsrfToken()),
            array(
                'title' => Yii::t('admin', 'Transaction'),
                'csrf' => true,
            )
        );
        ?>
    </li>
    <li>
        <?php echo CHtml::link(Yii::t('admin', 'Users'),
            array('/admin/user','token'=>Yii::app()->getRequest()->getCsrfToken()),
            array(
                'title' => Yii::t('admin', 'Users'),
                'csrf' => true,
            )
        );
        ?>
    </li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <li>
        <?php echo CHtml::link(Yii::t('admin', 'Logout'),
            array('/admin/auth/logout','token'=>Yii::app()->getRequest()->getCsrfToken()),
            array(
                'title' => Yii::t('admin', 'Logout'),
                'csrf' => true,
            )
        );
        ?>
    </li>
</ul>