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
                    $permissionForm->name = '';
                    $permissionForm->description = '';
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
     * 修改权限--没做完。。。
     * @return string|\yii\web\Response
     */
    public function actionEditPermission()
    {
        /**
         * 如果为get请求，获取对应的值
         */
        if (\Yii::$app->request->isGet) {
            $id = \Yii::$app->request->get('id');

            if (!$id) return $this->goBack();

            //获取此权限
            $auth = \Yii::$app->authManager;

            $permission = $auth->getPermission($id);

            if (!$permission) return $this->goBack();

            $permissionForm = new PermissionForm();
            $permissionForm->name = $permission->name;
            $permissionForm->description = $permission->description;

            return $this->render('edit', ['model' => $permissionForm, 'identify' => 'permission',]);
        }

        /**
         * 如果为post提交，去修改
         */
        if (\Yii::$app->request->isPost) {
            dd(\Yii::$app->request->post());
        }

    }

    public function actionDelPermission()
    {
        $id = \Yii::$app->request->get('id');

        if (!$id) return $this->goBack();

        //获取此权限
        $auth = \Yii::$app->authManager;

        $permission = $auth->getPermission($id);

        if (!$permission) return $this->goBack();

        //获取此权限的角色
//        $auth->getRole

        $permissionForm = new PermissionForm();
        $permissionForm->name = $permission->name;
        $permissionForm->description = $permission->description;

        return $this->render('edit', ['model' => $permissionForm, 'identify' => 'permission',]);
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
                    $permissionForm->name = '';
                    $permissionForm->description = '';
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
                $auth->addChild($parent, $child);  //添加对应关系
            }
            return $this->redirect([\Yii::$app->controller->id . '/list-permission']);
        }
    }

    /**
     * 将权限分配给角色
     * @return string|\yii\web\Response
     */
    public function actionDistributionRole()
    {
        if (\Yii::$app->request->isGet) {
            //获取权限id
            $id = \Yii::$app->request->get('id');
            if (!$id) {
                return $this->goHome();
            }
            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($id);
            if (!$role) {
                return $this->goHome();
            }

            //获取所有角色
            $permissions = $auth->getPermissions();
            return $this->render('distribution-role', ['list' => $permissions, 'role' => $role]);
        }

        if (\Yii::$app->request->isPost) {
            $postPermission = \Yii::$app->request->post('permission');
            $postRole = \Yii::$app->request->post('role');
            if (!$postRole || empty($postPermission)) {
                return $this->goBack();
            }


            $auth = \Yii::$app->authManager;

            //创建角色对象
            $parent = $auth->createRole($postRole);

            if (!$parent) {
                return $this->goBack();
            }
            //先删除角色的所有权限
            $auth->removeChildren($parent);

            //循环创建关系
            foreach ($postPermission as $k => $v) {
                $child = $auth->createRole($v);    //创建角色对象
                $auth->addChild($parent, $child);  //添加对应关系
            }
            return $this->redirect([\Yii::$app->controller->id . '/list-role']);
        }
    }
}