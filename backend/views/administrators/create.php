<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加文章';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group">
                        <label>账号</label>
                        <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'placeholder' => '账号 ...']); ?>
                        <span class="help-block m-b-none">
                            <?= $model->getFirstError('username'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label>密码</label>
                        <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => '密码 ...']); ?>
                        <span class="help-block m-b-none">
                            <?= $model->getFirstError('password'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label>确认密码</label>
                        <?= Html::activePasswordInput($model, 'passwordConfim', ['class' => 'form-control', 'placeholder' => '确认密码 ...']); ?>
                        <span class="help-block m-b-none">
                            <?= $model->getFirstError('passwordConfim'); ?>
                        </span>
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
        var ue = UE.getEditor('editor', {
//            serverUrl: imageUploadUrl
        });
    });

</script>

<?php $this->endBlock(); ?>
