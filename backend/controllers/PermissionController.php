<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 14:40
 */

namespace backend\controllers;


use backend\models\form\PermissionForm;

class PermissionController extends BaseController
{
    /**
     * 创建权限
     * @return string
     */
    public function actionCreatePermission()
    {
        $permissionForm = new PermissionForm();

        if (\Yii::$app->request->isPost) {
            $session = \Yii::$app->session;
            $permissionForm->setScenario(PermissionForm::SCENARIOS_CREATE);
            if ($permissionForm->load(\Yii::$app->request->post()) && $permissionForm->validate()) {
                if ($permissionForm->createPermission()) {
                    $session->setFlash('formSuccess', '创建权限成功 ...');
                } else {
                    $session->setFlash('formError', '创建权限失败 ...');
                }
            } else {
                $session->setFlash('formError', '创建权限失败 ...');
            }
        }

        return $this->render('create', [
            'model' => $permissionForm,
            'identify' => 'permission',
        ]);
    }

    /**
     * 创建角色
     * @return string
     */
    public function actionCreateRole()
    {
        $permissionForm = new PermissionForm();

        if (\Yii::$app->request->isPost) {
            $session = \Yii::$app->session;
            $permissionForm->setScenario(PermissionForm::SCENARIOS_CREATE);
            if ($permissionForm->load(\Yii::$app->request->post()) && $permissionForm->validate()) {
                if ($permissionForm->createRole()) {
                    $session->setFlash('formSuccess', '创建角色成功 ...');
                } else {
                    $session->setFlash('formError', '创建角色失败 ...');
                }
            } else {
                $session->setFlash('formError', '创建角色失败 ...');
            }
        }

        return $this->render('create', [
            'model' => $permissionForm,
            'identify' => 'role',
        ]);
    }
}