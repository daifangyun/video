<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $pid
 * @property integer $cid
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Tag extends \yii\db\ActiveRecord
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;
    const STATUS_DELETE = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
