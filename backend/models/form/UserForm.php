<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 17:43
 */

namespace backend\models\form;


use backend\models\UserModel;
use common\models\User;
use yii\base\Model;

class UserForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $passwordConfim;

    private $_administrators;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'edit';

    public function rules()
    {
        return [
            [['username', 'password', 'passwordConfim', 'email'], 'required', 'message' => '{attribute}必须填写'],
            [
                ['username', 'password', 'passwordConfim'], 'string', 'min' => 6, 'max' => 25,
                'tooLong' => '{attribute}最长为25位',
                'tooShort' => '{attribute}最少6位',
            ],
//            ['email', 'email', 'message' => '邮箱格式错误'],
            ['passwordConfim', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码不相同'],
            ['username', 'unique', 'targetClass' => '\backend\models\UserModel', 'filter' => function ($query) {
                $scenario = self::getScenario();
                if ($scenario == self::SCENARIO_EDIT) {
                    $query->andWhere(['<>', 'id', $this->id]);
                }
            }, 'message' => '该用户名已经被使用'],
            ['id', 'required', 'message' => '{attribute}必须填写'],
            ['id', 'integer', 'message' => '{attribute}必须为整数'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['username', 'password', 'passwordConfim',];
        $scenarios[self::SCENARIO_EDIT] = ['id', 'username', 'password', 'passwordConfim'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'passwordConfim' => '确认密码',
        ];
    }

    /**
     * 创建管理员账号
     * @return UserModel|bool
     */
    public function createAdministrators()
    {
        $userModel = new UserModel();
        $userModel->username = $this->username;
        $userModel->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        return $userModel->save() ? $userModel : false;
    }

    /**
     * 根据id查找管理员
     * @return static
     */
    public function findAdministratorsById()
    {
        return $this->_administrators = UserModel::findOne($this->id);
    }

    /**
     * 修改管理员资料
     * @return bool
     */
    public function editAdministrators()
    {
        $this->findAdministratorsById();

        if (!$this->_administrators) {
            return false;
        }

        $this->_administrators->username = $this->username;
        $this->_administrators->password_hash = \Yii::$app->security->generatePasswordHash($this->username);
        return $this->_administrators->save() ?: false;
    }

    /**
     * 删除管理员
     * @return bool
     */
    public function delAdministrators()
    {
        $this->findAdministratorsById();

        if (!$this->_administrators) {
            return false;
        }

        $this->_administrators->status = UserModel::STATUS_DELETED;
        return $this->_administrators->save() ?: false;
    }
}