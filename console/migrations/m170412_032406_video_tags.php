<?php

use yii\db\Migration;

class m170412_032406_video_tags extends Migration
{
    private $tableName = '{{%video_tags}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('自增id'),

            'vid' => $this->integer(11)->notNull()->defaultValue(0)->comment('视频id'),
            'tid' => $this->integer(11)->notNull()->defaultValue(0)->comment('标签id'),

            'status' => $this->smallInteger(1)->defaultValue(1)->comment('是否有效,1:有效,0:无效,-1:永久删除'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('最后修改时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
