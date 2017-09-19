<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M170213071241Add_backend_menu extends Migration
{
    public function up()
    {
        $this->insert('{{%admin_menu}}', [
            'name' => 'Url规则管理',
            'parent' => 3,
            'route' => '/system/url-rule/index',
            'icon' => 'fa-exclamation-triangle',
            'sort' => NULL,
            'data' => NULL
        ]);

        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => 'Url规则管理', 'parent' => 3,])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建URL规则', $id, '/url-rule/create', 0, NULL],
            ['更新URL规则', $id, '/url-rule/update', 0, NULL],
        ]);
        $this->insert('{{%admin_menu}}', [
            'name' => '单页管理',
            'parent' => 3,
            'route' => '/system/page/index',
            'icon' => 'fa-edit',
            'sort' => NULL,
            'data' => NULL
        ]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '单页管理', 'parent' => 3,])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建单页', $id, '/page/create', 0, NULL],
            ['更新单页', $id, '/page/update', 0, NULL],
        ]);
    }

    public function down()
    {
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => 'Url规则管理', 'parent' => 3])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '单页管理', 'parent' => 3])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
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
