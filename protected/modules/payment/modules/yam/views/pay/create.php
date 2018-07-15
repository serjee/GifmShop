<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="h-header-top-null">Оплата через платежную систему Яндекс.Деньги</h3><hr>

            <?php if(Yii::app()->user->hasFlash('error')) { ?>
                <div class="alert alert-danger">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php } elseif(Yii::app()->user->hasFlash('success')) { ?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php } else { ?>

                <p class="text-warning"><span class="label label-warning">Внимание!</span> Для автоматического зачисления денежных средств:</p>
                <ul>
                    <li><strong>Не изменяйте поля платежа</strong> и комментарий в форме оплаты!</li>
                    <li><strong>Не защищайте протекцией</strong> платеж!</li>
                </ul>
                <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=<?php echo $uid;?>&amp;button-text=01&amp;button-size=l&amp;button-color=orange&amp;targets=<?php echo $comment;?>&amp;default-sum=<?php echo $order['price'];?>" width="auto" height="54"></iframe>

            <?php } ?>
        </div>
    </div>
</div>