<?php

namespace yuncms\system\migrations;

use yii\db\Migration;

class M170321081838Add_backend_menu extends Migration
{
    public function up()
    {
        $this->insert('{{%admin_menu}}', [
            'name' => '栏目管理',
            'parent' => 3,
            'route' => '/system/category/index',
            'icon' => 'fa-bars',
            'sort' => NULL,
            'data' => NULL
        ]);

        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '栏目管理', 'parent' => 3,])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建栏目', $id, '/url-rule/create', 0, NULL],
            ['更新栏目', $id, '/url-rule/update', 0, NULL],
        ]);
        $this->insert('{{%admin_menu}}', [
            'name' => '语言管理',
            'parent' => 3,
            'route' => '/system/language/index',
            'icon' => 'fa-language',
            'sort' => NULL,
            'data' => NULL
        ]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '语言管理', 'parent' => 3,])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建语言', $id, '/system/language/create', 0, NULL],
            ['更新语言', $id, '/system/language/update', 0, NULL],
        ]);

        $this->insert('{{%admin_menu}}', [
            'name' => '地区管理',
            'parent' => 3,
            'route' => '/system/area/index',
            'icon' => 'fa-globe',
            'sort' => NULL,
            'data' => NULL
        ]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '地区管理', 'parent' => 3,])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['创建地区', $id, '/system/area/create', 0, NULL],
            ['更新地区', $id, '/system/area/update', 0, NULL],
        ]);
    }

    public function down()
    {
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '栏目管理', 'parent' => 3])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '语言管理', 'parent' => 3])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => '地区管理', 'parent' => 3])->scalar($this->getDb());
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
