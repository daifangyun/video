<?php

use yii\db\Migration;

class m170412_032719_teacher extends Migration
{
    private $tableName = '{{%teacher}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('自增id'),

            'name' => $this->char(35)->notNull()->defaultValue('')->comment('教师昵称'),
            'synopsis' => $this->char(255)->defaultValue('')->comment('教师简介'),
            'header_portrait' => $this->integer(11)->defaultValue(0)->comment('教师头像'),

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
