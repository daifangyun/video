<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 15:23
 */

namespace backend\models\form;


use backend\models\TagModel;
use yii\base\Model;

class TagForm extends Model
{
    public $id;
    public $name;
    public $sort;
    public $cid;
    public $pid;
    public $status;

    private $_tag;

    const SCENARIOS_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '{attribute} 必须填写'],
            ['name', 'string', 'min' => '1', 'max' => '25', 'tooShort' => '{attribute} 长度在1-25位', 'tooLong' => '{attribute} 长度在1-25位'],
            ['sort', 'integer', 'message' => '{attribute} 必须为整数'],
            ['id', 'required', 'message' => '{attribute} 必须填写'],
            ['id', 'integer', 'message' => '{attribute} 错误'],
            [['cid', 'pid'], 'required', 'message' => '{attribute} 必须填写'],
            [['cid', 'pid'], 'integer', 'message' => '{attribute} 错误'],
            ['status', 'required', 'message' => '{attribute} 必须填写'],
            ['status', 'in', 'range' => [TagModel::STATUS_ENABLE, TagModel::STATUS_DISABLE], 'message' => '{attribute} 填写错误'],
        ];
    }

    /**
     * 设置场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIOS_CREATE] = ['name', 'sort', 'status', 'cid', 'pid'];
        $scenarios[self::SCENARIO_UPDATE] = ['id', 'name', 'sort', 'status', 'cid', 'pid'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'pid' => '父级',
            'cid' => '分类',
            'sort' => '排序',
            'status' => '状态',
        ];
    }

    /**
     * 创建分类
     * @return bool
     */
    public function create()
    {
        if ($this->validate()) {
            $model = new TagModel();
            $model->name = $this->name;
            $model->pid = $this->pid ? :0;
            $model->cid = $this->cid ? :0;
            $model->sort = $this->sort ?: 0;
            $model->status = $this->status;
            return $model->save();
        }
        return false;
    }

    /**
     * 根据id获取分类
     * @return bool|static
     */
    public function getTagById()
    {
        if (!$this->id) {
            return false;
        }
        $this->_tag = TagModel::findOne($this->id);
        return $this->_tag;
    }

    /**
     * 修改分类
     * @return bool
     */
    public function edit()
    {
        if ($this->validate()) {
            $model = $this->getTagById();
            if ($model === false) {
                return false;
            }
            $model->name = $this->name;
            $model->pid = $this->pid ?: $model->pid;
            $model->cid = $this->cid ?: $model->cid;
            $model->sort = $this->sort ?: $model->sort;
            $model->status = $this->status;
            return $model->save();
        }
        return false;
    }
}