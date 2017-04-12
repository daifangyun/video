<?php

use yii\db\Migration;

class m170307_031511_video extends Migration
{
    private $tableName = '{{%video}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('自增id'),

            'title' => $this->string(255)->notNull()->defaultValue('')->comment('视频标题'),
            'open_at' => $this->integer(11)->notNull()->defaultValue(0)->comment('视频开启时间,当前时间 > 此时间才开放'),
            'how_long' => $this->char(15)->notNull()->defaultValue('')->comment('视频时长'),
            'cid' => $this->integer(11)->notNull()->defaultValue(0)->comment('视频所属分类,分类表中的顶级分类ID'),
            'tid' => $this->integer(11)->notNull()->defaultValue(0)->comment('视频所属讲师'),
            'level' => $this->smallInteger(2)->notNull()->defaultValue(0)->comment('视频难易等级'),
            'content' => $this->text()->comment('视频详情'),

            'sort' => $this->integer(4)->defaultValue(0)->comment('排序,按照由大到小的顺序排,大的在前边,小的在后边'),
            'status' => $this->smallInteger(1)->defaultValue(1)->comment('是否有效,1:有效,0:无效'),
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
