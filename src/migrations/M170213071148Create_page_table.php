<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M170213071148Create_page_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string(),
            'description' => $this->string(),
            'route' => $this->string(),
            'content' => $this->text()->notNull(),
            'view' => $this->string()->notNull()->defaultValue('show.php'),
            'views' => $this->integer()->defaultValue(0),
            'status' => $this->boolean()->defaultValue(true),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('{{%page_ibfk_1}}', '{{%page}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
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
