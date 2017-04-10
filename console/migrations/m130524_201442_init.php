<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('账号'),
            'auth_key' => $this->string(32)->notNull()->comment('自动登录key'),
            'password_hash' => $this->string()->notNull()->comment('加密密码'),
            'password_reset_token' => $this->string()->unique()->comment('重置密码token'),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),

            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('账号状态,10:启用:0:不启用'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('最后修改时间'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
