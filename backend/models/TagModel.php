<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 15:23
 */

namespace backend\models;


use common\models\Tag;

class TagModel extends Tag
{
    public function getCategory()
    {
        return $this->hasOne(CategoryModel::className(), ['id' => 'cid']);
    }

    /**
     * 获取所有有效的标签列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllEnableTags()
    {
        return self::find()
            ->where(['<>', 'status', self::STATUS_DELETE])
            ->asArray()
            ->all();
    }

    /**
     * 根据id来删除
     * @param $id int
     * @return bool
     */
    public static function delById($id)
    {
        $id = (int)$id;
        if (!$id) return false;

        $category = self::findOne($id);
        if (!$category) return false;

        $category->status = self::STATUS_DELETE;
        return $category->save();
    }
}