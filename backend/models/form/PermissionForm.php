<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 14:40
 */

namespace backend\models\form;


use yii\base\Model;

class PermissionForm extends Model
{
    public $id;
    public $name;
    public $description;

    private $_permission;

    const SCENARIOS_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            [['name', 'description'], 'required', 'message' => '{attribute}必须填写'],
            ['id', 'required', 'message' => '{attribute}必须填写'],
            ['id', 'integer', 'message' => '{attribute}必须为整数'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '权限名称',
            'description' => '权限说明',
        ];
    }

    /**
     * 设置场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIOS_CREATE] = ['name', 'description'];
        $scenarios[self::SCENARIO_UPDATE] = ['id', 'name', 'description'];
        return $scenarios;
    }

    /**
     * 创建权限
     * @return bool
     */
    public function createPermission()
    {
        $auth = \Yii::$app->authManager;
        $createPost = $auth->createPermission($this->name);
        $createPost->description = $this->description;
        return $auth->add($createPost) ?: false;
    }

    /**
     * 创建角色
     * @return bool
     */
    public function createRole()
    {
        $auth = \Yii::$app->authManager;
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        return $auth->add($role) ?: false;
    }
}