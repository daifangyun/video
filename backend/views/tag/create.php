<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加标签 ...';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\BreadcrumbWidget::widget([
            'level' => ['标签' => Url::to([Yii::$app->controller->id . '/list'])],
            'active' => '添加标签',
        ]); ?>
        <?= \backend\widget\FormAlertWidget::widget(); ?>

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group">
                        <label>Minimal</label>
                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected">Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-cj82-container"><span class="select2-selection__rendered" id="select2-cj82-container" title="Alabama">Alabama</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                    </div>

                    <div class="form-group <?= ($nameError = $model->getFirstError('name')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="name">
                            <?= $nameError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            标签名称
                        </label>
                        <?= Html::activeTextInput($model, 'name', ['id' => 'name', 'class' => 'form-control', 'placeholder' => '标签名称 ...']); ?>
                        <?= $nameError ? '<span class="help-block m-b-none">' . $nameError . '</span>' : '' ?>
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
