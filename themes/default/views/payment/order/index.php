<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">

            <?php if(Yii::app()->user->hasFlash('error')) { ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php } else { ?>

            <div class="row">
                <div class="col-lg-12">
                    <fieldset>
                        <legend>Выберите систему оплаты</legend>
                        <p class="text-success">Выберите наиболее подходящий для вас способ оплаты, кликнув на соответствующую кнопку.</p>
                        <p class="text-success"><strong>Cистемы оплаты <span style="color:red;">БЕЗ КОМИССИИ</span>:</strong></p>
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'choosePayment',
                            'htmlOptions'=>array('class'=>'form-inline'),
                        ));
                        echo $form->hiddenField($model,'paysys');
                        echo $form->hiddenField($model,'IncCurrLabel');
                        echo $form->hiddenField($model,'order_id',array('value'=>$InvId));
                        ?>
                        <div class="btn-group btn-group-lg">
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='WMR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/wmr.png', 'Оплата через WebMoney R'); ?></button>
                            <button disabled="" class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='QIWI'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/qiwi.png', 'Оплата через Qiwi-кошелек'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='YAM'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/yam.png', 'Оплата через Яндекс.Деньги'); ?></button>
                        </div>
                        <p class="text-success" style="padding-top:20px;"><strong>Банковские карты и терминалы через ROBOKASSA (взымается дополнительная комиссия)</strong></p>
                        <div class="btn-group btn-group-lg">
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='BANKOCEAN2R'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/bankcard.png', 'Оплата через Банковской картой'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='AlfaBankR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/alphaclick.png', 'Оплата через Альфа-Клик'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='VTB24R'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/vtb24.png', 'Оплата через ВТБ24'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='PSKBR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/psbbank.png', 'Оплата через Промсвязьбанк'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='TerminalsElecsnetOceanR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/elexnet.png', 'Оплата через Элекснет'); ?></button>
                        </div>
                        <p class="text-success" style="padding-top:20px;"><strong>Сотовые операторы и салоны связи через ROBOKASSA (взымается дополнительная комиссия)</strong></p>
                        <div class="btn-group btn-group-lg">
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='MtsR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/mts.png', 'Оплата через МТС'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='MegafonR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/megafon.png', 'Оплата через Мегафон'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='RapidaOceanSvyaznoyR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/svyaznoi.png', 'Оплата через Связной'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='RapidaOceanEurosetR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/euroset.png', 'Оплата через Евросеть'); ?></button>
                        </div>
                        <p class="text-success" style="padding-top:20px;"><strong>Электронным кошельком через ROBOKASSA (взымается дополнительная комиссия)</strong></p>
                        <div class="btn-group btn-group-lg">
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='WMZ'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/wmz.png', 'Оплата через WebMoney Z'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='WME'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/wme.png', 'Оплата через WebMoney E'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='WMU'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/wmu.png', 'Оплата через WebMoney U'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='MoneyMailR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/moneymail.png', 'Оплата через MoneyMail'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='TeleMoneyR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/telemoney.png', 'Оплата через TeleMoney'); ?></button>
                        </div>
                        <div class="btn-group btn-group-lg" style="padding-top:10px;">
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='W1R'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/w1.png', 'Оплата через Единый Кошелек'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='EasyPayB'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/easypay.png', 'Оплата через EasyPay'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='MailRuR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/mailru.png', 'Оплата через Деньги@Mail.Ru'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='ZPaymentR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/zpayment.png', 'Оплата через Z-Payment'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='RuPayR'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/rbkmoney.png', 'Оплата через RBK Money'); ?></button>
                            <button class="btn btn-default" type="button" onclick="document.getElementById('OrderForm_paysys').value='ROBOX'; document.getElementById('OrderForm_IncCurrLabel').value='LiqPayZ'; document.getElementById('choosePayment').submit();"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/views/payment/web/img/liqpay.png', 'Оплата через LiqPay'); ?></button>
                        </div>
                        <?php $this->endWidget(); ?>
                    </fieldset>
                </div>
            </div>

            <?php } ?>

            </div>
        </div>
    </div>
</div>