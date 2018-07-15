<div class="row">
    <div class="col-lg-12">
        <p class="text-right"><a href="/admin/main/view/id/<?php echo $modelOrders->id;?>" class="btn btn-danger">Вернуться к просмотру заказа</a></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <?php echo $this->renderPartial('_form_order', array('model'=>$modelOrders)); ?>
    </div>
    <div class="col-lg-6">
        <?php echo $this->renderPartial('_form_address', array('model'=>$modelDelivery)); ?>
        <?php echo $this->renderPartial('_form_user', array('model'=>$modelOrders)); ?>
    </div>
</div>