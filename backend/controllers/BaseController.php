<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 13:27
 */

namespace backend\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    public function init()
    {
        if (\Yii::$app->user->isGuest) return $this->redirect('/site/login.html');

        parent::init();
    }

    public function beforeAction($action)
    {
//        dd($action->controller->id);
        return true;
    }
}