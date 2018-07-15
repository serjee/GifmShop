<?php

class WmPayFormWidget extends CWidget
{
    public $orderSum;
    public $orderId;
    public $paySys;
    public $orderMessage=false;
    public $csrfToken=false;

    public function run()
    {
        // Вытаскиваем из базы опции для оплаты по WMR
        $options = Payoptions::model()->find(array(
            'select'=>'secret,purse,mode',
            'condition'=>'system=:system',
            'params'=>array(':system'=>$this->paySys),
        ));

		$this->render('_wmPayForm',array(
			'options'=>$options,
			'orderId'=>$this->orderId,
			'orderSum'=>$this->orderSum,
            'paySys'=>$this->paySys,
			'orderMessage'=>$this->orderMessage,
			'csrfToken'=>$this->csrfToken,
		));
    }
}