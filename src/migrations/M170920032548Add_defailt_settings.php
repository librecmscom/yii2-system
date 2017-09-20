<?php

namespace yuncms\system\migrations;

use Yii;
use yii\db\Migration;

/**
 * Class M170920032548Add_defailt_settings
 */
class M170920032548Add_defailt_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->batchInsert('{{%settings}}', ['type', 'section', 'key', 'value', 'active', 'created', 'modified'], [
            ['string', 'system', 'url', 'https://www.yuncms.net', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['string', 'system', 'name', 'YUNCMS', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],

            ['string', 'system', 'title', 'YUNCMS内容管理系统', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['string', 'system', 'keywords', 'Artificial Intelligence, Deep Learning, Big Data, Full Stack Engineering, UI/UX Design, Self-Driving Cars, Project based education, Project based learning, Coding, Code, Elearning, Online Learning, Inverview, Job', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],

            ['string', 'system', 'description', 'Join mastery programs to develop the elite skillsets ranging from Artificial Intelligence, Deep Learning, Big Data, Full Stack Engineering, UI/UX Design, to Self-Driving Cars.', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['string', 'system', 'copyright', 'Copyright © 2011-2017 YUNCMS.', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],

            ['boolean', 'system', 'close', '0', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['string', 'system', 'closeReason', '网站升级中。', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['string', 'system', 'analysisCode', '', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
        ]);

        Yii::$app->settings->clearCache();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%settings}}', ['section' => 'system']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170920032548Add_defailt_settings cannot be reverted.\n";

        return false;
    }
    */
}
