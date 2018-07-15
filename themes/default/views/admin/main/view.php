<div class="row">
    <div class="col-lg-12">
        <p class="text-right"><a href="/admin/main/update/id/<?php echo $modelOrders->id;?>" class="btn btn-danger">Изменить параметры заказа</a></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
    <?php $this->renderPartial('_view_order', array(
        'data'=>$modelOrders,
    )); ?>
    </div>
    <div class="col-lg-6">
        <?php $this->renderPartial('_view_address', array(
            'data'=>$modelDelivery,
        )); ?>
        <?php $this->renderPartial('_view_user', array(
            'data'=>$modelUser,
        )); ?>
    </div>
</div>