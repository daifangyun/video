<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 12:54
 */

namespace backend\models;

use common\models\Category;

class CategoryModel extends Category
{
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