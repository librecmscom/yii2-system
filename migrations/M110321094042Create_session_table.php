<?php

namespace yuncms\migrations;

use yii\db\Migration;

class M110321094042Create_session_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%session}}', [
            'id' => $this->string(40)->notNull()->unique(),
            'expire' => $this->integer(),
            'data' => 'LONGBLOB'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
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
