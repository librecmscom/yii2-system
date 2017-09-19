<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

/**
 * Class M170815072325Create_settings_table
 */
class M170815072325Create_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->notNull(),
            'section' => $this->string(255)->notNull(),
            'key' => $this->string(255)->notNull(),
            'value' => $this->text(),
            'active' => $this->boolean(),
            'created' => $this->dateTime(),
            'modified' => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex('settings_unique_key_section', '{{%settings}}', ['section', 'key'], true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170815072325Create_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
