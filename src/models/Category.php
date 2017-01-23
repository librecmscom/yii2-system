<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\models;

use yii\db\ActiveRecord;
use Overtrue\Pinyin\Pinyin;

/**
 * Class Category
 * @property int $id ID
 * @property integer $parent 父ID
 * @property string $name 标题
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property string $pinyin 拼音
 * @property string $letter 首字母
 * @property int $frequency 热度
 * @package common\models
 */
class Category extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * Get Category children
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(static::className(), ['parent' => 'id']);
    }



    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (empty($this->pinyin)) {
            $py = new Pinyin();
            $this->pinyin = strtolower($py->permalink($this->name, ''));
        }
        if (empty($this->letter)) {
            $this->letter = strtoupper(substr($this->pinyin, 0, 1));
        }
        return parent::beforeSave($insert);
    }
}