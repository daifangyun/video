<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\CategoryModel;

$this->title = '标签列表';
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
                                <th>序号</th>
                                <th>标签名称</th>
                                <th>所属分类</th>
                                <th>标签排序</th>
                                <th>是否启用</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($list as $k => $v): ?>
                                <tr>
                                    <td><?= ++$k ?></td>
                                    <td><?= $v['html'] . Html::encode($v['name']) ?></td>
                                    <td><?= Html::encode($v['category']['name']) ?></td>
                                    <td><?= $v['html'] . Html::encode($v['sort']) ?></td>
                                    <td>
                                        <?php
                                        if ($v['status'] == CategoryModel::STATUS_ENABLE) echo '启用';
                                        if ($v['status'] == CategoryModel::STATUS_DISABLE) echo '禁用';
                                        ?>
                                    </td>
                                    <td><?= date('Y-m-d H:i:s', $v['created_at']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a role="button" class="btn btn-info"
                                               href="<?= Url::to([Yii::$app->controller->id . '/edit', 'id' => $v['id']]) ?>">修改</a>
                                            <a role="button" class="btn btn-danger"
                                               href="<?= Url::to([Yii::$app->controller->id . '/del', 'id' => $v['id']]) ?>">删除</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="pull-right">
                                        <?= \yii\widgets\LinkPager::widget([
                                            'pagination' => $pages,
                                            'nextPageLabel' => '下一页',
                                            'prevPageLabel' => '上一页',
                                            'firstPageLabel' => '首页',
                                            'lastPageLabel' => '尾页',
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('myJs'); ?>

<?php $this->endBlock(); ?>
