<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M170321091658Create_setting_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull()->defaultValue(0),
            'code' => $this->string(32)->notNull(),
            'type' => $this->string(32)->notNull(),
            'store_range' => $this->string(255),
            'store_dir' => $this->string(255),
            'value' => $this->text(),
            'sort_order' => $this->integer()->notNull()->defaultValue(50),
        ], $tableOptions);
        // Indexes
        $this->createIndex('{{%setting_parent_id}}', '{{%setting}}', 'parent_id');
        $this->createIndex('{{%setting_code}}', '{{%setting}}', 'code');
        $this->createIndex('{{%setting_sort_order}}', '{{%setting}}', 'sort_order');

        $this->batchInsert('{{%setting}}', ['id', 'parent_id', 'code', 'type', 'store_range', 'store_dir', 'value', 'sort_order'], [
            [11, 0, 'Site', 'group', '', '', '', '50'],
            //[21, 0, 'Attachment', 'group', '', '', '', '50'],

            [1111, 11, 'siteName', 'text', '', '', 'Your Site', '50'],
            [1112, 11, 'siteTitle', 'text', '', '', 'Your Site Title', '50'],
            [1113, 11, 'siteKeyword', 'text', '', '', 'Your Site Keyword', '50'],
            [1114, 11, 'siteDescription', 'text', '', '', 'Your Site Description', '500'],
            [1115, 11, 'siteCloseReason', 'boolean', '', '','0', '500'],
            [1116, 11, 'siteCopyright', 'text', '', '版权所有','0', '500'],
            [1117, 11, 'siteAnalysisCode', 'test', '', '','0', '500'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
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
