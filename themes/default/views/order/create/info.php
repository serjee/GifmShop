<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">

                <?php if(Yii::app()->user->hasFlash('successMessage')) { ?>
                    <div class="alert alert-success">
                        <?php echo Yii::app()->user->getFlash('successMessage'); ?>
                    </div>
                <?php } elseif(Yii::app()->user->hasFlash('errorMessage')) { ?>
                    <div class="alert alert-danger">
                        <?php echo Yii::app()->user->getFlash('errorMessage'); ?>
                    </div>
                <?php } ?>

                <?php if($model->id > 0) { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="head"><?php echo Yii::t('user', 'Order Info'); ?></h2>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td style="width:150px;"><?php echo Yii::t('user', 'Order ID'); ?>:</td>
                                <td>#<?php echo $model->id; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('user', 'Price Order'); ?>:</td>
                                <td><?php echo $model->price . ' ' . $model->getCurrencyByCode($model->currency); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('user', 'Status Order'); ?>:</td>
                                <td><?php echo $model->getWordStatusById($model->status); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('user', 'Address for delivery'); ?>:</td>
                                <td><?php echo $model->getDeliveryByOrderId($model->id); ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <?php if($model->status=='NEW'): ?>
                        <div class="alert alert-warning"><strong>Внимание!</strong> Для поступления заказа в обработку, его необходимо оплатить.<br>Все не оплаченные заказы аннулируются автоматически через 14 дней.</div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4">
                                    <form id="pay" name="pay" method="POST" action="/payment/">
                                        <input type="hidden" name="InvId" value="<?php echo $model->id; ?>" />
                                        <input type="hidden" name="OutSum" value="<?php echo $model->price; ?>" />
                                        <button type="submit" class="btn btn-success btn-lg"><?php echo Yii::t('user', 'Pay Order'); ?></button>
                                    </form>
                                </div>
                                <?php /*
                                <div class="col-lg-4">
                                        <button type="submit" class="btn btn-danger btn-lg"><?php echo Yii::t('user', 'Cancel Order'); ?></button>
                                </div>
                                */ ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($model->status=='PAYED'): ?>
                            <div class="alert alert-success"><strong>Спасибо!</strong> Ваш заказ успешно оплачен и вскоре поступит к нам в обработку.</div>
                        <?php endif; ?>
                        <?php if($model->status=='PROCESS'): ?>
                            <div class="alert alert-success">
                                Ваш заказ успешно поступил к нам в обработку.<br>Этот процесс займет у нас от 1 до 3 дней рабочих дней, в течение которых мы подберем для Вас подарок и передадим его в службу доставки.
                                <?php if($model->msg_to_user != '') echo "<p><strong>Сообщение от магазина:</strong> ".$model->msg_to_user."</p>"; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($model->status=='SHIPPING' || $model->status=='SENT'): ?>
                            <div class="alert alert-success">
                                Ваш заказ был передан в службу доставки.<br>Отслеживать почтовое отправление Вы можете на <a href="http://www.russianpost.ru/tracking/" target="_blank">сайте Почты России</a> по этому почтовому идентификатору: <strong><?php echo $model->mail_id; ?></strong>
                                <?php if($model->msg_to_user != '') echo "<p><strong>Сообщение от магазина:</strong> ".$model->msg_to_user."</p>"; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($model->status=='DONE'): ?>
                            <div class="alert alert-success">Ваш заказ выполнен!</div>
                        <?php endif; ?>
                        <?php if($model->status=='DONE'): ?>
                            <div class="alert alert-danger">Ваш заказ аннулирован!</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>