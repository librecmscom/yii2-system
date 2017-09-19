<?php

namespace yuncms\migrations;

use yii\db\Migration;

class M110321093929Create_area_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%area}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'area_code' => $this->string(5),
            'post_code' => $this->string(7),
            'parent' => $this->integer(),
            'sort' => $this->smallInteger()->defaultValue(0)
        ], $tableOptions);
        $this->addForeignKey('{{%area_ibfk_1}}', '{{%area}}', 'parent', '{{%area}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%area}}');
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
