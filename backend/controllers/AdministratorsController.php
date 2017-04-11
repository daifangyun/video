<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 17:41
 */

namespace backend\controllers;

use backend\models\form\UserForm;
use backend\models\UserModel;
use yii\data\Pagination;

class AdministratorsController extends BaseController
{
    /**
     * 用户列表
     * @return string
     */
    public function actionList()
    {
        $query = UserModel::find()->where(['status' => UserModel::STATUS_ACTIVE])
            ->orderBy(['id' => 'desc']);

        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        if ($count) {
            $list = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        }

        return $this->render('list', [
            'list' => isset($list) ? $list : [],
            'pages' => $pages
        ]);
    }

    /**
     * 创建管理员
     * @return string
     */
    public function actionCreate()
    {
        $formModel = new UserForm();

        if (\Yii::$app->request->isPost) {
            $session = \Yii::$app->session;

            $formModel->setScenario(UserForm::SCENARIO_CREATE);
            if ($formModel->load(\Yii::$app->request->post(), 'UserForm') && $formModel->validate()) {
                if ($formModel->createAdministrators() !== false) {
                    $session->setFlash('formSuccess', '创建管理员成功 ...');
                } else {
                    $session->setFlash('formError', '创建管理员失败 ...');
                }
            }
        }

        return $this->render('create', ['model' => $formModel]);
    }

    /**
     * 修改管理员信息
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $formModel = new UserForm();

        if (\Yii::$app->request->isGet) {
            $id = (int)\Yii::$app->request->get('id');
            if (!$id) {
                return $this->goBack();
            }

            $formModel->id = $id;
            $administrators = $formModel->findAdministratorsById();
            if (!$administrators) {
                return $this->goBack();
            }
            $decryptPassword = '';
            $formModel->username = $administrators->username;
            $formModel->email = $administrators->email;
            $formModel->password = $decryptPassword;
            $formModel->passwordConfim = $decryptPassword;
        }

        if (\Yii::$app->request->isPost) {
            $session = \Yii::$app->session;
            $formModel->setScenario(UserForm::SCENARIO_EDIT);
            if ($formModel->load(\Yii::$app->request->post()) && $formModel->validate()) {
                if ($formModel->editAdministrators() !== false) {
                    $session->setFlash('formSuccess', '修改管理员成功 ...');
                } else {
                    $session->setFlash('formError', '修改管理员失败 ...');
                }
            } else {
                $session->setFlash('formError', '修改管理员失败 ...');
            }
        }

        return $this->render('edit', ['model' => $formModel]);
    }

    /**
     * 删除管理员
     * @return \yii\web\Response
     */
    public function actionDel()
    {
        $formModel = new UserForm();

        $id = (int)\Yii::$app->request->get('id');
        if (!$id) {
            return $this->goBack();
        }
        $session = \Yii::$app->session;
        $formModel->id = $id;
        if ($formModel->delAdministrators() !== false) {
            $session->setFlash('formSuccess', '删除管理员成功 ...');
        } else {
            $session->setFlash('formError', '删除管理员失败 ...');
        }

        return $this->redirect([\Yii::$app->controller->id . '/list']);
    }

    /**
     * 给用户分陪角色
     * @return string|\yii\web\Response
     */
    public function actionDistributionRoleToAdministrators()
    {
        if (\Yii::$app->request->isGet) {
            //获取权限id
            $id = (int)\Yii::$app->request->get('id');
            if (!$id) {
                return $this->goHome();
            }
            $auth = \Yii::$app->authManager;

            //获取所有角色
            $roles = $auth->getRoles();

            return $this->render('distribution-role', ['list' => $roles, 'id' => $id]);
        }

        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->post('id');
            $postRoles = \Yii::$app->request->post('roles');
            if (!$id || empty($postRoles)) {
                return $this->goBack();
            }


            $auth = \Yii::$app->authManager;

            //删除该管理员的所有角色
            $auth->revokeAll($id);

            //循环给管理员创建角色
            foreach ($postRoles as $k => $v) {
                $role = $auth->createRole($v);    //创建角色对象
                $auth->assign($role, $id);  //添加对应关系
            }
            return $this->redirect([\Yii::$app->controller->id . '/list']);
        }
    }
}