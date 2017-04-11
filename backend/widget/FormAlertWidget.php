<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 11:02
 */

namespace backend\widget;

/**
 * 后台表单提交后的提示小组件
 */
use yii\base\Widget;

class FormAlertWidget extends Widget
{
    public $status;

    public $message;

    public function init()
    {
        $session = \Yii::$app->session;
        if ($message = $session->getFlash('formSuccess')) {
            $this->message = $message;
            $this->status = 'success';
        }

        if ($message = $session->getFlash('formError')) {
            $this->message = $message;
            $this->status = 'error';
        }
    }

    public function run()
    {
        return $this->render('alert', ['alertStatus' => $this->status, 'alertMessage' => $this->message]);
    }
}