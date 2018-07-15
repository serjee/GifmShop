<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('admin', 'Edit order'); ?></h3>
    </div>
    <div class="panel-body">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'order-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
            'role'=>'form',
            'class'=>'form-horizontal',
        ),
    )); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model,'id',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <div style="margin-top:7px;font-size:16px;"><?php echo '#'.$model->id; ?></div>
                <?php echo $form->error($model,'id',array('class'=>'text-error')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'status',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo ZHtml::enumDropDownList($model,'status',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'status'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'price',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <div class="input-group">
                    <?php echo $form->textField($model,'price',array('class'=>'form-control')); ?>
                    <span class="input-group-addon"><?php echo $model->getCurrencyByCode($model->currency);?></span>
                </div>
                <?php echo $form->error($model,'price'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'timestamp',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <div style="margin-top:7px;font-size:16px;"><?php echo $model->timestamp; ?></div>
                <?php echo $form->error($model,'timestamp',array('class'=>'text-error')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'mail_id',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'mail_id',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'mail_id'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'msg_to_user',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'msg_to_user',array('rows'=>3,'class'=>'form-control','placeholder'=>Yii::t('admin','Notice: If you wish to provide additional information while status changed'))); ?>
                <?php echo $form->error($model,'msg_to_user'); ?>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <?php echo $form->labelEx($model,'category_id',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->dropDownList($model,'category_id',CMap::mergeArray(array(0=>'Любая'),Chtml::listData(Categories::model()->findAll(array('select'=>'id,name_ru')),'id','name_ru')),array('class'=>'form-control','options'=>array($model->category_id=>array('selected'=>true)))); ?>
                <?php echo $form->error($model,'category_id'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'whom',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo ZHtml::enumDropDownList($model,'whom',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'whom'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'age',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'age',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'age'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'hobbies',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'hobbies',array('rows'=>3,'class'=>'form-control')); ?>
                <?php echo $form->error($model,'hobbies'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'about',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'about',array('rows'=>3,'class'=>'form-control')); ?>
                <?php echo $form->error($model,'about'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'prize_from',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'prize_from',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'prize_from'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'message',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'message',array('rows'=>3,'class'=>'form-control')); ?>
                <?php echo $form->error($model,'message'); ?>
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <?php echo CHtml::submitButton(Yii::t('admin', 'Save'), array('class'=>'btn btn-success btn-lg')); ?>
            </div>
        </div>

    <?php $this->endWidget(); ?>
    <!-- form -->

    </div>
</div>