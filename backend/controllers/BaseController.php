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
//        dd(\Yii::$app->authManager);
        parent::init();
    }
}