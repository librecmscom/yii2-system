<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tag`.
 */
class m160823_055902_create_tag_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'title' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->text(),
            'pinyin' => $this->string(),
            'letter' => $this->string(1),
            'frequency' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%tag}}');
    }
}
