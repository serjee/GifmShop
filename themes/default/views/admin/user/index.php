<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('admin', 'User Management');?></h1>

<hr />
<?php echo Yii::t('admin', 'Messages of fast filter');?>

<?php echo CHtml::link(Yii::t('admin', 'Show extend search'),'#',array('class'=>'search-button btn btn-warning')); ?>
<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<hr />

<p>
<?php echo CHtml::link(Yii::t('admin', 'Create new user'),
    array('user/create','token'=>Yii::app()->getRequest()->getCsrfToken()),
    array(
        'class' => 'btn btn-lg btn-success',
        'title' => Yii::t('admin', 'Create new user'),
        'csrf' => true,
    )
);
?>
</p>
<br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'itemsCssClass' => 'table table-striped',
    'htmlOptions' => array('class' => 'filter'),
	'columns'=>array(
		'uid',
		'email',
        array(
            'name'=>'role',
            'value'=>'$data->getRoleStringById($data->role)',
            'filter'=>array('ADMIN'=>Yii::t('admin', 'Admin'),'MODERATOR'=>Yii::t('admin', 'Moderator'),'USER'=>Yii::t('admin', 'User')),
            'cssClassExpression'=>'form-control',
        ),
		'time_update',
        array(
            'name'=>'enabled',
            'value'=>'$data->getStatusStringById($data->enabled)',
            'filter'=>array('0'=>Yii::t('admin', 'No'),'1'=>Yii::t('admin', 'Yes')),
        ),
        'ip',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}&nbsp;&nbsp;{delete}',
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>'<i class="glyphicon glyphicon-pencil"></i>',
                    'imageUrl'=>false,
                    'options'=>array('class'=>'btn btn-xs btn-primary','title'=>Yii::t('admin', 'Edit')),
                ),
                'delete' => array
                (
                    'label'=>'<i class="glyphicon glyphicon-trash"></i>',
                    'imageUrl'=>false,
                    'options'=>array('class'=>'btn btn-xs btn-danger','title'=>Yii::t('admin', 'Delete')),
                ),
            ),
		),
	),
)); ?>