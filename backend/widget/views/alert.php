<?php if ($alertStatus === 'error'): ?>
    <div class="row">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> 错误</h4>
            <?= $alertMessage ?>
        </div>
    </div>

<?php elseif ($alertStatus === 'success'): ?>
    <div class="row">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 成功!</h4>
            <?= $alertMessage; ?>
        </div>
    </div>
<?php endif; ?>
