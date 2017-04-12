<?php

use yii\db\Migration;

class m170412_032015_tag extends Migration
{
    private $tableName = '{{%tag}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('自增id'),

            'name' => $this->string(50)->notNull()->defaultValue('')->comment('标签名称'),

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
