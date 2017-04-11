<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加管理员账号 ...';
?>
<div class="site-index">
    <div class="body-content">
        <?= \backend\widget\FormAlertWidget::widget(); ?>

        <div class="row">
            <div class="box-body">
                <form role="form"
                      action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                      method="post">

                    <div class="form-group <?= ($usernameError = $model->getFirstError('username')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="username">
                            <?= $usernameError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            账号
                        </label>
                        <?= Html::activeTextInput($model, 'username', ['id' => 'username', 'class' => 'form-control', 'placeholder' => '账号 ...']); ?>
                        <?= $usernameError ? '<span class="help-block m-b-none">' . $usernameError . '</span>' : '' ?>
                    </div>

                    <div class="form-group <?= ($emailError = $model->getFirstError('email')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="email">
                            <?= $emailError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            邮箱
                        </label>
                        <?= Html::activeTextInput($model, 'email', ['id' => 'username', 'class' => 'form-control', 'placeholder' => '账号 ...']); ?>
                        <?= $emailError ? '<span class="help-block m-b-none">' . $emailError . '</span>' : '' ?>
                    </div>

                    <div class="form-group <?= ($passwordError = $model->getFirstError('password')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="password">
                            <?= $passwordError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            密码
                        </label>
                        <?= Html::activePasswordInput($model, 'password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => '密码 ...']); ?>
                        <?= $passwordError ? '<span class="help-block m-b-none">' . $passwordError . '</span>' : '' ?>
                    </div>

                    <div class="form-group <?= ($passwordConfrimError = $model->getFirstError('passwordConfim')) ? 'has-error' : '' ?>">
                        <label class="control-label" for="passwordConfim">
                            <?= $passwordConfrimError ? '<i class="fa fa-times-circle-o"></i>' : '' ?>
                            确认密码
                        </label>
                        <?= Html::activePasswordInput($model, 'passwordConfim', ['id' => 'passwordConfim', 'class' => 'form-control', 'placeholder' => '确认密码 ...']); ?>
                        <?= $passwordConfrimError ? '<span class="help-block m-b-none">' . $passwordConfrimError . '</span>' : '' ?>
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
