<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 14:40
 */

namespace backend\controllers;


use backend\models\form\PermissionForm;
use yii\db\Exception;

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

    /**
     * 获取角色列表
     * @return string
     */
    public function actionListRole()
    {
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRoles();
        return $this->render('list-role', ['list' => $roles]);
    }

    /**
     * 获取权限列表
     * @return string
     */
    public function actionListPermission()
    {
        $auth = \Yii::$app->authManager;
        $permission = $auth->getPermissions();
        return $this->render('list-permission', ['list' => $permission]);
    }

    /**
     * 将权限分配给角色
     * @return string|\yii\web\Response
     */
    public function actionDistributionPermission()
    {
        if (\Yii::$app->request->isGet) {
            //获取权限id
            $id = \Yii::$app->request->get('id');
            if (!$id) {
                return $this->goHome();
            }
            $auth = \Yii::$app->authManager;
            $permission = $auth->getPermission($id);

            if (!$permission) {
                return $this->goHome();
            }

            //获取所有角色
            $roles = $auth->getRoles();
            return $this->render('distribution-permission', ['list' => $roles, 'permission' => $permission]);
        }

        if (\Yii::$app->request->isPost) {
            $postPermission = \Yii::$app->request->post('permission');
            $postRoles = \Yii::$app->request->post('role');
            if (!$postPermission || empty($postRoles)) {
                return $this->goBack();
            }

            $auth = \Yii::$app->authManager;

            $child = $auth->createPermission($postPermission);  //创建权限对象
            if (!$child) {
                return $this->goBack();
            }

            //先删除所有角色的此权限
            $roles = $auth->getRoles();
            foreach ($roles as $v) {
                $auth->removeChild($v, $child);
            }

            //循环创建关系
            foreach ($postRoles as $k => $v) {
                $parent = $auth->createRole($v);    //创建角色对象
                $addRs = $auth->addChild($parent, $child);  //添加对应关系
            }
            return $this->redirect([\Yii::$app->controller->id . '/list-permission']);
        }
    }
}