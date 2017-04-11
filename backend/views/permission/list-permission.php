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
                                        <a href="<?= Url::to([Yii::$app->controller->id . '/distribution-permission', 'id' => $v->name]) ?>"
                                           style="margin-right: 20px;">
                                            <i class="fa fa-hand-lizard-o"></i>
                                        </a>
                                        |
                                        <a href="<?= Url::to([Yii::$app->controller->id . '/edit', 'id' => $v->name]) ?>"
                                           style="margin-right: 20px;">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        |
                                        <a href="<?= Url::to([Yii::$app->controller->id . '/del', 'id' => $v->name]) ?>"
                                           style="margin-left: 20px;"><i
                                                    class="fa fa-trash text-navy"></i></a>
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
