<?php

use yii\helpers\Html;
use yii\helpers\Url;

$identify = ($identify === 'permission') ? '权限' : '角色';
$this->title = '添加' . $identify . ' ...';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\FormAlertWidget::widget(); ?>

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group <?= ($nameError = $model->getFirstError('name')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="name">
                            <?= $nameError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            <?= $identify ?>名称
                        </label>
                        <?= Html::activeTextInput($model, 'name', ['id' => 'name', 'class' => 'form-control', 'placeholder' => $identify . '名称 ...']); ?>
                        <?= $nameError ? '<span class="help-block m-b-none">' . $nameError . '</span>' : '' ?>
                    </div>

                    <div class="form-group <?= ($descriptionError = $model->getFirstError('description')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="description">
                            <?= $descriptionError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            <?= $identify ?>说明
                        </label>
                        <?= Html::activeTextInput($model, 'description', ['id' => 'description', 'class' => 'form-control', 'placeholder' => $identify . '说明 ...']); ?>
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
