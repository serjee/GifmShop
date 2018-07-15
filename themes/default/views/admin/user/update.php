<?php if(Yii::app()->user->hasFlash('updateMessage')): ?>
<div class="alert alert-success">
<?php echo Yii::app()->user->getFlash('updateMessage'); ?>
</div>
<?php else: ?>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="head"><?php echo Yii::t('admin', 'Edit user with UID');?> <?php echo $model->uid; ?></h2>
                <hr>
                <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>