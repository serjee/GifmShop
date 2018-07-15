<div class="row-fluid">
    <div class="span12">
        <div class="pay_head">Оплата через платежную систему Яндекс.Деньги</div>

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
    <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=<?php echo $uid;?>&amp;button-text=01&amp;button-size=l&amp;button-color=orange&amp;targets=<?php echo $comment;?>&amp;default-sum=<?php echo $order['amount'];?>" width="auto" height="54"></iframe> 

<?php } ?>
    </div>
</div>