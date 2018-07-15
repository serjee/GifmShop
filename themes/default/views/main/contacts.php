<div class="panel panel-default">
    <div class="panel-body">

        <h2 class="h-header-top-null">Наши контакты</h2>
        <hr>
        <p>Если у Вас возникли вопросы, Вы можете написать нам на почту, позвонить или воспользоваться формой обратной связи.</p>
        <p><strong>E-mail:</strong> <a href="mailto:sales@itlike.ru">sales@itlike.ru</a></p>
        <p><strong>Телефон:</strong> <?php echo Yii::t('user','Contact Phone'); ?></p>
        <hr>

        <h3>Форма обратной связи</h3>
        <?php if(Yii::app()->user->hasFlash('contact')): ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
            </div>
        <?php else: ?>

            <p>Используйте форму обратной связи для быстрого способа написать нам.</p>

            <?php $form=$this->beginWidget('CActiveForm'); ?>

            <p class="text-muted">Внимание! Все поля обязательны к заполнению!</p>

            <?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    <?php echo $form->labelEx($model,'name'); ?>
                    <?php echo $form->textField($model,'name',array('class'=>'form-control input-lg')); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    <?php echo $form->labelEx($model,'email'); ?>
                    <?php echo $form->textField($model,'email',array('class'=>'form-control input-lg')); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    <?php echo $form->labelEx($model,'subject'); ?>
                    <?php echo $form->textField($model,'subject',array('class'=>'form-control input-lg')); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                    <?php echo $form->labelEx($model,'body'); ?>
                    <?php echo $form->textArea($model,'body',array('class'=>'form-control input-lg')); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'buttonLabel'=>CHtml::image(Yii::app()->theme->baseUrl.'/web/img/refresh.png'),'imageOptions'=>array('class'=>'capcha-image', 'alt'=>'Картинка с кодом валидации', 'title'=>'Чтобы обновить картинку, нажмите по ней') )); ?>
                        <?php echo $form->textField($model,'verifyCode',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user', 'Enter Code'))); ?>
                        <?php //echo $form->error($model,'verifyCode',array('class'=>'help-block')); ?>
                    </div>
                </div>
            </div>

            <div class="form-group footer-bottom-null">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo CHtml::submitButton(Yii::t('user', 'Send'),array('class'=>'btn btn-lg btn-success')); ?>
                    </div>
                </div>
            </div>

            <?php $this->endWidget(); ?>

        <?php endif; ?>


        </div>
</div>