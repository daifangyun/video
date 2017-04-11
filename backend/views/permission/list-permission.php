<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = '文章列表';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\FormAlertWidget::widget() ?>
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>权限名称</th>
                                <th>权限说明</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $k => $v): ?>
                                <tr>
                                    <td><?= Html::encode($v->name) ?></td>
                                    <td><?= Html::encode($v->description) ?></td>
                                    <td><?= date('Y-m-d H:i:s', $v->createdAt) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a role="button" class="btn btn-info"
                                               href="<?= Url::to([Yii::$app->controller->id . '/edit-permission', 'id' => $v->name]) ?>">
                                                修改权限
                                            </a>
                                            <a role="button" class="btn btn-danger"
                                               href="<?= Url::to([Yii::$app->controller->id . '/del-permission', 'id' => $v->name]) ?>"
                                            >删除权限</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('myJs'); ?>

<?php $this->endBlock(); ?>
