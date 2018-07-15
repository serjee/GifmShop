<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="h-header-top-null">Оплата через платежную систему WebMoney</h3><hr>

<?php if(Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } else { ?>
<?php
    $orderSum = $order->price;
    //if ($paySys == 'WMZ')
    //{
    //    $orderSum = $order->currency;
    //}
	$this->widget('WmPayFormWidget', array(
        'orderSum'=>$orderSum,
        'orderId'=>$order->id,
		'orderMessage'=>'Оплата от пользователя {$userName} по счету № {$orderId}',
        'paySys'=>$paySys,
		'csrfToken'=>true,	));
?>
<?php } ?>
    </div>
</div>