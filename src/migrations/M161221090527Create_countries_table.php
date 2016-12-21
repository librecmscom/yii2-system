<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M161221090527Create_countries_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //https://www.iso.org/obp/ui/#search
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(11),
            //English short name
            'name' => $this->string()->notNull()->unique(),
            'iso_3166_2'=>$this->string()->notNull()->unique(),
            'alpha-2' => $this->string(2)->notNull()->unique(),
            'alpha-3' => $this->string(3)->notNull()->unique(),
            'number' => $this->integer(3)->notNull()->unique(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%countries}}');
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
