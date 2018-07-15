<div class="panel panel-default">
    <div class="panel-body" style="text-align:center;">

        <h2><?php echo Yii::t('user', 'Error');?> <?php echo $code; ?></h2>

        <div class="alert alert-danger">
        <?php echo CHtml::encode($message); ?>
        </div>

    </div>
</div>