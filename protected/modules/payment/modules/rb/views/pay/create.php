<div class="panel panel-default">
    <div class="panel-body">
        <h3 class="h-header-top-null">Оплата через платежную систему ROBOKASSA</h3><hr>

        <?php if(Yii::app()->user->hasFlash('error')) { ?>
            <div class="alert alert-danger">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } elseif(Yii::app()->user->hasFlash('success')) { ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php } else { ?>
            <p>Во время инициализации платежа возникла ошибка. Пожалуйста, вернитесь к заказу в своем личном кабинете и попробуйте оплатить его еще раз.</p>
        <?php } ?>
    </div>
</div>
</div>