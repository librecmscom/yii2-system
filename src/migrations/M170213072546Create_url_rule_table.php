<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M170213072546Create_url_rule_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%url_rule}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'route' => $this->string()->notNull(),
            'params' => $this->string(),
            'redirect' => $this->boolean()->defaultValue(false),
            'redirect_code' => $this->integer(3)->defaultValue(302),
            'status' => $this->boolean()->defaultValue(true),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%url_rule}}');
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
