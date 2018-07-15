<div class="pay_desc">
    <p class="text-info">Сумма: <strong>
    <?php
        echo floatval($orderSum)." ";
        if ($paySys == 'WMR') {
            echo 'WMR';
        } else {
            echo 'WMZ';
        }
    ?>
    </strong></p>
    <p class="text-muted">Нажмите "Оплатить" для перехода на сайт платежной системы WebMoney для авторизации платежа.</p>
</div>

<?php

    $userName = '';
    $ordersModel = Orders::model()->findByPk($orderId);
    if ($ordersModel)
    {
        $userModel = User::model()->findByPk($ordersModel->user_id);
        $userName = $userModel->email;
    }

	echo CHtml::beginForm('https://merchant.webmoney.ru/lmi/payment.asp'),
		 CHtml::hiddenField('LMI_PAYMENT_AMOUNT',floatval($orderSum)),
         CHtml::hiddenField('LMI_PAYMENT_DESC_BASE64', base64_encode( Yii::t('WmPayForm',$orderMessage,array('{$orderId}'=>$orderId,'{$userName}'=>$userName)) )),
		 CHtml::hiddenField('LMI_PAYMENT_NO',$orderId),
		 CHtml::hiddenField('LMI_PAYEE_PURSE',$options['purse']);
	echo ($options['mode']==9)?'':CHtml::hiddenField('LMI_SIM_MODE',$options['mode']);
	echo ($csrfToken)?CHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken):'';
?>

    <?php echo CHtml::submitButton('Оплатить', array('class'=>'btn btn-lg btn-success')); ?>

<?php echo CHtml::endForm(); ?>