<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 17:43
 */

namespace backend\models\form;


use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $password;
    public $passwordConfim;

    public function rules()
    {
        return [
            [['username', 'password', 'passwordConfim'], 'required', 'message' => '{attribute}必须填写'],
            [
                ['username', 'password', 'passwordConfim'], 'string', 'min' => 6, 'max' => 25,
                'tooLong' => '{attribute}最长为25位',
                'tooShort' => '{attribute}最少6位',
            ],
            ['passwordConfim', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不相同'],
        ];
    }
}