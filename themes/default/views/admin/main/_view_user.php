<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('admin', 'View user'); ?></h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width:140px;">E-mail:</th>
                <td><?php echo $data->email;?></td>
            </tr>
            <tr>
                <th>Роль:</th>
                <td><?php echo $data->role;?></td>
            </tr>
            <tr>
                <th>Регистрация:</th>
                <td><?php echo $data->time_create;?></td>
            </tr>
            <tr>
                <th>Дата входа:</th>
                <td><?php echo $data->time_update;?></td>
            </tr>
            <tr>
                <th>Активен:</th>
                <td><?php if($data->enabled > 0) { echo 'да'; } else { echo 'нет'; } ;?></td>
            </tr>
            <tr>
                <th>IP:</th>
                <td><?php echo $data->ip;?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>