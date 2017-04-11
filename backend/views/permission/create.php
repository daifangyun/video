<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加权限 ...';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\FormAlertWidget::widget(); ?>

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group <?= ($nameError = $model->getFirstError('username')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="name">
                            <?= $nameError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            权限名称
                        </label>
                        <?= Html::activeTextInput($model, 'name', ['id' => 'name', 'class' => 'form-control', 'placeholder' => '权限名称 ...']); ?>
                        <?= $nameError ? '<span class="help-block m-b-none">' . $nameError . '</span>' : '' ?>
                    </div>

                    <div class="form-group <?= ($descriptionError = $model->getFirstError('email')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="description">
                            <?= $descriptionError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            权限说明
                        </label>
                        <?= Html::activeTextInput($model, 'description', ['id' => 'description', 'class' => 'form-control', 'placeholder' => '权限说明 ...']); ?>
                        <?= $descriptionError ? '<span class="help-block m-b-none">' . $descriptionError . '</span>' : '' ?>
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
</script>

<?php $this->endBlock(); ?>
