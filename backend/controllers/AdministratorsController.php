<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 17:41
 */

namespace backend\controllers;


use backend\models\form\UserForm;

class AdministratorsController extends BaseController
{
    public function actionList()
    {

    }

    /**
     * 创建管理员
     * @return string
     */
    public function actionCreate()
    {
        $formModel = new UserForm();
        if (\Yii::$app->request->isGet) {
            return $this->render('create', ['model' => $formModel]);
        }

        if (\Yii::$app->request->isPost) {
//            var_dump($formModel->load(\Yii::$app->request->post(), 'UserForm'));
            if ($formModel->load(\Yii::$app->request->post(), 'UserForm') && $formModel->validate()) {
                dd('success');
            } else {
                dd($formModel->getErrors());
            }
        }
    }
}