<?php if(Yii::app()->user->hasFlash('createMessage')): ?>
<div class="alert alert-success">
<?php echo Yii::app()->user->getFlash('createMessage'); ?>
</div>
<?php else: ?>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="head"><?php echo Yii::t('admin', 'Create new user'); ?></h2>
                <hr>
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>