<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::addCssFile($this, [
    'plugins/select2/select2.css',
]);

AppAsset::addJsFile($this, [
    'plugins/select2/select2.full.js',
]);

$this->title = '修改标签 ...';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\BreadcrumbWidget::widget([
            'level' => ['标签' => Url::to([Yii::$app->controller->id . '/list'])],
            'active' => '修改标签',
        ]); ?>
        <?= \backend\widget\FormAlertWidget::widget(); ?>

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group">
                        <label>所属分类</label>
                        <select class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;"
                                tabindex="-1" aria-hidden="true"
                                name="TagForm[cid]"
                        >
                            <?php foreach ($categorys as $k => $v): ?>
                                <option <?php if ($v['id'] == $model->cid) 'selected="selected"' ?>
                                        value="<?= $v['id'] ?>">
                                    <?= $v['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group <?= ($nameError = $model->getFirstError('name')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="name">
                            <?= $nameError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            标签名称
                        </label>
                        <?= Html::activeTextInput($model, 'name', ['id' => 'name', 'class' => 'form-control', 'placeholder' => '标签名称 ...']); ?>
                        <?= $nameError ? '<span class="help-block m-b-none">' . $nameError . '</span>' : '' ?>
                    </div>

                    <div class="form-group">
                        <label>父级标签</label>
                        <select class="form-control select2 select2-hidden-accessible"
                                style="width: 100%;"
                                tabindex="-1" aria-hidden="true"
                                name="TagForm[pid]"
                        >

                            <?php foreach ($tags as $k => $v): ?>
                                <option <?php if ($v['id'] == $model->pid) 'selected="selected"' ?>
                                        value="<?= $v['id'] ?>">
                                    <?= $v['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group <?= ($sortError = $model->getFirstError('sort')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="sort">
                            <?= $sortError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            标签排序
                        </label>
                        <?= Html::activeTextInput($model, 'sort', ['id' => 'sort', 'class' => 'form-control', 'placeholder' => '标签排序 ...']); ?>
                        <?= $sortError ? '<span class="help-block m-b-none">' . $sortError . '</span>' : '' ?>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <?= Html::activeRadioList($model, 'status', ['1' => '启用', '0' => '禁用']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeHiddenInput($model, 'id'); ?>
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken); ?>
                        <?= Html::submitButton('保存内容', ['class' => 'btn btn-primary pull-right']); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('myJs'); ?>
<script>
    $(function () {
        $(".select2").select2();
    });
</script>

<?php $this->endBlock(); ?>
