<?php

namespace yuncms\migrations;

use yii\db\Migration;

class M170630043502Create_hits_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hits}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'model' => $this->string()->notNull(),
            'views' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('总计数'),
            'day_views' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('按日计数'),
            'week_views' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('按周计数'),
            'month_views' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('按月计数'),
            'yesterday_views' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('昨天计数'),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%hits_model_index}}', '{{%hits}}', ['model_id', 'model'], false);
    }

    public function safeDown()
    {
        $this->dropTable('{{%hits}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170630043502Create_hits_table cannot be reverted.\n";

        return false;
    }
    */
}
