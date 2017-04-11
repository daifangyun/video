<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = '分配权限给角色';

$auth = Yii::$app->authManager;
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
                    <form role="form"
                          action="<?= Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id]) ?>"
                          method="post">
                        <div class="form-group">
                            <?php foreach ($list as $k => $v): ?>
                                <!--查看改角色是否已经拥有了该权限-->
                                <?php $hasRoles = $auth->getAssignment($v->name, $id) ?>
                                <div class="checkbox-inline">
                                    <label>
                                        <input type="checkbox" name="roles[]"
                                               value="<?= Html::decode($v->name) ?>"
                                            <?= $hasRoles ? 'checked' : '' ?> />
                                        <?= Html::decode($v->name) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group">
                            <?= Html::hiddenInput('id', $id); ?>
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken); ?>
                            <?= Html::submitButton('保存内容', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('myJs'); ?>

<?php $this->endBlock(); ?>
